{{-- data-mdc-auto-init="MDCDialog" --}}
<div data-mdc-auto-init="MDCDialog" class="mdc-dialog mdc-dialog--open">
    <div id="mfa_dialog" class="mdc-dialog__container">
      <div class="mdc-dialog__surface"
        role="dialog"
        aria-modal="true"
        aria-labelledby="my-dialog-title"
        aria-describedby="my-dialog-content">
        <div class="mdc-dialog__header">
          <h2 class="mdc-dialog__title" id="my-dialog-title">
            Multi Factor authentication
          </h2>
        </div>
        <div class="mdc-dialog__content" id="my-dialog-content">
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
          <button id="mfa_confirm_btn" type="button" class="mdc-button mdc-dialog__button"
                  data-mdc-dialog-action="ok">
            <div class="mdc-button__ripple"></div>
            <span class="mdc-button__label">OK</span>
          </button>
        </div>
      </div>
    </div>
    <div class="mdc-dialog__scrim"></div>
</div>