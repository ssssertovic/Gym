<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Treninzi') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('add_workout') }}" class="m-2 p-2 text-xl flex justify-end text-purple-700 hover:text-purple-900 font-semibold">Dodaj trening</a>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-4">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">{{ session('status') }}</div>
                    @endif
                    <h1 class="font-xl mb-4 text-gray-800">Nedavni treninzi</h1>
                    <div class="overflow-x-auto mb-8">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2 text-gray-800">Datum</th>
                                    <th class="text-left py-2 text-gray-800">Član</th>
                                    <th class="text-left py-2 text-gray-800">Trener</th>
                                    <th class="text-left py-2 text-gray-800">Ocjena</th>
                                    <th class="text-left py-2 text-gray-800">Napomene</th>
                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <th class="text-left py-2 text-gray-800">Akcije</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($workouts as $w)
                                <tr class="border-b hover:bg-purple-50 transition-colors">
                                    <td class="py-2">{{ \Carbon\Carbon::parse($w->date)->format('Y-m-d H:i') }}</td>
                                    <td class="py-2">{{ $w->member_name }}</td>
                                    <td class="py-2">{{ $w->trainer_name }} {{ $w->trainer_lastname }}</td>
                                    <td class="py-2">{{ $w->grade }}/5</td>
                                    <td class="py-2 text-sm text-gray-600">{{ Str::limit($w->description ?? '-', 30) }}</td>
                                    @if(auth()->user() && auth()->user()->role === 'admin')
                                        <td class="py-2">
                                            <form method="POST" action="{{ route('delete_workout') }}" class="inline" onsubmit="return confirm('Obrisati ovaj trening?');">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $w->id }}">
                                                <button type="submit" class="text-red-600 text-xs hover:text-red-800" style="color: #e91e63;">Obriši</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                                @empty
                                <tr><td colspan="6" class="py-4 text-gray-500">Nema treninga još.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <h1 class="font-xl mb-4 text-gray-800">Statistika (posljednjih 30 dana)</h1>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="p-4 border rounded" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <h2 class="font-semibold mb-2 text-gray-800">Najaktivniji članovi</h2>
                            @foreach($most_common_members as $m)
                            <p class="text-sm text-gray-700">{{ $m->name }} - {{ $m->brojac }} treninga</p>
                            @endforeach
                        </div>
                        <div class="p-4 border rounded" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <h2 class="font-semibold mb-2 text-gray-800">Najkorišteniji planovi</h2>
                            @foreach($most_common_plans as $p)
                            <p class="text-sm text-gray-700">{{ $p->name }} - {{ $p->brojac }}</p>
                            @endforeach
                        </div>
                        <div class="p-4 border rounded" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <h2 class="font-semibold mb-2 text-gray-800">Treninzi (posljednjih 30 dana)</h2>
                            <p class="text-2xl font-bold text-purple-700">{{ $number_of_workouts }}</p>
                        </div>
                        <div class="p-4 border rounded" style="border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <h2 class="font-semibold mb-2 text-gray-800">Najbolji treneri ovog mjeseca</h2>
                            @foreach($top_trainers_this_month as $t)
                            <p class="text-sm text-gray-700">{{ $t->trainer_name }} {{ $t->trainer_lastname }} - {{ $t->brojac }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
