<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dodaj trening') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-6">
                    <x-jet-validation-errors class="mb-4" />
                    <form method="POST" action="{{ route('store_workout') }}">
                        @csrf
                        <div>
                            <x-jet-label for="member" value="{{ __('Član') }}" />
                            <select id="member" name="member" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200" required>
                                <option value="">Izaberi člana</option>
                                @foreach($members as $m)
                                <option value="{{ $m->id }}" {{ old('member') == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="trainer" value="{{ __('Trener') }}" />
                            <select id="trainer" name="trainer" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200" required>
                                <option value="">Izaberi trenera</option>
                                @foreach($trainers as $t)
                                <option value="{{ $t->id }}" {{ old('trainer') == $t->id ? 'selected' : '' }}>{{ $t->name }} {{ $t->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="date" value="{{ __('Datum i vrijeme') }}" />
                            <x-jet-input id="date" class="block mt-1 w-full" type="datetime-local" name="date" value="{{ old('date', now()->format('Y-m-d\TH:i')) }}" required />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="grade" value="{{ __('Intenzitet/Ocjena (1-5)') }}" />
                            <x-jet-input id="grade" class="block mt-1 w-full" type="number" min="1" max="5" name="grade" :value="old('grade')" required />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="description" value="{{ __('Napomene') }}" />
                            <textarea id="description" name="description" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200">{{ old('description') }}</textarea>
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
