<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RespondentModel;

class ResponseModel extends Model
{
    use SoftDeletes;

    // TABLE NAME
    protected $table = 'response';

    // TABLE ATTRIBUTES
    protected $fillable = [
        'respondent_id',
        'location',
        'date_time',
        'involve',
        'refered_hospital',
        'incident_type',
        'immediate_cause_or_reason',
        'remark'
    ];

    // type casting
    protected function casts(): array
    {
        return [
            'date_time' => 'datetime',
        ];
    }

    // get a record
    public function scopeGetRecord($query, array $data, $id) {
        try {
            return $query->where($id)->select($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
