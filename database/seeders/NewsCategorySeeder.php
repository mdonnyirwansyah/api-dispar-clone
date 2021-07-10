<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newsCategories = collect([
            'Pariwisata Riau',
            'Pariwisata Nasional',
            'Pariwisata Internasional',
            'Umum'
        ]);

        $newsCategories->each(function ($newsCategory) {
            NewsCategory::create([
                'name' => $newsCategory,
                'slug' => Str::slug($newsCategory)
            ]);
        });
    }
}
