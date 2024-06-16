<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CartConfirmationFormRequest;
use App\Models\Screening;
use App\Models\Seat;
use App\Services\Payment;
use App\Notifications\PurchasePaid;
use Illuminate\Support\Facades\Notification;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart');
        $payment_types = [
            'PAYPAL' => 'PayPal',
            'MBWAY' => 'MBWay',
            'VISA' => 'Visa credit card'
        ];

        return view(
            'main.cart.show',
            compact('cart', 'payment_types')
        );
    }

    public function addToCart(Request $request, Screening $screening, Seat $seat): RedirectResponse
    {
        $cart = session('cart');
        if (!$cart) {
            $cart = collect();
            $cart->push([
                'screening' => $screening,
                'seat' => $seat
            ]);
            $request->session()->put('cart', $cart);
        } else {
            if (
                $cart->first(function ($item) use ($screening, $seat) {
                    return $item['screening']->id === $screening->id
                        && $item['seat']->id === $seat->id;
                })
            ) {
                $alertType = 'warning';
                $url = route('screenings.show', ['screening' => $screening]);
                $htmlMessage = "Screening <a href='$url'>#{$screening->id}</a> of the movie <strong>{$screening->movie->title}</strong> (seat {$seat->row}-{$seat->seat_number}) was not added to the cart because it is already there!";
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', $alertType);
            } else {
                $cart->push([
                    'screening' => $screening,
                    'seat' => $seat
                ]);
            }
        }
        $alertType = 'success';
        $url = route('screenings.show', ['screening' => $screening]);
        $htmlMessage = "Screening <a href='$url'>#{$screening->id}</a> of the movie <strong>{$screening->movie->title}</strong> (seat {$seat->row}-{$seat->seat_number}) was added to the cart.";
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function removeFromCart(Request $request, Screening $screening, Seat $seat): RedirectResponse
    {
        $url = route('screenings.show', ['screening' => $screening]);
        $cart = session('cart');
        if (!$cart) {
            $alertType = 'warning';
            $htmlMessage = "Screening <a href='$url'>#{$screening->id}</a> of the movie <strong>{$screening->movie->title}</strong> (seat {$seat->row}-{$seat->seat_number}) was not removed from the cart because cart is empty!";
            return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', $alertType);
        } else {
            $element = $cart->first(function ($item) use ($screening, $seat) {
                return $item['screening']->id === $screening->id
                    && $item['seat']->id === $seat->id;
            });
            if ($element) {
                $cart->forget($cart->search($element));
                if ($cart->count() == 0) {
                    $request->session()->forget('cart');
                }
                $alertType = 'success';
                $htmlMessage = "Screening <a href='$url'>#{$screening->id}</a> of the movie <strong>{$screening->movie->title}</strong> (seat {$seat->row}-{$seat->seat_number}) was removed from the cart.";
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', $alertType);
            } else {
                $alertType = 'warning';
                $htmlMessage = "Screening <a href='$url'>#{$screening->id}</a> of the movie <strong>{$screening->movie->title}</strong> (seat {$seat->row}-{$seat->seat_number}) was not removed from the cart because cart does not include it!";
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', $alertType);
            }
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        $cart = session('cart');
        if (!$cart) {
            return back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', 'Nothing to clear. Shopping cart is empty');
        }

        $request->session()->forget('cart');
        return back()
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Shopping Cart has been cleared');
    }


    public function confirm(CartConfirmationFormRequest $request): RedirectResponse
    {
        $cart = session('cart');
        if (!$cart || ($cart->count() == 0)) {
            return back()
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Cart was not confirmed, because cart is empty!");
        } else {
            $ticketsAlreadyBought = new Collection();
            foreach ($cart as $ticket) {
                $ticketQuery = Ticket::query()->with('screening')->whereHas('screening', function ($query) use ($ticket) {
                    return $query->where('id', $ticket['screening']->id);
                });
                $ticketQuery->with('seat')->whereHas('seat', function ($query) use ($ticket) {
                    return $query->where('id', $ticket['seat']->id);
                });
                if (!$ticketQuery->with(['screening', 'seat'])->get()->isEmpty()) {
                    $ticketsAlreadyBought->push($ticket);
                }
            }

            if (!$ticketsAlreadyBought->isEmpty()) {
                $ticketsRemoved = '';
                foreach ($ticketsAlreadyBought as $ticket) {
                    $cart->forget($cart->search($ticket));
                    if ($ticketsRemoved == '')
                        $ticketsRemoved = $ticketsRemoved . 'Screening <a href="' . route('screenings.show', ['screening' => $ticket['screening']->id]) . '">#' . $ticket['screening']->id . '</a> with seat ' . $ticket['seat']->row . '-' . $ticket['seat']->seat_number;
                    else
                        $ticketsRemoved = $ticketsRemoved . ' and Screening #' . $ticket['screening']->id . ' with seat ' . $ticket['seat']->row . '-' . $ticket['seat']->seat_number;
                }
                if ($cart->count() == 0) {
                    $request->session()->forget('cart');
                }
                return back()
                    ->with('alert-type', 'warning')
                    ->with('alert-msg', "Some tickets in the cart were bought while finishing the payment. $ticketsRemoved");
            }

            match ($request->payType) {
                'PAYPAL' => $paymentSuccess = Payment::payWithPaypal($request->payRef),
                'MBWAY' => $paymentSuccess = Payment::payWithMBway($request->payRef),
                'VISA' => $paymentSuccess = Payment::payWithVisa(substr($request->payRef, 0, 16), substr($request->payRef, 16))
            };

            if (!$paymentSuccess) {
                return back()
                    ->with('alert-type', 'danger')
                    ->with('alert-msg', "Payment was not successfull.");
            }

            $totalTickets = match ($cart->count()) {
                1 => "1 ticket was purchased.",
                default => $cart->count() . " tickets were purchased",
            };

            $user = $request?->user();
            $validatedData = $request->validated();
            $newPurchase = DB::transaction(function () use ($validatedData, $user, $cart) {
                $newPurchase = new Purchase();
                if ($user?->customer) {
                    $newPurchase->customer_id = $user->customer->id;
                }

                $newPurchase->customer_name = $validatedData['name'];
                $newPurchase->customer_email = $validatedData['email'];

                $newPurchase->nif = $validatedData['nif'];
                $newPurchase->payment_type = $validatedData['payType'];
                if ($validatedData['payType'] == 'VISA') {
                    $newPurchase->payment_ref = substr($validatedData['payRef'], 0, 16);
                } else {
                    $newPurchase->payment_ref = $validatedData['payRef'];
                }

                $newPurchase->total_price = 0;
                $newPurchase->date = now();
                $newPurchase->save();

                $total = 0;
                $tickets = [];

                $config = \App\Models\Configuration::find(1);
                foreach ($cart as $ticket) {
                    $newTicket = new Ticket();

                    $newTicket->purchase_id = $newPurchase->id;
                    $newTicket->screening_id = $ticket['screening']->id;
                    $newTicket->seat_id = $ticket['seat']->id;

                    $newTicket->price = $config->ticket_price;
                    if ($user?->customer) {
                        $newTicket->price -= $config->registered_customer_ticket_discount;
                    }

                    $newTicket->status = 'valid';
                    $newTicket->save();

                    $newTicket->generateQRCode();

                    $total += $newTicket->price;
                    $tickets[] = $newTicket;
                }
                $newPurchase->total_price = $total;
                $newPurchase->generatePDF();
                $newPurchase->update();

                Notification::route('mail', $validatedData['email'])
                    ->notify(new PurchasePaid($newPurchase, collect($tickets)));

                return $newPurchase;
            });

            $request->session()->forget('cart');
            if ($user) {
                $route = ['purchases.show', ['purchase' => $newPurchase]];
            } else {
                $route = ['movies.showcase'];
            }
            return redirect()->route(...$route)
                ->with('alert-type', 'success')
                ->with('alert-msg', "Your receipt has been sent to email and a total of $totalTickets.");
        }
    }
}
