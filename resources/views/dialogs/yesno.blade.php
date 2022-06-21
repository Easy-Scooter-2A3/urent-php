<div data-mdc-auto-init="MDCDialog" class="mdc-dialog">
    <div id="mfa_dialog" class="mdc-dialog__container">
      <div class="mdc-dialog__surface"
        role="dialog"
        aria-modal="true"
        aria-labelledby="dialog-title"
        aria-describedby="dialog-content">
        <div class="mdc-dialog__header">
          <h2 class="mdc-dialog__title" id="dialog-title">
          </h2>
        </div>
        <div class="mdc-dialog__content" id="dialog-content">
            Confirmer ?
        </div>
        <div class="mdc-dialog__actions">
          <button id="mfa_confirm_btn" type="button" class="mdc-button mdc-dialog__button"
                  data-mdc-dialog-action="accept">
            <div class="mdc-button__ripple"></div>
            <span class="mdc-button__label">OK</span>
          </button>
          <button id="mfa_cancel_btn" type="button" class="mdc-button mdc-dialog__button"
                  data-mdc-dialog-action="cancel">
            <div class="mdc-button__ripple"></div>
            <span class="mdc-button__label">Cancel</span>
          </button>
        </div>
      </div>
    </div>
    <div class="mdc-dialog__scrim"></div>
</div>