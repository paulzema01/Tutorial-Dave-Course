<?php

namespace App\Http\Controllers;

use App\Support\DemoDashboardData;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the authenticated user's dashboard.
     */
    public function __invoke(Request $request): View
    {
        return view('dashboard', [
            'user' => $request->user(),
            'demo' => DemoDashboardData::make(),
        ]);
    }
}
