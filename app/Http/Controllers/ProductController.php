<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::paginate(10);
    
        if ($request->has('export')) 
        {
             if ($request->get('export') == 'pdf') {
                 $pdf = PDF::loadView('product.pdfView', compact('products'));
                 return $pdf->download('products.pdf');
             }
        }
 
        return view('product.list',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
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
            'prodName' => 'required',
        ]);
    
        Product::create($request->all());
     
        return redirect()->action([ProductController::class, 'index'])
                        ->with('success','Product inserted successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $resource = Product::find($product)->first();
        return view('product.show')->with('resource', $resource);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $resource = Product::find($product)->first();
        $edit = true;

        return view('product.show', compact('resource', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'prodName' => 'required',
        ]);
    
        $product->update($request->all());
    
        return redirect()->action([ProductController::class, 'index'])
                        ->with('success','Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->action([ProductController::class, 'index'])
                        ->with('success','Product deleted successfully.');
    }
}
