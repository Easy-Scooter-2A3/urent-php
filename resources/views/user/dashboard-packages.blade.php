<div class="p-4 gap-3 xl:w-2/12 lg:w-1/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md justify-between">
    <h1 class="text-center text-2xl">Pay as you go 
        @if ($current_package == 1)
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>
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
        ])
        @endcomponent
    </div>
</div>

<div class="p-4 gap-3 xl:w-2/12 lg:w-1/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md justify-between">
    <h1 class="text-center text-2xl">Mensuel
        @if ($current_package == 2)
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>
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
    
    
        <ul class="list-decimal m-4">
            <li>
                8 trajets à 19.99€
            </li>
            <li>
                25 trajets à 44.99€
            </li>
            <li>
                50 trajets à 79.99€
            </li>
        </ul>
    </div>

    <div class="self-center">
        @component('components.button', [
            'text' => 'Choisir',
            'type' => 'button',
            'id' => 'pickPackageBtn2',
        ])
        @endcomponent
    </div>
</div>

<div class="p-4 gap-3 xl:w-2/12 lg:w-1/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md justify-between">
    <h1 class="text-center text-2xl">Journalier
        @if ($current_package == 3)
        <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>
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
        ])
        @endcomponent
    </div>
    <script src="/js/user.packages.js"></script>
</div>