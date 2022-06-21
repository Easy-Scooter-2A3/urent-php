<div class="w-full">
    <div class="p-4 gap-3 xl:w-9/12 lg:w-4/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md">

        <div class="relative">
            {{-- <div class="flex justify-between">
                <button class="hover:text-red-600" data-carousel-prev type="button">
                    <span class="material-icons">arrow_back</span>
                </button>
                <button class="hover:text-red-600" data-carousel-next type="button">
                    <span class="material-icons">arrow_forward</span>
                </button>
            </div> --}}
            {{-- <div class="overflow-hidden relative h-48 rounded-lg">
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <div class="flex justify-around">
                        <button type="button">
                            <img class="w-28 h-28 rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/2/21/Solid_black.svg" alt="Rounded avatar">
                            <h2 class="mt-2">Soleil</h2>
                        </button>
                        <button type="button">
                            <img class="w-28 h-28 rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/2/21/Solid_black.svg" alt="Rounded avatar">
                            <h2 class="mt-2">Pluie</h2>
                        </button>
                        <button type="button">
                            <img class="w-28 h-28 rounded-full" src="https://upload.wikimedia.org/wikipedia/commons/2/21/Solid_black.svg" alt="Rounded avatar">
                            <h2 class="mt-2">Température</h2>
                        </button>
                    </div>
                </div>

                <div class="hidden duration-200 ease-linear" data-carousel-item>
                </div>
            </div> --}}
            <hr>
            {{-- Graphique --}}

            <canvas id="weather-canvas" class="w-full h-72 border"></canvas>
            <script src="/js/canvas.js"></script>

            <div></div>
        </div>
    </div>

    <div class="p-4 gap-3 xl:w-9/12 lg:w-4/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md">
        @include('user.weather-bar')
    </div>
</div>