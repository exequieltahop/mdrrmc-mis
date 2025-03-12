<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\RespondentModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create(
            // RespondentModel::create(
                // for user
                [
                    'name' => 'MDRRMC Admin',
                    'email' => 'mdrrmc.admin@gmail.com',
                    'password' => Hash::make('mdrrmc_strong_password'),
                    'role' => 'admin'
                ]
                // [
                //     'name' => 'Respondent Lastname',
                //     'email' => 'respondent.user@gmail.com',
                //     'password' => Hash::make('respondent_strong_password'),
                // ]

                // for respondent
                // [
                //     'first_name' => 'John',
                //     'middle_name' => 'A.',
                //     'last_name' => 'Doe',
                //     'age' => '30',
                //     'gender' => 'm',
                //     'address' => '123 Main St, Cityville',
                //     'birthdate' => '1993-01-01',
                //     'birthplace' => 'Cityville',
                //     'civil_status' => 'Single',
                //     'photo' => null,
                //     'created_at' => now(),
                //     'updated_at' => now(),
                // ]

                // [
                //     'first_name' => 'Jane',
                //     'middle_name' => 'B.',
                //     'last_name' => 'Smith',
                //     'age' => '28',
                //     'gender' => 'f',
                //     'address' => '456 Elm St, Townsville',
                //     'birthdate' => '1995-05-15',
                //     'birthplace' => 'Townsville',
                //     'civil_status' => 'Married',
                //     'photo' => null,
                //     'created_at' => now(),
                //     'updated_at' => now(),
                // ],
        );

    }
}
