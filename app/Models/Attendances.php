<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    public $timestamps = false;

    protected $primaryKey = 'attendance_id';

    protected $fillable = [
        'time_in',
        'time_out',
        'total_hours',
        'required_hours',
        'date',
        'student_id',
        'admin_id'
    ];
    // protected $casts = [
    //     'total_hours' => 'float',
    // ];

    // protected $dates = [
    //     'time_in',
    //     'time_out',
    // ];

    // public function student()
    // {
    //     return $this->belongsTo(Students::class, 'student_id');
    // }

    // public function admin()
    // {
    //     return $this->belongsTo(Admins::class, 'admin_id');
    // }
}
