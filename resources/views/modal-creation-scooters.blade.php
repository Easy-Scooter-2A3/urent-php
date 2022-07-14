<!-- Main modal -->
<div id="modal-creation" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                    Creation
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="modal-creation">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>
            <!-- Modal body -->
            <div id="modal-creation-body" class="p-6 h-40 overflow-y-auto w-100">
                <div class="flex justify-evenly border">
                    @component('components.inputfield', [
                        'text' => 'Quantity',
                        'icon' => 'password',
                        'name' => 'quantity',
                        'type' => 'number',
                        'min' => '1',
                        'max' => '20',
                        'id' => 'modal-creation-quantity',
                    ])
                    @endcomponent

                    <div id="modal-creation-model" data-mdc-auto-init="MDCSelect" class="mdc-select mdc-select--filled demo-width-class">
                        <div class="mdc-select__anchor"
                            role="button"
                            aria-labelledby="demo-label demo-selected-text">
                        <span class="mdc-select__ripple"></span>
                        <span id="demo-label" class="mdc-floating-label">Select a model</span>
                        <span class="mdc-select__selected-text-container">
                            <span id="demo-selected-text" class="mdc-select__selected-text"></span>
                        </span>
                        <span class="mdc-select__dropdown-icon">
                            <svg
                                class="mdc-select__dropdown-icon-graphic"
                                viewBox="7 10 10 5" focusable="false">
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
                        <span class="mdc-line-ripple"></span>
                        </div>
                    
                        <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth">
                        <ul class="mdc-list" role="listbox" aria-label="Food picker listbox">
                            <li class="mdc-list-item mdc-list-item--selected" aria-selected="true" data-value="" role="option">
                            <span class="mdc-list-item__ripple"></span>
                            </li>
                            @foreach (["Sonic", "Tesla"] as $item)
                            <li class="mdc-list-item" aria-selected="false" data-value="{{ $item }}" role="option">
                                <span class="mdc-list-item__ripple"></span>
                                <span class="mdc-list-item__text">
                                    {{ $item }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
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
                    'modal' => 'modal-creation',
                ])
                @endcomponent
                @component('components.button', [
                    'text' => 'Confirm',
                    'type' => 'button',
                    'id' => 'confirmCreationBtn',
                    'modal' => 'modal-creation',
                ])
                @endcomponent
            </div>
        </div>
    </div>
</div>