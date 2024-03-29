<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Exécuter les seeds dans la base de données.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Technologies de haute qualité',
            'slug' => 'Technologies de haute qualité'
        ]);
        Category::create([
            'name' => 'Livres',
            'slug' => 'Livres'
        ]);
        Category::create([
            'name' => 'Jeux Vidéos',
            'slug' => 'Jeux Vidéos'
        ]);
        Category::create([
            'name' => 'Meubles',
            'slug' => 'Meubles'
        ]);
        Category::create([
            'name' => 'Nourriture',
            'slug' => 'Nourriture'
        ]);
    }
}
