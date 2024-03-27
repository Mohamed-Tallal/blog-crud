<?php
namespace App\Facade\Drivers\Socials;


use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Facade\Contracts\SocialDriverInterface;

class FacebookDriver implements SocialDriverInterface
{

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }
        catch(\Exception $e)
        {
            return false;
        }

    }

}
