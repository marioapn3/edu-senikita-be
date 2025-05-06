<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListCourseResource extends ResourceCollection
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
            'title' => $data->title,
            'description' => $data->description,
            'certificate_available' => $data->certificate_available,
            'slug' => $data->slug,
            'status' => $data->status,
            'thumbnail' => $data->thumbnail,
            'category' => $data->categories->map(function ($category) {
                return $category->name;
            })->toArray(),
            'instructor' => [
                'id' => $data->instructor->id,
                'name' => $data->instructor->name,
                'photo' => $data->instructor->photo,
                'expertise' => $data->instructor->expertise,
            ],
            'duration' => $data->lessons->sum('duration') ? $data->lessons->sum('duration') . ' menit' : '0 menit',
            'level' => $data->level,
            'enrolled_count' => $data->enrollments->count(),
            'rating' => $data->ratings->avg('rating') ? (float)$data->ratings->avg('rating') : 0,
            "lessons_count" => $data->lessons->count(),
            "created_at" => $data->created_at->format('Y-m-d H:i:s'),
            "updated_at" => $data->updated_at->format('Y-m-d H:i:s'),
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
