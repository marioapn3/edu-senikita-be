<?php

namespace App\Http\Resources\Enrollment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListEnrollmentResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->transformCollection($this->collection),
            'meta' => [
                "success" => true,
                "message" => "Success get course lists",
                'pagination' => $this->metaData()
            ]
        ];
    }

    private function transformData($data)
    {
        return [
            'id' => $data->id,
            'user_id' => $data->user_id,
            'course_id' => $data->course_id,
            'status' => $data->status,
            'completed_at' => $data->completed_at,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'completion_stats' => $data->completion_stats,
            'course' => [
                'id' => $data->course->id,
                'title' => $data->course->title,
                'description' => $data->course->description,
                'certificate_available' => $data->course->certificate_available,
                'slug' => $data->course->slug,
                'status' => $data->course->status,
                'thumbnail' => $data->course->thumbnail,
                'duration' => $data->course->lessons->sum('duration') ? $data->course->lessons->sum('duration') . ' menit' : '0 menit',
                'level' => $data->course->level,
                'category' => $data->course->categories->map(function ($category) {
                return $category->name;
            })->toArray(),
                'instructor' => [
                    'id' => $data->course->instructor->id,
                    'name' => $data->course->instructor->name,
                    'photo' => $data->course->instructor->photo,
                    'expertise' => $data->course->instructor->expertise,
                ],
            ],
        ];
    }

    private function transformCollection($collection)
    {
        return $collection->transform(function ($data) {
            return $this->transformData($data);
        });
    }

    private function metaData()
    {
        return [
            "total" => $this->total(),
            "count" => $this->count(),
            "per_page" => (int)$this->perPage(),
            "current_page" => $this->currentPage(),
            "total_pages" => $this->lastPage(),
            "links" => [
                "next" => $this->nextPageUrl()
            ],
        ];
    }

}
