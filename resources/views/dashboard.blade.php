@include('head')
@include('header')

<body class="bg-gray-100">
    
    <aside id="notif-snackbar" class="mdc-snackbar">
        <div class="mdc-snackbar__surface" role="status" aria-relevant="additions">
          <div class="mdc-snackbar__label" aria-atomic="false">
            Can't send photo. Retry in 5 seconds.
          </div>
          <div class="mdc-snackbar__actions" aria-atomic="true">
            <button type="button" class="mdc-button mdc-snackbar__action">
              <div class="mdc-button__ripple"></div>
              <span class="mdc-button__label">Retry</span>
            </button>
          </div>
        </div>
      </aside>

    <div class="flex flex-col md:flex-row">
        @include('collections')

        @include( $view )
    </div>

</body>
