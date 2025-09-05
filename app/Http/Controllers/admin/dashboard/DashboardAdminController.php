<?php

namespace App\Http\Controllers\admin\dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\users\Admin;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    public function showDashboard() {
        $admin = Auth::guard('admin')->user();

        $dataAdmin = Admin::where('email', $admin->email)
            ->makeHidden(['password'])
            ->first();

        return view('admin.dashboard', compact('dataAdmin'));
    }
}
