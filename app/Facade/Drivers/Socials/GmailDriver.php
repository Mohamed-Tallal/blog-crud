<?php
namespace App\Facade\Drivers\Socials;

use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Facade\Contracts\SocialDriverInterface;

class GmailDriver implements SocialDriverInterface
{

    public function redirectToProvider(sting $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider)
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
