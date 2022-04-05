@include('head')
@include('header')

<body class="bg-gray-100">

    <div class="xl:w-5/12 lg:w-4/6 md:w-full flex flex-col sm:flex-row justify-between mx-auto px-5 bg-white my-5 drop-shadow-md">
            <form method="POST" class="flex flex-col md:grid md:grid-cols-2 md:grid-rows-2 m-4 md:gap-6 w-full">
            @csrf
            {{-- Name field --}}
            @component('components.inputfield', [
                'text' => 'Username',
                'icon' => 'account_circle',
                'name' => 'name',
                'type' => 'text',
            ])
            @endcomponent

            {{-- Email field --}}
            @component('components.inputfield', [
                'text' => 'Email',
                'icon' => 'email',
                'name' => 'email',
                'type' => 'email',
            ])
            @endcomponent

            {{-- Location field --}}
            @component('components.inputfield', [
                'text' => 'Location',
                'icon' => 'place',
                'name' => 'location',
                'type' => 'text',
            ])
            @endcomponent

            {{-- Phone number field --}}
            @component('components.inputfield', [
                'text' => 'Phone number',
                'icon' => 'phone',
                'name' => 'phone',
                'type' => 'phone',
            ])
            @endcomponent

            {{-- Password field --}}
            @component('components.inputfield', [
                'text' => 'Password',
                'icon' => 'password',
                'name' => 'password',
                'type' => 'password',
            ])
            @endcomponent
            
            {{-- Confirm password field --}}
            @component('components.inputfield', [
                'text' => 'Password confirmation',
                'icon' => 'password',
                'name' => 'password_confirmation',
                'type' => 'password',
            ])
            @endcomponent

            {{-- Partner code button --}}
            @component('components.inputfield', [
                'text' => 'Code partenaire',
                'icon' => 'account_circle',
                'name' => 'partner_code',
                'type' => 'text',
                'optional' => true,
            ])
            @endcomponent

            <div class="border col-start-2 justify-self-end self-end mt-4">
                @error('email')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
                @error('password')
                    <div class="text-red-600 text-sm">{{ $message }}</div>
                @enderror
                
                {{-- Submit button --}}
                @component('components.button', [
                    'text' => 'Submit',
                    'type' => 'submit',
                    'id' => 'submit-button1',
                ])
                @endcomponent
            </div>
        </form>
    </div>
    
</body>
@include('footer')