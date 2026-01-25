<?php

namespace App\Http\Controllers;

use App\Models\Inverter;
use App\Models\Avr;
use App\Models\SolarPanel;
use App\Models\Battery;
use App\Models\Ups;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $inverters = Inverter::all();
        $avrs = Avr::all();
        $solarPanels = SolarPanel::all();
        $batteries = Battery::all();
        $upsSystems = Ups::all();
        $transactions = Transaction::latest()->paginate(10);

        return view('dashboard', compact('inverters', 'avrs', 'solarPanels', 'batteries', 'upsSystems', 'transactions'));
    }
    
}

