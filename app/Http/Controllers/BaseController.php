<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class BaseController extends Controller
{
    public function renderUserList() {
        return view('user-list', [
            'users' => DB::table('users')->paginate(15)
        ]);
    }

    public function getFacebookCredentials(): JsonResponse {
        $user = Auth::user();
        return response()->json([
            'accessToken' => $user->facebook_token,
            'pageId' => $user->facebook_page
        ]);
    }

    public function showProfile() {
        $user = Auth::user();
        $model = [
            'name' => $user->name,
            'language' => $user->language,
            'facebook_token' => $user->facebook_token,
            'facebook_page' => $user->facebook_page
        ];
        return view('profile', ['model' => $model]);
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|min:4',
            'language' => 'required|string',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->language = $request->language;
        $user->facebook_token = $request->token;
        $user->facebook_page = $request->page;

        if ($user->save()) {
            $cookie = [];
            if (App::getLocale() !== $user->language) {
                App::setLocale($user->language);
                $cookie = [cookie('lang', $user->language, 1000)];
            }
            return redirect('profile')->with('success', __('Your data was successfully updated.'))->withCookies($cookie);
        } else {
            dd('err');
            return redirect(url()->previous())->withInput()->with('error', __('Error occurred! Data was not saved!'));
        }
    }
}
