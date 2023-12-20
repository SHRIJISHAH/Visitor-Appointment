<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCodeScan extends Model
{
    use HasFactory;

    protected $table = 'qr_code_scans';

    protected $fillable = ['content'];
}
