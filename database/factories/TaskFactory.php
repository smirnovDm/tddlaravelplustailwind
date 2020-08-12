<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'body'       => $faker->paragraph,
        'project_id' => function() {
            return factory(\App\Project::class)->create()->id;
        }
    ];
});
