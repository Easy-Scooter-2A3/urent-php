@include('modal-payment')

<div class="p-4 gap-3 xl:w-2/12 lg:w-1/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md justify-between">
    <h1 class="text-center text-2xl">Pay as you go 
        @if ($current_package == 1)
        <em class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</em>
        @endif
    </h1>

    <div class="mx-5">
        <ul class="list-disc m-4">
            <li>
                Déverrouillage à 1€
            </li>
            <li>
                23 centimes / min
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
    <h1 class="text-center text-2xl">Mensuel
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
                30 min par trajet
            </li>
            <li>
                Déverrouillage gratuit
            </li>
        </ul>
    
    
        {{-- <ul class="list-decimal m-4">
            <li>
                8 trajets à 19.99€
            </li>
            <li>
                25 trajets à 44.99€
            </li>
            <li>
                50 trajets à 79.99€
            </li>
        </ul> --}}

        <div class="flex">
            <form action="#">
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
                        {{ $nb[$i-1] }} trajets à {{ $prices[$i-1] }} €
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
    <h1 class="text-center text-2xl">Journalier
        @if ($current_package == 3)
        <em class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</em>
        @endif
    </h1>

    <div class="mx-5">
        <ul class="list-disc m-4">
            <li>
                Tarif: 9.99€ / jour
            </li>
            <li>
                30 min par jour
            </li>
            <li>
                Déverrouillage gratuit
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


    <script src="/js/user.packages.js"></script>
</div>