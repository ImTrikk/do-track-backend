<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    protected $primaryKey = 'admin_id';
    protected $guarded = [];

    protected $hidden = ['password'];

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'admin_id', 'admin_id');
    }

    public function college()
    {
        return $this->belongsTo(Colleges::class, 'college_id', 'college_id');
    }

    use HasFactory;
}
