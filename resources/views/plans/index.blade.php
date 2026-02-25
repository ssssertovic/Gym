<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Planovi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user() && auth()->user()->role === 'admin')
                <a href="{{ route('add_plan') }}" class="m-2 p-2 text-xl flex items-center justify-end text-purple-700 hover:text-purple-900 font-semibold">Dodaj plan</a>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-2">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">{{ session('status') }}</div>
                    @endif
                    <h1 class="font-xl mb-4 text-gray-800">Lista planova</h1>
                    @forelse ($plans as $plan)
                        <div class="p-2 border-b flex justify-between items-start hover:bg-purple-50 transition-colors">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $loop->iteration }}. <a href="{{ route('plans.show', $plan->id) }}" class="text-purple-600 hover:underline">{{ $plan->name }}</a> - {{ number_format($plan->price ?? 0, 2) }} KM</p>
                                @if(!empty($plan->duration_days))
                                    <p class="text-sm text-gray-600">{{ $plan->duration_days }} dana</p>
                                @endif
                                @if(!empty($plan->description))
                                    <p class="text-sm text-gray-600">{{ $plan->description }}</p>
                                @endif
                            </div>
                            @if(auth()->user() && auth()->user()->role === 'admin')
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('edit_plan') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $plan->id }}">
                                        <button type="submit" class="px-3 py-1 text-white text-xs rounded" style="background-color: #7c3aed;">Uredi</button>
                                    </form>
                                    <form method="POST" action="{{ route('delete_plan') }}" class="inline" onsubmit="return confirm('Obrisati ovaj plan?');">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $plan->id }}">
                                        <button type="submit" class="px-3 py-1 text-white text-xs rounded" style="background-color: #e91e63;">Obriši</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="p-4 text-gray-500">Nema dostupnih planova.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
