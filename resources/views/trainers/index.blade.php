<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Treneri') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('add_trainer') }}" class="m-2 p-2 text-xl flex justify-end text-purple-700 hover:text-purple-900 font-semibold">Dodaj trenera</a>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-2">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">{{ session('status') }}</div>
                    @endif
                    <h1 class="font-xl mb-4 text-gray-800">Lista trenera</h1>
                    @forelse ($trainers as $trainer)
                    <div class="p-2 border-b flex justify-between items-center hover:bg-purple-50 transition-colors">
                        <div>
                            <p class="font-semibold text-gray-800"><a href="{{ route('trainers.show', $trainer->id) }}" class="text-purple-600 hover:underline">{{ $trainer->name }} {{ $trainer->lastname }}</a></p>
                            <p class="text-sm text-gray-600">Nivo: {{ $trainer->level ?? 0 }} - {{ $trainer->description ?? '-' }}</p>
                        </div>
                        @if(auth()->user() && auth()->user()->role === 'admin')
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('edit_trainer') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $trainer->id }}">
                                    <button type="submit" class="px-3 py-1 text-white text-xs rounded" style="background-color: #7c3aed;">Uredi</button>
                                </form>
                                <form method="POST" action="{{ route('delete_trainer') }}" class="inline" onsubmit="return confirm('Obrisati ovog trenera?');">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $trainer->id }}">
                                    <button type="submit" class="px-3 py-1 text-white text-xs rounded" style="background-color: #e91e63;">Obriši</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    @empty
                    <p class="p-4 text-gray-500">Nema trenera još.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
