<?php

namespace App\Http\Controllers;
use DB;
use PDF;
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
        $invId = Invoice::all()->last()->id + 1;
        $invoice = new Invoice;
        $invoice->companyId = $request['company'];
        $invoice->invTotal = $request['invTotal'];
        $invoice->save();
        
        $company = Company::find($request['company']);
        $company->companyDebt = $company->companyDebt + $request['invTotal'];
        $company->save();

        for($orderCount = 0; $orderCount <= $request->rowNum ; $orderCount++)
        {
            if ( isset($request->product[$orderCount])) 
            {
                $order = new Order;
                $order->invId = $invId;
                $order->prodId = $request->product[$orderCount];
                $order->weight = $request->weight[$orderCount];
                $order->Mweight = $request->Mweight[$orderCount];
                $order->price = $request->price[$orderCount];
                $order->total = $request->total[$orderCount];
                $order->remarks = $request->remarks[$orderCount];
                $order->save();
            }
        }

        return redirect()->action([CustomerController::class, 'index'])
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
        $companies = Company::all();
        $products = Product::all();

        $invoices = DB::table('invoice')
        ->join('company', 'company.id', '=', 'invoice.companyId')
        ->where('id', '=', "56")
        ->get();

        $orders = DB::table('order')
        ->join('invoice', 'invoice.id', '=', 'order.invId')
        ->join('product', 'product.id', '=', 'order.prodId')
        ->where('invId', '=', "56")
        ->get();

        // $resource = Invoice::find($invoice)->first();
        $data = array(
            "invoices" => $invoices,
            "orders" => $orders,
            "companies" => $companies,
            "products" => $products
        ); 

        return view('customer.edit')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $invoices = DB::table('invoice')
        ->join('company', 'company.id', '=', 'invoice.companyId')
        ->where('id', '=', $invoice);

        $orders = DB::table('order')
        ->join('invoice', 'invoice.id', '=', 'order.invId')
        ->join('product', 'product.id', '=', 'order.prodId')
        ->where('invId', '=', $invoice);

        // $invoice = $invoices->find($invoice);
 
        // $resource = Invoice::find($invoice)->first();
        // $companies = Company::where($id);
        // $products = Product::all();
        return view('customer.create')->compact($invoices, $orders);
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
