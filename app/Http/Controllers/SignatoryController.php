<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use Illuminate\Http\Request;

class SignatoryController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ];
        
        // Department only required if not Direktur or Direktur Utama
        if (!in_array($request->position, ['Direktur', 'Direktur Utama'])) {
            $rules['department'] = 'required|exists:departments,id';
        }
        
        $request->validate($rules);
        
        Signatory::create([
            'name' => $request->full_name,
            'position' => $request->position,
            'department_id' => $request->department ?: null,
        ]);
        
        return redirect()->back()->with('success', 'Signatory added successfully!');
    }
}
