<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CheckSideBarLinksTest extends DuskTestCase
{
    public function testCRUDSidebar()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/')
                ->assertSee('Drop Zone')
                ->assertSee('Auto Suggest')
                ->assertSee('Lazy Load')
                ->assertSee('Excel Import and Export')
                ->assertSee('Generate PDF')
                ->assertSee('CRUD')
                ->assertSee('Import Export CSV')
                ->assertSee('Full Calander')
                ->assertSee('Weather API')
                ->assertSee('Encrypt and Decrypt')
                ->assertSee('Form Builder')
                ->assertSee('Image Crop');
        });
    }
}
