@include('head')
@include('header')

<body class="bg-gray-100">

    <div class="flex flex-col md:flex-row">
        <div class="flex p-4 bg-white w-full md:w-60">
            <div class="grid grid-cols-1 gap-4 text-center justify-items-center w-full">
                @foreach ($collection as $item)
                    <a class="hover:text-red-600 text-2xl" href="{{ route($item[0]) }}">{{ $item[1] }}</a>
                @endforeach
            </div>
        </div>

        <div class="w-full">
            <div class="p-4 gap-3 xl:w-5/12 lg:w-4/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md">

                <div id="controls-carousel" class="relative" data-carousel="static">
                    <div class="flex justify-between">
                        <button class="hover:text-red-600" data-carousel-prev type="button">
                            <span class="material-icons">arrow_back</span>
                        </button>
                        <button class="hover:text-red-600" data-carousel-next type="button">
                            <span class="material-icons">arrow_forward</span>
                        </button>
                    </div>
                    <div class="overflow-hidden relative h-48 rounded-lg">
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
                    </div>
                    <hr>
                    {{-- Graphique --}}
                    <div></div>
                </div>
            </div>

            <div class="p-4 gap-3 xl:w-5/12 lg:w-4/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md">
                <h2>
                    {{-- Jours --}}
                </h2>
            </div>
        </div>
    </div>

</body>
@include('footer')