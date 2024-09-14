<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'file_name',
        'file_path',
        'patient_id',
        'provider_id',
        'doctor_id',
        'document_type',
        'visit_date',
        'description',
        'note',
        'status'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}
