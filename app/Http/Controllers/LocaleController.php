<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LocaleController extends Controller
{
    public function setLocale(string $lang): RedirectResponse
    {
        $cookie = [];
        if (in_array($lang, config('app.allowed_locales'))) {
            App::setLocale($lang);
            $user = Auth::user();
            if ($user) {
                $user->language = $lang;
                $user->save();
            }
            $cookie = [cookie('lang', $lang, 1000)];
        }

        return redirect()->back()->withCookies($cookie);
    }
}
