<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'certificate_available' => $this->certificate_available,
            'slug' => $this->slug,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail,
            'category' => $this->categories->map(function ($category) {
                return $category->name;
            })->toArray(),
            'instructor' => [
                'id' => $this->instructor->id,
                'name' => $this->instructor->name,
                'photo' => $this->instructor->photo,
                'expertise' => $this->instructor->expertise,
            ],
            'duration' => $this->lessons->sum('duration') ? $this->lessons->sum('duration') . ' menit' : '0 menit',
            'level' => $this->level,
            'sneakpeeks' => $this->sneakpeeks->map(function ($sneakpeek) {
                return $sneakpeek->text;
            })->toArray(),
            'requirements' => $this->requirements->map(function ($requirement) {
                return $requirement->text;
            })->toArray(),
            'ratings' => $this->ratings->avg('rating') ? (float)$this->ratings->avg('rating') : 0,
            "enrolled_count" => $this->enrollments->count(),
            "lessons_count" => $this->lessons->count(),
            "is_enrolled" => $this->is_enrolled ?? false,
            "additional_materials" => $this->additionalMaterials->map(function ($material) {
                return [
                    'id' => $material->id,
                    'title' => $material->title,
                    'file_path' => $material->file_path,
                ];
            })->toArray(),
            "created_at" => $this->created_at->format('Y-m-d H:i:s'),
            "updated_at" => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

}
