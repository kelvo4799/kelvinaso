<?php

namespace Tests\Feature;

use App\Models\Referral;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AffiliateSystemTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $clientUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->adminUser = User::where('role', 'admin')->first() ?? User::first();
        $this->adminUser->update(['role' => 'admin']);

        $this->clientUser = User::factory()->create([
            'role' => 'user',
            'referral_code' => 'REF-TEST01',
        ]);
    }

    public function test_user_has_unique_referral_code_and_link(): void
    {
        $this->assertNotNull($this->clientUser->referral_code);
        $this->assertStringContainsString('?ref=REF-TEST01', $this->clientUser->referral_link);
    }

    public function test_public_url_with_ref_param_tracks_referral_click(): void
    {
        $response = $this->get('/?ref=' . $this->clientUser->referral_code);
        $response->assertStatus(200);

        $this->assertDatabaseHas('referrals', [
            'referrer_id' => $this->clientUser->id,
            'status' => 'pending',
        ]);
    }

    public function test_user_can_view_affiliate_portal_on_dashboard(): void
    {
        $response = $this->actingAs($this->clientUser)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Affiliate');
        $response->assertSee('REF-TEST01');
    }

    public function test_admin_can_view_and_update_affiliate_commission(): void
    {
        $referral = Referral::create([
            'referrer_id' => $this->clientUser->id,
            'visitor_ip' => '127.0.0.1',
            'status' => 'pending',
            'commission_amount' => 0,
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('affiliates.admin'));
        $response->assertStatus(200);
        $response->assertSee('Affiliate');

        $updateResponse = $this->actingAs($this->adminUser)->patch(route('affiliates.update.admin', $referral->id), [
            'status' => 'converted',
            'commission_amount' => 150.00,
            'notes' => 'Project client contract signed',
        ]);

        $updateResponse->assertRedirect();
        $referral->refresh();
        $this->assertEquals('converted', $referral->status);
        $this->assertEquals(150.00, $referral->commission_amount);
    }
}
