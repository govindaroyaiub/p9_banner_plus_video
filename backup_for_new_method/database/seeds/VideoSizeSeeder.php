<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Sizes;

class VideoSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Youtube Bumper Ad 6', 'width' => 1920, 'height' => 1080],
            ['name' => 'Youtube Pre-Roll 15" (Skippable)', 'width' => 1920, 'height' => 1080],
            ['name' => 'Youtube Pre-Roll 20" (Skippable)', 'width' => 1920, 'height' => 1080],
            ['name' => 'Facebook Shared Post Video Landscape 15"', 'width' => 1280, 'height' => 720],
            ['name' => 'Facebook / Instagram Social Video 1:1 15"	', 'width' => 1080, 'height' => 1080],
            ['name' => 'Facebook Carousel Video 15"', 'width' => 1080, 'height' => 1080],
            ['name' => 'Facebook / Instagram Social Video 1:1 6"', 'width' => 1080, 'height' => 1080],
            ['name' => 'Facebook Shared Post Video Portrait 15"', 'width' => 720, 'height' => 1280],
        ];

        Sizes::insert($data);
    }
}
