@if (!Auth::guest())
    @include('modal-payment')
@endif

<div class="p-4 gap-3 xl:w-2/12 lg:w-1/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md justify-between">
    <h1 class="text-center text-2xl">@lang('Pay as you go')
        @if ($current_package == 1)
        <em class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</em>
        @endif
    </h1>

    <div class="mx-5">
        <ul class="list-disc m-4">
            <li>
                @lang('Unlocking at 1€')
            </li>
            <li>
                @lang('23 centimes / min')
            </li>
        </ul>
    </div>

    <div class="self-center">
        @component('components.button', [
            'text' => 'Choisir',
            'type' => 'button',
            'id' => 'pickPackageBtn1',
            'modal' => 'modal-payment'
        ])
        @endcomponent
    </div>
</div>

<div class="p-4 gap-3 xl:w-2/12 lg:w-1/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md justify-between">
    <h1 class="text-center text-2xl">@lang('Monthly')
        @if ($current_package == 2)
        <em class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</em>
        @endif
    </h1>

    <div class="mx-5">
        <ul class="list-disc m-4">
            <li>
                3 Options
            </li>
            <li>
                @lang('30 mins each way')
            </li>
            <li>
                @lang('Free Unlock')
            </li>
        </ul>

        <div class="flex">
            <form class="flex flex-col" action="#">
                @php
                    $pkg = $packages->where('id', 2)->first();
                    $prices = [$pkg->option1_price, $pkg->option2_price, $pkg->option3_price];
                    $nb = [$pkg->option1_nb, $pkg->option2_nb, $pkg->option3_nb];
                @endphp
                @for ($i = 1; $i < 4; $i++)
                <div class="mdc-form-field">
                    <div class="mdc-checkbox">
                      <input option="{{ $i }}" name="option"
                             type="checkbox"
                             class="mdc-checkbox__native-control"
                             id="checkbox-{{ $i }}"/>
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
                    <label for="checkbox-1">
                        {{ $nb[$i-1] }} @lang('trips to') {{ $prices[$i-1] }} €
                    </label>
                </div>
                @endfor
            </form>
        </div>
    </div>

    <div class="self-center">
        @component('components.button', [
            'text' => 'Choisir',
            'type' => 'button',
            'id' => 'pickPackageBtn2',
            'modal' => 'modal-payment'
        ])
        @endcomponent
    </div>
</div>

<div class="p-4 gap-3 xl:w-2/12 lg:w-1/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md justify-between">
    <h1 class="text-center text-2xl">@lang('Daily')
        @if ($current_package == 3)
        <em class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">@lang('done')</em>
        @endif
    </h1>

    <div class="mx-5">
        <ul class="list-disc m-4">
            <li>
                @lang('Price: 9.99€ / day')
            </li>
            <li>
                @lang('30 mins per day')
            </li>
            <li>
                @lang('Free Unlock')
            </li>
        </ul>
    </div>

    <div class="self-center">
        @component('components.button', [
            'text' => 'Choisir',
            'type' => 'button',
            'id' => 'pickPackageBtn3',
            'modal' => 'modal-payment'
        ])
        @endcomponent
    </div>

    @if (!Auth::guest())
    <script src="/js/user.packages.js"></script>
    @endif
</div>