<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
   public function index(Request $request)
{
    $query = shipping::with('country');

    if ($request->search) {
        $query->whereHas('country', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    $shippings = $query->paginate(10);

    return view('admin.shippings.index', compact('shippings'));
}

   // Show create form
    public function create()
    {
        $countries = Country::all();
        return view('admin.shippings.create', compact('countries'));
    }

public function store(Request $request)
{
    $request->validate([
        'country_id' => 'required|exists:countries,id',
        'shipping_price' => 'required|numeric'
    ]);

    shipping::updateOrCreate(
        ['country_id' => $request->country_id],
        ['amount' => $request->shipping_price]
    );

    return redirect()->route('admin.shippings.index')
        ->with('success', 'Shipping price saved successfully!');
}

public function edit($id)
{
    $shipping = shipping::findOrFail($id);
    $countries = Country::all();

    return view('admin.shippings.edit', compact('shipping', 'countries'));
}

 public function update(Request $request, $id)
{
    $request->validate([
        'country_id' => 'required|exists:countries,id',
        'amount' => 'required|numeric'
    ]);

    $shipping = shipping::findOrFail($id);
    $shipping->update([
        'country_id' => $request->country_id,
        'amount' => $request->amount,
    ]);

    return redirect()->route('admin.shippings.index')
        ->with('success', 'Shipping updated successfully!');
}

public function destroy($id)
{
    $shippingRecord = Shipping::findOrFail($id); // not Country::
    $shippingRecord->delete();

    return redirect()->route('admin.shippings.index')
        ->with('success', 'Shipping removed successfully!');
}
}
