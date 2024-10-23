<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Faker\Factory as Faker;

class UpdateUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-users-random';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update users first name, last name and their timezones randomly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faker = Faker::create();
        $userTimeZones = ['CET', 'CST', 'GMT+1'];

        $getAllUsers = User::get();

        foreach ($getAllUsers as $index => $user) {
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->timezone = $faker->randomElement($userTimeZones);
            $user->save();

            $count = $index + 1;

            $this->info("Count: {$count}");
        }
        $this->info("Operation is successful");
        return true;
    }
}
