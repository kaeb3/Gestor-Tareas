<?php

namespace App\Providers;

// Importa los modelos y la Policy que estás usando
use App\Models\Proyecto; 
use App\Models\User; // Usualmente ya importado
use App\Policies\ProyectoPolicy; 

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 🛑 ESTA LÍNEA ES CRUCIAL PARA LA AUTORIZACIÓN 🛑
        Proyecto::class => ProyectoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define aquí cualquier Gate (puerta) o simplemente deja vacío si usas solo Policies
        // $this->registerPolicies(); // Esta línea es usualmente llamada por el constructor base

        // Opcional: Si quieres definir el Gate de 'admin' aquí en lugar de en la Policy
        // Gate::before(function (User $user, $ability) {
        //     if ($user->rol === 'admin') {
        //         return true;
        //     }
        // });
    }
}