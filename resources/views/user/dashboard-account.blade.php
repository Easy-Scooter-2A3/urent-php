<div class="p-4 gap-3 xl:w-5/12 lg:w-4/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md">
    <strong class="text-lg">@lang('Personal information')</strong>
    <h2>@lang('Username') : {{ Auth::user()->name }}</h2>
    <h2>@lang('Email') : {{ Auth::user()->email }}</h2>
    <h2>@lang('Phone number') : {{ Auth::user()->phone }}</h2>
    <h2>@lang('Location') : {{ Auth::user()->location }}</h2>

    @if ($partnership)
        <h2>@lang('partnership') {{ $partnership->name }}</h2>
    @endif

    <h2>MFA: 
        <form id="mfa_form" action="/user/two-factor-authentication" method="post">
            @csrf
        @component('components.switch', [
            'id' => 'mfa_switch',
        ])
        @endcomponent
        </form>
        {{-- /user/confirmed-two-factor-authentication POST + CSRF --}}
        @if (Auth::user()->two_factor_secret)
            @if (Auth::user()->two_factor_confirmed_at)
                @lang('Enabled')
            @else
                <button id="mfa_dialog_open" type="button">@lang('Confirm MFA')</button>
                <div id="custom_mfa_error" class="text-red-600 text-sm"></div>

                <div id="mfa_dialog2" class="mdc-dialog">
                    <div class="mdc-dialog__container">
                      <div class="mdc-dialog__surface"
                        role="alertdialog"
                        aria-modal="true"
                        aria-labelledby="dialog"
                        aria-describedby="dialog-content">
                        <h2 class="mdc-dialog__title" id="dialog">@lang('Confirm MFA')</h2>
                        <div class="mdc-dialog__content" id="dialog-content">
                            <h2 class="mb-3">@lang('Please scan the following QR Code in your Authenticator App')</h2>
                            {!! Auth::user()->twoFactorQrCodeSvg() !!}

                            {{-- Code field --}}
                            @component('components.inputfield', [
                                'text' => 'Code',
                                'icon' => 'password',
                                'name' => 'code',
                                'type' => 'code',
                            ])
                            @endcomponent
                        </div>
                        <div class="mdc-dialog__actions">
                          <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="close">
                            <div class="mdc-button__ripple"></div>
                            <span class="mdc-button__label">@lang('Cancel')</span>
                          </button>
                          <button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="accept">
                            <div class="mdc-button__ripple"></div>
                            <span class="mdc-button__label">OK</span>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="mdc-dialog__scrim"></div>
                </div>
            @endif
        @else
            @lang('Disabled')
        @endif
        
    </h2>
    <h2>@lang('Fidelity points') : {{ Auth::user()->fidelity_points }}</h2>
    <h2>@lang('Credits') : {{ Auth::user()->balance() }}</h2>
    <h2>@lang('Package') : {{ $current_package }}</h2>
    @component('components.button', [
        'text' => 'Stripe',
        'type' => 'button',
        'href' => route('dashboard.stripe-portal'),
    ])
    @endcomponent

    @component('components.button', [
        'text' => 'Convert points',
        'type' => 'button',
        'id' => 'fidelityBtn',
    ])
    @endcomponent
    
    {{-- @include('dialogs.MFA') --}}

    @if (session('status') == 'two-factor-authentication-enabled')
        <div class="mb-4 font-medium text-sm">
            @lang('Please finish configuring two factor authentication below.')
            {{-- @include('dialogs.MFA') --}}
        </div>
    @endif
    @include('modal-payment')
    <script src="/js/dashboard.js"></script>
</div>