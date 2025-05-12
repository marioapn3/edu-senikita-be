<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\FinalSubmission;
use App\Models\Lesson;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\PdfToImage\Pdf as PdfToImage;


class FinalSubmissionController extends Controller
{
    public function score(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'required|string',
            'status' => 'required|in:reviewed,approved,rejected',
        ]);

        if ($validator->fails()) {
            return $this->exceptionError($validator->errors(), 422);
        }

        $submission = FinalSubmission::findOrFail($id);
        $submission->score = $request->score;
        $submission->feedback = $request->feedback;
        $submission->status = $request->status;
        $submission->save();

        if ($submission->status == 'approved') {
            $lesson = Lesson::find($submission->lesson_id);
            if (!$lesson) return;


            $lesson->users()->attach($submission->user_id, [
                'is_completed' => true,
                'completed_at' => now(),
            ]);

            $course = Course::find($lesson->course_id);
            if (!$course) return;

            $enrollment = Enrollment::where('user_id', $submission->user_id)
                                    ->where('course_id', $course->id)
                                    ->first();
            if (!$enrollment) return;

            $enrollment->status = 'completed';
            $enrollment->completed_at = now();
            $enrollment->save();

            $certificateNumber = 'CERT-' . $enrollment->id . '-' . now()->format('YmdHis');

            $certificate = Certificate::create([
                'enrollment_id' => $enrollment->id,
                'certificate_number' => $certificateNumber,
            ]);

            $dataPdf = [
                'nama' => $enrollment->user->name,
                'course' => $course->title,
                'tanggal' => now()->format('d F Y'),
                'certificate_id' => $certificateNumber,
                'tanggal_penyelesaian' => now()->format('d F Y'),
            ];

            // Pastikan direktori storage/app/public/certificate sudah ada
            $pdfPath = storage_path('app/public/certificate');
            if (!file_exists($pdfPath)) {
                mkdir($pdfPath, 0755, true);
            }

            $pdfFilename = $certificateNumber . '.pdf';
            $imageFilename = $certificateNumber . '.png';

            $pdf = Pdf::setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ])
            ->loadView('pdf.certificate', $dataPdf)
            ->setPaper('a4', 'landscape');

            // Simpan PDF
            $pdf->save($pdfPath . '/' . $pdfFilename);

            // Simpan path PDF ke database
            $certificate->certificate_pdf = 'storage/certificate/' . $pdfFilename;

            // Convert PDF ke gambar (png)
            $pdfToImage = new PdfToImage($pdfPath . '/' . $pdfFilename);
            $pdfToImage->setPage(1)
                       ->setOutputFormat('png')
                       ->saveImage($pdfPath . '/' . $imageFilename);

            $certificate->certificate_image = 'storage/certificate/' . $imageFilename;
            $certificate->save();

            $emailData =[
                'nama' => $enrollment->user->name,
                'course' => $course->title,
                'tanggal_penyelesaian' => now()->format('d F Y'),
                'certificate_id' => $certificateNumber,
                'certificate_url' => $certificate->certificate_pdf,
            ];

            Mail::send('email.certificate', ['data' => $emailData], function ($message) use ($emailData, $enrollment) {
                $message->to($enrollment->user->email)
                        ->subject('Sertifikat Kelulusan - Widya Senikita');
            });
        }

        return redirect()->back()->with('success', 'Final submission updated successfully');
    }
}
