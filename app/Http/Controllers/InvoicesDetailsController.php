<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Invoices_Attachments;
use App\Invoices_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:اضافة مرفق|عرض مرفق|تحميل مرفق|حذف مرفق', ['only' => ['show']]);
        $this->middleware('permission:حذف مرفق', ['only' => ['destroy']]);
        $this->middleware('permission:عرض مرفق', ['only' => ['view_file']]);
        $this->middleware('permission:تحميل مرفق', ['only' => ['download_file']]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoices_Details  $invoices_Details
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $invoices = Invoices::where('id' , $id)->first();
        $details = Invoices_Details::where('invoice_id' , $id)->get();
        $attachments = Invoices_Attachments::where('invoice_id' , $id)->get();

        return view('invoices.invoices_details' , compact('invoices' , 'details' , 'attachments'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoices_Details  $invoices_Details
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices_Details $invoices_Details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoices_Details  $invoices_Details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_Details $invoices_Details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoices_Details  $invoices_Details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = Invoices_Attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function view_file($invoice_number , $file_name){

        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($files);

    }

    public function download_file($invoice_number,$file_name)

    {
        $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download($contents);
    }
}
