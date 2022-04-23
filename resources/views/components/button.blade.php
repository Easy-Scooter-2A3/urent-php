<button
    @isset($id)
    id="{{ $id }}"
    @endisset

    @isset($hidden)
        @class(['mdc-button--raised', 'my-auto', 'hidden' => true])
    @endisset

    @isset($modal)
        data-modal-toggle="{{ $modal }}"
    @endisset

    @empty($hidden)
        @class(['mdc-button', 'mdc-button--raised', 'my-auto', 'mdc-button' => true])
    @endempty


    type="{{ $type }}">
    <span class="mdc-button__ripple"></span>
    <span class="mdc-button__touch"></span>
    <span class="mdc-button__label m-3">{{ $text }}</span>
</button>