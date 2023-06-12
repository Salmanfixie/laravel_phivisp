<x-filament::page>
    <form wire:submit.prevent="submitAnswer">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- question name -->
                <x-filament::card class="w-full mb-6 sm:flex  justify-between p-6 bg-white sm:rounded-lg shadow dark:bg-gray-800">

                    <!-- question image -->
                    @if(!empty($questionImage))
                    <div class="flex-shrink-0 mr-4">
                        <img class="h-64 w-64 object-cover rounded-md mx-auto my-4" src="{{ Storage::disk('question')->url($questionImage) }}" alt="Question Image">
                    </div>
                    @endif

                    <h3 class="text-gray-900 text-lg font-medium flex-shrink-1">
                        <span class="flex ">
                            <span class="dark:text-white">
                                {{ $question }}
                            </span>

                            <!-- for showing question results -->
                            @if($this->optionIsCorrect === 1)
                            <span class="text-green-500 font-bold inline-block ml-1 -mb-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </span>
                            @elseif($this->optionIsCorrect === 0)
                            <span class="text-red-500 font-bold inline-block ml-1 -mb-1 ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            @endif
                        </span>
                    </h3>
                </x-filament::card>

                <!-- for showing answer explanation -->
                @if(!empty($optionExplanation))
                <div class="w-full mt-6 mb-6 p-6 sm:rounded-lg shadow {{ $this->optionIsCorrect === 1 ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' : 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900' }}">
                    <strong>Explanation:</strong> {{ $this->optionExplanation }}
                </div>
                @endif

                <fieldset>
                    <div class="bg-white sm:rounded-md -space-y-px dark:bg-gray-800">
                        <label class="border-gray-200 dark:border-gray-600  border-gray-200 sm:rounded-tl-md sm:rounded-tr-md relative border p-4 flex items-center relative border p-4 flex items-center cursor-pointer">
                            {{ $this->form }}
                        </label>
                    </div>
                </fieldset>

                <div class="w-full mt-6 text-center text-gray-400 text-sm">
                    <strong>Tip: {{ $answered }} questions have already been answered!</strong>
                </div>

                <div class="w-full mt-6 flex items-center justify-between p-6 bg-white sm:rounded-lg shadow dark:bg-gray-800">
                    <button wire:click="previous" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                        <span wire:loading.remove wire:target="">
                            Previous
                        </span>
                    </button>
                    <button type="submit" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                        <span wire:loading.remove wire:target="">
                            Submit
                        </span>
                    </button>
                    <button wire:click="continue" type="button" wire:loading.attr="disabled" :disabled="$buttonDisabled" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                        <span wire:loading.remove wire:target="">
                            Next
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-filament::page>