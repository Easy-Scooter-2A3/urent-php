<!-- Main modal -->
<div id="modal-payment" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                    Payment
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="modal-payment">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
            </div>
            <!-- Modal body -->
            <div id="modal-payment-body" class="p-6 space-y-6 h-96 overflow-y-auto">

                <div id="payment-cardlist" class="flex flex-col">
                    @php
                        $cards = Auth::user()->paymentMethods();
                    @endphp
                    @if (count($cards) > 0)
                    @foreach (Auth::user()->paymentMethods() as $pm)
                    <div class="mdc-form-field">
                        <div class="mdc-checkbox">
                            <input paymentMethod={{ $pm->id }} name="payment-card" type="checkbox" class="mdc-checkbox__native-control" id="checkbox-{{ $pm->id }}" />
                            <div class="mdc-checkbox__background">
                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                </svg>
                                <div class="mdc-checkbox__mixedmark"></div>
                            </div>
                            <div class="mdc-checkbox__ripple"></div>
                        </div>
                        <label for="checkbox-{{ $pm->id }}">
                            <img class="h-5" src="{{ asset('/img/'.$pm->card->brand.'.svgz') }}" alt="{{ $pm->card->brand }}">
                            XXXX XXXX XXXX {{ $pm->card->last4 }}   -   {{ $pm->card->exp_month." / ".$pm->card->exp_year }}
                        </label>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center">
                        <p class="text-gray-500">You have no saved cards</p>
                        {{-- <a href="{{ route('payment.add') }}" class="btn btn-primary">Add a card</a> --}}
                    @endif
                </div>

                {{-- @foreach (Auth::user()->paymentMethods() as $pm)
                    {{ $pm->id }}

                @endforeach --}}
                {{-- <div id="modal-payment-body-container">
                    
                </div> --}}
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 rounded-b border-t border-gray-200 dark:border-gray-600">
                @component('components.button', [
                    'text' => 'Close',
                    'type' => 'button',
                    'id' => 'closeModalBtn',
                    'modal' => 'modal-payment',
                ])
                @endcomponent
                @component('components.button', [
                    'text' => 'Pay',
                    'type' => 'button',
                    'id' => 'confirmPayBtn',
                ])
                @endcomponent
            </div>
        </div>
    </div>
</div>