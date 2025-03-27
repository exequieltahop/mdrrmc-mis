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
            return $query->where('id', $id)->select($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // update a row
    public static function UpdateRow(array $data, $id) {
        try {
            $record = self::find($id);

            if(!$record){
                throw new \Exception("Record not found!");
            }

            return $record->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
