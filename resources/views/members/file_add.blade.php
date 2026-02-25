<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj fajl') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div class="p-6">
                <form action="{{ route('process') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" value = "{{$id}}" name="id">
                    <div class="mt-4">
                        <x-jet-label for="file" value="{{ __('Fajl') }}" />
                        <input type="file" name="file" id="file" class="block mt-1 w-full text-sm text-gray-500">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG, PDF, max 2MB</p>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-jet-button class="ml-4" style="background-color: #6366f1;">
                            {{ __('Učitaj') }}
                        </x-jet-button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
