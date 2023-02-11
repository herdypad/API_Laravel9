<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Students extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table ='students';

    protected $fillable = [
        'idnumber',
        'fullname',
        'address'
    ];

       /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


}
