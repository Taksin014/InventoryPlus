<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    // protected $primaryKey = 'id';
    protected $fillable = [
        // 'user_id',
        'company',
        // 'age_id',
        'bill_date',
        'state',
    ];
    
    public function bills()
{
    return $this->hasMany(Bill::class, 'user_id');
}
}
