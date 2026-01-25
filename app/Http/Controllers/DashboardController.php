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

    $threshold = 3;

    // Fetch low stock items from all categories
    $lowInverters = \App\Models\Inverter::where('quantity_in_stock', '<', $threshold)->get()->map(fn($item) => [
        'name' => $item->model_name,
        'qty' => $item->quantity_in_stock,
        'icon' => '🔹',
        'category' => 'Inverter'
    ]);

    $lowPanels = \App\Models\SolarPanel::where('quantity_in_stock', '<', $threshold)->get()->map(fn($item) => [
        'name' => $item->panel_model,
        'qty' => $item->quantity_in_stock,
        'icon' => '☀️',
        'category' => 'Solar Panel'
    ]);

    $lowBatteries = \App\Models\Battery::where('quantity_in_stock', '<', $threshold)->get()->map(fn($item) => [
        'name' => $item->battery_model,
        'qty' => $item->quantity_in_stock,
        'icon' => '🔋',
        'category' => 'Battery'
    ]);

    // Merge them into one collection for the view
    $stockAlerts = collect()
        ->concat($lowInverters)
        ->concat($lowPanels)
        ->concat($lowBatteries)
        ->sortBy('qty');

        return view('dashboard', compact('inverters', 'avrs', 'solarPanels', 'batteries', 'upsSystems', 'transactions', 'stockAlerts'));
    }

    public function show()
    {
        $threshold = 3;

    // Fetch low stock items from all categories
    $lowInverters = \App\Models\Inverter::where('quantity_in_stock', '<', $threshold)->get()->map(fn($item) => [
        'name' => $item->product_name,
        'qty' => $item->quantity_in_stock,
        'icon' => '🔹',
        'category' => 'Inverter'
    ]);

    $lowPanels = \App\Models\SolarPanel::where('quantity_in_stock', '<', $threshold)->get()->map(fn($item) => [
        'name' => $item->product_name,
        'qty' => $item->quantity_in_stock,
        'icon' => '☀️',
        'category' => 'Solar Panel'
    ]);

    $lowBatteries = \App\Models\Battery::where('quantity_in_stock', '<', $threshold)->get()->map(fn($item) => [
        'name' => $item->product_name,
        'qty' => $item->quantity_in_stock,
        'icon' => '🔋',
        'category' => 'Battery'
    ]);

     $lowUps = \App\Models\Ups::where('quantity_in_stock', '<', $threshold)->get()->map(fn($item) => [
        'name' => $item->product_name,
        'qty' => $item->quantity_in_stock,
        'icon' => '🔋',
        'category' => 'UPS'
    ]);

    // Merge them into one collection for the view
    $stockAlerts = collect()
        ->concat($lowInverters)
        ->concat($lowPanels)
        ->concat($lowBatteries)
        ->sortBy('qty');

        return view('lowstock', compact('stockAlerts'));
    }
    
}

