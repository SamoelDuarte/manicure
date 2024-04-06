<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->randomElement(['Casa', 'Trabalho', 'Mãe', 'Pai']),
            'default_address' => rand(0, 1),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->streetAddress,
            'address2' => $this->faker->address,
            'zip_code' => $this->faker->postcode,
            'po_box' => $this->faker->numberBetween(1000, 9999),
        ];

        $table->string('zipcode')->nullable();
        $table->string('address')->nullable();
        $table->string('neighborhood')->nullable();
        $table->string('state')->nullable();
        $table->string('city')->nullable();
        $table->string('complement')->nullable();
        $table->string('number')->nullable();
    }
}
