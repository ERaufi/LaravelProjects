<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CheckFormTest extends DuskTestCase
{
    public function testFormElements()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/dusk-test')
                ->waitForLocation('/dusk-test')
                ->assertSee('Test Page for Laravel Dusk')
                ->type('text_input', 'This is A Test Text')
                ->select('select_option', 'option2')
                ->radio('radio_options', 'option1')
                ->check('#checkbox1')
                ->check('#checkbox2')

                ->scrollIntoView('#date_picker')
                ->pause(1000)
                ->click('#date_picker')
                ->within('.datepicker-dropdown', function (Browser $browser) {
                    $browser->click('table > tbody > tr:nth-child(3) > td:nth-child(5)');
                })

                ->attach('file_upload', public_path('/images/logo.png'))

                ->press('Open Bootstrap Modal')
                ->pause(1000)
                ->within('#exampleModal', function (Browser $browser) {
                    $browser->type('modal_text_input', 'This is A Test Text')
                        ->select('modal_select_option', 'option2')
                        ->radio('modal_radio_options', 'option1')
                        ->check('#modal_checkbox1')
                        ->check('#modal_checkbox2')
                        ->press('Close');
                })

                ->press('Show Alert')
                ->assertDialogOpened('This is a sample alert!')
                ->acceptDialog()

                ->press('Show Confirm Dialog')
                ->assertDialogOpened('Do you want to proceed?')
                ->dismissDialog()

                ->press('Show Confirm Dialog')
                ->assertDialogOpened('Do you want to proceed?')
                ->acceptDialog()

                ->pause(10000);
        });


    }
}
