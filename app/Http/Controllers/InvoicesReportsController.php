<?php

namespace App\Http\Controllers;

use App\Invoices;
use Illuminate\Http\Request;

class InvoicesReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:تقرير الفواتير', ['only' => ['index' , 'search_invoices']]);
    }

    public function index(){

    return view('reports.invoices_reports');

    }

    public function search_invoices (Request $request){

        $radio = $request->radio;
        $invoices_type = $request->invoices_type;
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);

        //Search With Invoice Type
        if ($radio == 1) {

            //Without Select Date
            if ($invoices_type && $start_at =='' && $end_at =='') {

                if ($invoices_type == 'كل الفواتير'){

                    $invoices = Invoices::withTrashed()->get();
                    return view('reports.invoices_reports',compact('invoices_type'))->withDetails($invoices);

                }

                else{

                    $invoices = Invoices::select('*')->where('status','=',$invoices_type)->withTrashed()->get();
                    return view('reports.invoices_reports',compact('invoices_type'))->withDetails($invoices);

                }

            }

            //With Select Date
            else {

                if ($invoices_type == 'كل الفواتير') {

                    $invoices = Invoices::whereBetween('invoice_Date', [$start_at, $end_at])->withTrashed()->get();
                    return view('reports.invoices_reports', compact('invoices_type', 'start_at', 'end_at'))->withDetails($invoices);
                }

                else{

                    $invoices = Invoices::whereBetween('invoice_Date', [$start_at, $end_at])->withTrashed()->where('status', '=', $invoices_type)->get();
                    return view('reports.invoices_reports', compact('invoices_type', 'start_at', 'end_at'))->withDetails($invoices);

                }
            }

        }

        //Search With Invoice Number
        else {

            $invoices = Invoices::select('*')->withTrashed()->where('invoice_number','=',$request->invoice_number)->get();
            return view('reports.invoices_reports')->withDetails($invoices);

        }

    }

}
