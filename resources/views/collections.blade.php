<div class="p-4 bg-white w-full md:w-60">
    <div class="flex flex-col gap-4 text-center justify-items-center w-full">
        @foreach ($collection as $item)
            <a class="hover:text-red-600 text-2xl" href="{{ route($item[0]) }}">{{ $item[1] }}</a>
        @endforeach
    </div>
</div>