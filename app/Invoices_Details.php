<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices_Details extends Model
{
    protected $fillable = [
        'invoice_id',
        'invoice_number',
        'product',
        'section',
        'status',
        'value_status',
        'note',
        'user',
        'payment_date',
    ];

}
