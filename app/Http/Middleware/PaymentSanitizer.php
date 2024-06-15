<?php

namespace App\Http\Middleware;

use App\Http\Requests\CartConfirmationFormRequest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentSanitizer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (($request?->payType == 'MBWAY' || $request?->payType == 'VISA') && $request?->payRef) {
            $ref = $request->input('payRef');
            $ref = preg_replace('/\s+/', '', $ref); // Remove existing spaces
            $ref = preg_replace('/\D/', '', $ref); // Remove non-digit characters
            $request->merge(['payRef' => $ref]);
        }

        return $next($request);
    }
}
