<?php
namespace App\Repositories;

use App\Models\Subscriber;

class TaskRepository {

    public function logicCheck($inputData)
    {
        $exists = Subscriber::matchSegment(
            $inputData['segment_name'],
            $inputData['segment_logic_type'],
            $inputData['text_type'],
            $inputData['word']
        )->exists();

        return response()->json(['exists' => $exists]);
    }
}
