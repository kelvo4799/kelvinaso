<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Page;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        $users = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'you@yourdomain.com',
            'password' => bcrypt('Paramour123$'),
        ]);

        $homePage = Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => [
                'meta_description' => 'Keviloq Systems builds scalable web applications, enterprise software, Laravel solutions, mobile applications, cloud infrastructure, UI/UX design, and digital transformation solutions for startups and businesses worldwide.',
                'meta_keywords' => 'Keviloq Systems, Keviloq, Keviloq Systems Nigeria, Keviloq Systems Lagos, Keviloq Systems Abuja, Keviloq Systems Port Harcourt, Keviloq Systems Enugu, Keviloq Systems Ibadan, Keviloq Systems Kano, Keviloq Systems Kaduna, Keviloq Systems Benin City, Keviloq Systems Jos, Keviloq Systems Ilorin, Keviloq Systems Maiduguri, Keviloq Systems Sokoto, Keviloq Systems Uyo, Keviloq Systems Calabar, Keviloq Systems Warri, Keviloq Systems Bauchi, Keviloq Systems Yola',
                'image' => 'https://www.keviloq.com/assets/images/keviloq-logo.png',
                'url' => 'https://www.keviloq.com',
                'type' => 'website',
                'author' => 'Keviloq Systems',
                'robots' => 'index, follow',
                'site_name' => 'Keviloq Systems',
                'locale' => 'en_US',
            ]
        ]);

        $homePage->sections()->create([
            'section_name' => 'profile_card',
            'order' => 1,
            'content' => [
                'hero_title' => 'I\'m',
                'hero_title_two' => 'A fullstack developer who',
                'hero_title_highlight' => 'modern websites and software',
                'hero_title_suffix' => 'for businesses and individuals.',
                'hero_meta' => "Available for Freelancing",
            ]
        ]);

        $homePage->sections()->create([
            'section_name' => 'work_with_card',
            'order' => 2,
            'content' => [
                'title' => 'My Tech Stack',
                'subtitle' => 'These are the tools and technologies I work with to build modern web applications and software solutions for businesses and individuals.',
            ],
        ]);


        $homePage = Page::create([
            'title' => 'Projects',
            'slug' => 'projects',
            'content' => [
                'meta_description' => 'Keviloq Systems builds scalable web applications, enterprise software, Laravel solutions, mobile applications, cloud infrastructure, UI/UX design, and digital transformation solutions for startups and businesses worldwide.',
                'meta_keywords' => 'Keviloq Systems, Keviloq, Keviloq Systems Nigeria, Keviloq Systems Lagos, Keviloq Systems Abuja, Keviloq Systems Port Harcourt, Keviloq Systems Enugu, Keviloq Systems Ibadan, Keviloq Systems Kano, Keviloq Systems Kaduna, Keviloq Systems Benin City, Keviloq Systems Jos, Keviloq Systems Ilorin, Keviloq Systems Maiduguri, Keviloq Systems Sokoto, Keviloq Systems Uyo, Keviloq Systems Calabar, Keviloq Systems Warri, Keviloq Systems Bauchi, Keviloq Systems Yola',
                'image' => 'https://www.keviloq.com/assets/images/keviloq-logo.png',
                'url' => 'https://www.keviloq.com',
                'type' => 'website',
                'author' => 'Keviloq Systems',
                'robots' => 'index, follow',
                'site_name' => 'Keviloq Systems',
                'locale' => 'en_US',
            ]
        ]);

        $homePage->sections()->create([
            'section_name' => 'project_card',
            'order' => 1,
            'content' => [
                'title' => 'My',
                'title_highligted' => 'Projects',
                'subtitle' => 'A handful of recent backend, analytics and data engineering projects — each one shipped, measured and learned from.',
                'categories' => [
                    'wordpress' => 'Wordpress',
                    'spotify' => 'Spotify',
                    'web' => 'Web Development',
                    'mobile' => 'Mobile'
                ]
            ]
        ]);


        $users->profile()->create([
            'first_name' => 'Keviloq',
            'last_name' => 'Systems',
            'bio_title' => 'Fullstack Developer | Laravel & React Enthusiast | Software Engineer | Api Developer | Cloud Solutions Architect | UI/UX Designer | Digital Transformation Specialist',
            'bio_header' => 'Crafting robust architectural solutions with an eye for exceptional visual detail.',
            'bio' => 'I am a fullstack developer with experience in building modern web applications and software solutions for businesses and individuals.',
            'bio_extra' => 'Extra Here',
            'avatar' => 'https://www.keviloq.com/assets/images/keviloq-logo.png',
            'cover_image' => 'http://localhost/1785098586025.jpeg',
            'location' => 'Lagos, Nigeria',
            'direct_email' => 'you@yourdomain.com',
            'direct_phone' => '+234 803 123 4567',
            'social_links' => [
                'linkedin' => 'https://www.linkedin.com/in/keviloq',
                'github' => 'https://github.com/keviloq',
                'x' => 'https://twitter.com/keviloq',
                'facebook' => 'https://www.facebook.com/keviloq',
                'instagram' => 'https://www.instagram.com/keviloq',
            ],
            'others' => ['meta' => null],

        ]);

        $stacks = [
    [
        'name' => 'PHP',
        'color' => '#777BB4',
        'type' => 'language',
        'level' => 'advanced',
        'is_lang' => true,
    ],
    [
        'name' => 'JavaScript',
        'color' => '#F7DF1E',
        'type' => 'language',
        'level' => 'pro',
        'is_lang' => true,
    ],
    [
        'name' => 'TypeScript',
        'color' => '#3178C6',
        'type' => 'language',
        'level' => 'pro',
        'is_lang' => true,
    ],
    [
        'name' => 'Python',
        'color' => '#3776AB',
        'type' => 'language',
        'level' => 'intermidiate',
        'is_lang' => true,
    ],
    [
        'name' => 'HTML5',
        'color' => '#E34F26',
        'type' => 'frontend',
        'level' => 'expert',
        'is_lang' => true,
    ],
    [
        'name' => 'CSS3',
        'color' => '#1572B6',
        'type' => 'frontend',
        'level' => 'expert',
        'is_lang' => true,
    ],
    [
        'name' => 'Tailwind CSS',
        'color' => '#06B6D4',
        'type' => 'frontend',
        'level' => 'expert',
        'is_lang' => false,
    ],
    [
        'name' => 'Bootstrap',
        'color' => '#7952B3',
        'type' => 'frontend',
        'is_lang' => false,
    ],
    [
        'name' => 'Vue.js',
        'color' => '#4FC08D',
        'type' => 'frontend',
        'is_lang' => false,
    ],
    [
        'name' => 'Next.js',
        'color' => '#000000',
        'type' => 'frontend',
        'is_lang' => false,
    ],
    [
        'name' => 'Node.js',
        'color' => '#339933',
        'type' => 'backend',
        'is_lang' => false,
    ],
    [
        'name' => 'Express.js',
        'color' => '#000000',
        'type' => 'backend',
        'is_lang' => false,
    ],
    [
        'name' => 'MySQL',
        'color' => '#4479A1',
        'type' => 'database',
        'is_lang' => false,
    ],
    [
        'name' => 'PostgreSQL',
        'color' => '#4169E1',
        'type' => 'database',
        'is_lang' => false,
    ],
    [
        'name' => 'SQLite',
        'color' => '#003B57',
        'type' => 'database',
        'is_lang' => false,
    ],
    [
        'name' => 'MongoDB',
        'color' => '#47A248',
        'type' => 'database',
        'is_lang' => false,
    ],
    [
        'name' => 'Redis',
        'color' => '#DC382D',
        'type' => 'database',
        'is_lang' => false,
    ],
    [
        'name' => 'Git',
        'color' => '#F05032',
        'type' => 'tool',
        'is_lang' => false,
    ],
    [
        'name' => 'GitHub',
        'color' => '#181717',
        'type' => 'tool',
        'is_lang' => false,
    ],
    [
        'name' => 'Docker',
        'color' => '#2496ED',
        'type' => 'devops',
        'is_lang' => false,
    ],
    [
        'name' => 'Linux',
        'color' => '#FCC624',
        'type' => 'tool',
        'is_lang' => false,
    ],
    [
        'name' => 'Nginx',
        'color' => '#009639',
        'type' => 'server',
        'is_lang' => false,
    ],
    [
        'name' => 'Apache',
        'color' => '#D22128',
        'type' => 'server',
        'is_lang' => false,
    ],
    [
        'name' => 'Firebase',
        'color' => '#FFCA28',
        'type' => 'cloud',
        'is_lang' => false,
    ],
    [
        'name' => 'Supabase',
        'color' => '#3ECF8E',
        'type' => 'cloud',
        'is_lang' => false,
    ],
    [
        'name' => 'AWS',
        'color' => '#FF9900',
        'type' => 'cloud',
        'is_lang' => false,
    ],
    [
        'name' => 'DigitalOcean',
        'color' => '#0080FF',
        'type' => 'cloud',
        'is_lang' => false,
    ],
    [
        'name' => 'Vercel',
        'color' => '#000000',
        'type' => 'hosting',
        'is_lang' => false,
    ],
    [
        'name' => 'Netlify',
        'color' => '#00C7B7',
        'type' => 'hosting',
        'is_lang' => false,
    ],
    [
        'name' => 'Cloudflare',
        'color' => '#F38020',
        'type' => 'hosting',
        'is_lang' => false,
    ],
    [
        'name' => 'Figma',
        'color' => '#F24E1E',
        'type' => 'design',
        'is_lang' => false,
    ],
    [
        'name' => 'VS Code',
        'color' => '#007ACC',
        'type' => 'tool',
        'is_lang' => false,
    ],
    [
        'name' => 'Composer',
        'color' => '#885630',
        'type' => 'tool',
        'is_lang' => false,
    ],
    [
        'name' => 'NPM',
        'color' => '#CB3837',
        'type' => 'tool',
        'is_lang' => false,
    ],
    [
        'name' => 'PNPM',
        'color' => '#F69220',
        'type' => 'tool',
        'is_lang' => false,
    ],
    [
        'name' => 'Vite',
        'color' => '#646CFF',
        'type' => 'tool',
        'is_lang' => false,
    ],
    [
        'name' => 'Livewire',
        'color' => '#FB70A9',
        'type' => 'frontend',
        'is_lang' => false,
    ],
    [
        'name' => 'Alpine.js',
        'color' => '#77C1D2',
        'type' => 'frontend',
        'is_lang' => false,
    ],
    [
        'name' => 'Flutter',
        'color' => '#02569B',
        'type' => 'mobile',
        'is_lang' => false,
    ],
    [
        'name' => 'Dart',
        'color' => '#0175C2',
        'type' => 'language',
        'is_lang' => true,
    ],
];

foreach ($stacks as $stack) {
    $users->stacks()->create([
        'name' => $stack['name'],
        'image' => '',
        'icon' => '',
        'color' => $stack['color'],
        'type' => $stack['type'],
        'level' => $stack['level'] ?? '',
        'is_lang' => $stack['is_lang'],
        'is_active' => true,
    ]);
}

        // Products


$projects = [
    [
        'title' => 'Keviloq Portfolio',
        'slug' => 'keviloq-portfolio',
        'description' => 'A modern portfolio website built with Laravel, Tailwind CSS, and MySQL.',
        'image' => 'projects/portfolio.jpg',
        'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS'],
        'github_url' => 'https://github.com/username/keviloq-portfolio',
        'project_type' => 'web',
        'view_type' => 'live',
        'live_url' => 'https://portfolio.example.com',
        'featured' => true,
        'order' => 1,
        'is_active' => true,
    ],
    [
        'title' => 'E-Commerce Platform',
        'slug' => 'ecommerce-platform',
        'description' => 'A complete e-commerce solution with payment integration.',
        'image' => 'projects/ecommerce.jpg',
        'tech_stack' => ['Laravel', 'React', 'PostgreSQL', 'Redis'],
        'github_url' => 'https://github.com/username/ecommerce',
        'project_type' => 'web',
        'view_type' => 'live',
        'live_url' => 'https://shop.example.com',
        'featured' => true,
        'order' => 2,
        'is_active' => true,
    ],
    [
        'title' => 'Task Management System',
        'slug' => 'task-management-system',
        'description' => 'A collaborative task management application for teams.',
        'image' => 'projects/task-manager.jpg',
        'tech_stack' => ['Laravel', 'Livewire', 'MySQL'],
        'github_url' => 'https://github.com/username/task-manager',
        'project_type' => 'web',
        'view_type' => 'preview',
        'live_url' => null,
        'featured' => false,
        'order' => 3,
        'is_active' => true,
    ],
    [
        'title' => 'Restaurant Ordering App',
        'slug' => 'restaurant-ordering-app',
        'description' => 'An online ordering and reservation system for restaurants.',
        'image' => 'projects/restaurant.jpg',
        'tech_stack' => ['Flutter', 'Laravel', 'MySQL'],
        'github_url' => 'https://github.com/username/restaurant-app',
        'project_type' => 'mobile',
        'view_type' => 'preview',
        'live_url' => null,
        'featured' => false,
        'order' => 4,
        'is_active' => true,
    ],
    [
        'title' => 'Inventory Management System',
        'slug' => 'inventory-management-system',
        'description' => 'Inventory and warehouse management for SMEs.',
        'image' => 'projects/inventory.jpg',
        'tech_stack' => ['Laravel', 'Vue.js', 'PostgreSQL'],
        'github_url' => 'https://github.com/username/inventory',
        'project_type' => 'web',
        'view_type' => 'live',
        'live_url' => 'https://inventory.example.com',
        'featured' => true,
        'order' => 5,
        'is_active' => true,
    ],


    [

        'title' => 'Business Portfolio Website',

        'slug' => 'business-portfolio-website',

        'description' => 'A fast, SEO-friendly corporate website with a custom CMS and contact management.',

        'image' => 'projects/business-portfolio.webp',

        'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS'],

        'github_url' => null,

        'project_type' => 'web',

        'view_type' => 'live',

        'live_url' => 'https://business.example.com',

        'featured' => true,

        'order' => 1,

        'is_active' => true,

    ],

    [

        'title' => 'School Management System',

        'slug' => 'school-management-system',

        'description' => 'Complete school administration software for managing students, teachers, attendance, and results.',

        'image' => 'projects/school-management.webp',

        'tech_stack' => ['Laravel', 'Livewire', 'MySQL'],

        'github_url' => null,

        'project_type' => 'web',

        'view_type' => 'preview',

        'live_url' => null,

        'featured' => true,

        'order' => 2,

        'is_active' => true,

    ],

    [

        'title' => 'Hospital Management System',

        'slug' => 'hospital-management-system',

        'description' => 'Healthcare platform for patient records, appointments, billing, and pharmacy management.',

        'image' => 'projects/hospital-management.webp',

        'tech_stack' => ['Laravel', 'PostgreSQL', 'Redis'],

        'github_url' => null,

        'project_type' => 'web',

        'view_type' => 'preview',

        'live_url' => null,

        'featured' => true,

        'order' => 3,

        'is_active' => true,

    ],

    [

        'title' => 'Real Estate Listing Platform',

        'slug' => 'real-estate-listing-platform',

        'description' => 'Property listing platform with advanced search, agent dashboards, and inquiry management.',

        'image' => 'projects/real-estate.webp',

        'tech_stack' => ['Laravel', 'MySQL', 'Alpine.js', 'Tailwind CSS'],

        'github_url' => null,

        'project_type' => 'web',

        'view_type' => 'live',

        'live_url' => 'https://realestate.example.com',

        'featured' => false,

        'order' => 4,

        'is_active' => true,

    ],

    [

        'title' => 'Restaurant Website & Online Ordering',

        'slug' => 'restaurant-website-ordering',

        'description' => 'Modern restaurant website with digital menu, online ordering, and reservation features.',

        'image' => 'projects/restaurant-ordering.webp',

        'tech_stack' => ['Laravel', 'MySQL', 'Tailwind CSS'],

        'github_url' => null,

        'project_type' => 'web',

        'view_type' => 'live',

        'live_url' => 'https://restaurant.example.com',

        'featured' => false,

        'order' => 5,

        'is_active' => true,

    ],

    [

        'title' => 'HR & Payroll Management System',

        'slug' => 'hr-payroll-management-system',

        'description' => 'Human resource management software featuring payroll, leave requests, attendance, and employee records.',

        'image' => 'projects/hr-payroll.webp',

        'tech_stack' => ['Laravel', 'MySQL', 'Bootstrap'],

        'github_url' => null,

        'project_type' => 'web',

        'view_type' => 'preview',

        'live_url' => null,

        'featured' => false,

        'order' => 6,

        'is_active' => true,

    ],

];

foreach ($projects as $project) {
    Project::updateOrCreate(
        ['slug' => $project['slug']], // Unique key
        $project
    );
}




foreach ($projects as $index => $project) {

    Project::updateOrCreate(

        ['slug' => $project['slug']],

        array_merge($project, [

            'created_at' => Carbon::now()->subDays(($index + 1) * 15),

            'updated_at' => Carbon::now()->subDays($index * 5),

        ])

    );

}

    }
}
