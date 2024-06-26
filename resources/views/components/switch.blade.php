<button data-mdc-auto-init="MDCSwitch" @isset($id)id="{{ $id }}"@endisset type="button" role="switch"
@class([
  'mdc-switch',
  Auth::user()->two_factor_secret ? 'mdc-switch--selected' : 'mdc-switch--unselected'
  ])
>
    <div class="mdc-switch__track"></div>
    <div class="mdc-switch__handle-track">
      <div class="mdc-switch__handle">
        <div class="mdc-switch__shadow">
          <div class="mdc-elevation-overlay"></div>
        </div>
        <div class="mdc-switch__ripple"></div>
        {{-- <div class="mdc-switch__icons">
          <svg class="mdc-switch__icon mdc-switch__icon--on" viewBox="0 0 24 24">
            <path d="M19.69,5.23L8.96,15.96l-4.23-4.23L2.96,13.5l6,6L21.46,7L19.69,5.23z" />
          </svg>
          <svg class="mdc-switch__icon mdc-switch__icon--off" viewBox="0 0 24 24">
            <path d="M20 13H4v-2h16v2z" />
          </svg>
        </div> --}}
      </div>
    </div>
  </button>