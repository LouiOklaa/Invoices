<?php

namespace App\Http\Controllers;

use App\Invoices;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Chart_js
        $count_all =Invoices::count();
        $count_invoices1 = Invoices::where('value_status', 1)->count();
        $count_invoices2 = Invoices::where('value_status', 2)->count();
        $count_invoices3 = Invoices::where('value_status', 3)->count();

        if($count_invoices2 == 0){

            $invoices_2=0;
        }

        else{

            $invoices_2 = $count_invoices2/ $count_all*100;
        }

        if($count_invoices1 == 0){

            $invoices_1=0;
        }

        else{

            $invoices_1 = $count_invoices1/ $count_all*100;
        }

        if($count_invoices3 == 0){

            $invoices_3=0;
        }

        else{

            $invoices_3 = $count_invoices3/ $count_all*100;
        }


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels([''])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$invoices_2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$invoices_1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$invoices_3]
                ],

            ])
            ->options([]);

        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$invoices_2, $invoices_1,$invoices_3]
                ]

            ])
            ->options([]);

        return view('home', compact('chartjs' , 'chartjs_2'));

    }

}
