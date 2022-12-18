<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    


    public function institution(){

        return $this->belongsTo(Institutions::class);

    }

    public function invoices(){

        return $this->hasMany(Institutions::class);

    }
}
