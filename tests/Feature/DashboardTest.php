<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
    }

    public function test_guests_do_not_receive_any_dashboard_content(): void
    {
        $user = User::factory()->create(['name' => 'Private Person', 'email' => 'private@example.com']);

        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
        $this->assertStringNotContainsString('Private Person', $response->getContent());
        $this->assertStringNotContainsString($user->email, $response->getContent());
    }

    public function test_authenticated_users_can_open_the_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard')->assertOk()->assertSee('Dashboard');
    }

    public function test_dashboard_shows_the_authenticated_users_details(): void
    {
        $user = User::factory()->create([
            'name' => 'Ada Lovelace',
            'email' => 'ada@example.com',
            'created_at' => '2026-03-15 10:00:00',
        ]);

        $this->actingAs($user)->get('/dashboard')
            ->assertOk()
            ->assertSee('Welcome, Ada Lovelace.')
            ->assertSee('data-testid="profile-name">Ada Lovelace<', false)
            ->assertSee('data-testid="profile-email">ada@example.com<', false)
            ->assertSee('March 15, 2026')
            ->assertSee('AL'); // avatar initials
    }

    public function test_dashboard_does_not_show_other_users_details(): void
    {
        $user = User::factory()->create(['name' => 'Ada Lovelace']);
        $other = User::factory()->create(['name' => 'Grace Hopper', 'email' => 'grace@example.com']);

        $this->actingAs($user)->get('/dashboard')
            ->assertOk()
            ->assertDontSee($other->name)
            ->assertDontSee($other->email);
    }

    public function test_user_provided_values_are_escaped(): void
    {
        $user = User::factory()->create(['name' => '<script>alert("x")</script>']);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $this->assertStringNotContainsString('<script>alert("x")</script>', $response->getContent());
        $response->assertSee('&lt;script&gt;', false);
    }

    public function test_every_dashboard_link_points_to_a_working_page(): void
    {
        $user = User::factory()->create();
        $html = $this->actingAs($user)->get('/dashboard')->getContent();

        preg_match_all('/<a\b[^>]*\bhref="([^"]+)"/i', $html, $matches);
        $links = collect($matches[1])
            ->map(fn ($href) => html_entity_decode($href))
            ->filter(fn ($href) => Str::startsWith($href, [url('/'), '/']))
            ->reject(fn ($href) => Str::startsWith($href, '#'))
            ->map(fn ($href) => Str::before($href, '#'))
            ->unique()
            ->values();

        $this->assertContains(route('dashboard'), $links);
        $this->assertContains(route('profile.edit'), $links);

        foreach ($links as $link) {
            $this->actingAs($user)->get($link)->assertOk();
        }
    }

    public function test_change_password_links_target_the_password_section(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard')
            ->assertSee(route('profile.edit').'#update-password', false);

        $this->actingAs($user)->get('/profile')
            ->assertSee('id="update-password"', false);
    }

    public function test_logout_is_a_post_form_with_a_csrf_token(): void
    {
        $user = User::factory()->create();
        $html = $this->actingAs($user)->get('/dashboard')->getContent();

        preg_match_all('/<form method="POST" action="'.preg_quote(route('logout'), '/').'"[^>]*>\s*<input type="hidden" name="_token"/', $html, $forms);

        // One in each sidebar copy (desktop + mobile) and one in the account menu.
        $this->assertCount(3, $forms[0]);
        $this->assertStringNotContainsString('href="'.route('logout').'"', $html);
    }

    public function test_layout_includes_mobile_navigation_controls(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard')
            ->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1">', false)
            ->assertSee('Open navigation')
            ->assertSee('Close navigation')
            ->assertSee('aria-current="page"', false)
            ->assertSee('Skip to content');
    }

    public function test_dashboard_runs_no_extra_database_queries(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $queries = 0;
        DB::listen(function () use (&$queries) {
            $queries++;
        });

        $this->get('/dashboard')->assertOk();

        $this->assertSame(0, $queries);
    }
}
