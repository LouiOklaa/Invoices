<?php

namespace App\Http\Controllers;

use App\Products;
use App\Sections;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:المنتجات|اضافة منتج|تعديل منتج|حذف منتج', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        $sections = Sections::all();
        return view('products.index' , compact('sections' , 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData=$request->validate([

            'product_name' => 'required|max:255',
            'section_id' => 'required',

        ],[

            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'section_id.required' => 'يرجى تحديد القسم'

        ]);

        Products::create([

            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,

        ]);

        session()->flash('Add' , 'تم اضافة المنتج بنجاح');
        return redirect("/products");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Sections::where('section_name' , $request->section_name)->first()->id;

        $products = Products::findOrFail($request->product_id);

        $this->validate($request, [

            'product_name' => 'required|max:255',
            'section_name' => 'required',
        ],[

            'product_name.required' =>'يرجي ادخال اسم المنتج',
            'section_name.required' => 'يرجى تحديد القسم',

        ]);

        $products->update([
            'product_name' => $request->product_name,
            'section_id' => $id,
            'description' => $request->description,
        ]);

        session()->flash('Edit','تم تعديل المنتج بنجاج');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $products = Products::findOrFail($request->product_id);
        $products->delete();

        session()->flash('Delete','تم حذف المنتج بنجاح');
        return back();


    }
}
