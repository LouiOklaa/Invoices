<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Invoices;
use App\Invoices_Details;
use App\Invoices_Attachments;
use App\Sections;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:قائمة الفواتير|اضافة فاتورة|تغير حالة الدفع|تعديل الفاتورة|حذف الفاتورة|طباعةالفاتورة|تصدير EXCEL', ['only' => ['index']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['show','status_update']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف الفاتورة|ارشفة الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:الفواتير المدفوعة', ['only' => ['paid_invoices']]);
        $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['unpaid_invoices']]);
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['partial_invoices']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['print_invoice']]);
        $this->middleware('permission:تصدير EXCEL', ['only' => ['export']]);
        $this->middleware('permission:الاشعارات', ['only' => ['View_All_Notification' , 'MarkAsRead_All' , 'MarkAsRead']]);
    }

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
        $section_name = Sections::where('id' , '=' , $request->section)->first();

        $this->validate($request, [

            'invoice_number' => 'required|max:255|unique:invoices',
            'invoice_Date' => 'required',
            'due_date' => 'required',
            'section' => 'required',
            'product' => 'required',
            'amount_collection' => 'required',
            'amount_commission' => 'required',
            'discount' => 'required',
            'value_VAT' => 'required'
        ],[

            'invoice_number.required' =>'يرجى ادخال رقم الفاتورة',
            'invoice_number.unique' => 'رقم الفاتورة موجود مسبقا',
            'invoice_Date.required' =>'يرجى ادخال تاريخ الفاتورة',
            'due_date.required' =>'يرجى ادخال تاريخ استحقاق الفاتورة',
            'section.required' =>'يرجى ادخال اسم القسم',
            'product.required' =>'يرجى ادخال اسم المنتج',
            'amount_collection.required' =>'يرجى ادخال مبلغ التحصيل',
            'amount_commission.required' =>'يرجى ادخال مبلغ العمولة',
            'discount.required' =>'يرجى ادخال قيمة الخصم',
            'value_VAT.required' =>'يرجى ادخال قيمة الضريبة المضافة'
        ]);

        Invoices::create([

           'invoice_number' => $request->invoice_number,
           'invoice_Date' => $request->invoice_Date,
           'due_date' => $request->due_date,
           'product' => $request->product,
           'section_name' => $section_name->section_name,
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
           'created_by' => Auth::user()->name

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
            'user' => (Auth::user()->name)

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

            //Move File
            $request->attachment->move(public_path('Attachments/' . $invoice_number), $file_name);

        }
        session()->flash('Add','تم اضافة الفاتورة بنجاح');

        //Send Notification & Mail
        $user = User::where('role_name' , '=' , 'Owner')->orWhere('role_name' , '=' , 'Admin')->get();
        Notification::send($user, new \App\Notifications\AddInvoice($InvoiceID));

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

        $this->validate($request, [

            'invoice_number' => 'required|max:255|unique:invoices,invoice_number,'.$request->invoice_id,
            'invoice_Date' => 'required',
            'due_date' => 'required',
            'section' => 'required',
            'product' => 'required',
            'amount_collection' => 'required',
            'amount_commission' => 'required',
            'discount' => 'required',
            'value_VAT' => 'required'
        ],[

            'invoice_number.required' =>'يرجى ادخال رقم الفاتورة',
            'invoice_number.unique' => 'رقم الفاتورة موجود مسبقا',
            'invoice_Date.required' =>'يرجى ادخال تاريخ الفاتورة',
            'due_date.required' =>'يرجى ادخال تاريخ استحقاق الفاتورة',
            'section.required' =>'يرجى ادخال اسم القسم',
            'product.required' =>'يرجى ادخال اسم المنتج',
            'amount_collection.required' =>'يرجى ادخال مبلغ التحصيل',
            'amount_commission.required' =>'يرجى ادخال مبلغ العمولة',
            'discount.required' =>'يرجى ادخال قيمة الخصم',
            'value_VAT.required' =>'يرجى ادخال قيمة الضريبة المضافة'
        ]);

        if ($request->invoice_number != 'invoice_number'){
            if(Storage::exists(public_path('Attachments/' . $invoices->invoice_number))) {

                rename(public_path('Attachments/' . $invoices->invoice_number), public_path('Attachments/' . $request->invoice_number));

            }
        }

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
            'note' => $request->note

        ]);

        session()->flash('Edit','تم تعديل الفاتورة بنجاج');
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
            session()->flash('Delete' , 'تم حدف الفاتورة بنجاح');
            return redirect('/invoices');

        }

        else {

            $invoices->update([

                'archived_by' =>Auth::user()->name

            ]);
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

        $this->validate($request, [

            'status' => 'required',
            'payment_date' => 'required'

        ],[

            'status.required' =>'يرجى ادخال حالة الدفع',
            'payment_date.required' => 'يرجى ادخال تاريخ الدفع'

        ]);

        if ($request->status == 'مدفوعة'){

            $invoice->update([

                'status' => $request->status,
                'value_status' => 1,
                'payment_date' => $request->payment_date

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
                'user' => (Auth::user()->name)

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
                'user' => (Auth::user()->name)

            ]);

        }

        session()->flash('Update_Status' , 'تم تغيير حالة الدفع بنجاح');
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

    public function print_invoice ($id){

        $invoices = Invoices::where('id' , $id)->first();
        return view('invoices.print_invoice' , compact('invoices'));

    }

    public function export ($page_id) {

        return Excel::download(new InvoicesExport($page_id) , 'Invoices.xlsx');

    }

    public function View_All_Notification (){

        return view('notification.index');

    }

    public function MarkAsRead_All ()
    {
        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {

            $userUnreadNotification->markAsRead();

        }

        return back();

    }

    public function MarkAsRead ()
    {
        $id = auth()->user()->unreadNotifications[0]->id;
        $userUnreadNotification = auth()->user()
            ->unreadNotifications
            ->where('id', $id)
            ->first();

        $Invoices_id = $userUnreadNotification->data['id'];

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
        }

        return redirect()->route('InvoicesDetails', ['id' => $Invoices_id]);

    }

}
