<?php

namespace App\Services;

use App\Models\Instructor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class InstructorService
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function all()
    {
        return Instructor::all();
    }

    public function getAll($request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('search', null);

        $query = Instructor::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        return Instructor::findOrFail($id);
    }

    public function delete($id)
    {
        $instructor = Instructor::findOrFail($id);

        if ($instructor->photo) {
            Storage::disk('public')->delete($instructor->photo);
        }

        $instructor->delete();
        return true;
    }

    public function create($request)
    {
        $data = $request->only([
            'name',
            'expertise',
            'email',
            'phone'
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadService->upload($request->file('photo'), 'instructors');
        }

        $instructor = Instructor::create($data);
        return $instructor;
    }

    public function update($id, $request)
    {
        $instructor = Instructor::findOrFail($id);

        $data = $request->only([
            'name',
            'expertise',
            'email',
            'phone'
        ]);

        if ($request->hasFile('photo')) {
            if ($instructor->photo) {
                Storage::disk('public')->delete($instructor->photo);
            }
            $data['photo'] = $this->uploadService->upload($request->file('photo'), 'instructors');
        }

        $instructor->update($data);
        return $instructor;
    }
}
