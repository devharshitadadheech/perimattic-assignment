<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'status',
        'status_code'
    ];
}
