<?php

namespace App\Http\Controllers;

use App\Models\Avr;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AvrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avrs = Avr::all();
        return view('avrs.index', compact('avrs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('avrs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'capacity' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string|max:255',
        ]);

        $avr = Avr::create($validated);

        // Create transaction record
        $transaction = Transaction::create([
            'date' => now()->toDateString(),
            'reference' => '', // Updated below
            'product_type' => 'avr',
            'particulars' => 'Added ' . $avr->product_name . ' (' . $avr->model . ')',
            'qty' => $avr->quantity_in_stock,
            'remarks' => $request->remarks ?? 'Initial stock added'
        ]);

        $reference = $this->generateReference($transaction->date);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('avrs.index')->with('success', 'AVR added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Avr $avr)
    {
        return view('avrs.show', compact('avr'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Avr $avr)
    {
        return view('avrs.edit', compact('avr'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Avr $avr)
    {
        $oldQty = $avr->quantity_in_stock;

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'capacity' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string|max:255',
        ]);

        $avr->update($validated);

        $qtyDifference = $avr->quantity_in_stock - $oldQty;
        if ($qtyDifference != 0) {
            $transaction = Transaction::create([
                'date' => now()->toDateString(),
                'reference' => '',
                'product_type' => 'avr',
                'particulars' => ($qtyDifference > 0 ? 'Stock added: ' : 'Stock removed: ') . $avr->product_name,
                'qty' => $qtyDifference,
                'remarks' => $request->remarks ?? 'Quantity updated from ' . $oldQty . ' to ' . $avr->quantity_in_stock
            ]);

            $reference = $this->generateReference($transaction->date);
            $transaction->update(['reference' => $reference]);
        }

        return redirect()->route('avrs.index')->with('success', 'AVR updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Avr $avr)
    {
        $avr->delete();
        return redirect()->route('avrs.index')->with('success', 'AVR deleted successfully');
    }

    /**
     * Show the form for removing stock.
     */
    public function showRemovalForm()
    {
        $avrs = Avr::all();
        return view('avrs.remove', compact('avrs'));
    }

    /**
     * Store the AVR removal and create transaction.
     */
    public function storeRemoval(Request $request)
    {
        $validated = $request->validate([
            'avr_id' => 'required|exists:avrs,id',
            'particulars' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
            'date' => 'required|date',
            'remarks' => 'nullable|string|max:255',
        ]);

        $avr = Avr::findOrFail($validated['avr_id']);

        if ($validated['qty'] > $avr->quantity_in_stock) {
            return redirect()->back()->withErrors([
                'qty' => 'Cannot remove more than available in stock (' . $avr->quantity_in_stock . ')'
            ])->withInput();
        }

        $avr->update([
            'quantity_in_stock' => $avr->quantity_in_stock - $validated['qty']
        ]);

        $transaction = Transaction::create([
            'date' => $validated['date'],
            'reference' => '',
            'product_type' => 'avr',
            'particulars' => $validated['particulars'],
            'qty' => -$validated['qty'],
            'remarks' => $validated['remarks'] ?? 'AVR removed from stock'
        ]);

        $reference = $this->generateReference($transaction->date);
        $transaction->update(['reference' => $reference]);

        return redirect()->route('avrs.index')->with('success', 'AVR removed successfully. Reference: ' . $reference);
    }

    /**
     * Generate transaction reference: 00 + DD + MM + YY + sequence
     */
    private function generateReference($date)
    {
        $dateObj = Carbon::parse($date);
        $day = str_pad($dateObj->day, 2, '0', STR_PAD_LEFT);
        $month = str_pad($dateObj->month, 2, '0', STR_PAD_LEFT);
        $year = str_pad($dateObj->year % 100, 2, '0', STR_PAD_LEFT);
        
        $sequence = Transaction::whereDate('date', $date)->count();
        $sequenceStr = str_pad($sequence, 2, '0', STR_PAD_LEFT);
        
        return '00' . $day . $month . $year . $sequenceStr;
    }
}
