<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function providers()
    {
        return $this->hasManyThrough(Provider::class, ProviderDoctorRelation::class, 'doctor_id', 'id', 'id', 'provider_id');
    }
    public function patients()
    {
        return $this->hasManyThrough(Patient::class, DoctorPatientRelation::class, 'doctor_id', 'id', 'id', 'patient_id');
    }
}
