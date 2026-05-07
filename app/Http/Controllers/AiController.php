<?php

namespace App\Http\Controllers;

use App\Models\Arsip;

class AiController extends Controller
{
    public function index()
    {
        $totalArsip     = Arsip::count();
        $unclassified   = Arsip::whereNull('kategori')->count();
        $recentUploads  = Arsip::latest()->take(3)->get();

        return view('ai.index', compact('totalArsip', 'unclassified', 'recentUploads'));
    }
}
