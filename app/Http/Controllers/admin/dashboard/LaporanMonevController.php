<?php

namespace App\Http\Controllers\admin\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\users\Admin;
use Illuminate\Support\Facades\Auth;

class LaporanMonevController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        //
        $admin = Auth::guard('admin')->user();

        $dataAdmin = Admin::where('email', $admin->email)
            ->where('user_id', $admin->user_id)
            ->first();

        $dataAdmin->makeHidden(['password']);

        // return dd($dataAdmin);

        return view('admin.laporan-monev', ['dataAdmin'=>$dataAdmin]);
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
