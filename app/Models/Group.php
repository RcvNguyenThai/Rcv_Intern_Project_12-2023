<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Get the users associated with this object.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * * 22/12/2023
     * version:1
     */
    public function users(): HasMany
    {

        return $this->hasMany(User::class);
    }

    /**
     * Retrieves all records from the database.
     *
     * @return array An array containing all the records.
     * * 22/12/2023
     * version:1
     */
    public static function getAll()
    {
        return self::all();

    }
}
