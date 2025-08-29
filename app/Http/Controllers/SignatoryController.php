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

    public function edit($id)
    {
        $signatory = Signatory::findOrFail($id);
        return response()->json($signatory);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ];
        
        if (!in_array($request->position, ['Direktur', 'Direktur Utama'])) {
            $rules['department'] = 'required|exists:departments,id';
        }
        
        $request->validate($rules);
        
        $signatory = Signatory::findOrFail($id);
        $signatory->update([
            'name' => $request->full_name,
            'position' => $request->position,
            'department_id' => $request->department ?: null,
        ]);
        
        return redirect()->back()->with('success', 'Signatory updated successfully!');
    }

    public function destroy($id)
    {
        $signatory = Signatory::findOrFail($id);
        $signatory->delete();

        return redirect()->back()->with('success', 'Signatory deleted successfully!');
    }
}
