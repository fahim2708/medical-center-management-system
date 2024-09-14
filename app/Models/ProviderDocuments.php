<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderDocuments extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'folder_id',
        'doctor_id',
        'patient_id',
        'provider_id',
        'file_name',
        'file_path',
        'favourites',
        'urgent'
    ];
}
