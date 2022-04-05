<label data-mdc-auto-init="MDCTextField" class="mt-5 mdc-text-field mdc-text-field--filled mdc-text-field--with-leading-icon">
    <span class="mdc-text-field__ripple"></span>
    <span class="mdc-floating-label">{{ $text }}</span>
    <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading">{{ $icon }}</i>
    <input
    @empty($optional)
        required
    @endisset
    class="mdc-text-field__input focus:ring-transparent" name="{{ $name }}" type="{{ $type }}">
    <span class="mdc-line-ripple"></span>
</label>