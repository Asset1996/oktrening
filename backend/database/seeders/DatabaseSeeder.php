<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\System\Models\User;
use Modules\Categories\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('1234');
        User::createUser('admin', 'admin@mail.com', $password);
        User::createUser('test', 'test@mail.com', $password);

        $Category1 = Category::createCategory('Men');
        $Category2 = Category::createCategory('Women');
        $Category3 = Category::createCategory('Unisex');

        $Category11 = Category::createCategory('Shoes', $Category1->id);
        $Category12 = Category::createCategory('Trousers', $Category1->id);
        $Category13 = Category::createCategory('Jackets', $Category1->id);

        $Category21 = Category::createCategory('Hats', $Category2->id);
        $Category22 = Category::createCategory('Skirts', $Category2->id);
        $Category23 = Category::createCategory('Bags', $Category2->id);

        $Category111 = Category::createCategory('Summer Shoes', $Category11->id);
        $Category112 = Category::createCategory('Demi-season Shoes', $Category11->id);
        $Category113 = Category::createCategory('Winter Shoes', $Category11->id);
        $Category121 = Category::createCategory('Tapered Trousers', $Category12->id);
        $Category122 = Category::createCategory('Loose Trousers', $Category12->id);
        $Category132 = Category::createCategory('Heavy Jackets', $Category13->id);

        $Category211 = Category::createCategory('Travellers Hats', $Category21->id);
        $Category212 = Category::createCategory('Natural Skin Hats', $Category21->id);
        $Category221 = Category::createCategory('Long Skirts', $Category22->id);
        $Category222 = Category::createCategory('Short Skirts', $Category22->id);
        $Category231 = Category::createCategory('Big Bags', $Category23->id);
        $Category232 = Category::createCategory('Medium Bags', $Category23->id);
        $Category233 = Category::createCategory('Small Bags', $Category23->id);
    }
}
