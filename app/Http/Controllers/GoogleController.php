<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        // with prompt will display a page where user need to choose account first.
        return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                return redirect()->intended('pvs');
            } else {
                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('password')
                ];

                $newUser = User::create($data);

                $newUser->assignRole("filament_user");

                $permissions = $newUser->getPermissionsViaRoles();
                $newUser->givePermissionTo($permissions);

                Auth::login($newUser);

                return redirect()->intended('pvs');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
