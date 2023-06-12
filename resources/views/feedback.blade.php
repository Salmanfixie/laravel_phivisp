<title>Simulation feedback</title>
<x-guest-layout>

    <x-jet-authentication-card>

        <x-slot name="logo">
            <a href="https://www.maybank.com/" class="flex items-center justify-center">
                <span class="text-4xl font-bold text-black-700">PHIVISP</span>
            </a>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('feedback_data') }}">
            @csrf

            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block" style="background-color: green; color: white;">
                <button type="button" class="close" data-dismiss="alert"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 mx-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg></button>
                <strong>{{ $message }}</strong>
            </div>

            @endif

            <div>
                <center><strong>Feedback Form</strong></center>
            </div>

            <div class="mt-4 relative">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-2 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2c-3.866 0-7 3.134-7 7 0 3.275 2.207 6.032 5.21 6.899-.04-.351-.061-.71-.061-1.083 0-2.757 2.243-5 5-5s5 2.243 5 5c0 .372-.021.732-.061 1.083 3.004-.867 5.21-3.624 5.21-6.899 0-3.866-3.134-7-7-7zm0 2c2.757 0 5 2.243 5 5 0 1.938-1.144 3.625-2.912 4.394C14.905 13.922 13.706 14 12 14s-2.905-.078-4.088-.606C6.144 12.625 5 10.938 5 9c0-2.757 2.243-5 5-5zm0 9c1.93 0 3.5 1.57 3.5 3.5S13.93 20 12 20s-3.5-1.57-3.5-3.5S10.07 11 12 11z" />
                        </svg>
                    </span>
                    <x-jet-input id="name" class="pl-8 block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>
            </div>

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-2 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M0 3.727V20.27C0 21.222.777 22 1.727 22h20.545c.95 0 1.728-.778 1.728-1.728V3.727c0-.951-.778-1.728-1.728-1.728H1.727C.777 2 .001 2.777.001 3.727zm22.091 0v1.091l-10.91 7.455-10.91-7.455V3.727h21.82zM1.727 5.454L12 12.455l10.273-7.001v12.364H1.727V5.454zm10.364 7.455L24 20.27V5.454l-11.91 7.727z" />
                        </svg>
                    </span>
                    <x-jet-input id="email" class="pl-8 block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="name" />
                </div>
            </div>

            <div class="mt-4 relative">
                <x-jet-label for="comments" value="{{ __('Comments') }}" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-2 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2c-5.514 0-10 4.486-10 10 0 5.514 4.486 10 10 10 5.514 0 10-4.486 10-10 0-5.514-4.486-10-10-10zm0 18c-4.411 0-8-3.589-8-8 0-4.411 3.589-8 8-8 4.411 0 8 3.589 8 8 0 4.411-3.589 8-8 8zm2-13h-4v6h4v-6zm0 8h-4v2h4v-2z" />
                        </svg>
                    </span>
                    <x-jet-input id="comments" class="pl-8 block mt-1 w-full" type="text" name="comments" :value="old('comments')" required autofocus autocomplete="name" />
                </div>
            </div>

            <div class="mt-4 relative">
                <x-jet-label for="rating" value="{{ __('Rating') }}" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-2 flex items-center">
                        <!-- Replace the existing SVG with the desired rating icon -->
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2c-5.514 0-10 4.486-10 10 0 5.514 4.486 10 10 10 5.514 0 10-4.486 10-10 0-5.514-4.486-10-10-10zm0 18c-4.411 0-8-3.589-8-8 0-4.411 3.589-8 8-8 4.411 0 8 3.589 8 8 0 4.411-3.589 8-8 8zm2-13h-4v6h4v-6zm0 8h-4v2h4v-2z" />
                        </svg>
                    </span>
                    <select id="rating" name="rating" class="pl-8 block mt-1 w-full">
                        <!-- Add options for the rating scale from 1 to 5 -->
                        <option value="1: Not beneficial at all">1: Not beneficial at all</option>
                        <option value="2: Somewhat beneficial">2: Somewhat beneficial</option>
                        <option value="3: Beneficial, but not significant">3: Beneficial, but not significant</option>
                        <option value="4: Highly beneficial, would recommend">4: Highly beneficial, would recommend</option>
                        <option value="5: Extremely beneficial, a must recommend">5: Extremely beneficial, a must recommend</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 relative">
                <x-jet-label for="improvement" value="{{ __('Improvement') }}" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-2 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2c-5.514 0-10 4.486-10 10 0 5.514 4.486 10 10 10 5.514 0 10-4.486 10-10 0-5.514-4.486-10-10-10zm0 18c-4.411 0-8-3.589-8-8 0-4.411 3.589-8 8-8 4.411 0 8 3.589 8 8 0 4.411-3.589 8-8 8zm2-13h-4v6h4v-6zm0 8h-4v2h4v-2z" />
                        </svg>
                    </span>
                    <x-jet-input id="improvement" class="pl-8 block mt-1 w-full" type="text" name="improvement" :value="old('improvement')" required autofocus autocomplete="name" />
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="terms">
                    <div class="flex items-center">
                        <x-jet-checkbox name="terms" id="terms" required />
                        <div class="ml-2">
                            {!! __('I confirm that all the information provided is correct',) !!}
                        </div>
                    </div>
                </x-jet-label>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-jet-button class="ml-4">
                    {{ __('Submit') }}
                </x-jet-button>
            </div>
        </form>

    </x-jet-authentication-card>
</x-guest-layout>