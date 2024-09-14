<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderDoctorRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'doctor_id'
    ];
}
