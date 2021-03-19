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
            if ( isset($request->product[$orderCount])) //if the row is not deleted
            {
                $order = new Order;
                $order->invId = $invId;
                $order->prodId = $request->product[$orderCount];
                $order->weight = $request->weight[$orderCount];
                $order->quantity = $request->quantity[$orderCount];
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
    public function show(int $invoice, Request $request)
    {
        $invoices = DB::table('invoice')
        ->join('company', 'company.id', '=', 'invoice.companyId')
        ->select('company.companyName', 'invoice.invTotal', 'invoice.id')
        ->where('invoice.id', "=", $invoice)
        ->first();

        $orders = DB::table('order')
        ->join('invoice', 'invoice.id', '=', 'order.invId')
        ->join('product', 'product.id', '=', 'order.prodId')
        ->select('product.prodName', 'order.weight', 'order.Mweight', 'order.price', 'order.total', 'order.remarks', 'order.quantity')
        ->where('order.invId', "=", $invoice)
        ->get();

        $resource = array(
            "invoices" => $invoices,
            "orders" => $orders,
        ); 

        if ($request->has('export')) 
        {
             if ($request->get('export') == 'pdf') {
                 $pdf = PDF::loadView('customer.pdfView', compact('invoices', 'orders'));
                 return $pdf->download('invoice.pdf');
             }
        }

        return view('customer.show')->with($resource);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(int $invoice)
    {
        $invoices = DB::table('invoice')
        ->join('company', 'company.id', '=', 'invoice.companyId')
        ->select('company.companyName', 'invoice.companyId', 'invoice.invTotal', 'invoice.id')
        ->where('invoice.id', "=", $invoice)
        ->first();

        $orders = DB::table('order')
        ->join('invoice', 'invoice.id', '=', 'order.invId')
        ->join('product', 'product.id', '=', 'order.prodId')
        ->select('product.prodName', 'order.weight', 'order.Mweight', 'order.price', 'order.total', 'order.remarks', 'order.id', 'order.quantity')
        ->where('order.invId', "=", $invoice)
        ->get();

        $products = Product::all();

        $resource = array(
            "invoices" => $invoices,
            "orders" => $orders,
            "products" => $products
        ); 

        return view('customer.edit')->with($resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $invoice)
    {
        $company = Company::find($request->compId);
        $company->companyDebt = $company->companyDebt - $request->initialTotal + $request->invTotal;
        $company->save(); //update company debt

        $invoice = Invoice::find($invoice);
        $invoice->invTotal = $request->invTotal;
        $invoice->save();

        for ($i = 0; $i <= $request->rowNum; $i++)  
        {
            if(isset($request->orderId[$i]))
            {
                $order = Order::find($request->orderId[$i]);
                $order->prodId = $request->product[$i];
                $order->weight = $request->weight[$i];
                $order->quantity = $request->quantity[$i];
                $order->Mweight = $request->Mweight[$i];
                $order->price = $request->price[$i];
                $order->total = $request->total[$i];
                $order->remarks = $request->remarks[$i];
                $order->save();
            }
            else
            {
                $order=new Order;
                $order->prodId = $request->product[$i];
                $order->weight = $request->weight[$i];
                $order->quantity = $request->quantity[$i];
                $order->Mweight = $request->Mweight[$i];
                $order->price = $request->price[$i];
                $order->total = $request->total[$i];
                $order->remarks = $request->remarks[$i];
                $order->invId = $invoice->id;
                $order->save();
            }
        }
    
        return redirect()->action([CustomerController::class, 'index'])
                        ->with('success','Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $invoice = Invoice::find($id);
        if($invoice){
            $invoice->delete();
        }
        return redirect()->action([CustomerController::class, 'index'])
                        ->with('success','Invoice deleted successfully.');
    }
}
