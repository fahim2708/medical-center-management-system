<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderDocumentsFolder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'folder_name',
        'provider_id',
        'doctor_id',
        'date'
    ];
}
