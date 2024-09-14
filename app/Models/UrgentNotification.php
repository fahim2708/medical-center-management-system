<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrgentNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'file_id',
        'folder_id',
        'message',
    ];

    public function file()
    {
        return $this->belongsTo(ProviderDocuments::class);
    }
    public function folder()
    {
        return $this->belongsTo(ProviderDocumentsFolder::class);
    }
}
