<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CheckCRUDTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testCheckCRUDForm()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/products')
                ->clickLink('Create Product')
                ->waitForLocation('/products/create')
                ->assertsee('Create Product')
                ->type('name', 'test Name')
                ->type('quantity', '12')
                ->type('buyingPrice', 20)
                ->type('sellingPrice', 30)
                ->type('image_url', 'https://unsplash.com/photos/a-box-filled-with-lots-of-different-colored-ornaments-vqUnGm6vkXA')
                ->type('weight', '23')
                ->type('description', 'this is from Laravel DUSK')
                ->press('Create')
                ->waitForLocation('/products')
                ->waitForText('Product created successfully')
                ->assertSee('Product created successfully');
        });
    }

    public function testEdit()
    {
        $this->browse(function (Browser $browser) {
            $browser->scrollIntoView('#paginiation')
                ->pause(2000)
                ->click('#paginiation > nav > div.d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between > div:nth-child(2) > ul > li:nth-child(14) > a')
                ->waitForLocation('/products')
                ->click('tbody tr:last-child td:last-child .editButton')
                ->pause(3000)
                ->waitForText('Edit Product')
                ->assertInputValue('name', 'test Name')
                ->assertInputValue('quantity', '12')
                ->assertInputValue('buyingPrice', 20)
                ->assertInputValue('sellingPrice', 30)
                ->assertInputValue('image_url', 'https://unsplash.com/photos/a-box-filled-with-lots-of-different-colored-ornaments-vqUnGm6vkXA')
                ->assertInputValue('weight', '23')
                ->assertInputValue('description', 'this is from Laravel DUSK');
        });
    }

    public function testCheckValidations()
    {
        $this->browse(function (Browser $browser) {
            $browser->type('name', '')
                ->type('quantity', '')
                ->type('buyingPrice', '')
                ->type('sellingPrice', '')
                ->type('image_url', '')
                ->type('weight', '')
                ->type('description', '')
                ->press('Update')
                ->waitForText('The selling price field is required.')
                ->assertSee('The buying price field is required.')
                ->assertSee('The quantity field is required.')
                ->assertSee('The name field is required');
        });
    }

    public function testDeleting()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/products')
                ->scrollIntoView('#paginiation')
                ->pause(2000)
                ->click('#paginiation > nav > div.d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between > div:nth-child(2) > ul > li:nth-child(14) > a')
                ->waitForLocation('/products')
                ->click('tbody tr:last-child td:last-child .deleteButton')
                ->acceptDialog()
                ->waitForText('Product deleted successfully')
                ->assertSee('Product deleted successfully');
        });
    }
}
