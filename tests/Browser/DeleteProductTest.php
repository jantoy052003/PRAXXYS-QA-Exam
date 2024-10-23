<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DeleteProductTest extends DuskTestCase
{
    /** @test */
    public function a_user_can_login_correctly(): void
    {
        $this->browse(function (Browser $browser) {
           $browser->visit('/login')
                   ->type('email', 'mohr.marietta@example.com')
                   ->type('password', 'password')
                   ->click('button[type="submit"]')
                   ->assertSee('Products');
        });
    }

     /** @test */
     public function a_user_can_cancel_delete_modal_successfully(): void
     {
         $this->browse(function (Browser $browser) {
            $browser->visit('/product')
                    ->waitForLocation('/product')
                    ->pause(2000)
                    ->click('#app > div > div > div > div.card-body.table-responsive > table > tbody > tr:nth-child(1) > td.col-1 > div > a.btn.btn-danger.my-1')
                    ->pause(2000)
                    ->within('.swal2-popup', function (Browser $browser){                       
                            $browser->press('Cancel');                       
                    })
                    ->pause(2000)
                    ->assertSee('Products');
         });
     }

     /** @test */
    public function a_user_can_delete_product_successfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/product')
                    ->waitForLocation('/product')
                    ->pause(2000)
                    ->click('#app > div > div > div > div.card-body.table-responsive > table > tbody > tr:nth-child(1) > td.col-1 > div > a.btn.btn-danger.my-1')
                    ->pause(2000)
                    ->assertSee('Are you sure?');
        });
    }
}    