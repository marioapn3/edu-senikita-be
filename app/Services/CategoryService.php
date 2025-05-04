<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    public function getAll($request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('search', null);

        $query = Category::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        return Category::findOrFail($id);
    }
    public function getBySlug($slug)
    {
        return Category::where('slug', $slug)->firstOrFail();
    }
    public function delete($id)
    {
        $category = Category::findOrFail($id);

        if ($category->thumbnail) {
            Storage::disk('public')->delete($category->thumbnail);
        }

        $category->delete();
        return true;
    }

    public function create($request)
    {
        $data = $request->only([
            'name',
            'description',
            'status'
        ]);

        $slug = Str::slug($data['name']);
        if(Category::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . Str::random(5);
        }
        $data['slug'] = $slug;

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->uploadService->upload($request->file('thumbnail'), 'categories');
        }

        $category = Category::create($data);
        return $category;
    }

    public function update($id, $request)
    {
        $category = Category::findOrFail($id);

        $data = $request->only([
            'name',
            'description',
            'status'
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($category->thumbnail) {
                Storage::disk('public')->delete($category->thumbnail);
            }
            $data['thumbnail'] = $this->uploadService->upload($request->file('thumbnail'), 'categories');
        }

        $category->update($data);
        return $category;
    }
}
