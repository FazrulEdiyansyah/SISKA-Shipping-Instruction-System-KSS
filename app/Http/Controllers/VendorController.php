<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::orderBy('created_at', 'desc')->get();
        return view('vendor.ship-vendor-management', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company' => 'required|string|max:255|unique:vendors,company',
            'initials' => 'required|string|max:5',
        ]);

        \App\Models\Vendor::create([
            'company' => $request->company,
            'initials' => strtoupper($request->initials),
            'status' => 'Active',
        ]);

        return redirect()->route('vendor.index')->with('success', 'Vendor added successfully!');
    }
}
