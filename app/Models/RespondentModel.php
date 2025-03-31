<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespondentModel extends Model
{
    use SoftDeletes;

    // TABLE NAME
    protected $table = 'respondents';

    // TABLE ATTRIBUTES
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'address',
        'birthdate',
        'birthplace',
        'civil_status',
        'photo'
    ];

    // GET RESPONDER FULL NAME
    public function scopeFullName($query, $id) {
        return $query->withTrashed()
                     ->selectRaw('CONCAT(first_name, " ", COALESCE(middle_name, ""), " ", last_name) AS full_name')
                     ->where('id', $id);
    }

    // delete a row
    public static function deleteRow($id) : bool {
        try {
            $item = self::find($id);

            if(!$item){
                throw new \Exception("Can\'t Find Responder");
            }

            $delete_status = $item->delete();

            if(!$delete_status){
                throw new \Exception("Failed to delete Responder");
            }

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // update a row
    public static function updateRow(array $data, $id) : bool {
        try {
            $item = self::find($id);

            $updated_status = $item->update($data);

            return $updated_status;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
