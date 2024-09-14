<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
    public function doctors()
    {
        return $this->hasManyThrough(Doctor::class, ProviderDoctorRelation::class, 'provider_id', 'id', 'id', 'doctor_id');
    }
}
