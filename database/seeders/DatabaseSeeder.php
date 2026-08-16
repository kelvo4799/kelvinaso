<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {

        $this->call([
            AuthPageSeeder::class,

        ]);

        $users = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('Admin123$'),
        ]);

        $homePage = Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => [
                'meta_description' => '',
                'meta_keywords' => '',
            ],
        ]);

        $homePage->sections()->create([
            'section_name' => 'profile_card',
            'order' => 1,
            'content' => [
                'hero_title' => 'title',
                'hero_title_two' => 'title 2',
                'hero_title_highlight' => 'highlighted',
                'hero_title_suffix' => 'suffix',
                'hero_meta' => 'Available for Freelancing',
            ],
        ]);

        $homePage->sections()->create([
            'section_name' => 'work_with_card',
            'order' => 2,
            'content' => [
                'title' => 'My Tech Stack',
                'subtitle' => 'i love my stacks',
            ],
        ]);

        $homePage = Page::create([
            'title' => 'Projects',
            'slug' => 'projects',
            'content' => [
                'meta_description' => '',
                'meta_keywords' => '',
            ],
        ]);

        $homePage->sections()->create([
            'section_name' => 'project_card',
            'order' => 1,
            'content' => [
                'title' => 'My',
                'title_highligted' => 'Projects',
                'subtitle' => '',
                'categories' => [
                    'wordpress' => 'Wordpress',
                    'spotify' => 'Spotify',
                    'web' => 'Web Development',
                    'mobile' => 'Mobile',
                ],
            ],
        ]);

        $users->profile()->create([
            'first_name' => 'Keviloq',
            'last_name' => 'Systems',
            'bio_title' => 'Fullstack Developer | Laravel & React Enthusiast | Software Engineer | Api Developer | Cloud Solutions Architect | UI/UX Designer | Digital Transformation Specialist',
            'bio_header' => 'Crafting robust architectural solutions with an eye for exceptional visual detail.',
            'bio' => 'I am a fullstack developer with experience in building modern web applications and software solutions for businesses and individuals.',
            'bio_extra' => 'Extra Here',
            'avatar' => '',
            'cover_image' => '',
            'location' => '',
            'direct_email' => '',
            'direct_phone' => '',
            'social_links' => [
                'linkedin' => '',
                'github' => '',
                'x' => '',
                'facebook' => '',
                'instagram' => '',
            ],
            'others' => ['meta' => null],

        ]);

        


    

    }
}
