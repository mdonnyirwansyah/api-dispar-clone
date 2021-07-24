<?php

namespace Database\Seeders;

use App\Models\NewsPost;
use App\Models\NewsTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsPostNewsTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news_post_news_tag')->insert(
            [
                'news_post_id' => NewsPost::select('id')->orderByRaw("RAND()")->first()->id,
                'news_tag_id' => NewsTag::select('id')->orderByRaw("RAND()")->first()->id,
            ]
        );
    }
}
