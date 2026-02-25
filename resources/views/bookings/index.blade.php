<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ auth()->user()->role === 'admin' ? __('Sve rezervacije') : __('Moje rezervacije') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->role !== 'admin')
                <a href="{{ route('bookings.create') }}" class="m-2 p-2 text-xl flex items-center justify-end text-purple-700 hover:text-purple-900 font-semibold">Nova rezervacija</a>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-4">
                    @if (session('status'))<div class="mb-4 font-medium text-sm text-green-600">{{ session('status') }}</div>@endif
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2 text-gray-800">Datum i vrijeme</th>
                                    <th class="text-left py-2 text-gray-800">Plan</th>
                                    <th class="text-left py-2 text-gray-800">Trener</th>
                                    @if(auth()->user()->role === 'admin')<th class="text-left py-2 text-gray-800">Korisnik</th>@endif
                                    <th class="text-left py-2 text-gray-800">Napomene</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bookings as $b)
                                <tr class="border-b hover:bg-purple-50 transition-colors">
                                    <td class="py-2">{{ \Carbon\Carbon::parse($b->scheduled_at)->format('d.m.Y H:i') }}</td>
                                    <td class="py-2">{{ $b->plan_name }}</td>
                                    <td class="py-2">{{ $b->trainer_name }} {{ $b->trainer_lastname }}</td>
                                    @if(auth()->user()->role === 'admin')<td class="py-2">{{ $b->user_name ?? '-' }}</td>@endif
                                    <td class="py-2 text-sm text-gray-600">{{ Str::limit($b->notes ?? '-', 40) }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="py-4 text-gray-500">Nema rezervacija.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
