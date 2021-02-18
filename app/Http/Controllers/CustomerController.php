<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Company;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $invoices = DB::table('invoice')
       ->join('company', 'company.id', '=', 'invoice.companyId')
       ->select('invoice.id', 'company.companyName', 'invoice.invTotal')
       ->paginate(10);
        
        return view('customer.list',compact('invoices'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        $products = Product::all();
        return view('customer.create', compact('companies', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invId = count(Invoice::all())+1;
        $invoice = new Invoice;
        $invoice->companyId = $request['company'];
        $invoice->invTotal = $request['invTotal'];
        $invoice->save();
        for($orderCount = 0; $orderCount <= $request->rowNum ; $orderCount++)
        {
            $order = new Order;
            $order->invId = $invId;
            $order->prodId = $request->product[$orderCount];
            $order->weight = $request->weight[$orderCount];
            $order->Mweight = $request->Mweight[$orderCount];
            $order->price = $request->price[$orderCount];
            $order->total = $request->total[$orderCount];

            $order->save();
        }

        return redirect()->action([CustomerController::class, 'create'])
                        ->with('success','Invoice inserted successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $resource = Invoice::find($invoice)->first();
        return view('customer.show')->with('resource', $resource);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $resource = Invoice::find($invoice)->first();
        return view('customer.create')->with('resource', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'companyName' => 'required',
            'companyAddress' => 'required',
            'companyPhone' => 'required'
        ]);
    
        $invoice->update($request->all());
    
        return redirect()->action([CustomerController::class, 'index'])
                        ->with('success','Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->action([CustomerController::class, 'index'])
                        ->with('success','Invoice deleted successfully.');
    }
}
