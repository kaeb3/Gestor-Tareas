<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nueva Tarea para Proyecto: {{ $proyecto->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form method="POST" action="{{ route('tareas.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="proyecto_id" value="{{ $proyecto->id }}">

                    <div>
                        <x-input-label for="titulo" :value="__('Título de la Tarea')" />
                        <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo')" required autofocus />
                        
                        @error('titulo')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="descripcion" :value="__('Descripción')" />
                        <textarea id="descripcion" name="descripcion" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                    </div>
                    
                    <div class="mt-6 p-4 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                        <x-input-label for="archivos" :value="__('Adjuntar Archivos (Opcional)')" class="mb-2"/>
                        <input type="file" name="archivos[]" multiple 
                               class="block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                        @error('archivos.*')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Guardar Tarea') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>