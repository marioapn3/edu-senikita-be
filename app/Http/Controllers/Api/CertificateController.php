<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class CertificateController extends Controller
{

    public function getAll(Request $request)
    {
        $userId = $request->user()->id;
        $certificates = Certificate::with('enrollment.course')
            ->whereHas('enrollment', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();
        return $this->successResponse($certificates, 'Certificates retrieved successfully');
    }


}
