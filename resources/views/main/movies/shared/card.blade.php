 <figure class="h-full w-full flex flex-col p-auto">
     <a class="h-48 w-auto md:h-72 lg:h-96"
         href="{{ route('movies.show', ['movie' => $movie]) }}">
         <img class="h-full aspect-auto mx-auto rounded-[10px]"
             src="{{ $movie->imageUrl }}">
     </a>
 </figure>
