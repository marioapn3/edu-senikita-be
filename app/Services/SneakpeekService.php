<?php

namespace App\Services;

use App\Models\SneakPeek;

class SneakpeekService
{
    public function create($request, $courseId){
        $sneakPeek = SneakPeek::create([
            'text' => $request->text,
            'course_id' => $courseId,
        ]);

        return $sneakPeek;
    }

    public function update($request, $sneakPeekId){
        $sneakPeek = SneakPeek::find($sneakPeekId);
        $sneakPeek->update([
            'text' => $request->text,
        ]);

        return $sneakPeek;
    }

    public function delete($sneakPeekId){
        $sneakPeek = SneakPeek::find($sneakPeekId);
        $sneakPeek->delete();

        return $sneakPeek;
    }

}