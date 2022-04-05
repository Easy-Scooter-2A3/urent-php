@include('head')
@include('header')

<body class="bg-gray-100">

    <div class="xl:w-3/6 lg:w-4/6 md:w-full flex flex-col sm:flex-row justify-between mx-auto px-5 border bg-white my-5 drop-shadow-md">
        <form method="POST" class="flex flex-col m-5 md:w-2/5 sm:w-full">
            @csrf

            {{-- Login field --}}
            @component('components.inputfield', [
                'text' => 'Login',
                'icon' => 'account_circle',
                'name' => 'email',
                'type' => 'text',
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


            <div class="mt-5 flex justify-between">
                {{-- Remember me --}}
                <div class="mdc-form-field">
                    <div class="mdc-checkbox">
                      <input type="checkbox"
                             class="mdc-checkbox__native-control"
                             name="remember"
                             id="checkbox-1"/>
                      <div class="mdc-checkbox__background">
                        <svg class="mdc-checkbox__checkmark"
                             viewBox="0 0 24 24">
                          <path class="mdc-checkbox__checkmark-path"
                                fill="none"
                                d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                        </svg>
                        <div class="mdc-checkbox__mixedmark"></div>
                      </div>
                      <div class="mdc-checkbox__ripple"></div>
                    </div>
                    <label for="checkbox-1">Remember me</label>
                </div>

                {{-- Login button --}}
                @component('components.button', [
                    'text' => 'Submit',
                    'type' => 'submit',
                ])
                    
                @endcomponent
            </div>

            <div class="flex">
                <a href="/register" class="hover:text-red-600 text-gray-500 mt-3 text-sm hover:underline">No account ? Create one</a>
                <h3 class="text-gray-500 mt-3 text-sm">&nbsp;/&nbsp;</h3>
                <a href="/resetpassword" class="hover:text-red-600 text-gray-500 mt-3 text-sm hover:underline">Reset password</a>
            </div>
            @error('email')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
            @error('password')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </form>
        <span class="border"></span>
        <div class="m-5 md:w-2/5 sm:w-full border">
            <h3>TODO</h3>
            <h3>TODO</h3>
            <h3>TODO</h3>
            <h3>TODO</h3>
        </div>
    </div>
    
</body>
@include('footer')