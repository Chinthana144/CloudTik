<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;

class MikrotikServices
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => '192.168.1.242',
            'user' => 'admin',
            'pass' => 'bluecat4',
            'port' => 8728,
        ]);
    }

    public function getInterfaces()
    {
        $query = new Query('/interface/print');
        return $this->client->query($query)->read();
    }

    public function getUsers()
    {
        $query = new Query('/user/print');
        return $this->client->query($query)->read();
    }

    public function addUser($name, $password)
    {
        $query = new Query('/user/add');
        $query->equal('name', $name)->equal('password', $password)->equal('group', 'read');

        return $this->client->query($query)->read();
    }
}//class
