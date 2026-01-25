<?php

namespace App\Http\Controllers;

use App\Models\Ups;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UpsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $upsSystems = Ups::all();
        return view('ups.index', compact('upsSystems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'power_capacity' => 'required|numeric|min:0',
            'backup_time' => 'nullable|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string|max:255',
        ]);

        $ups = Ups::create($validated);

        // Create transaction record
        $transaction = Transaction::create([
            'date' => now()->toDateString(),
            'reference' => '', // Will be updated below
            'product_type' => 'ups',
            'particulars' => 'Added ' . $ups->product_name . ' (' . $ups->model . ')',
            'qty' => $ups->quantity_in_stock,
            'remarks' => $request->remarks ?? 'Initial stock added'
        ]);

        // Generate and update reference with format: 000 + date + id
        $reference = $this->generateReference($transaction->date, $transaction->id);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('ups.index')->with('success', 'UPS added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ups $ups)
    {
        return view('ups.show', compact('ups'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ups $ups)
    {
        return view('ups.edit', compact('ups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ups $ups)
    {
        $oldQty = $ups->quantity_in_stock;

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'power_capacity' => 'required|numeric|min:0',
            'backup_time' => 'nullable|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string|max:255',
        ]);

        $ups->update($validated);

        // Create transaction record if quantity changed
        $qtyDifference = $ups->quantity_in_stock - $oldQty;
        if ($qtyDifference != 0) {
            $transaction = Transaction::create([
                'date' => now()->toDateString(),
                'reference' => '', // Will be updated below
                'product_type' => 'ups',
                'particulars' => ($qtyDifference > 0 ? 'Stock added: ' : 'Stock removed: ') . $ups->product_name,
                'qty' => $qtyDifference,
                'remarks' => $request->remarks ?? 'Quantity updated from ' . $oldQty . ' to ' . $ups->quantity_in_stock
            ]);

            // Generate and update reference with format: 000 + date + id
            $reference = $this->generateReference($transaction->date, $transaction->id);
            $transaction->update(['reference' => $reference]);
        }

        return redirect()->route('ups.index')->with('success', 'UPS updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ups $ups)
    {
        $ups->delete();
        return redirect()->route('ups.index')->with('success', 'UPS deleted successfully');
    }

    public function showRemovalForm()
    {
        $upsUnits = Ups::all();
        return view('ups.remove', compact('upsUnits'));
    }

    public function storeRemoval(Request $request)
    {
        $validated = $request->validate([
            'ups_id' => 'required|exists:ups,id',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:255',
        ]);

        $ups = Ups::findOrFail($validated['ups_id']);

        if ($validated['quantity'] > $ups->quantity_in_stock) {
            return redirect()->back()->withErrors(['quantity' => 'Quantity to remove exceeds stock available.'])->withInput();
        }

        // Update UPS stock
        $ups->quantity_in_stock -= $validated['quantity'];
        $ups->save();

        // Create transaction record
        $transaction = Transaction::create([
            'date' => now()->toDateString(),
            'reference' => '', // Will be updated below
            'product_type' => 'ups',
            'particulars' => 'Removed ' . $validated['quantity'] . ' of ' . $ups->product_name,
            'qty' => -$validated['quantity'],
            'remarks' => $validated['remarks'] ?? 'Stock removal'
        ]);

        // Generate and update reference with format: 000 + date + id
        $reference = $this->generateReference($transaction->date, $transaction->id);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('ups.index')->with('success', 'UPS stock updated successfully');
    }   



    /**
     * Generate transaction reference with format: 00 + DD + MM + YY + sequence
     * Example: 0018012601 (00 + 18 day + 01 month + 26 year + 01 sequence)
     */
    private function generateReference($date, $transactionId)
    {
        $dateObj = \Carbon\Carbon::parse($date);
        $day = str_pad($dateObj->day, 2, '0', STR_PAD_LEFT);
        $month = str_pad($dateObj->month, 2, '0', STR_PAD_LEFT);
        $year = str_pad($dateObj->year % 100, 2, '0', STR_PAD_LEFT);
        
        // Count transactions for this date to create sequence number
        $sequence = Transaction::whereDate('date', $date)->count();
        $sequenceStr = str_pad($sequence, 2, '0', STR_PAD_LEFT);
        
        return '00' . $day . $month . $year . $sequenceStr;
    }
}
