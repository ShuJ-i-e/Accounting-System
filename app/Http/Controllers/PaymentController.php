<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Payment;
use App\Models\Company;
use App\Models\Invoice;
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
        $payments = DB::table('payment')
        ->join('company', 'company.id', '=', 'payment.companyId')
        ->select('payment.id', 'company.companyName', 'payment.payment')
        ->paginate(10);
         
        return view('payment.list',compact('payments'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function setCompanyId(Request $request)
    {
        $resource = DB::table('company')
        ->select('companyDebt', 'companyBalance')
        ->where('id', '=', $request->id)
        ->get(); //get companyDebt and companyBalance based on company id
        
        $invoices = DB::table('invoice')
        ->join('company', 'company.id', '=', 'invoice.companyId')
        ->select('invoice.id', 'company.companyName', 'invoice.invTotal', 'invoice.created_at')
        ->where('company.id', '=', $request->id)
        ->where('payment', '=', '0')
        ->get(); //get unpaid invoice based on company id
        
        return response()->json(['success'=>'Data is successfully added', 'resource'=> $resource, 'invoice' => $invoices]); //return json response to ajax request
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
        $payment = new Payment;
        $payment->companyId = $request->companyId;
        $payment->payment = $request->payment;
        $payment->save(); //create new row in payment table
        
        $company = Company::find($request->companyId);
        $company->companyDebt = $request->debtAfter;
        $company->companyBalance = $request->balance;
        $company->save(); //update company debt and balance

        //update invoice from unpaid to paid, table-invoice, column-payment
        $invoiceLength = count($request->inoviceIdList);
        for ($i = 0; $i < $invoiceLength; $i++)  
        {
            $invoice = Invoice::find($request->inoviceIdList[$i]);
            $invoice->payment = true;
            $invoice->save();
        }
        return response()->json(['url'=>url('/payment')]); //return response to ajax request
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
