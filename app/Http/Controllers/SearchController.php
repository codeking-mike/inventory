<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
{
    $query = $request->get('query');

    // Search across all models
    $results = [
        'Inverters' => \App\Models\Inverter::where('product_name', 'LIKE', "%{$query}%")->orWhere('model', 'LIKE', "%{$query}%")->get(),
        'Solar Panels' => \App\Models\SolarPanel::where('product_name', 'LIKE', "%{$query}%")->orWhere('model', 'LIKE', "%{$query}%")->get(),
        'Batteries' => \App\Models\Battery::where('product_name', 'LIKE', "%{$query}%")->orWhere('model', 'LIKE', "%{$query}%")->get(),
        'UPS' => \App\Models\Ups::where('product_name', 'LIKE', "%{$query}%")->orWhere('model', 'LIKE', "%{$query}%")->get(),
        'AVR' => \App\Models\Avr::where('product_name', 'LIKE', "%{$query}%")->orWhere('model', 'LIKE', "%{$query}%")->get(),
    ];

    // if this request was triggered by JavaScript (AJAX) return JSON
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json($results);
    }

    // otherwise render full search page
    return view('search.results', [
        'query'     => $query,
        'inverters' => $results['Inverters'],
        'panels'    => $results['Solar Panels'],
        'batteries' => $results['Batteries'],
        'ups'       => $results['UPS'],
        'avrs'      => $results['AVR'],
    ]);
}
}
