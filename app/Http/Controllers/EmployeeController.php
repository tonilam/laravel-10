<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $perPage = 10;
        $employees = Employee::orderBy('updated_at','desc')->paginate($perPage);
        return view('employees.index', compact('employees'));
    }

    public function show(Employee $employee): View
    {
        return view('employees.show',compact('employee'));
    }
    
    public function create(): View
    {
        return view('employees.create');
    }
    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'sometimes|email',
        ]);
        
        Employee::create($request->post());

        return redirect()->route('employees.index')->with('success','Employee has been created successfully.');
    }

    public function edit(Employee $employee) {
        return view('employees.edit',compact('employee'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse {
         $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        
        $employee->fill($request->post())->save();

        return redirect()->route('employees.index')->with('success','Employee has been updated successfully');
    }
    
    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success','Employee has been deleted successfully');
    }
}
