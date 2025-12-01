<x-app-layout>
    <div style="position: absolute; top: 15px; right: 20px; z-index: 1000;">
        <a href="{{ route('proyectos.tareas.create', $proyecto) }}" 
            style="
                background-color: #f73737; 
                color: white;
                padding: 8px 12px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: bold;
                font-size: 14px;
                text-transform: uppercase;
                box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.4);
                display: inline-block;
            ">
            {{ __('CREAR TAREA (BOTÓN VISIBLE)') }}
        </a>
    </div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Proyecto: {{ $proyecto->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-xl font-bold mb-3 border-b pb-2">Detalles del Proyecto</h3>
                <p class="text-gray-700 mb-6">{{ $proyecto->descripcion }}</p>

                <p class="text-sm text-gray-500 mb-4">
                    **Dueño:** <span class="font-semibold text-gray-700">{{ $proyecto->dueno->name }}</span>
                </p>

                <hr class="my-6">
                <h3 class="text-xl font-bold mb-4">Tareas Asignadas ({{ $proyecto->tareas->count() }})</h3>
                
                @forelse ($proyecto->tareas as $tarea)
                    <div class="border p-4 rounded-lg mb-3 flex justify-between items-center bg-gray-50 hover:bg-gray-100">
                        <span class="font-semibold">{{ $tarea->titulo }}</span>
                        <a href="{{ route('tareas.show', $tarea) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Ver Tarea
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 italic p-4 border rounded-lg">Este proyecto aún no tiene tareas asignadas. El botón para crear una está arriba.</p>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>