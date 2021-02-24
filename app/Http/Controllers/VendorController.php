<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\Order;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = DB::table('purchaseInvoice')
       ->join('company', 'company.id', '=', 'purchaseInvoice.companyId')
       ->select('purchaseInvoice.id', 'company.companyName', 'purchaseInvoice.invTotal')
       ->paginate(10);
        
        return view('vendor.list',compact('invoices'))
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
        return view('vendor.create', compact('companies', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invId = count(PurchaseInvoice::all())+1;
        $invoice = new PurchaseInvoice;
        $invoice->companyId = $request['company'];
        $invoice->invTotal = $request['invTotal'];
        $invoice->save();
        
        $company = Company::find($request['company']);
        $company->companyDebt = $company->companyDebt + $request['invTotal'];
        $company->save();

        for($orderCount = 0; $orderCount <= $request->rowNum ; $orderCount++)
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

        return redirect()->action([VendorController::class, 'index'])
                        ->with('success','Invoice inserted successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
