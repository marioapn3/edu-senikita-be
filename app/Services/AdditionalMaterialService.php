<?php

namespace App\Services;

use App\Models\AdditionalMaterial;
use Illuminate\Support\Facades\Storage;


class AdditionalMaterialService
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function create($request){
        $data = $request->only(['title', 'course_id']);
        if($request->hasFile('file')){
            $filePath = $this->uploadService->upload($request->file('file'), 'additional_materials');
            $data['file_path'] = $filePath;
        }

        $additionalMaterial = AdditionalMaterial::create($data);
        return $additionalMaterial;
    }

    public function delete($id){
        $additionalMaterial = AdditionalMaterial::findOrFail($id);
        $additionalMaterial->delete();
    }
}