<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $pendampingRandom = null;
        if (auth()->check() && auth()->user()->role == 'penerima') {
            $pendampingRandom = \App\Models\Pendamping::inRandomOrder()->first();
        }
        return view('dashboard', [
            'title' => 'Dashboard',
            'menuDashboard' => 'active',
            'pendampingRandom' => $pendampingRandom
        ]);
    }
}
