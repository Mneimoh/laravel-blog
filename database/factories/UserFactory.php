<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Models\CategoryPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

}

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition(){
        $title = $this->faker->unique()->sentence();
        $isPublished = ['1', '0'];
        return [
            'user_id' => rand(1, 5),
            'title' => $title,
            'slug' => str_slug($title),
            'sub_title' => $this->faker->sentence(),
            'details' => $this->faker->paragraph(), 
            'post_type' => 'post',
            'is_published' => $isPublished[rand(0,1)],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }


}

class CategoryPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition(){
        return [
            'category_id' => rand(1, 5),
            'post_id' => rand(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

}


