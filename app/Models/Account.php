<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'acc_id',
        'CODE_COMBINATION_ID',
        'SEGMENT1',
        'SEGMENT2',
        'SEGMENT3',
        'SEGMENT4',
        'SEGMENT5',
        'SEGMENT6',
        'SEGMENT7',
        'SEGMENT8',
        'SEGMENT1_DESC',
        'SEGMENT2_DESC',
        'SEGMENT3_DESC',
        'SEGMENT4_DESC',
        'SEGMENT5_DESC',
        'SEGMENT6_DESC',
        'SEGMENT7_DESC',
        'SEGMENT8_DESC',
        'CHART_OF_ACCOUNTS_ID',
        'ACCOUNT_TYPE',
    ];
}