<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Car;
use App\Models\User;

class CarFactory extends Factory
{
    protected $model = Car::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'make' => $this->faker->randomElement([
                'Toyota', 'Volkswagen', 'Ford', 'Honda', 'Nissan',
                'Hyundai', 'KIA', 'Renault', 'Mercedes', 'Peugeot'
            ]),
            'model' => $this->faker->word,
            'year' => rand(1980, (int)date('Y')),
            'color' => $this->faker->safeColorName,
            'user_id'  => User::where('role', '=', 'driver')->get()->random()->id
        ];
    }
}
