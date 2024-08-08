<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

     protected $table = 'kayıt';


     public $timestamps = false;

    protected $fillable =
     ['name',
     'surname',
     'appointment',
     'purpose',
     'who',
     'Date',
     'Date_exit',
     'image'];
}
