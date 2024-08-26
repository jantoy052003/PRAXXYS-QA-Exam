<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SearchTest extends DuskTestCase
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
     public function a_user_can_search_products_successfully(): void
     {
         $this->browse(function (Browser $browser) {
            $browser->visit('/product')
                    ->type('input[type="text"]', 'tempora')
                    ->click('@search-btn')
                    ->pause(1000)
                    ->assertSee('Beauty & Personal Care');
         });
     }

     /** @test */
     public function a_user_can_search_using_Search_Products_with_Select_Category_filter_successfully(): void
     {
         $this->browse(function (Browser $browser) {
            $browser->visit('/product')
                    ->type('input[type="text"]', 'cum')
                    //->click('select')
                    ->select('@select-category', '3')
                    ->click('select')
                    ->pause(1000)
                    ->click('@search-btn')
                    ->pause(1000)
                    ->assertSee('Home & Furnitures');
         });
     }

     /** @test */
     public function a_user_can_search_products_using_only_Select_Category_successfully(): void
     {
         $this->browse(function (Browser $browser) {
            $browser->visit('/product')
                    ->select('@select-category', '1')
                    ->click('select')
                    ->pause(1000)
                    ->click('@search-btn')
                    ->pause(1000)
                    ->assertSee('Electonics');
         });
     }
}
