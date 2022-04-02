@include('head')
@include('header')

<body class="h-1/5 bg-gray-100">

    <div class="w-4/6 flex justify-between mx-auto px-5 border bg-white">
        <div class="flex flex-col m-5">

            {{-- Login field --}}
            <label data-mdc-auto-init="MDCTextField" class="mdc-text-field mdc-text-field--filled mdc-text-field--with-leading-icon">
                <span class="mdc-text-field__ripple"></span>
                <span class="mdc-floating-label" id="my-label-id">Login</span>
                <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading" tabindex="0" role="button">account_circle</i>
                <input class="mdc-text-field__input" type="text">
                <span class="mdc-line-ripple"></span>
            </label>

            {{-- Password field --}}
            <label data-mdc-auto-init="MDCTextField" class="mdc-text-field mdc-text-field--filled mdc-text-field--with-leading-icon">
                <span class="mdc-text-field__ripple"></span>
                <span class="mdc-floating-label" id="my-label-id">Password</span>
                <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading" tabindex="0" role="button">password</i>
                <input class="mdc-text-field__input" type="text">
                <span class="mdc-line-ripple"></span>
            </label>

            <div class="border flex justify-between">
                {{-- Remember me --}}
                <div class="mdc-form-field">
                    <div class="mdc-checkbox">
                      <input type="checkbox"
                             class="mdc-checkbox__native-control"
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
                <button class="mdc-button mdc-button--raised">
                    <span class="mdc-button__ripple"></span>
                    <span class="mdc-button__touch"></span>
                    <span class="mdc-button__label">Valider</span>
                </button>
            </div>
        </div>
        <div class="m-5 border">
            <h3>TODO</h3>
            <h3>TODO</h3>
            <h3>TODO</h3>
            <h3>TODO</h3>
        </div>
    </div>
    
</body>
@include('footer')