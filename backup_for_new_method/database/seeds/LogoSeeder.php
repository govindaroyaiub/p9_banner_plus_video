<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Logo;


class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Logo::insert([
            'name' => 'Planetnine',
            'website' => 'http://localhost:8000',
            'company_website' => 'https://www.planetnine.com',
            'favicon' => 'https://www.planetnine.com/wp-content/uploads/2020...',
            'path' => 'logo.png',
            'default_color' => '#4b4e6d'
        ]);
    }
}
