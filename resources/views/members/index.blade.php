<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Članovi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('add_member') }}" class="m-2 p-2 text-xl flex items-center justify-end text-purple-700 hover:text-purple-900 font-semibold">Dodaj člana</a>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-6">
                    <h1 class="text-xl mb-4 text-center text-gray-800 font-semibold">Lista članova</h1>
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif
                    <hr class="border-gray-200 mb-0"/>
                    @forelse ($members as $member)
                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-4 min-w-0 flex-1">
                            @if($member->profile_photo_url)
                                <img src="{{ $member->profile_photo_url }}" alt="" class="w-12 h-12 rounded-full object-cover flex-shrink-0" width="48" height="48">
                            @else
                                @php
                                    $words = preg_split('/\s+/', trim($member->name), 2);
                                    $initials = isset($words[1])
                                        ? strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1))
                                        : strtoupper(mb_substr($member->name, 0, 2));
                                @endphp
                                <div class="w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center text-white font-semibold text-sm" style="background-color: #7c3aed;">
                                    {{ $initials }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800">{{ $member->name }}</p>
                                <p class="text-sm text-gray-600">
                                    Broj članarine #{{ 1000 + $member->id }} | Plan: {{ $member->latestBooking && $member->latestBooking->plan ? $member->latestBooking->plan->name : '—' }} |
                                </p>
                                <p class="text-sm text-gray-600">
                                    Težina: {{ $member->weight_kg !== null && $member->weight_kg !== '' ? $member->weight_kg : '—' }} kg | Visina: {{ $member->height_cm !== null && $member->height_cm !== '' ? $member->height_cm : '—' }} cm
                                </p>
                            </div>
                        </div>
                        @if(auth()->user() && auth()->user()->role === 'admin')
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <form method="POST" action="{{ route('delete_member') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $member->id }}">
                                    <button type="submit" class="text-sm font-semibold px-4 py-2 rounded text-white uppercase" style="background-color: #e91e63;">
                                        {{ __('Obriši') }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('edit_member') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $member->id }}">
                                    <button type="submit" class="text-sm font-semibold px-4 py-2 rounded text-white uppercase bg-purple-600 hover:bg-purple-700">
                                        {{ __('Uredi') }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('file_add') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $member->id }}">
                                    <button type="submit" class="text-sm font-semibold px-4 py-2 rounded text-white uppercase bg-indigo-600 hover:bg-indigo-700">
                                        {{ __('Dodaj fajl') }}
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    @empty
                    <p class="p-4 text-gray-500">Nema članova još.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
