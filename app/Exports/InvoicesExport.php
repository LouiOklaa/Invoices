<?php

namespace App\Exports;

use App\Invoices;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromCollection,WithHeadings
{

    protected $page_id;

    function __construct($page_id) {

        $this->page_id = $page_id;

    }

    public function headings(): array {

        return ["رقم الفاتورة","تاريخ الفاتورة","تاريخ الاستحقاق","القسم","المنتج","الخصم","نسبة الضريبة","قيمة الضريبة","الاجمالي","الحالة","تاريخ الدفع","ملاحظات"];

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //Export All Invoices
        if ($this->page_id == 1){

            return invoices::select('invoice_number', 'invoice_Date', 'due_date','section_name', 'product','discount', 'rate_VAT', 'value_VAT','total', 'status', 'payment_date','note')->get();
        }
        //Export Paid Invoices
        elseif ($this->page_id == 2){

            return invoices::select('invoice_number', 'invoice_Date', 'due_date','section_name', 'product','discount', 'rate_VAT', 'value_VAT','total', 'status', 'payment_date','note')->where('value_status','=' , 1)->get();
        }
        //Export Unpaid Invoices
        elseif ($this->page_id == 3){

            return invoices::select('invoice_number', 'invoice_Date', 'due_date','section_name', 'product','discount', 'rate_VAT', 'value_VAT','total', 'status', 'payment_date','note')->where('value_status','=' , 2)->get();
        }
        //Export Partial Invoices
        elseif ($this->page_id == 4){

            return invoices::select('invoice_number', 'invoice_Date', 'due_date','section_name', 'product','discount', 'rate_VAT', 'value_VAT','total', 'status', 'payment_date','note')->where('value_status','=' , 3)->get();
        }




    }

}
