<x-app-layout>
    <x-slot name="header">
        <div class="md:flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Quizzes') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-lg p-5 md:p-20 mx-2">

                    <!-- If quiz is in progress -->

                    <!-- End if quiz is in progress -->

                    <!-- If showing quiz result -->

                    <!-- End showing quiz result -->

                    <!-- If setup/ view quiz -->
                    @if($setupQuiz)
                    <section class="text-gray-600 mx-auto body-font">
                        <div class="container px-5 py-2 mx-auto">
                            <div class="flex flex-wrap -m-4">
                                <div class="p-4 md:w-1/2 w-full">
                                    <div class="h-full bg-gray-100 p-8 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-5 h-5 text-gray-400 mb-4" viewBox="0 0 975.036 975.036">
                                            <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>
                                        </svg>
                                        <p class="leading-relaxed mb-6">Those who cannot learn from history are doomed to repeat it.</p>
                                        <a class="inline-flex items-center">
                                            <span class="flex-grow flex flex-col">
                                                <span class="title-font font-medium text-gray-900">Author</span>
                                                <span class="inline-block h-1 w-18 rounded bg-indigo-500 mt-2 mb-1"></span>
                                                <span class="text-gray-500 text-sm">George Santayan</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="p-4 md:w-1/2 w-full">
                                    <form wire:submit.prevent="startQuiz">
                                        @csrf
                                        <h2 class="text-gray-900 text-lg font-medium title-font mb-5">Take a Quiz</h2>
                                        <div class="relative mx-full mb-4">
                                            <select name="quiz" id="quiz_id" class="block w-full mt-1 rounded-md bg-gray-100 border-2 border-gray-500 focus:bg-white focus:ring-0">
                                                @if($quizzes->isEmpty())
                                                <option value="">No Quiz Available Yet</option>
                                                @else
                                                <option value="">Select a Quiz</option>
                                                @foreach($quizzes as $quiz)
                                                @if($quiz->questions_count>0)
                                                <option value="{{$quiz->id}}">{{$quiz->name}}</option>
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input wire:model="learningMode" id="learningMode" name="learningMode" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="learningMode" class="font-medium text-gray-700">Learning Mode?</label>
                                                <p class="text-gray-500">If checked, this will enable explanation tab for each question.</p>
                                            </div>
                                        </div>
                                        <div class="relative mb-4">
                                            <select name="quiz_size" id="quiz_size" wire:model="quizSize" class="max-w-full block w-full mt-1 rounded-md bg-gray-100 border-2 border-gray-500 focus:bg-white focus:ring-0">
                                                @for ($i = 1; $i <= 50; $i++) <option value="{{ $i }}">{{ $i }}</option> @endfor
                                            </select>
                                            @error('quizSize') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <button type="submit" class="block w-full text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Start Quiz</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    @endif
                    <!-- End setup/ view quiz -->
                </div>
        </div>
    </div>


</x-app-layout>