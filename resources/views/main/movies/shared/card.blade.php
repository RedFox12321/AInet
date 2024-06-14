 <figure
     class="h-full w-full flex flex-col p-auto transform hover:rotate-6 hover:scale-110 hover:z-20 transition duration-500 ease-in-out">
     <a class="h-48 w-auto md:h-72 lg:h-96" href="{{ route('movies.show', ['movie' => $movie]) }}">
         <img class="h-full aspect-auto mx-auto rounded-[10px]" src="{{ $movie->imageUrl }}">
     </a>
 </figure>
