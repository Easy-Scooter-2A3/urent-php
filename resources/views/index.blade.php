@include('head')
<header class="h-1/5">
    <div class="flex justify-between darkBackground p-4">
        <img src="/img/logo4.png" alt="logo">
        <div class="flex justify-end w-3/5 items-center text-white">
            <!-- <a class="hover:text-red-600" href="/#todo">
                <h3>HOME</h3>
            </a>
            <a class="hover:text-red-600" href="/#todo">
                <h3>Application</h3>
            </a>
            <a class="hover:text-red-600" href="/#todo">
                <h3>About us</h3>
            </a> -->

            <ul class="flex">
                <li class="hover:text-red-600 m-2">HOME</li>
                <li class="hover:text-red-600 m-2">Application</li>
                <li class="hover:text-red-600 m-2">About us</li>
                <li>
                    <button id="userDropdownButton" data-dropdown-toggle="userDropdown" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Dropdown header
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </li>
            </ul>

            <!-- Dropdown menu -->
            <div id="userDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                <div class="py-3 px-4 text-sm text-gray-900 dark:text-white">
                    <div>Marcel Patulacci</div>
                    <div class="font-medium truncate">marcel@patulacci.com</div>
                </div>
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                    </li>
                </ul>
                @auth
                <div class="py-1">
                    <a href="{{ route('signout') }}" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                </div>
                @else
                <div class="py-1">
                    <a href="{{ route('login') }}" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Register</a>
                </div>
                @endauth
            </div>

        </div>
    </div>
</header>

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