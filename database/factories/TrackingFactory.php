<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tracking>
 */
class TrackingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tracking_code' => $this->faker->unique()->numberBetween($min = 1000, $max = 9000),
            'estimated_delivery' => $this->faker->dateTimeInInterval($startDate = '-1 year', $interval = '+ 15 days', $timezone = 'CET')
        ];
    }
}
