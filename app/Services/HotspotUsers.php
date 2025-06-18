<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;

class HotspotUsers
{
    protected $client;

    public function __construct($host, $user, $pwd, $port)
    {
        $this->client = new Client([
            'host' => $host,
            'user' => $user,
            'pass' => $pwd,
            'port' => (int)$port,
        ]);
    } //constructor

    public function addHotspotUser($username, $user_pwd, $package_name)
    {
        $query = new Query('/ip/hotspot/user/add');
        $query->equal('name', $username);
        $query->equal('password', $user_pwd);
        $query->equal('profile', $package_name); // Assign to created profile
        // $query->equal('comment', 'Created by CloudTik system');

        try {
            $this->client->query($query)->read();
            // echo "Hotspot user created successfully!";
        } catch (\Exception $e) {
            echo "Error creating hotspot user: " . $e->getMessage();
        }
    }

    public function getAllhotspotUsers()
    {
        $query = new Query('/ip/hotspot/user/print');
        $query->equal('.proplist', '.id,name,password,profile,comment');

        try {
            $response = $this->client->query($query)->read();
            return $response;
        } catch (\Exception $e) {
            echo "Error fetching hotspot users: " . $e->getMessage();
            return [];
        }
    }

    public function getHotspotUserByUsername($username)
    {
        $query = new Query('/ip/hotspot/user/print');
        $query->equal('name', $username);
        $query->equal('.proplist', '.id,name,password,profile,comment');

        try {
            $response = $this->client->query($query)->read();
            return $response;
        } catch (\Exception $e) {
            echo "Error fetching hotspot user: " . $e->getMessage();
            return [];
        }
    }

    public function deleteHotspotUser($username)
    {
        $query = new Query('/ip/hotspot/user/remove');
        $query->equal('numbers', $username);

        try {
            $this->client->query($query)->read();
            // echo "Hotspot user deleted successfully!";
        } catch (\Exception $e) {
            echo "Error deleting hotspot user: " . $e->getMessage();
        }
    }

    //check connection
    public function CheckConnection(): bool
    {
        $pastha = false;
        try {
            $query = new \RouterOS\Query('/system/identity/print');
            $this->client->query($query)->read();
            $pastha = true;
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            //Log::error('MikroTik connection failed: ' . $e->getMessage());
            $pastha = false;
        }

        return $pastha;
    }
}//hotspot users class
