<x-app-layout>
    <x-slot name="header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Proyectos y Colaboraciones') }}
        </h2>
        
        <a href="{{ route('proyectos.create') }}" 
            style="
                background-color: #4f46e5; /* Color del botón */
                color: white;
                padding: 8px 12px;
                border-radius: 6px;
                text-decoration: none;
                font-weight: bold;
                font-size: 12px;
                text-transform: uppercase;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            ">
            {{ __('Crear Nuevo Proyecto') }}
        </a>
    </div>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @forelse ($proyectos as $proyecto)
                    <div class="bg-white overflow-hidden shadow-md rounded-lg p-6 
                                @if($proyecto->user_id == Auth::id()) border-l-4 border-indigo-600 @else border-l-4 border-green-600 @endif">
                        
                        <h3 class="text-xl font-bold mb-2 truncate">
                            <a href="{{ route('proyectos.show', $proyecto) }}" class="text-gray-900 hover:text-indigo-600">
                                {{ $proyecto->titulo }}
                            </a>
                        </h3>

                        <p class="text-sm mb-4">
                            @if($proyecto->user_id == Auth::id())
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full font-medium">Dueño</span>
                            @else
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full font-medium">Colaborador</span>
                                de: <span class="font-semibold">{{ $proyecto->dueno->name }}</span>
                            @endif
                        </p>
                        
                        <p class="text-gray-700 text-sm line-clamp-3 mb-4">{{ $proyecto->descripcion }}</p>

                        <div class="mt-4 border-t pt-3 flex justify-end space-x-2">
                            
                            @can('update', $proyecto)
                                <a href="{{ route('proyectos.edit', $proyecto) }}" 
                                   class="text-sm font-medium text-indigo-600 hover:text-indigo-900 transition duration-150">
                                    Editar
                                </a>
                            @endcan

                            @can('delete', $proyecto)
                                <form action="{{ route('proyectos.destroy', $proyecto) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proyecto (Borrado Lógico)?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-sm font-medium text-red-600 hover:text-red-900 transition duration-150 ml-2">
                                        Eliminar
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 p-8 bg-gray-50 rounded-lg shadow-inner">
                        Aún no tienes proyectos propios ni colaboraciones. ¡Crea el primero usando el botón de arriba!
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>