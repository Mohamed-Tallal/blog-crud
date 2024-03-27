<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Enums\SocialDriversEnums;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Facade\Services\SocialFacade;
use Illuminate\Support\Facades\Cache;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use App\Repositories\Interfaces\UserRepositoryInterface;

class SocialiteController extends Controller
{

    
    public function __construct(readonly UserRepositoryInterface $userRepository)
    {
    }

    public function redirectToProvider($provider)
    {
        $driver = SocialFacade::driver($provider);
        return $driver->redirectToProvider($provider);
    }


    public function handleCallback($provider)
    {
        $driver = SocialFacade::driver($provider);
        $socialUser = $driver->handleProviderCallback($provider);

        $user = $this->getUserBySocialProvider($socialUser, $provider);
        
        if ($user) {
            Auth::login($user);
            Cache::forget('authUser');
            Cache::put('authUser', $user, 60*60*1000);

            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            return redirect('/');
        }
    }


    
    private function getUserBySocialProvider($socialUser, $provider)
    {
        $socialProvider = $this->userRepository->getByCondition(['provider_id' => $socialUser->getId()]);
        
        if (!$socialProvider) {
            $user =  $this->userRepository->getByCondition(['email' => $socialUser->email]);
            
            if (!$user) {
                $user = $this->createUserWithSocialProvider($socialUser, $provider);
            }
        } else {
            $user = $socialProvider->user;
        }
        
        return $user;
    }


    private function createUserWithSocialProvider($socialUser, $provider)
    {
        $user = $this->userRepository->store([
            'email'         => $socialUser->email,
            'name'          => $socialUser->name,
            'password'      => bcrypt('123456'),
            'is_provider'   => 1,
        ]);
        
        $user->socialProviders()->create(['provider_id' => $socialUser->getId(), 'provider' => $provider]);
        
        return $user;
    }

}