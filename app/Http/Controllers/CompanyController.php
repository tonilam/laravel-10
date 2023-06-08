<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Company;

class CompanyController extends Controller
{
    public function index(): View
    {
        $perPage = 10;
        $companies = Company::orderBy('updated_at','desc')->paginate($perPage);
        return view('companies.index', compact('companies'));
    }

    public function show(Company $company): View
    {
        return view('companies.show',compact('company'));
    }
    
    public function create(): View
    {
        return view('companies.create');
    }
    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);
        
        Company::create($request->post());

        return redirect()->route('companies.index')->with('success','Company has been created successfully.');
    }

    public function edit(Company $company) {
        return view('companies.edit',compact('company'));
    }

    public function update(Request $request, Company $company): RedirectResponse {
         $request->validate([
            'name' => 'required',
        ]);
        
        $company->fill($request->post())->save();

        return redirect()->route('companies.index')->with('success','Company has been updated successfully');
    }
    
    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success','Company has been deleted successfully');
    }
}
