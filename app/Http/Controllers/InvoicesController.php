<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Invoices_Details;
use App\Invoices_Attachments;
use App\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::all();
        return view('invoices.index' , compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Sections::all();
        return view('invoices.create' , compact('sections') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Invoices::create([

           'invoice_number' => $request->invoice_number,
           'invoice_Date' => $request->invoice_Date,
           'due_date' => $request->due_date,
           'product' => $request->product,
           'section_id' => $request->section,
           'amount_collection' => $request->amount_collection,
           'amount_commission' => $request->amount_commission,
           'discount' => $request->discount,
           'value_VAT' => $request->value_VAT,
           'rate_VAT' => $request->rate_VAT,
           'total' => $request->total,
           'status' => 'غير مدفوعة',
           'value_status' => 2,
           'note' => $request->note,

        ]);

        $InvoiceID = Invoices::latest()->first()->id;
        Invoices_Details::create([

            'invoice_id' => $InvoiceID,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),

        ]);

        if ($request->hasFile('attachment')) {

            $InvoiceID = Invoices::latest()->first()->id;
            $image = $request->file('attachment');
            $file_name = rand() . '.' . $image->getClientOriginalExtension();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoices_Attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $InvoiceID;
            $attachments->save();

            // move pic
            $request->attachment->move(public_path('Attachments/' . $invoice_number), $file_name);

        }

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return redirect('/invoices');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = Invoices::where('id' , $id)->first();
        return view('invoices.invoices_status' , compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = Invoices::where('id' , $id)->first();
        $sections = Sections::all();
        return view('invoices.edit' , compact('invoices' , 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = Invoices::findOrFail($request->invoice_id);
        $invoices->update([

            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_VAT' => $request->value_VAT,
            'rate_VAT' => $request->rate_VAT,
            'total' => $request->total,
            'note' => $request->note,

        ]);

//        $attachment = Invoices_Attachments::findOrFail($request->invoice_id);
//
//        // move pic
//        $attachment->file_name->move(public_path('Attachments/' . $request->invoice_number), $file_name);
//
//        $invoices->delete();
//        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$attachment->file_name);

        session()->flash('edit_invoice','تم تعديل الفاتورة بنجاج');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = Invoices::where('id', $id)->first();
        $details = Invoices_Attachments::where('invoice_id', $id)->first();
        $page_id =$request->page_id;

        if ($page_id!=2){

            if (!empty($details->invoice_number)) {

                Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
            }

            $invoices->forceDelete();
            session()->flash('delete_invoice' , 'تم حدف الفاتورة بنجاح');
            return redirect('/invoices');

        }

        else {

            $invoices->delete();
            session()->flash('archive' , 'تم ارشفة الفاتورة بنجاح');
            return redirect('/Invoices_Archive');

        }

    }

    public function get_products ($id){

        $products = DB::table("products")->where('section_id' , $id)->pluck("product_name" , "id");
        return json_encode($products);

    }

    public function status_update ($id , Request $request){

        $invoice = Invoices::findorFail($id);

        if ($request->status == 'مدفوعة'){

            $invoice->update([

                'status' => $request->status,
                'value_status' => 1,
                'payment_date' => $request->payment_date,

            ]);

            Invoices_Details::create([

                'invoice_number' => $request->invoice_number,
                'invoice_id' => $request->invoice_id,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 1,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),

            ]);

        }

        else {

            $invoice->update([

                'status' => $request->status,
                'value_status' => 3,
                'payment_date' => $request->payment_date,

            ]);

            Invoices_Details::create([

                'invoice_number' => $request->invoice_number,
                'invoice_id' => $request->invoice_id,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 3,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
                'user' => (Auth::user()->name),

            ]);

        }

        session()->flash('status_update' , 'تم تغيير حالة الدفع بنجاح');
        return redirect('/invoices');


    }

    public function paid_invoices (){

        $paid_invoices = Invoices::where('value_status' , 1)->get();
        return view('invoices.paid_invoices', compact('paid_invoices'));

    }

    public function unpaid_invoices (){

        $unpaid_invoices = Invoices::where('value_status' , 2)->get();
        return view('invoices.unpaid_invoices', compact('unpaid_invoices'));

    }

    public function partial_invoices (){

        $partial_invoices = Invoices::where('value_status' , 3)->get();
        return view('invoices.partial_invoices', compact('partial_invoices'));

    }

}
