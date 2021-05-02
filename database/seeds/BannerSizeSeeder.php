<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\BannerSizes;

class BannerSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['width' => '120', 'height' => '240'],
            ['width' => '120', 'height' => '600'],
            ['width' => '160', 'height' => '600'],
            ['width' => '180', 'height' => '150'],
            ['width' => '200', 'height' => '200'],
            ['width' => '212', 'height' => '177'],
            ['width' => '234', 'height' => '60'],
            ['width' => '250', 'height' => '250'],
            ['width' => '262', 'height' => '184'],
            ['width' => '300', 'height' => '600'],
            ['width' => '300', 'height' => '120'],
            ['width' => '300', 'height' => '50'],
            ['width' => '300', 'height' => '60'],
            ['width' => '300', 'height' => '250'],
            ['width' => '305', 'height' => '325'],
            ['width' => '306', 'height' => '230'],
            ['width' => '306', 'height' => '325'],
            ['width' => '320', 'height' => '240'],
            ['width' => '320', 'height' => '50'],
            ['width' => '320', 'height' => '100'],
            ['width' => '320', 'height' => '480'],
            ['width' => '336', 'height' => '280'],
            ['width' => '468', 'height' => '60'],
            ['width' => '500', 'height' => '500'],
            ['width' => '580', 'height' => '400'],
            ['width' => '600', 'height' => '100'],
            ['width' => '600', 'height' => '700'],
            ['width' => '728', 'height' => '90'],
            ['width' => '768', 'height' => '1024'],
            ['width' => '960', 'height' => '300'],
            ['width' => '970', 'height' => '500'],
            ['width' => '970', 'height' => '250'],
            ['width' => '970', 'height' => '90'],
            ['width' => '1024', 'height' => '768'],
            ['width' => '1080', 'height' => '1080'],
            ['width' => '1115', 'height' => '300'],
            ['width' => '1272', 'height' => '328'],
        ];

        BannerSizes::insert($data);
    }
}
