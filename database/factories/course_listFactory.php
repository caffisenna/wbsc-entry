<?php

namespace Database\Factories;

use App\Models\course_list;
use Illuminate\Database\Eloquent\Factories\Factory;

class course_listFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = course_list::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->word,
            'director' => $this->faker->word,
            'place' => $this->faker->word,
            'day_start' => $this->faker->word,
            'day_end' => $this->faker->word,
            'guidance_date' => $this->faker->word,
            'deadline' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
