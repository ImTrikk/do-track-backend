<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model implements Authenticatable
{
    use AuthenticatableTrait, HasFactory, HasApiTokens, Notifiable;

    protected $primaryKey = 'admin_id';
    protected $keyType = 'string';
    public $incrementing = false;

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
