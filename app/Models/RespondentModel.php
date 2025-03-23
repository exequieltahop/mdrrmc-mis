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
        return $query->selectRaw('CONCAT(first_name, " ", middle_name, " ", last_name) AS full_name')
                     ->where('id', $id);
    }
}
