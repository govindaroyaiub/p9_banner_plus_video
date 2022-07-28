<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'Planetnine Admin',
            'email' => 'admin@planetnine.com',
            'company_id' => 1,
            'is_send_mail' => 1,
            'is_admin' => 1,
            'password' => Hash::make('password')
        ]);
    }
}
