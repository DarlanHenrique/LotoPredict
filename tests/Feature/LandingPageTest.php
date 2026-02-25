<?php

namespace Tests\Feature;

use App\Models\LotteryGame;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_is_accessible(): void
    {
        $response = $this->get(route('landing'));

        $response->assertStatus(200);
    }

    public function test_landing_page_contains_cta_for_guests(): void
    {
        $response = $this->get(route('landing'));

        $response->assertSee('Começar Grátis Agora');
        $response->assertSee('LotoPredict');
    }

    public function test_landing_page_shows_dashboard_link_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('landing'));

        $response->assertSee('Acessar Dashboard');
    }

    public function test_dashboard_is_accessible_to_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_dashboard_requires_authentication(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_predictions_create_page_shows_lottery_games(): void
    {
        $user = User::factory()->create();

        LotteryGame::create([
            'name' => 'Mega-Sena',
            'slug' => 'mega-sena',
            'min_number' => 1,
            'max_number' => 60,
            'numbers_drawn' => 6,
            'active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('predictions.create'));

        $response->assertStatus(200);
        $response->assertSee('Mega-Sena');
    }
}

