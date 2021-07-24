<?php

namespace Database\Seeders;

use App\Models\NewsTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newsTags = collect([
            'Travel',
            'Backpacker',
            'Summer',
            'Winter',
            'Fest',
            'Lifestyle',
            'Sport',
            'Health',
            'Covid-19'
        ]);

        $newsTags->each(function ($newsTag) {
            NewsTag::create([
                'name' => $newsTag,
                'slug' => Str::slug($newsTag)
            ]);
        });
    }
}
