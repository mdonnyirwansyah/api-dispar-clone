<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect([
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

        $tags->each(function ($tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag)
            ]);
        });
    }
}
