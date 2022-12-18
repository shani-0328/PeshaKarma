<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institutions extends Model
{
    use HasFactory;


    protected $fillable = [
        'id' , 'code','name','department_id','total_loan_amount','paid','balance', 'percentage'
      ];

    
    public function department(){

        return $this->belongsTo(Department::class);

    }
}
