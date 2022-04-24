@include('head')
@include('header')

<body>
    <div class="flex darkBackground text-white h-4/5 p-10">
        <div class="flex">
            <div class="w-3/6 ml-36">
                <p class="text-xl">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas amet quo libero architecto doloribus</p>
                <h2>Desc</h2>
                <br>
                <button class="p-4 border-2 border-red-600">Get started</button>
            </div>
        </div>
        <div class="flex justify-around w-2/4 items-center text-white">
            <img src="/img/trot.jpg" alt="logo" class="w-1/2">
        </div>
    </div>

    <div class="flex justify-center pt-7">
        <div class="w-2/6 text-center">
            <h2 class="font-bold text-red-600">Forfaits</h2>
            <p class="text-lg">Lorem ipsum dolor sit amet, consectetur adipliscing elit</p>
        </div>
    </div>
    <div class="my-7 flex justify-evenly">
        @php
        $packages = [
            'Forfait 1' => [
                "Prix :" => 10,
                "Status :" => "Valide",
            ],
            'Forfait 2' => [
                "Prix : " => 10,
                "Status :" => "Valide",
            ],
            'Forfait 3' => [
                "Prix :" => 10,
                "Status :" => "Valide",
            ],
        ];
        @endphp
        <?php
        foreach ($packages as $key => $package) { ?>
            <div class="border text-center p-7 bg-gray-300">
                <div>
                    <h5 class="font-bold"><?php echo $key ?> :</h5>
                </div>
                <?php foreach ($package as $key => $val) { ?>
                    <div class="flex my-4">
                        <span class="font-bold"><?php echo $key ?></span>
                        <p>
                            <?php if ($key == "Prix : ") {
                                echo $val . " €";
                            } else {
                                echo $val;
                            } ?>
                        </p>
                    </div>
                <?php } ?>
                <button class="mdc-button mdc-button--raised mt-4">
                    <span class="mdc-button__label">Acheter</span>
                </button>
            </div>
        <?php } ?>
    </div>
    <div class="darkBackground text-white h-4/5 p-10">
        <div class=" text-center">
            <h2 class="text-red-600">Application</h2>
            <p class="text-lg ">Lorem ipsum dolor sit amet, consectetur adipliscing elit</p>
        </div>
        <div class="flex w-2/4 ml-36 text-white mt-10">
            <div>
                <img src="/img/trot.jpg" alt="logo" class="w-1/2">
            </div>
            <div class="grid pb-36">
                <div class="mdc-touch-target-wrapper">
                    <div class="mdc-radio mdc-radio--touch">
                        <input class="mdc-radio__native-control" type="radio" id="radio-1" name="radios" checked>
                        <div class="mdc-radio__background">
                            <div class="mdc-radio__outer-circle"></div>
                            <div class="mdc-radio__inner-circle"></div>
                            <p class="ml-10">Locate</p>
                        </div>
                        <div class="mdc-radio__ripple"></div>
                    </div>
                </div>
                <div class="vertical-line" style="height: 45px;"></div>
                <div class="mdc-touch-target-wrapper">
                    <div class="mdc-radio mdc-radio--touch">
                        <input class="mdc-radio__native-control" type="radio" id="radio-1" name="radios" checked>
                        <div class="mdc-radio__background">
                            <div class="mdc-radio__outer-circle"></div>
                            <div class="mdc-radio__inner-circle"></div>
                            <p class="ml-10">Unlock</p>
                        </div>
                        <div class="mdc-radio__ripple"></div>
                    </div>
                </div>
                <div class="vertical-line" style="height: 45px;"></div>
                <div class="mdc-touch-target-wrapper">
                    <div class="mdc-radio mdc-radio--touch">
                        <input class="mdc-radio__native-control" type="radio" id="radio-1" name="radios" checked>
                        <div class="mdc-radio__background">
                            <div class="mdc-radio__outer-circle"></div>
                            <div class="mdc-radio__inner-circle"></div>
                            <p class="ml-10">Drive</p>
                        </div>
                        <div class="mdc-radio__ripple"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="darkBackground text-white h-4/5 p-10">
        <div class=" text-center">
            <p class="text-lg ">BLA BLA BLA BLA</p>
        </div>
    </div>

    <!-- CAROUSEL -->

    <!-- <form action="/osef" method="POST">
    @method('POST')
    @csrf
    <input type="text" name="name" value="">
    <input type="submit" value="Submit">
</form> -->

</body>
@include('footer')