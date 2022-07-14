@include('head')
@include('header')

<body>
    <div class="flex darkBackground text-white h-4/5 p-10">
        <div class="flex">
            <div class="w-3/6 md:ml-36 ml-0">
                <p class="text-xl">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas amet quo libero architecto doloribus</p>
                <h2>Desc</h2>
                <br>
                @component('components.button', [
                    'text' => 'Get started',
                    'type' => 'button',
                ])
                @endcomponent
            </div>
        </div>
        <div class="flex justify-around w-2/4 items-center text-white">
            <img src="/img/trot.png" alt="logo" class="hidden md:block w-1/2">
        </div>
    </div>

    <div class="flex justify-center pt-7">
        <div class="w-2/6 text-center">
            <h2 class="font-bold text-red-600">Forfaits</h2>
            <p class="text-lg">Lorem ipsum dolor sit amet, consectetur adipliscing elit</p>
        </div>
    </div>
    <div class="flex flex-col md:flex-row">
        @include('user.dashboard-packages')
    </div>
    <div class="darkBackground text-white h-4/5 p-10">
        <div class="text-center">
            <h2 class="text-red-600">Application</h2>
            <p class="text-lg ">Lorem ipsum dolor sit amet, consectetur adipliscing elit</p>
        </div>
        <div class="flex w-2/4 mx-auto text-white mt-10 justify-evenly">
            <div>
                <img src="/img/iphone7.webp" alt="logo" class="w-1/2">
            </div>
            <div class="grid pb-36 ml-40 mt-20 absolute">
                @foreach (["Locate", "Unlock", "Drive"] as $item)
                <div class="mdc-touch-target-wrapper mt-24">
                    <div class="mdc-radio mdc-radio--touch">
                        <input class="mdc-radio__native-control" type="radio" id="radio-{{ $item }}" name="radios" checked>
                        <div class="mdc-radio__background">
                            <div class="mdc-radio__outer-circle"></div>
                            <div class="mdc-radio__inner-circle"></div>
                            <p class="ml-10">{{ $item }}</p>
                        </div>
                        <div class="mdc-radio__ripple"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="flex justify-evenly darkBackground">
        <div class="flex flex-col w-10/12">
            <a href="#">
                <img src="/img/googleplay.png" class="w-72" alt="">
            </a>
        </div>
    </div>
</body>
@include('footer')