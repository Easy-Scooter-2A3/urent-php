    <div class="relative overflow-x-auto lg:w-full mx-10 my-10">

    <div class="flex flex-row justify-around">
        <div data-mdc-auto-init="MDCDataTable" id="dataTable" class="mdc-data-table w-full">
            <div class="mdc-data-table__table-container">
              <table class="mdc-data-table__table" aria-label="Dessert calories">
                <thead>
                  <tr class="mdc-data-table__header-row">

                    <th class="mdc-data-table__header-cell mdc-data-table__header-cell--checkbox" role="columnheader" scope="col">
                        <div class="mdc-checkbox mdc-data-table__header-row-checkbox mdc-checkbox--selected">
                          <input type="checkbox" class="mdc-checkbox__native-control" aria-label="Toggle all rows"/>
                          <div class="mdc-checkbox__background">
                            <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                              <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                            </svg>
                            <div class="mdc-checkbox__mixedmark"></div>
                          </div>
                          <div class="mdc-checkbox__ripple"></div>
                        </div>
                    </th>

                    @foreach ($cols as $col)
                        <th scope="col" role="columnheader" class="mdc-data-table__header-cell">{{ $col }}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody class="mdc-data-table__content">
                @foreach ($users as $user)
                  <tr id="row-{{ $user->id }}" data-row-id="{{ $user->id }}" isActive="{{ $user->isActive }}" isAdmin="{{ $user->isAdmin }}" useridParent class="mdc-data-table__row">

                    <td class="mdc-data-table__cell mdc-data-table__cell--checkbox">
                        <div class="mdc-checkbox mdc-data-table__row-checkbox">
                        <input type="checkbox" class="mdc-checkbox__native-control"/>
                          <div class="mdc-checkbox__background">
                            <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                              <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                            </svg>
                            <div class="mdc-checkbox__mixedmark"></div>
                          </div>
                          <div class="mdc-checkbox__ripple"></div>
                        </div>
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                        {{ $user->isActive ? 'Active' : 'Inactive' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $user->created_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $user->updated_at }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $user->id }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($user->isAdmin == 1)
                            <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>
                        @else
                            <i class="material-icons mdc-text-fieldfield__icon mdc-text-field__icon--leading text-red-600">clear</i>
                        @endif
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          
            <div class="mdc-data-table__pagination">
              <div class="mdc-data-table__pagination-trailing">
                <div class="mdc-data-table__pagination-rows-per-page">
                  <div class="mdc-data-table__pagination-rows-per-page-label">
                    @lang('Rows per page')
                  </div>
          
                  <div class="mdc-select mdc-select--outlined mdc-select--no-label mdc-data-table__pagination-rows-per-page-select">
                    <div class="mdc-select__anchor" role="button" aria-haspopup="listbox"
                          aria-labelledby="demo-pagination-select" tabindex="0">
                      <span class="mdc-select__selected-text-container">
                        <span id="demo-pagination-select" class="mdc-select__selected-text">10</span>
                      </span>
                      <span class="mdc-select__dropdown-icon">
                        <svg
                            class="mdc-select__dropdown-icon-graphic"
                            viewBox="7 10 10 5">
                          <polygon
                              class="mdc-select__dropdown-icon-inactive"
                              stroke="none"
                              fill-rule="evenodd"
                              points="7 10 12 15 17 10">
                          </polygon>
                          <polygon
                              class="mdc-select__dropdown-icon-active"
                              stroke="none"
                              fill-rule="evenodd"
                              points="7 15 12 10 17 15">
                          </polygon>
                        </svg>
                      </span>
                      <span class="mdc-notched-outline mdc-notched-outline--notched">
                        <span class="mdc-notched-outline__leading"></span>
                        <span class="mdc-notched-outline__trailing"></span>
                      </span>
                    </div>
          
                    <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth" role="listbox">
                      <ul class="mdc-list">
                        <li class="mdc-list-item mdc-list-item--selected" aria-selected="true" role="option" data-value="10">
                          <span class="mdc-list-item__text">10</span>
                        </li>
                        <li class="mdc-list-item" role="option" data-value="25">
                          <span class="mdc-list-item__text">25</span>
                        </li>
                        <li class="mdc-list-item" role="option" data-value="100">
                          <span class="mdc-list-item__text">100</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
          
                <div class="mdc-data-table__pagination-navigation">
                  <div class="mdc-data-table__pagination-total">
                    1‑10 of 100
                  </div>
                  <button class="mdc-icon-button material-icons mdc-data-table__pagination-button" data-first-page="true" disabled>
                    <div class="mdc-button__icon">first_page</div>
                  </button>
                  <button class="mdc-icon-button material-icons mdc-data-table__pagination-button" data-prev-page="true" disabled>
                    <div class="mdc-button__icon">chevron_left</div>
                  </button>
                  <button class="mdc-icon-button material-icons mdc-data-table__pagination-button" data-next-page="true">
                    <div class="mdc-button__icon">chevron_right</div>
                  </button>
                  <button class="mdc-icon-button material-icons mdc-data-table__pagination-button" data-last-page="true">
                    <div class="mdc-button__icon">last_page</div>
                  </button>
                </div>
              </div>
            </div>
          </div>
    </div>

    <div class="gap-3 lg-5/6 md:w-full p-4 m-5 mx-auto flex items-center bg-white drop-shadow-md">
        @component('components.inputfield', [
            'text' => 'Search',
            'icon' => 'search',
            'name' => 'search',
            'type' => 'search',
            'id' => 'searchField',
        ])
        @endcomponent
        @component('components.button', [
            'text' => 'View details',
            'type' => 'button',
            'id' => 'viewDetailsBtn',
            'modal' => 'modal-details',
        ])
        @endcomponent
        @component('components.button', [
            'text' => 'Toggle admin',
            'type' => 'button',
            'id' => 'toggleAdminBtn',
        ])
        @endcomponent
        @component('components.button', [
            'text' => 'Toggle user status',
            'type' => 'button',
            'id' => 'toggleActivationUserBtn',
        ])
        @endcomponent
    </div>
</div>
@include('modal-details')

<template id="modal-details-body-template">
    <div>
        <h2>ID : </h2>
        <h2>Name : </h2>
        <h2>Email : </h2>
        <h2>Email verified at : </h2>
        <h2>MFA activated at : </h2>
        <h2>Date de création : </h2>
        <h2>Date de dernière modification : </h2>
        <h2>Location : </h2>
        <h2>Phone : </h2>
        <h2>Partner code : </h2>
        <h2>Fidelity points : </h2>
        <h2>Credit points : </h2>
        <h2>Is admin : </h2>
        <h2>Is active : </h2>
    </div>
</template>

@csrf
<script src="/js/admin.users.js"></script>
