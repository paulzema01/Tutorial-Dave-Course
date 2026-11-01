<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response
            ->assertStatus(200)
            ->assertSee('name="_token"', false)
            ->assertSee(route('login'), false);
    }

    public function test_registration_screen_has_password_toggles_and_match_feedback(): void
    {
        $response = $this->get('/register');

        $response
            ->assertSee('aria-controls="password"', false)
            ->assertSee('aria-controls="password_confirmation"', false)
            ->assertSee('id="password-match"', false)
            ->assertSee('Passwords match')
            ->assertSee("Passwords don't match");
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_password_is_stored_as_a_hash(): void
    {
        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Sunny-Day42',
            'password_confirmation' => 'Sunny-Day42',
        ]);

        $user = User::where('email', 'test@example.com')->firstOrFail();

        $this->assertNotSame('Sunny-Day42', $user->password);
        $this->assertTrue(Hash::check('Sunny-Day42', $user->password));
    }

    public function test_mismatched_password_confirmation_is_rejected(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Sunny-Day42',
            'password_confirmation' => 'Sunny-Day43',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/register')->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    public function test_password_shorter_than_eight_characters_is_rejected(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Short1!',
            'password_confirmation' => 'Short1!',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('password');
    }

    public function test_email_already_in_use_is_rejected(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'taken@example.com',
            'password' => 'Sunny-Day42',
            'password_confirmation' => 'Sunny-Day42',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
        $this->assertSame(1, User::where('email', 'taken@example.com')->count());
    }

    public function test_required_fields_are_validated(): void
    {
        $response = $this->from('/register')->post('/register', []);

        $this->assertGuest();
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_validation_errors_are_shown_on_the_form_and_old_input_is_kept(): void
    {
        $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'not-an-email',
            'password' => 'Sunny-Day42',
            'password_confirmation' => 'Sunny-Day42',
        ]);

        $this->get('/register')
            ->assertSee('id="email-error"', false)
            ->assertSee('value="Test User"', false)
            ->assertDontSee('Sunny-Day42');
    }
}
