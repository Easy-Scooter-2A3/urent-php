<div class="w-full mx-auto my-4 border-b-2 pb-4">	
    <div class="flex pb-3">
        <div class="flex-1">
        </div>

        @foreach ($days as $item)
        
        {{-- Rond --}}
        <div class="flex-1">
            <span id="tmp" class="w-12 h-12"></span>
            <div day-circle class="w-10 h-10 hover:border-zinc-800 hover:border-2 bg-green-400 mx-auto rounded-full text-lg text-white flex items-center transition-all ease-in-out duration-300">
                <button type="button" data-tooltip-target="tooltip-day-{{ $item }}" class="text-black text-center w-full">{{ $item[0] }}</button>

                <div id="tooltip-day-{{ $item }}" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                    {{ $item }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </div>

        </div>

        {{-- Useless if it's t he last day --}}
        {{-- @if ($loop->iteration != count($days)) --}}
        {{-- Barre --}}
        <div class="w-1/6 align-center items-center align-middle content-center flex">
            <div class="w-full bg-gray-300 rounded items-center align-middle align-center flex-1">
                 <div class="bg-green-400 text-xs leading-none py-1 text-center text-gray-600 rounded"
                 @php
                    $value = ($loop->iteration < $currentDay) ? 100 : (100/24) * $currentHour;
                    if ($loop->iteration > $currentDay) {
                        $value = 0;
                    }
                 @endphp
                    style="width: {{ $value }}%"></div>
                 
            </div>
        </div>
        {{-- @endif --}}

        @endforeach
    
        <div class="flex-1">
        </div>
    </div>
</div>