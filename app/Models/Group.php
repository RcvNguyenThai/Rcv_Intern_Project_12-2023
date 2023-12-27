<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Group model to contain the group type for user
 *
 * 22/12/2023
 * version:1
 */
class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function users()
    {

        return $this->hasMany(User::class);
    }

    public static function getAll()
    {
        return self::all();

    }
}
