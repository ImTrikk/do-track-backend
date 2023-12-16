<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenicatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admins extends Model implements Authenticatable
{

    use AuthenicatableTrait, HasFactory, HasApiTokens, Notifiable;


    public $incrementing = false;
    protected $primaryKey = 'admin_id';
    protected $guarded = [];

    protected $casts = [
        'admin_id' => 'string',
    ];

    protected $hidden = ['password'];

    public function attendance()
    {
        return $this->hasMany(Attendances::class, 'admin_id', 'admin_id');
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute('admin_id');
    }

    public function getAuthIdentifierName()
    {
        return 'admin_id';
    }
}
