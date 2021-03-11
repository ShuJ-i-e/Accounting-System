<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = Company::paginate(10); //retrieve company data from database and paginate to 10 in a page
    
        if ($request->has('export')) //if request has export (/company?export)
        {
             if ($request->get('export') == 'pdf') { //if export = pdf (/company?export=pdf)
                 $pdf = PDF::loadView('company.pdfView', compact('companies')); //pdfview = company.pdfview
                 return $pdf->download('companyList.pdf'); //download the pdf file
             }
        }

        return view('company.list',compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5); //return company.list
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create'); //return empty form
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([ //validate inputs
            'companyName' => 'required',
            'companyAddress' => 'required',
            'companyPhone' => 'required'
        ]);
    
        Company::create($request->all()); //add new row in database
     
        return redirect()->action([CompanyController::class, 'index'])
                        ->with('success','Company inserted successfully.'); //return to company.list if create is success
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $resource = Company::find($company)->first(); //find company data based on company id
        return view('company.show')->with('resource', $resource); //return  company.show with company data retrieved
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $resource = Company::find($company)->first(); //find company data based on company id
        $edit = true; //variable to distinguish edit and display

        return view('company.show', compact('resource', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([ //validate inputs
            'companyName' => 'required',
            'companyAddress' => 'required',
            'companyPhone' => 'required'
        ]);
    
        $company->update($request->all());
    
        return redirect()->action([CompanyController::class, 'index'])
                        ->with('success','Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->action([CompanyController::class, 'index'])
                        ->with('success','Company deleted successfully.');
    }
}
