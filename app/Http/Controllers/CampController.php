<?php

namespace App\Http\Controllers;

use App\Models\Camps;
use Illuminate\Http\Request;

class CampController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $camps = Camps::all();

        return view('camps.camp_view', compact('camps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('camps.camp_add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
