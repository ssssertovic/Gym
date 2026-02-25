<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj člana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-6">
                    <x-jet-validation-errors class="mb-4" />
                    <form method="POST" action="{{ route('store_member') }}">
                        @csrf
                        <div>
                            <x-jet-label for="name" value="{{ __('Ime') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="email" value="{{ __('Email') }}" />
                            <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="password" value="{{ __('Lozinka') }}" />
                            <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="height_cm" value="{{ __('Visina (cm)') }}" />
                            <x-jet-input id="height_cm" class="block mt-1 w-full" type="number" name="height_cm" :value="old('height_cm')" />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="weight_kg" value="{{ __('Težina (kg)') }}" />
                            <x-jet-input id="weight_kg" class="block mt-1 w-full" type="number" step="0.01" name="weight_kg" :value="old('weight_kg')" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-jet-button class="ml-4" style="background-color: #7c3aed; hover:background-color: #6d28d9;">
                                {{ __('Sačuvaj') }}
                            </x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
