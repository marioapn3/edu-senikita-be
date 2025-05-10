<?php

namespace App\Services;

use App\Models\Requirement;

class RequirementService
{
    public function create($request, $courseId){
        $sneakPeek = Requirement::create([
            'text' => $request->text,
            'course_id' => $courseId,
        ]);

        return $sneakPeek;
    }

    public function update($request, $sneakPeekId){
        $sneakPeek = Requirement::find($sneakPeekId);
        $sneakPeek->update([
            'text' => $request->text,
        ]);

        return $sneakPeek;
    }

    public function delete($sneakPeekId){
        $sneakPeek = Requirement::find($sneakPeekId);
        $sneakPeek->delete();

        return $sneakPeek;
    }

}