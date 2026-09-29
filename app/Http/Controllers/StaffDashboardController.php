<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $staff = $request->user()
            ->staffProfile;

        return view('staff.dashboard', compact('staff'));
    }
}