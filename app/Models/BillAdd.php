<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillAdd extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_number',
        'item_id',
        'depart_id',
        'reason_code',
        'acc_desc',
        'qty',
        'desc',
        'state',
        'verify',
        'dispense',
        'investor',
        'receiver'
    ];
}
