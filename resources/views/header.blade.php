<header class="h-1/5">
    <div class="flex justify-between darkBackground p-4">
        <a href="/">
            <img width="250" height="250" src="/img/logo4.png" alt="logo">
        </a>
        <div class="flex justify-end w-3/5 items-center text-white">
            
            <ul class="flex gap-9 items-center">
                <li class="hover:text-red-600 m-2">
                    <a href="/">
                        {{ __('Home') }}
                    </a>
                </li>
                <li>
                    <button data-dropdown-toggle="languageDropdown" type="button">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__touch"></span>
                        <span class="mdc-button__label">
                            {{ __('Language') }}
                        {{-- <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg> --}}
                    </button>
                </li>
                <div id="languageDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                   
                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                        
                        <li >
                            <a href="{{ route(Route::currentRouteName(), 'en') }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">EN</a>
                        </li>
                        <li>
                            <a href="{{ route(Route::currentRouteName(), 'fr') }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">FR</a>
                        </li>
                        
                    </ul>
                </div>
                <li class="hover:text-red-600 m-2">Application</li>
                <li class="hover:text-red-600 m-2">{{ __('About us') }}</li>
                
                <li>
                    <button data-dropdown-toggle="userDropdown" type="button">
                        <span class="mdc-button__ripple"></span>
                        <span class="mdc-button__touch"></span>
                        <img class="w-16 h-16 rounded-full"
                        {{ Auth::check() ? 'src=https://images.pexels.com/photos/60597/dahlia-red-blossom-bloom-60597.jpeg?cs=srgb&dl=pexels-pixabay-60597.jpg&fm=jpg' : 'src=https://vistapointe.net/images/unknown-2.jpg' }}
                        alt="Avatar">
                        @if (Auth::check())
                        <div class="relative">
                            <span class="bottom-0 left-12 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                        </div>
                        @endif
                        {{-- <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg> --}}
                    </button>
                </li>
            </ul>

            <!-- Dropdown menu -->
            <div id="userDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                @auth
                <div class="py-3 px-4 text-sm text-gray-900 dark:text-white">
                        <h2>{{ Auth::user()->name }}</h2>
                        <div data-tooltip-target="tooltip-email" class="font-medium truncate">{{ Auth::user()->email }}</div>
                        <div id="tooltip-email" role="tooltip" class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                            {{ Auth::user()->email }}
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                </div>
                @endauth
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                    <li>
                        <a href="{{ route('dashboard', app()->getLocale()) }}" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('Dashboard') }}</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('Settings') }}</a>
                    </li>
                    
                </ul>
                @auth
                <div class="py-1">
                    <a href="{{ route('logout') }}" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">{{ __('Sing out') }}</a>
                </div>
                @else
                <div class="py-1">
                    <a href="{{ route('login', app()->getLocale()) }}" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Login</a>
                    <a href="{{ route('register', app()->getLocale()) }}" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Register</a>
                </div>
                @endauth
            </div>

        </div>
    </div>
</header>