<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProyectoFeatureTest extends TestCase
{
    /** @test */
public function un_usuario_autenticado_puede_ver_la_lista_de_proyectos()
{
    $usuario = User::factory()->create();

    $this->actingAs($usuario) // Siendo usuario X
         ->get('/proyectos')   // al consultar ruta Y
         ->assertStatus(200)   // aseguro código 200
         ->assertSee('Mis Proyectos'); // y se muestra un texto determinado
}

/** @test */
public function se_puede_crear_un_proyecto_y_redirigir_correctamente()
{
    $usuario = User::factory()->create();
    $datos = ['titulo' => 'Proyecto de Prueba', 'descripcion' => 'Descripción del test'];

    $respuesta = $this->actingAs($usuario) // Siendo usuario X
                     ->post('/proyectos', $datos); // al enviar petición POST

    $respuesta->assertRedirect('/proyectos'); // aseguro redireccionamiento
    
    // aseguro creación de registro en DB
    $this->assertDatabaseHas('proyectos', ['titulo' => 'Proyecto de Prueba', 'user_id' => $usuario->id]); 
}

/** @test */
public function la_creacion_falla_si_falta_el_titulo()
{
    $usuario = User::factory()->create();

    $this->actingAs($usuario)
         ->post('/proyectos', ['titulo' => '', 'descripcion' => 'Vacio']) // con información incorrecta
         ->assertSessionHasErrors('titulo'); // asegurar error en validación
    
    // Asegurar que no se creó el registro
    $this->assertDatabaseMissing('proyectos', ['descripcion' => 'Vacio']);
}

/** @test */
public function un_proyecto_es_eliminado_logicamente()
{
    $proyecto = Proyecto::factory()->create();
    $usuario = $proyecto->dueno;

    $respuesta = $this->actingAs($usuario) // Siendo usuario X
                     ->delete('/proyectos/' . $proyecto->id); // al enviar petición DELETE

    $respuesta->assertRedirect('/proyectos'); // aseguro redireccionamiento

    // aseguro eliminación de registro en DB (Borrado lógico)
    $this->assertSoftDeleted('proyectos', ['id' => $proyecto->id]); 
}
}
