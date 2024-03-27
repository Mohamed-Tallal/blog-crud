<?php
namespace App\Facade\Contracts;


interface SocialDriverInterface
{
    /**
     * Execute the driver logic.
     *
     * @param  array  $data
     * @return array
     */
    public function redirectToProvider($provider);

    public function handleProviderCallback($provider);

}
