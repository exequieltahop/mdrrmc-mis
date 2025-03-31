<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime'
        ];
    }

    // get all users
    public static function AllUser() {
        // get all user with encryted ids
        return self::all()
            ->map(function($query){
                $query->encrypted_id = Crypt::encrypt($query->id);
                return $query;
            });
    }

    // delete a row
    public static function delete_row($id) : bool {
        try {
            $item = self::find($id);

            $delete_status = $item->delete();

            return $delete_status;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // get a row
    public static function get_row($id) {
        try {
            $user = self::find($id); // find user

            $user->encrypted_id = Crypt::encrypt($user->id); // encryt id

            return $user; // return user data
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // update a row
    public static function update_row(array $data, $id) : bool {
        try {
            $user = self::find($id); // find user

            // if user does not exist return false
            if(!$user){
                Log::error("Error : User does not exist in database");
                return false;
            }
            // else update and return a boolean
            return $user->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
