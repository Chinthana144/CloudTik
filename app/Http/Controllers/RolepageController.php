<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\RolePages;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all();
        $pages = Pages::all();
        $role_pages = RolePages::orderBy('role_id', 'asc')->get();

        return view('Pageaccess.page_access', compact('roles', 'pages', 'role_pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role_id = $request->input('cmb_role');
        $pages = Pages::all();

        //check role access
        $access_exists = RolePages::where('role_id', $role_id)->exists();

        if (!$access_exists) {

            foreach ($pages as $page) {
                $has_access = $request->has('page_' . $page->id) ? 1 : 0;

                RolePages::create([
                    'role_id' => $role_id,
                    'page_id' => $page->id,
                    'permissions' => $has_access,
                ]);
            }

            // dd(
            //     $home_access,
            // );
            return redirect()->route('rolepages.index');
        } //no access
        else {
            //show error
        }
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

    //=================== ajax methods ===================//
    public function updatePermission(Request $request)
    {
        $id = $request->input('id');
        $permission = $request->input('permission');

        $rolepage = RolePages::find($id);

        $rolepage->permissions = $permission;

        $rolepage->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
