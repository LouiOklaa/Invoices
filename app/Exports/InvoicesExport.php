<?php

namespace App\Exports;

use App\Invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return invoices::select('invoice_number', 'invoice_Date', 'due_date','section_id', 'product', 'amount_collection','amount_commission', 'rate_VAT', 'value_VAT','total', 'status', 'payment_date','note')->get();

    }
}
