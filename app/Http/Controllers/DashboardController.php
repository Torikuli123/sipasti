<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArsip      = Arsip::count();
        $arsipAktif      = Arsip::active()->count();
        $arsipBaru       = Arsip::where('created_at', '>=', now()->subDay())->count();
        $totalUsers      = User::count();
        $recentArsip     = Arsip::latest()->take(3)->get();
        $recentActivities = Arsip::with('user')->latest('updated_at')->take(4)->get();

        return view('dashboard.index', compact(
            'totalArsip',
            'arsipAktif',
            'arsipBaru',
            'totalUsers',
            'recentArsip',
            'recentActivities'
        ));
    }
}
