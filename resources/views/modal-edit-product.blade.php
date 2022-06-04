<!-- Main modal -->
<div id="modal-edit" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                    Edition
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="modal-edit">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>
            <!-- Modal body -->
            <div id="modal-edit-body" class="p-6 space-y-6 h-96 overflow-y-auto">
                <div class="flex flew-row justify-around">
                    <div class="w-5/12 flex flex-col">
                        @component('components.inputfield', [
                            'text' => 'Name',
                            'icon' => 'password',
                            'name' => 'name',
                            'type' => 'text',
                            'id' => 'modal-edit-name',
                        ])
                        @endcomponent

                        @component('components.inputfield', [
                            'text' => 'Price',
                            'icon' => 'password',
                            'name' => 'status',
                            'type' => 'text',
                            'id' => 'modal-edit-price'
                        ])
                        @endcomponent


                        @component('components.button', [
                          'text' => 'Upload',
                          'type' => 'button',
                          'id' => 'uploadEditBtn',
                        ])
                        @endcomponent
                        
                        <p class="text-sm mt-2">Max size: 2mo</p>
                        <p class="text-sm mt-1" hidden id="fileLoadedEdit">File loaded</p>

                        <input hidden type="file" name="image" id="imageEdit">
                      
                    </div>

                    <div class="w-5/12 flex flex-col">
                        
                        @component('components.inputfield', [
                            'text' => 'Stock',
                            'icon' => 'password',
                            'name' => 'stock',
                            'type' => 'text',
                            'id' => 'modal-edit-stock'
                        ])
                        @endcomponent
                        <h2 class="text-xl mt-4">Available
                            <span class="mx-4">
                                @component('components.switch', [
                                    'id' => 'modal-edit-available',
                                ])
                                @endcomponent
                            </span>
                        </h2>
                    </div>
                </div>

                <div class="flex flex-row justify-around">
                    @component('components.inputarea', [
                        'text' => 'Description',
                        'icon' => 'password',
                        'name' => 'description',
                        'type' => 'textarea',
                        'id' => 'modal-edit-description',
                        // 'label' => 'Description'
                    ])
                    @endcomponent
                </div>


                <div class="flex flex-row justify-around">
                    <div class="mdc-data-table">
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

                                <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Attributes</th>
                                <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Desc</th>
                              </tr>
                            </thead>
                            <tbody class="mdc-data-table__content">
                              @foreach ($attributes as $attribute)
                              <tr productattributeParent class="mdc-data-table__row">
                                      
                                <td class="mdc-data-table__cell mdc-data-table__cell--checkbox">
                                    <div class="mdc-checkbox mdc-data-table__row-checkbox">
                                      <input edit productattribute-edit={{ $attribute->id }} type="checkbox" class="mdc-checkbox__native-control" aria-labelledby="u0"/>
                                      <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                          <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                      </div>
                                      <div class="mdc-checkbox__ripple"></div>
                                    </div>
                                </td>

                                <td class="mdc-data-table__cell">{{ $attribute->name }}</td>
                                <td class="mdc-data-table__cell">TODO</td>
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
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                @component('components.button', [
                    'text' => 'Close',
                    'type' => 'button',
                    'id' => 'closeModalBtn',
                    'modal' => 'modal-edit',
                ])
                @endcomponent
                @component('components.button', [
                    'text' => 'Confirm',
                    'type' => 'button',
                    'id' => 'confirmEditBtn',
                    'modal' => 'modal-edit',
                ])
                @endcomponent
            </div>
        </div>
    </div>
</div>