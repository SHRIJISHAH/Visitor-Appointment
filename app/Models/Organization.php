<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $primaryKey = 'org_id'; // Specify org_id as the primary key
    public $incrementing = false; // Disable auto-incrementing for org_id

    protected $fillable = [
        'org_id',
        'org_name',
        'address',
        'gst_no',
        'mobile_no',
        'org_email',
        'contact_person',
        'superadmin_id'
    ];

}
