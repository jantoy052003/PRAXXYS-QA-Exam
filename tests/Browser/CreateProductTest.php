<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;

class CreateProductTest extends DuskTestCase
{
    
    /** @test */
    public function a_user_can_login_correctly(): void
    {
        $this->browse(function (Browser $browser) {
           $browser->visit('/login')
                   ->type('email', 'mayert.scot@example.com')
                   ->type('password', 'password')
                   ->click('button[type="submit"]')
                   ->assertSee('Products');
        });
    }

    /** @test */
    public function a_user_can_click_the_create_button_successfully(): void
    {
        $this->browse(function (Browser $browser) {
           $browser->visit('/product')
                   ->click('@create-btn')
                   ->assertSee('Product Create');
        });
    }
    

    //use DatabaseMigrations; 

    /** @test */
    public function a_user_can_create_product_successfully(): void
    {
        $this->browse(function (Browser $browser) {
           $browser->visit('/product/form')
                    ->type('input[type="text"]', 'Test Product3')
                    ->select('@select-category', '2')
                    ->within(".ck-editor__main", function (Browser $browser){
                        $browser->type(".ck-editor__editable", "Test product3");
                    })
                    ->pause(2000)
                    ->click("@next-btn")
                    ->pause(2000)
                    ->assertSee('Step 2 / 3')
                    //->click("@plus-btn") i still can't figure out how to automate selecting from file picker :(
                    ->attach('file-upload', public_path('/assets/images/test-img.jpg'))
                    ->pause(2000)
                    ->click("@next-btn")
                    ->assertSee('Step 3 / 3')
                    ->click('.dp__pointer')
                    ->pause(1000)
                    ->within('.dp__calendar_row', function (Browser $browser){
                        $browser->click('.dp__cell_inner', '27'); //time constraints, not selecting as i wanted to               
                    })
                    ->pause(2000)
                    ->within('.dp__action_row', function (Browser $browser){
                        $browser->click('.dp__action_button.dp__action_select');
                    })
                    ->pause(3000)
                    ->click('@submit-btn')
                    ->pause(2000)
                    // ->attach('input[type="file"]', base_path('downloads/test-img.jpg'))
                    // ->pause(2000)
                    // ->press('Open')
                    // ->pause(2000)
                    ->assertSee('Successfully Saved!');
                    // ->click("@next-btn")
                    // ->pause(2000)
                    // ->assertSee('Step 3 / 3');
        });
    }
}
