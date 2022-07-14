<header class="h-1/5">

@php
    $langs = [
        [
            "flag" => "us",
            "lang" => "English (US)"
        ],
        [
            "flag" => "fr",
            "lang" => "Français"
        ],
        [
            "flag" => "de",
            "lang" => "Deutsch"
        ],
        [
            "flag" => "es",
            "lang" => "Español"
        ],
        [
            "flag" => "it",
            "lang" => "Italiano"
        ],
        [
            "flag" => "pt",
            "lang" => "Português"
        ],
        [
            "flag" => "ru",
            "lang" => "Русский"
        ],
        [
            "flag" => "tr",
            "lang" => "Türkçe"
        ],
        [
            "flag" => "cn",
            "lang" => "China"
        ]
    ];
@endphp
<nav class="bg-white border-gray-200 shadow-md px-2 sm:px-4 py-2.5 rounded dark:bg-gray-900">
  <div class="container flex flex-wrap justify-between items-center mx-auto">
    <h2 class="flex items-center">
        <img src="/img/logo4.png" class="mr-3 h-6 sm:h-9" alt="">
        <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">URent</span>
    </h2>
    <div class="flex items-center md:order-2">
        <button type="button" data-dropdown-toggle="language-dropdown-menu" class="inline-flex justify-center items-center p-2 text-sm text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
          @foreach ($langs as $lang)
                @if ($lang['flag'] == App::getLocale())
            <img class="h-8 w-8 mr-2" src="https://flagicons.lipis.dev/flags/4x3/{{ $lang["flag"] }}.svg" alt="">
            {{ $lang["lang"] }}
                @endif
          @endforeach
        </button>
        <!-- Dropdown -->
        <div class="z-50 my-4 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 hidden" id="language-dropdown-menu" data-popper-placement="bottom" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(664px, 76px);">
          <ul class="py-1" role="none">
            @foreach ($langs as $lang)
            <li>
              <a href="{{ route('setlang', $lang["flag"]) }}"class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                <div class="inline-flex items-center">
                    <img class="h-8 w-8 mr-2" src="https://flagicons.lipis.dev/flags/4x3/{{ $lang["flag"] }}.svg" alt="">
                  {{ $lang["lang"] }}
                </div>
              </a>
            </li>
            @endforeach
          </ul>
        </div>
        <button data-collapse-toggle="mobile-menu-language-select" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-language-select" aria-expanded="false">
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
        <svg class="hidden w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </button>
    </div>
    <div class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1" id="mobile-menu-language-select">
      <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">
        <li>
          <a href="/" class="
          @if (Request::is('/'))
          md:text-red-700
          @else
          md:text-gray-700
          @endif
          block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('Home') }}</a>
        </li>

        <li>
          <a href="{{ route('dashboard') }}" class="
          @if (Request::is('dashboard*'))
          md:text-red-700
          @else
          md:text-gray-700
          @endif
          block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('Dashboard') }}</a>
        </li>
        <li>
          <a href="#" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('About us') }}</a>
        </li>
        <li>
          <a href="http://demo.scrypteur.com" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Demo</a>
        </li>

        <li>
          <a href="{{ route('catalogue') }}" class="
          @if (Request::is('catalogue*'))
          md:text-red-700
          @else
          md:text-gray-700
          @endif
          block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Catalogue</a>
        </li>

        @auth
          <li>
            <a href="{{ route('logout') }}" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">{{ __('Sing out') }}</a>
          </li>
        @else
          <li>
            <a href="{{ route('login') }}" class="
            @if (Request::is('login*'))
            md:text-red-700
            @else
            md:text-gray-700
            @endif
            block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Login</a>
          </li>
          <li>
            <a href="{{ route('register') }}" class="
            @if (Request::is('register*'))
            md:text-red-700
            @else
            md:text-gray-700
            @endif
            block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-red-700 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Register</a>
          </li>
        @endauth

      </ul>
    </div>
    </div>
  </nav>
</header>

<aside id="notif-snackbar" class="mdc-snackbar">
    <div class="mdc-snackbar__surface" role="status" aria-relevant="additions">
      <div class="mdc-snackbar__label" aria-atomic="false">
        Can't send photo. Retry in 5 seconds.
      </div>
      <div class="mdc-snackbar__actions" aria-atomic="true">
        <button type="button" class="mdc-button mdc-snackbar__action">
          <div class="mdc-button__ripple"></div>
          <span class="mdc-button__label">Retry</span>
        </button>
      </div>
    </div>
  </aside>

@include('dialogs.yesno')
