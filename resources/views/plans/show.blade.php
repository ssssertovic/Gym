<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Detalji plana') }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-6">
                    <p class="text-sm text-gray-500 mb-2"><a href="{{ route('plans') }}" class="text-purple-600 hover:underline">← Lista planova</a></p>
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $plan->name }}</h1>
                    <p class="text-lg text-gray-700 mb-2"><strong>Cijena:</strong> {{ number_format($plan->price ?? 0, 2) }} KM</p>
                    @if(!empty($plan->duration_days))<p class="text-gray-700 mb-2"><strong>Trajanje:</strong> {{ $plan->duration_days }} dana</p>@endif
                    @if(!empty($plan->description))<p class="text-gray-700 mt-4"><strong>Opis:</strong><br>{{ $plan->description }}</p>@endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
