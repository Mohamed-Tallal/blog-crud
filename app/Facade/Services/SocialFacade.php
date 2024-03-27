<?php
namespace App\Facade\Services;

use App\Enums\SocialDriversEnums;
use App\Strategy\Interfaces\FCMInterface;
use App\Strategy\Interfaces\SMSInterface;
use App\Facade\Drivers\Socials\GmailDriver;
use App\Strategy\Interfaces\EMAILInterface;
use App\Facade\Drivers\Socials\GitHubDriver;
use App\Facade\Drivers\Socials\FacebookDriver;
use App\Facade\Contracts\SocialDriverInterface;

class SocialFacade
{
    protected static $socialDrivers = [
        SocialDriversEnums::FACEBOOK    => FacebookDriver::class,
        SocialDriversEnums::GITHUB      => GitHubDriver::class,
        SocialDriversEnums::GMAIL       => GmailDriver::class,
    ];


    public static function driver($driver)
    {

        if (!isset(self::$socialDrivers[$driver])) {
            throw new \InvalidArgumentException("Invalid Social Driver name");
        }

        switch ($driver) {
            case SocialDriversEnums::FACEBOOK:
                return app(FacebookDriver::class);
                break;
            case SocialDriversEnums::GITHUB:

                return app(GitHubDriver::class);
                break;
            case SocialDriversEnums::GMAIL:

                return app(GmailDriver::class);
                break;
            default:
                return app(FacebookDriver::class);
                break;
        }

    }
}
