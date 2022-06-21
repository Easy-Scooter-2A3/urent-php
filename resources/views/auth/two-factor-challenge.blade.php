@include('head')
@include('header')

<body class="bg-gray-100">

    @if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
    @endif

    <div class="xl:w-1/6 lg:w-1/6 md:w-full flex flex-col sm:flex-row justify-between mx-auto px-5 border bg-white my-5 drop-shadow-md">
        <form action="/two-factor-challenge" method="POST" class="flex flex-col m-5 mx-auto w-full">
            @csrf
            {{-- Code field --}}
            @component('components.inputfield', [
                'text' => 'Code',
                'icon' => 'password',
                'name' => 'code',
                'type' => 'code',
            ])

            @endcomponent
            
            @error('code')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
            @isset($status)
                <div class="text-green-600 text-sm">{{ $status }}</div>
            @endisset

            <div class="mt-4 flex justify-end">
                {{-- Submit button --}}
                @component('components.button', [
                    'text' => 'Submit',
                    'type' => 'submit',
                ])
                    
                @endcomponent
            </div>
        </form>
    </div>

</body>