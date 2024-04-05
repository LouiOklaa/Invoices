<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Invoices_Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:الفواتير المؤرشفة|استعادة الفاتورة|حذف فاتورة مؤرشفة', ['only' => ['index']]);
        $this->middleware('permission:استعادة الفاتورة', ['only' => ['update']]);
        $this->middleware('permission:حذف فاتورة مؤرشفة', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.invoices_archive' , compact('invoices'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $invoice = Invoices::withTrashed()->where('id', $request->invoice_id);
        $invoice->restore();
        session()->flash('Restore' , 'تم استعادة الفاتورة بنجاح');
        return redirect('/invoices');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->first();
        $details = Invoices_Attachments::where('invoice_id', $request->invoice_id)->first();
        if (!empty($details->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
        }
        $invoices->forceDelete();
        session()->flash('delete' , 'تم حذف الفاتورة بنجاح');
        return redirect('/Invoices_Archive');

    }
}
