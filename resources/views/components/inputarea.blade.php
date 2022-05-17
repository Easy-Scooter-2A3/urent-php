<label data-mdc-auto-init="MDCTextField" class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--no-label">
    {{-- <span class="mdc-text-field__ripple"></span> --}}
    @isset ($label)
    <span class="mdc-floating-label">{{ $label }}</span>
    @endisset
    <span class="mdc-notched-outline">
        <span class="mdc-notched-outline__leading"></span>
        <span class="mdc-notched-outline__trailing"></span>
      </span>
    <span>
        <textarea
        @isset($id)
            id="{{ $id }}"
        @endisset
        @isset($onKeyUp)
            onKeyUp="{{ $onKeyUp }}"
        @endisset
        @empty($optional)
            required
        @endisset
        class="mdc-text-field__input focus:ring-transparent" rows="8" cols="60" name="{{ $name }}" type="{{ $type }}"></textarea>
    </span>
    <span class="mdc-line-ripple"></span>
</label>