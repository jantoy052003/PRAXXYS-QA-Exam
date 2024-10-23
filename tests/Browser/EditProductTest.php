<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;

class EditProductTest extends DuskTestCase
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
    public function a_user_can_edit_product_successfully(): void
    {
        $this->browse(function (Browser $browser) {
           $browser->visit('/product')
                    ->pause(2000)
                    ->scrollIntoView('.pagination')
                    ->click('#app > div > div > div > div.card-footer > nav > ul > li:nth-child(6) > a')
                    ->waitForLocation('/product')
                    ->click('tbody tr:last-child td:last-child .btn')
                    ->pause(2000)
                    ->waitForText('Product Update')
                    ->type('input[type="text"]', 'This is edited')
                    ->select('@select-category', '3')
                    ->within(".ck-editor__main", function (Browser $browser){
                        $browser->type(".ck-editor__editable", "Edit test");
                    })
                    ->pause(2000)
                    ->click("@next-btn")
                    ->pause(2000)
                    ->assertSee('Step 2 / 3')
                    ->attach('file-upload', public_path('/assets/images/test-img.jpg'))
                    ->pause(2000)
                    ->click("@next-btn")
                    ->assertSee('Step 3 / 3')
                    ->click('.dp__pointer')
                    ->pause(1000)

                    //Select date inside date picker
                    ->within('.dp__menu_inner', function (Browser $browser){      
                        $browser->click('button[aria-label="Open months overlay"]')                                
                                ->pause(3000)
                                ->within('.dp__overlay_container', function (Browser $overlay) {
                                    $overlay->click('.dp__overlay_row:nth-child(4) .dp__overlay_col:nth-child(2)'); //this selects August
                                })
                                ->pause(2000)
                                ->click('button[aria-label="Open years overlay"]')
                                ->pause(2000)
                                ->within('.dp__overlay_container', function (Browser $overlay) {
                                    $overlay->click('.dp__overlay_row:nth-child(43) .dp__overlay_col:nth-child(2)'); //this selects 2024
                                })
                                ->pause(2000)
                                ->within('.dp__calendar[aria-label="Calendar days"]', function (Browser $browser) {
                                    $browser->click('.dp__calendar_row:nth-child(4) .dp__calendar_item:nth-child(4)'); //this selects 22 in August
                                })
                                ->pause(2000);    
                    })
                    ->within('.dp__action_buttons', function (Browser $browser){
                        $browser->click('.dp__action_select');
                    })

                    ->pause(3000)
                    ->click('@submit-btn')
                    ->pause(2000)
                    ->assertSee('Successfully Updated!');
        });
    }
}
