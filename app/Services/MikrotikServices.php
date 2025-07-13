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
            'host' => 'hh50a4k5h3f.sn.mynetname.net',
            'user' => 'admin',
            'pass' => 'Admin*123',
            'port' => 8721,
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

        $response = $this->client->read();
        dd($response);
    }
}//class
