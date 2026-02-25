<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dodaj plan') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-6">
                    <x-jet-validation-errors class="mb-4" />
                    <form method="POST" action="{{ route('store_plan') }}">
                        @csrf
                        <div>
                            <x-jet-label for="name" value="{{ __('Naziv plana') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="price" value="{{ __('Cijena (KM)') }}" />
                            <x-jet-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price')" required />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="duration_days" value="{{ __('Trajanje (dana)') }}" />
                            <x-jet-input id="duration_days" class="block mt-1 w-full" type="number" name="duration_days" :value="old('duration_days', 30)" />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="description" value="{{ __('Opis') }}" />
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-jet-button class="ml-4" style="background-color: #7c3aed;">{{ __('Sačuvaj') }}</x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
