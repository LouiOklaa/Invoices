<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'due_date',
        'product',
        'section_name',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_VAT',
        'rate_VAT',
        'total',
        'status',
        'value_status',
        'note',
        'payment_date',
    ];

    use SoftDeletes;

    public function section(){

        return $this->belongsTo('App\sections');

    }

    protected $dates = ['deleted_at'];

}
