<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
     'code','name','total_loan_amount','paid','balance', 'percentage'
    ];

    protected $table = 'departments';


}
