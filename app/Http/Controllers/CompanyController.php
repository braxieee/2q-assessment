<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('company.index', compact('companies'));
    }

    public function create()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:companies',
            'logo' => 'required|image|mimes:jpeg,jpg|dimensions:max_width=100,max_height=100',
            'website' => 'required|string|unique:companies'
        ]);
        
        if ($validation->fails()) {
            return redirect()->route('company.store')->withErrors($validation)->withInput();
        }

        $companyName = $request->get('name');
        $companyEmail = $request->get('email');
        $companyWebsite = $request->get('website');

        //to store image at public folder =
        $image = $request->file('logo');
        $imageName = $image->getClientOriginalName();
        $storage_path = public_path('images');
        $image->move($storage_path, $imageName);

        //to insert data into companies table
        try {
            Company::create([
                'name' => $companyName,
                'email' => $companyEmail,
                'logo' => "images/".$imageName,
                'website' => $companyWebsite
            ]);

            return redirect()->route('company.index')->with(['color' => 'success', 'msg' => 'Company created successfully!']);

        } catch (\Exception $e) {
            return back()->with(['color' => 'error', 'msg' => 'There was an error while creating company.'])->withInput();
        }

    }

    public function edit($companyId)
    {
        $companyData = Company::find($companyId);

        return view('company.edit', compact('companyData'));
    }

    public function update(Request $request, $companyId)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'logo' => 'image|mimes:jpeg,jpg|dimensions:max_width=100,max_height=100',
            'website' => 'required|string'
        ]);
        
        if ($validation->fails()) {
            return redirect()->route('company.edit', $companyId)->withErrors($validation)->withInput();
        }

        $companyName = $request->get('name');
        $companyEmail = $request->get('email');
        $companyWebsite = $request->get('website');
        
        try {
            $companyData = Company::find($companyId);

            if($companyData->name != $companyName){
                $companyData->name = $companyName;
            }

            if($companyData->email != $companyEmail){
                $companyData->email = $companyEmail;
            }

            if($request->file('logo')){
                $image = $request->file('logo');
                $imageName = $image->getClientOriginalName();
                $storage_path = public_path('images');
                $image->move($storage_path, $imageName);

                if($companyData->logo != $companyName){
                    $companyData->logo = "images/".$imageName;
                }
            }

            if($companyData->website != $companyWebsite){
                $companyData->website = $companyWebsite;
            }

            $companyData->save();

            return redirect()->route('company.index')->with(['color' => 'success', 'msg' => 'Company updated successfully!']);

        } catch (\Exception $e) {
            return back()->with(['color' => 'error', 'msg' => 'There was an error while updating company.'])->withInput();
        }
    }

    public function delete($companyId)
    {
        try{
            $company = Company::find($companyId);

            if($company){
                //to delete image on public folder
                $imagePath = public_path('images/' . $company->logo);

                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }

                $company->forceDelete();
            }

            return redirect()->route('company.index')->with(['color' => 'success', 'msg' => 'Company deleted successfully!']);

        } catch (\Exception $e) {
            return back()->with(['color' => 'error', 'msg' => 'There was an error while deleting company.'])->withInput();
        }
    }
}
