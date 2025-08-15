<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['department_name' => 'required|string|max:255']);
        
        Department::create(['name' => $request->department_name]);
        
        return redirect()->back()->with('success', 'Department added successfully!');
    }
}
