@include('head')
@include('header')

<body>
    <div class="flex justify-between border darkBackground text-white h-4/5">
        <div class="w-2/4">
            <div class="w-3/6 ml-36">
                <p class="text-xl">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas amet quo libero architecto doloribus</p>
                <h2>Desc</h2>
                <br>
                <button class="p-4 border-2 border-red-600">Get started</button>
            </div>
        </div>
        <div class="flex justify-around w-2/4 items-center text-white">
        </div>
    </div>

    <div class="flex justify-center">
        <div class="w-2/6 text-center">
            <h2 class="text-red-600">Forfaits</h2>
            <p class="text-lg">Lorem ipsum dolor sit amet, consectetur adipliscing elit</p>
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