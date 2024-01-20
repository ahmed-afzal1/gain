<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Subscriber extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeMatchSegment(Builder $query, $segmentName, $logicType, $textType, $word)
    {

        $logicType === 'first_name' ? 'first_name' : 'last_name';
        $segmentParts = explode(' ', $segmentName);

        if($logicType !== 'first_name' || $logicType !== 'last_name'){
            $wordToMatch = $segmentName;
        }

        if($logicType === 'first_name')
        {
            $wordToMatch = $segmentParts[0];
        }

        if($logicType === 'last_name')
        {
            $wordToMatch = $segmentParts[1];
        }

        return $query->where(function (Builder $query) use ($wordToMatch, $logicType,$textType, $word) {
            $this->applyTextCondition($query, $logicType, $textType, $word);
        });
    }

    private function applyTextCondition(Builder $query, $field, $textType, $value)
    {
        switch ($textType) {
            case 'is':
                $query->where($field, '=', $value);
                break;
            case 'is_not':
                $query->where($field, '!=', $value);
                break;
            case 'starts_with':
                $query->where($field, 'LIKE', "$value%");
                break;
            case 'ends_with':
                $query->where($field, 'LIKE', "%$value");
                break;
            case 'contains':
                $query->where($field, 'LIKE', "%$value%");
                break;
            case 'doesnot_starts_with':
                $query->where($field, 'NOT LIKE', "$value%");
                break;
            case 'doesnot_ends_with':
                $query->where($field, 'NOT LIKE', "%$value");
                break;
            case 'doesnot_contains':
                $query->where($field, 'NOT LIKE', "%$value%");
                break;
        }
    }

}
