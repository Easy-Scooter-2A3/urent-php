@include('head')
@include('header')

<body class="bg-gray-100">
    
    <div class="m-2 w-11/12 mx-auto">
        @component('components.button', [
            'text' => 'Catalogue',
            'type' => 'button',
            'id' => 'catalogueBtn',
            'href' => route('catalogue', app()->getLocale()),
        ])
        @endcomponent
    </div>

    <div class="m-2 flex flex-col md:flex-row w-11/12 mx-auto justify-between">
        <div class="bg-white drop-shadow-md w-2/12 p-4">
            @component('components.inputfield', [
                'text' => 'Search',
                'icon' => 'search',
                'name' => 'search',
                'type' => 'search',
                'id' => 'searchField',
            ])
            @endcomponent

            <h2 class="text-lg mt-3">Filtres :</h2>

            <div class="flex flex-col">
                @foreach ($attributes as $attribute)
                <div class="mdc-form-field">
                    <div class="mdc-checkbox">
                        <input type="checkbox" class="mdc-checkbox__native-control" attributeId={{ $attribute->id }} id="checkbox-{{ $attribute->id }}" />
                        <div class="mdc-checkbox__background">
                            <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                            </svg>
                            <div class="mdc-checkbox__mixedmark"></div>
                        </div>
                        <div class="mdc-checkbox__ripple"></div>
                    </div>
                    <label for="checkbox-{{ $attribute->id }}">{{ $attribute->name }}</label>
                </div>
                @endforeach
            </div>

        </div>

        <div class="w-9/12">

            <div class="mdc-data-table w-full">
                <div class="mdc-data-table__table-container">
                  <table class="mdc-data-table__table">
                    <thead>
                      <tr class="mdc-data-table__header-row">
                        <th class="mdc-data-table__header-cell" role="columnheader" scope="col">
                          <h2 class="text-lg">Total : <span id="cart-total">{{ $total }}</span> € (Voucher(s) included)</h2>
                        </th>
                        <th class="mdc-data-table__header-cell w-2/6" role="columnheader" scope="col">
                          @component('components.button', [
                            'text' => 'Pay',
                            'type' => 'button',
                            'id' => 'payBtn',
                            'modal' => 'modal-payment',
                          ])
                          @endcomponent
                        </th>
                      </tr>
                    </thead>
                    <tbody id="panier" class="mdc-data-table__content">
                      @foreach ($products as $product)
                      <tr productattributeParent rowid="{{ $product->id }}" class="mdc-data-table__row">
                        <td class="mdc-data-table__cell">
                            <div class="p-3 flex">
                              <img class="h-80" src="{{ asset('storage/images/'.$product->image) }}" alt="">
                              <div class="ml-3 flex flex-col justify-around">
                                  <div>
                                      <h2 class="text-lg ">{{ $product->name }}</h2>
                                      <h2 class="text-slate-400">{{ $product->description }}</h2>
                                      <h2 class="text-lg ">{{ $product->price }} €</h2>
                                  </div>
                                  

                                  <div class="w-4/6">
                                      @component('components.inputfield', [
                                          'text' => 'Quantity',
                                          'icon' => 'search',
                                          'id' => 'productId-'.$product->id.'-quantity',
                                          'name' => 'quantity',
                                          'type' => 'number',
                                          'value' => $quantity[$product->id],
                                          ])
                                      @endcomponent
                                      @component('components.button', [
                                        'text' => 'Set quantity',
                                        'type' => 'button',
                                        'id' => 'setQuantityBtn-'.$product->id,
                                        'customId' => $product->id,
                                      ])
                                      @endcomponent
                                      @component('components.button', [
                                        'text' => 'Remove',
                                        'type' => 'button',
                                        'id' => 'removeBtn-'.$product->id,
                                        'customId' => $product->id,
                                      ])
                                      @endcomponent
                                  </div>
                              </div>
                            </div>
                        </td>
                        {{-- TODO: rework --}}
                        <td class="mdc-data-table__cell">
                            <div class="flex flex-col justify-around">
                              <ul class="list-disc mb-5">
                                  @isset($attributesList[$product->id])
                                      @foreach ($attributesList[$product->id] as $attribute)
                                      <li attr={{ $attributes[$attribute->attribute_id]->id }} class="text-lg">{{ $attributes[$attribute->attribute_id]->name }}</li>
                                      @endforeach
                                  @endisset
                              </ul>
                          </div>
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
                        Rows per page
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
    </div>

    @include('modal-payment')

</body>
<script src="/js/panier.js"></script>