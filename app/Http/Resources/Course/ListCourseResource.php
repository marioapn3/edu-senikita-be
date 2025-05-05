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
            'category' => [
                'id' => $data->category->id,
                'name' => $data->category->name,
                'slug' => $data->category->slug,
            ],
            'instructor' => [
                'id' => $data->instructor->id,
                'name' => $data->instructor->name,
                'photo' => $data->instructor->photo,
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
