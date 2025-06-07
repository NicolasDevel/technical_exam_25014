<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            'name' => 'Tecnología',
            'description' => 'Representa productos, servicios o contenido relacionado con innovaciones tecnológicas,
            software, hardware y herramientas digitales.'
        ]);

        Category::factory()->create([
            'name' => 'Educación',
            'description' => 'Incluye recursos educativos como cursos, talleres, libros, materiales
             de aprendizaje o instituciones académicas.'
        ]);

        Category::factory()->create([
            'name' => 'Salud y Bienestar',
            'description' => 'Cubre temas como servicios médicos, productos de cuidado personal,
            ejercicio físico, nutrición y salud mental.'
        ]);

        Category::factory()->create([
            'name' => 'Moda y Estilo',
            'description' => 'Agrupa artículos y tendencias relacionadas con ropa,
            accesorios, calzado y consejos de estilo personal.'
        ]);

        Category::factory()->create([
            'name' => 'Hogar y Jardín',
            'description' => 'Incluye productos y servicios relacionados con la decoración,
            mantenimiento y mejora del hogar, así como jardinería.'
        ]);

        Category::factory()->create([
            'name' => 'Entretenimiento',
            'description' => 'Contiene contenido como música, películas, videojuegos,
            eventos, espectáculos y actividades recreativas.'
        ]);

        Category::factory()->create([
            'name' => 'Alimentos y Bebidas',
            'description' => 'Agrupa restaurantes, recetas, productos alimenticios, bebidas y servicios de catering.'
        ]);

        Category::factory()->create([
            'name' => 'Deportes y Aventura',
            'description' => 'Enfocado en actividades deportivas, equipos, experiencias al aire libre, y destinos de aventura.'
        ]);

        Category::factory()->create([
            'name' => 'Negocios y Finanzas',
            'description' => 'Incluye recursos relacionados con administración, emprendimiento,
            inversión, economía y desarrollo profesional.'
        ]);

        Category::factory()->create([
            'name' => 'Arte y Cultura',
            'description' => 'Representa obras de arte, literatura, historia, patrimonio cultural, eventos y actividades creativas.'
        ]);


    }
}
