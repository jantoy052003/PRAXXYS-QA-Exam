<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LogInTest extends DuskTestCase
{
    /** @test */
    public function a_user_can_login_correctly(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->typeSlowly('email', 'mayert.scot@example.com')
                    ->typeSlowly('password', 'password')
                    ->click('button[type="submit"]')
                    ->assertSee('Products');
        });
    }

    /** @test */
    public function a_user_can_logout_correctly(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/product')
                    ->clickLink('Logout')
                    ->assertSee('Sign In');
        });
    }
}
