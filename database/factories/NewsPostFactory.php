<?php

namespace Database\Factories;

use App\Models\NewsCategory;
use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->unique()->sentence($nbWords = 6, $variableNbWords = true);
        $status = $this->faker->randomElement(['Published', 'Draft', 'Pending']);
        if ($status == 'Published') {
            $time = now();
        } else {
            $time = null;
        }
        return [
            'title' => $title,
            'category_id' => $this->faker->randomElement([1, 2, 3, 4]),
            'content' => $this->faker->paragraph($nbSentences = 40, $variableNbSentences = true),
            'author_id'=> User::factory(),
            'source' => $this->faker->company,
            'status' => $status,
            'published_at' => $time,
            'slug' => Str::slug($title)
        ];
    }
}
