<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'description',
        'date',
        'start_time',
        'end_time',
        'name',
        'mobile_no',
        'category',
        'user_id',
        'qr_code',
        'url_token',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
