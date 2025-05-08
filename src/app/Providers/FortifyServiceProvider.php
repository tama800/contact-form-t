<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(CreatesNewUsers::class, CreateNewUser::class);

        // ログインレート制限（30回/分）
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(30)->by($request->email . $request->ip());
        });

        // ログインビュー
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 会員登録ビュー
        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
         ]);

        if ($validator->fails()) {
        throw new ValidationException(
            $validator,
            redirect()->back()->withErrors($validator)->withInput()
        );
        }

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
            return $user;
        }

            return null;
        });

    }
}
