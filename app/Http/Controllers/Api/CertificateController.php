<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class CertificateController extends Controller
{
    public function test(){

        $pdf = Pdf::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
        // ->loadView('pdf.certificate', compact('certificate'))->setPaper('a4', 'landscape');
        ->loadView('pdf.certificate')->setPaper('a4', 'landscape');

        return $pdf->stream('test.pdf');
    }
}
