<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class AuthPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loginPage = Page::create([
            'title' => 'Login',
            'slug' => 'login',
            'content' => [
                'meta_description' => 'Login to your account',
                'meta_keywords' => 'login, account, Keviloq Systems',
                'image' => 'https://www.keviloq.com/assets/images/keviloq-logo.png',
                'url' => 'https://www.keviloq.com',
                'type' => 'website',
                'author' => 'Keviloq Systems',
                'robots' => 'index, follow',
                'site_name' => 'Keviloq Systems',
                'locale' => 'en_US',
            ]
        ]);

        $loginPage->sections()->create([
            'section_name' => 'auth_card',
            'order' => 1,
            'content' => [
                'title' => 'Login to your account',
                'subtitle' => 'Please enter your credentials to login.',                'button_text' => 'Login',
                'forgot_password_text' => 'Forgot your password?',
                'register_text' => "Don't have an account?",
            ]
        ]);
    


        $registerPage = Page::create([
            'title' => 'Register',
            'slug' => 'register',
            'content' => [
                'meta_description' => 'Create a new account',
                'meta_keywords' => 'register, account, Keviloq Systems',
                'image' => 'https://www.keviloq.com/assets/images/keviloq-logo.png',
                'url' => 'https://www.keviloq.com',
                'type' => 'website',
                'author' => 'Keviloq Systems',
                'robots' => 'index, follow',
                'site_name' => 'Keviloq Systems',
                'locale' => 'en_US',
            ]
        ]);

        $registerPage->sections()->create([
            'section_name' => 'auth_card',
            'order' => 1,
            'content' => [
                'title' => 'Create a new account',
                'subtitle' => 'Please fill in the details to create your account.',
                'button_text' => 'Register',
                'login_text' => "Already have an account?",
            ]
        ]);



        $resetPage = Page::create([
            'title' => 'Reset Password',
            'slug' => 'reset-password',
            'content' => [
                'meta_description' => 'Reset your password',
                'meta_keywords' => 'reset, password, Keviloq Systems',
                'image' => 'https://www.keviloq.com/assets/images/keviloq-logo.png',
                'url' => 'https://www.keviloq.com',
                'type' => 'website',
                'author' => 'Keviloq Systems',
                'robots' => 'index, follow',
                'site_name' => 'Keviloq Systems',
                'locale' => 'en_US',
            ]
        ]);

        $resetPage->sections()->create([
            'section_name' => 'auth_card',
            'order' => 1,
            'content' => [
                'title' => 'Reset your password',
                'subtitle' => 'Please enter your email address to reset your password.',
                'button_text' => 'Reset Password',
                'login_text' => "Already have an account?"
            ]
        ]);
    }

}
