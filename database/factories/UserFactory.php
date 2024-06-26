<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'siswa'
        ];
        // return [
        //     'email' => 'aldysp34@gmail.com',
        //     'password' => Hash::make('aldysp34'),
        //     'remember_token' => Str::random(10),
        //     'role' => 'admin'
        // ];
        // return [
        //     'email' => 'aldysp32@gmail.com',
        //     'password' => Hash::make('aldysp34'),
        //     'remember_token' => Str::random(10),
        //     'role' => 'adminweb'
        // ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
