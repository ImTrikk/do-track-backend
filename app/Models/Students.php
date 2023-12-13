<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $primaryKey = 'student_id';
    protected $guarded =[];
    use HasFactory;
}
