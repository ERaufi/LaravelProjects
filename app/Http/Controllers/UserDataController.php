<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use WhichBrowser\Parser;

class UserDataController extends Controller
{
    //
    public function collectData(Request $request)
    {
        $userAgent = $request->header('User-Agent');
        $parser = new Parser($userAgent);

        $browser = $parser->browser->getName(); // Get browser name
        $browserVersion = $parser->browser->getVersion(); // Get browser version
        $os = $parser->os->getName(); // Get operating system name
        $osVersion = $parser->os->getVersion(); // Get operating system version

        $deviceBrand = $parser->device->getManufacturer(); // Get device brand or manufacturer
        $deviceModel = $parser->device->getModel(); // Get device model

        // Check if the device is a desktop
        $isDesktop = $parser->isType('desktop');

        // Check if the device is a smartphone
        $isSmartphone = $parser->isType('smartphone');

        // Check if the device is a tablet
        $isTablet = $parser->isType('tablet');





        $language = $request->server('HTTP_ACCEPT_LANGUAGE');
        $referrer = $request->server('HTTP_REFERER');
        $pageUrl = $request->fullUrl();
        $method = $request->method();

        return [
            'browser' => $browser,
            'browserVersion' => $browserVersion,
            'os' => $os,
            'osVersion' => $osVersion,
            'deviceBrand' => $deviceBrand,
            'deviceModel' => $deviceModel,
            'isDesktop' => $isDesktop,
            'isSmartphone' => $isSmartphone,
            'isTablet' => $isTablet,


            'language' => $language,
            'referrer' => $referrer,
            'pageUrl' => $pageUrl,
            'method' => $method,
        ];
    }
}
