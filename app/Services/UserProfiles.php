<?php

use RouterOS\Client;
use RouterOS\Query;

class UserProfiles
{
    protected $client;

    public function __construct($host, $user, $pwd, $port)
    {
        $this->client = new Client([
            'host' => $host,
            'user' => $user,
            'pass' => $pwd,
            'port' => $port,
        ]);
    }

    public function getPackages()
    {
        $query = new Query('/ip/hotspot/user/profile/print');
        return $this->client->query($query)->read();
    } //get packages

    public function createPackage($package_name, $download, $upload, $duration)
    {
        $speed = $download . "M/" . $upload . "M";
        $duration = $duration . "d";
        $query = new Query('/ip/hotspot/user/profile/add');
        $query->equal('name', $package_name);
        $query->equal('rate-limit', $speed);          // Upload/Download limit
        $query->equal('shared-users', 1);              // Number of concurrent logins
        $query->equal('session-timeout', $duration);        // Optional timeout
        $query->equal('keepalive-timeout', '30m');      // Optional

        $this->client->query($query);
    }

    public function updatePackage($package_name, $download, $upload, $duration)
    {
        $speed = $download . "M/" . $upload . "M";
        $duration = $duration . "d";

        $findQuery = (new Query('/ip/hotspot/user/profile/print'))
            ->where('name', $package_name);
        if (!empty($findQuery)) {
            $profile = $this->client->query($findQuery)->read()[0];

            $editQuery = new Query('/ip/hotspot/user/profile/set');
            $editQuery->equal('.id', $profile['.id']);
            $editQuery->equal('rate-limit', $speed);
            $editQuery->equal('session-timeout', $duration);

            $this->client->query($editQuery);
        }
    }
}//class user profiles
