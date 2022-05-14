<!-- Main modal -->
<div id="modal-creation" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                    creation
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="modal-creation">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>
            <!-- Modal body -->
            <div id="modal-creation-body" class="p-6 space-y-6 h-96 overflow-y-auto">
                @component('components.inputfield', [
                    'text' => 'Name',
                    'icon' => 'password',
                    'name' => 'name',
                    'type' => 'text',
                    'id' => 'modal-creation-name',
                ])
                @endcomponent

                @component('components.inputfield', [
                    'text' => 'Price',
                    'icon' => 'password',
                    'name' => 'status',
                    'type' => 'text',
                    'id' => 'modal-creation-price'
                ])
                @endcomponent

                @component('components.inputfield', [
                    'text' => 'Description',
                    'icon' => 'password',
                    'name' => 'description',
                    'type' => 'text',
                    'id' => 'modal-creation-description'
                ])
                @endcomponent

                @component('components.inputfield', [
                    'text' => 'Stock',
                    'icon' => 'password',
                    'name' => 'stock',
                    'type' => 'text',
                    'id' => 'modal-creation-stock'
                ])
                @endcomponent
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