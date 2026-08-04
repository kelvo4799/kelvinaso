<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homePage = Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => [
                'meta_description' => 'Welcome to our awesome agency.',
                'seo_title' => 'Home'
            ]
        ]);

        $homePage->sections()->create([
            'section_name' => 'hero',
            'order' => 1,
            'content' => [
                'hero_badge' => 'I love Jesus',
                'hero_title' => 'Web and Mobile',
                'hero_title_highlight' => 'solutions',
                'hero_title_suffix' => '.',
                'hero_subtitle' => "Partner with one of the Best Web Designers in Nigeria to take your brand to the next level. As a Top Web Design Company in Lagos, we deliver powerful web solutions that drive traffic, leads, and sales.",
            ]
        ]);
    }
}
