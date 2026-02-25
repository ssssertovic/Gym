<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Nova rezervacija treninga') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-6">
                    <x-jet-validation-errors class="mb-4" />
                    <form method="POST" action="{{ route('bookings.store') }}">
                        @csrf
                        <div>
                            <x-jet-label for="plan_id" value="{{ __('Plan') }}" />
                            <select id="plan_id" name="plan_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200" required>
                                <option value="">Izaberi plan</option>
                                @foreach($plans as $p)
                                    <option value="{{ $p->id }}" {{ old('plan_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ number_format($p->price ?? 0, 2) }} KM)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="trainer_id" value="{{ __('Trener') }}" />
                            <select id="trainer_id" name="trainer_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200" required>
                                <option value="">Izaberi trenera</option>
                                @foreach($trainers as $t)
                                    <option value="{{ $t->id }}" {{ old('trainer_id') == $t->id ? 'selected' : '' }}>{{ $t->name }} {{ $t->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="scheduled_at" value="{{ __('Datum i vrijeme') }}" />
                            <x-jet-input id="scheduled_at" class="block mt-1 w-full" type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" required min="{{ now()->addHour()->format('Y-m-d\TH:i') }}" />
                            <p class="text-xs text-gray-500 mt-1">Rezervacija mora biti u budućnosti.</p>
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="notes" value="{{ __('Napomene (opcionalno)') }}" />
                            <textarea id="notes" name="notes" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200">{{ old('notes') }}</textarea>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('bookings.index') }}" class="mr-4 text-gray-600 hover:text-gray-800">Odustani</a>
                            <x-jet-button type="submit" style="background-color: #7c3aed;">{{ __('Rezerviši') }}</x-jet-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
