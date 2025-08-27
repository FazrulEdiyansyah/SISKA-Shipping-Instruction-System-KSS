<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create([
            'name' => $request->department_name,
        ]);

        return redirect()->back()->with('success', 'Department added successfully!');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        
        // Check if department has signatories
        if ($department->signatories()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete department that has signatories assigned.');
        }
        
        $department->delete();

        return redirect()->back()->with('success', 'Department deleted successfully!');
    }
}
