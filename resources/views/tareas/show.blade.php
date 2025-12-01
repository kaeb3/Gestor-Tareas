<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de Tarea: {{ $tarea->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-2xl font-bold mb-4">{{ $tarea->titulo }}</h3>
                <p class="text-gray-600 mb-6">
                    <strong>Proyecto:</strong> 
                    <a href="{{ route('proyectos.show', $tarea->proyecto) }}" class="text-indigo-600 hover:text-indigo-800">
                        {{ $tarea->proyecto->titulo }}
                    </a>
                </p>

                <div class="mb-6 border-t pt-4">
                    <p class="font-semibold text-lg mb-2">Descripción:</p>
                    <p class="text-gray-700">{{ $tarea->descripcion }}</p>
                </div>
                
                <div class="mb-8">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        @if($tarea->estado == 'pendiente') bg-red-100 text-red-800 
                        @elseif($tarea->estado == 'en_progreso') bg-yellow-100 text-yellow-800 
                        @else bg-green-100 text-green-800 @endif">
                        Estado: {{ ucfirst($tarea->estado) }}
                    </span>
                </div>

                <div class="mt-6 border-t pt-4">
                    <h4 class="font-semibold text-xl mb-3">📎 Archivos Adjuntos</h4>

                    @if($tarea->archivos->count())
                        <ul class="list-disc ml-5 space-y-2">
                            @foreach ($tarea->archivos as $archivo)
                                <li class="text-gray-700 flex justify-between items-center">
                                    <span>{{ $archivo->nombre_original }}</span>
                                    <a href="{{ route('archivos.download', $archivo) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                                       target="_blank">
                                        Descargar
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 italic">No hay archivos adjuntos para esta tarea.</p>
                    @endif
                </div>

                <div class="mt-8 border-t pt-4 flex justify-end space-x-3">
                    <a href="{{ route('tareas.edit', $tarea) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Editar Tarea
                    </a>
                    </div>

            </div>
        </div>
    </div>
</x-app-layout>