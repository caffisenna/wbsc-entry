<?php

namespace Database\Factories;

use App\Models\Entry_info;
use Illuminate\Database\Eloquent\Factories\Factory;

class Entry_infoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entry_info::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'furigana' => $this->faker->word,
        'gender' => $this->faker->word,
        'bs_id' => $this->faker->word,
        'prefecture' => $this->faker->word,
        'district' => $this->faker->word,
        'dan' => $this->faker->word,
        'troop' => $this->faker->word,
        'troop_role' => $this->faker->word,
        'cell_phone' => $this->faker->word,
        'zip' => $this->faker->word,
        'address' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'district_role' => $this->faker->word,
        'prefecture_role' => $this->faker->word,
        'scout_camp' => $this->faker->word,
        'bs_basic_course' => $this->faker->word,
        'wb_basic1_category' => $this->faker->word,
        'wb_basic1_number' => $this->faker->word,
        'wb_basic1_date' => $this->faker->word,
        'wb_adv1_category' => $this->faker->word,
        'wb_adv1_number' => $this->faker->word,
        'wb_adv1_date' => $this->faker->word,
        'service_hist1_role' => $this->faker->word,
        'service_hist1_term' => $this->faker->word,
        'health_illness' => $this->faker->word,
        'health_memo' => $this->faker->word,
        'commi_checked_at' => $this->faker->word,
        'ais_checked_at' => $this->faker->word,
        'gm_checked_at' => $this->faker->word
        ];
    }
}
