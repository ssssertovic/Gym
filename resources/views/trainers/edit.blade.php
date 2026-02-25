<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Uredi trenera') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-6">
                    <x-jet-validation-errors class="mb-4" />
                    @foreach($trainers as $trainer)
                    <form method="POST" action="{{ route('update_trainer') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$trainer->id}}"/>
                        <div>
                            <x-jet-label for="name" value="{{ __('Ime') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $trainer->name) }}" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="lastname" value="{{ __('Prezime') }}" />
                            <x-jet-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" value="{{ old('lastname', $trainer->lastname) }}" required />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="level" value="{{ __('Nivo') }}" />
                            <x-jet-input id="level" class="block mt-1 w-full" type="number" name="level" value="{{ old('level', $trainer->level) }}" />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="description" value="{{ __('Opis') }}" />
                            <textarea id="description" name="description" rows="2" class="block mt-1 w-full border-gray-300 focus:border-purple-300 focus:ring focus:ring-purple-200 rounded-md shadow-sm">{{ old('description', $trainer->description) }}</textarea>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-jet-button class="ml-4" style="background-color: #7c3aed;">{{ __('Sačuvaj') }}</x-jet-button>
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
