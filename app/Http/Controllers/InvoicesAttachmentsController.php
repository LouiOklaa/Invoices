<?php

namespace App\Http\Controllers;

use App\Invoices_Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:اضافة مرفق', ['only' => ['store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        $image = $request->file('file_name');
        $file_name = rand() . '.' . $image->getClientOriginalExtension();

        $attachments =  new Invoices_Attachments();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->invoice_id = $request->invoice_id;
        $attachments->created_by = Auth::user()->name;
        $attachments->save();

        // move pic
        $request->file_name->move(public_path('Attachments/' . $request->invoice_number), $file_name);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoices_Attachments  $invoices_Attachments
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices_Attachments $invoices_Attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoices_Attachments  $invoices_Attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices_Attachments $invoices_Attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoices_Attachments  $invoices_Attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_Attachments $invoices_Attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoices_Attachments  $invoices_Attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoices_Attachments $invoices_Attachments)
    {
        //
    }
}
