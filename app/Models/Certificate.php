<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'enrollment_id',
        'certificate_number',
        'certificate_image',
        'certificate_pdf',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCertificateImageAttribute($value)
    {
        return asset($value);
    }

    public function getCertificatePdfAttribute($value)
    {
        return asset($value);
    }
}
