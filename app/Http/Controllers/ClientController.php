<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard()
    {
        // Logic for client dashboard
        return view('Client.client_analysis');
    }


}//class
