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

    public function admin()
    {
        return $this->belongsTo(Admins::class, 'admin_id');
    }
}
