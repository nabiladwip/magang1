<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datastock extends Model
{
   
    
    protected $fillable =['kode','minimum','maksimal'];
    protected $table = 'datastocks';
    use HasFactory;
}
