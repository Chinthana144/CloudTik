<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;

class MikrotikStatus
{
    protected $client;
    public $isConnected = false;

    public function __construct($host, $user, $pwd, $port)
    {
        try{
            $this->client = new Client([
                'host' => $host,
                'user' => $user,
                'pass' => $pwd,
                'port' => intval($port),
                'timeout' => 3, // seconds
            ]);
            $this->isConnected = true; // success

        } catch (\Exception $e) {
            // Handle connection error
            // echo "Connection failed: " . $e->getMessage();
            $this->isConnected = false; // failed
        }
    } //constructor

    public function fetchAny($query)
    {
        $response = [];

        if($this->isConnected){
            $new_query = new Query($query);
            $response = $this->client->query($new_query)->read();

            return $response;
        }
        else{
            return $response;
        }
    }//fetch any

    public function getIdentity(){

        $response = [];

        if($this->isConnected){
            $query = new Query('/system/identity/print');
            $response = $this->client->query($query)->read();

            return $response;
        }
        else{
            return $response;
        }
    }//get identity

    public function getConnection(){

        $response = [];

        if($this->isConnected){
            $query = new Query('/ip/firewall/connection/print');
            $response = $this->client->query($query)->read();

            return $response;
        }
        else{
            return $response;
        }
    }//get identity

    public function dhcpLease(){

        $response = [];

        if($this->isConnected){
            $query = new Query('/ip/dhcp-server/lease/print');
            $response = $this->client->query($query)->read();

            return $response;
        }
        else{
            return $response;
        }
    }//get identity

    public function hotspotActive()
    {
        $response = [];

        if($this->isConnected){
            $query = new Query('/ip/hotspot/active/print');
            $response = $this->client->query($query)->read();

            return $response;
        }
        else{
            return $response;
        }
    }
}//class
