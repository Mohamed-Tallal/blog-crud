<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{
    public function setLocale(Request $request)
    {
        $this->validate($request, [
            'locale' => 'required'
        ]);

        $locale = $request->get('locale');
        Cache::forget('locale');
        Cache::put('locale', $locale, 60*60*24*30);
        App::setLocale($locale);
        return redirect()->back();
    }
}
