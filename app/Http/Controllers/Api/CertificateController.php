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
        $certificates = Certificate::with('enrollment.course')->where('user_id', $request->user()->id)->get();
        return $this->successResponse($certificates, 'Certificates retrieved successfully');
    }
}
