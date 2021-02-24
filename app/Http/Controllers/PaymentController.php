<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Payment;
use App\Models\Company;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function setCompanyId(Request $request)
    {
        $resource = DB::table('company')
        ->where('id', '=', $request->id)
        ->value('total');
        return response()->json(['success'=>'Data is successfully added', 'resource'=> $resource]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $companies = Company::all();

        if ($request->has('id')) 
        {
            $invoices = DB::table('invoice')
            ->join('company', 'company.id', '=', 'invoice.companyId')
            ->select('invoice.id', 'company.companyName', 'invoice.invTotal')
            ->where('company.companyId', '=', $request->companyId);
            return view('payment.createMain', compact('invoices', 'companies'));     
        }
        return view('payment.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment' => 'required',
        ]);
        Payment::create($request->all());

        $resource = DB::table('company')
        ->where('id', '=', $request->id)
        ->value('total');
        
        $company = Company::find($request->companyId);
        $company->total = $request->finalTotal;
        $company->save();
        return redirect()->action([PaymentController::class, 'index'])
                        ->with('success','Payment created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
