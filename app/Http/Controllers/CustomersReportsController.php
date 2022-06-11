<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\Sections;
use Illuminate\Http\Request;

class CustomersReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:تقرير العملاء', ['only' => ['index' , 'search_customers']]);
    }

    public function index(){

        $sections = Sections::all();
        return view('reports.customers_reports' , compact('sections'));

    }

    public function search_customers (Request $request){

        $section = $request->section;
        $product = $request->product;
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);

        //Without Select Date
        if ($section && $product && $start_at =='' && $end_at =='') {

            if ($product == 'كل المنتجات'){

                $invoices = Invoices::select('*')->withTrashed()->where('section_id', '=', $section)->get();
                $sections = Sections::all();
                return view('reports.customers_reports', compact('sections'))->withDetails($invoices);

            }

            else {

                $invoices = Invoices::select('*')->withTrashed()->where('section_id', '=', $section)->where('product', '=', $product)->get();
                $sections = Sections::all();
                return view('reports.customers_reports', compact('sections'))->withDetails($invoices);

            }

        }

        //With Select Date
        else {

            if ($product == 'كل المنتجات'){

                $invoices = Invoices::whereBetween('invoice_Date', [$start_at, $end_at])->withTrashed()->where('section_id', '=', $section)->get();
                $sections = Sections::all();
                return view('reports.customers_reports', compact('sections'))->withDetails($invoices);

            }

            else {

                $invoices = Invoices::whereBetween('invoice_Date', [$start_at, $end_at])->withTrashed()->where('section_id', '=', $section)->where('product', '=', $product)->get();
                $sections = Sections::all();
                return view('reports.customers_reports', compact('sections'))->withDetails($invoices);

            }

        }

    }

}
