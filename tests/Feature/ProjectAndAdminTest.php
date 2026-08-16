<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectAndAdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->adminUser = User::where('role', 'admin')->first() ?? User::first();
        $this->adminUser->update(['role' => 'admin']);
    }

    public function test_projects_page_is_accessible(): void
    {
        $response = $this->get('/projects');
        $response->assertStatus(200);
        $response->assertSee('Keviloq Portfolio');
    }

    public function test_project_detail_page_renders_without_errors(): void
    {
        $project = Project::where('slug', 'keviloq-portfolio')->first();
        $response = $this->get('/projects/' . $project->slug);

        $response->assertStatus(200);
        $response->assertSee('Keviloq Portfolio');
        $response->assertSee('CEO');
        $response->assertSee('Sam Ergu');
    }

    public function test_admin_dashboard_is_accessible_by_admin(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('dashboard.admin'));
        $response->assertStatus(200);
        $response->assertSee('Recent projects');
        $response->assertSee('Total projects');
    }

    public function test_admin_projects_list_is_accessible(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('projects.admin'));
        $response->assertStatus(200);
        $response->assertSee('Projects');
        $response->assertSee('Keviloq Portfolio');
    }

    public function test_admin_can_create_project(): void
    {
        $response = $this->actingAs($this->adminUser)->post(route('projects.store.admin'), [
            'title' => 'New SaaS Platform',
            'category' => 'web',
            'year' => 2026,
            'description' => 'A SaaS platform built with Laravel.',
            'tech' => 'Laravel, Vue, Tailwind CSS',
        ]);

        $project = Project::where('slug', 'new-saas-platform')->first();
        $this->assertNotNull($project);
        $this->assertEquals('New SaaS Platform', $project->title);
        $this->assertEquals(['Laravel', 'Vue', 'Tailwind CSS'], $project->tech_stack);

        $response->assertRedirect(route('projects.show.admin', 'new-saas-platform'));
    }

    public function test_admin_can_update_project(): void
    {
        $project = Project::first();

        $response = $this->actingAs($this->adminUser)->patch(route('projects.update.admin', $project->slug), [
            'title' => 'Updated Project Title',
            'category' => 'mobile',
            'year' => 2026,
            'description' => 'Updated description text.',
            'tech' => 'Flutter, Dart',
            'comment_name' => 'John Doe',
            'comment_position' => 'CTO',
            'comment_text' => 'Brilliant work and execution!',
            'status' => 'published',
        ]);

        $project->refresh();
        $this->assertEquals('Updated Project Title', $project->title);
        $this->assertEquals('mobile', $project->project_type);
        $this->assertEquals(['Flutter', 'Dart'], $project->tech_stack);
        $this->assertEquals('John Doe', $project->client_comment['name']);
        $this->assertEquals('CTO', $project->client_comment['position']);
    }

    public function test_admin_can_delete_project(): void
    {
        $project = Project::first();
        $slug = $project->slug;

        $response = $this->actingAs($this->adminUser)->delete(route('projects.destroy.admin', $slug));
        $response->assertRedirect(route('projects.admin'));

        $this->assertNull(Project::where('slug', $slug)->first());
    }

    public function test_admin_can_view_and_update_page(): void
    {
        $page = Page::where('slug', 'home')->first();

        $response = $this->actingAs($this->adminUser)->get(route('pages.show', $page->slug));
        $response->assertStatus(200);

        $updateResponse = $this->actingAs($this->adminUser)->patch(route('pages.update', $page->slug), [
            'title' => 'Home Page',
            'slug' => 'home',
            'meta_description' => 'Updated meta description.',
            'meta_keywords' => 'laravel, portfolio, developer',
            'robots' => 'index, follow',
            'status' => '1',
        ]);

        $updateResponse->assertRedirect(route('pages.show', 'home'));
        $page->refresh();
        $this->assertEquals('Updated meta description.', $page->content['meta_description']);
    }
}
