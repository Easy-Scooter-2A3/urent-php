@include('head')
@include('header')

<body class="bg-gray-100">
    
    <div class="xl:w-1/6 lg:w-1/6 md:w-full flex flex-col sm:flex-row justify-between mx-auto px-5 border bg-white my-5 drop-shadow-md">
        <form action="/reset-password" method="POST" class="flex flex-col m-5 mx-auto w-full">
            @csrf

            @component('components.inputfield', [
                'text' => 'Password',
                'icon' => 'password',
                'name' => 'password',
                'type' => 'password',
            ])
            @endcomponent

            @component('components.inputfield', [
                'text' => 'Password confirmation',
                'icon' => 'password',
                'name' => 'password_confirmation',
                'type' => 'password',
            ])
            @endcomponent

            <input type="hidden" value="{{ request()->route('token') }}" name="token">
            <input type="hidden" value="{{ $email }}" name="email">

            @isset($status)
                <div class="text-green-600 text-sm">{{ $status }}</div>
            @endisset
            @error('token')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
            @error('email')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
            @error('password')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
            @error('password_confirmation')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror

            <div class="mt-4 flex justify-end">
                {{-- LogResetin button --}}
                @component('components.button', [
                    'text' => 'Submit',
                    'type' => 'submit',
                ])
                    
                @endcomponent
            </div>
        </form>
    </div>

</body>