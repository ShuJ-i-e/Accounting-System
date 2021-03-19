<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;
    protected $table = 'purchaseInvoice';
    protected $fillable = [
        'companyId',
        'invTotal',
    ];

}
