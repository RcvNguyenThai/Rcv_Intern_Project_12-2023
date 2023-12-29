<?php

namespace App\Models;

use App\Models\Group;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AddNewUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Notifications\Notifiable;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User model to contain the information about user in the application
 *
 * 22/12/2023
 * version:1
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *  * 22/12/2023
     * version:1
     */

    protected $table = "mst_users";
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'is_deleted',
        'last_login_at',
        'last_login_ip',
        'attempt_time',
        'group_id',
        'lock_time'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     *  * 22/12/2023
     * version:1
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     *  * 22/12/2023
     * version:1
     */
    protected $casts = [
        'verify_email' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * A define method for user belong to just one group.
     *
     * @param datatype $paramname description
     * @return BelongsTo
     *  22/12/2023
     * version:1
     */
    public function group(): BelongsTo
    {

        return $this->belongsTo(Group::class);
    }

    /**
     * A function that returns a HasMany relationship for the "products" model.
     *
     * @return HasMany The HasMany relationship for the "products" model.
     *  27/12/2023
     * version:1
     */
    public function products(): HasMany
    {

        return $this->hasMany(Product::class);
    }

    //methods for auth controller

    /**
     * Retrieves an existing user by email.
     *
     * @param string $email The email of the user.
     * @throws Some_Exception_Class Description of exception
     * @return User The retrieved user.
     * 27/12/2023
     * version:1
     */
    public static function getExistUser(string $email = ""): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Updates the attempt time of a user.
     *
     * @param User $user The user object to update the attempt time for.
     * @throws None
     * @return void
     * 27/12/2023
     * version:1
     */
    public static function updateAttemptTime(User $user): void
    {

        $user->update(['attempt_time' => $user->attempt_time + 1]);
    }

    /**
     * Resets the attempt time for a user.
     *
     * @param User $user The user object.
     * @throws None
     * @return void
     * 27/12/2023
     * version:1
     */
    public static function resetAttemptTime(User $user): void
    {

        $user->update(['attempt_time' => 0]);
    }

    /**
     * Lock the user for a specified number of minutes.
     *
     * @param User $user The user to be locked.
     * @param int $minutes The number of minutes to lock the user for. Defaults to 5 minutes.
     * @throws \Some_Exception_Class If there is an error while updating the user's lock time.
     * @return void
     * 27/12/2023
     * version:1
     */
    public static function lockUser(User $user, int $minutes = 5): void
    {

        $user->update(['lock_time' => now()->addMinutes($minutes)]);
    }


    /**
     * Unlocks a user by removing the lock time.
     *
     * @param User $user The user to unlock.
     * @throws \Exception If an error occurs while updating the user.
     * @return void
     * 27/12/2023
     * version:1
     */
    public static function unlockUser(User $user): void
    {

        $user->update(['lock_time' => null]);
    }

    /**
     * Updates the user information after a successful login.
     *
     * @param User $user The user object.
     * @param LoginRequest $request The login request object.
     * @throws Some_Exception_Class Description of the exception.
     * @return void
     * 27/12/2023
     * version:1
     */
    public static function updateAfterLogin(User $user, LoginRequest $request): void
    {
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);
    }

    // methods for user controller
    /**
     * Retrieves users with optional query parameters.
     *
     * @param string $nameParam (optional) The name parameter to filter users by name.
     * @param string $emailParam (optional) The email parameter to filter users by email.
     * @param string $statusParam (optional) The status parameter to filter users by status.
     * @param string $groupParam (optional) The group parameter to filter users by group.
     * @param string $perPage (optional) The number of users to display per page.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return LengthAwarePaginator The paginated list of users.
     * 27/12/2023
     * version:1
     */
    public static function getUserWithQuery(string $nameParam = null, string $emailParam = null, string $statusParam = null, string $groupParam = null, string $perPage = null): LengthAwarePaginator
    {
        return self::with('group')->where('is_delete', 0)->where('name', 'like', "%{$nameParam}%")
            ->where('email', 'like', "%{$emailParam}%")
            ->when($statusParam !== null && $statusParam !== "-1", function ($query) use ($statusParam) {
                return $query->where('is_active', $statusParam);
            })
            ->when($groupParam !== null, function ($query) use ($groupParam) {
                return $query->where('group_id', $groupParam);
            })->latest()->paginate($perPage ?? 5);
    }

    /**
     * Retrieves the user information for a given email.
     *
     * @param string $email The email of the user. Defaults to an empty string.
     * @return User|null The User object containing the user's name, email, group ID, and last login IP address. Returns null if no user is found.
     *  27/12/2023
     * version:1
     */
    public static function getUserForSession(string $email = ""): ?User
    {
        return User::select('name', 'email', 'group_id', 'last_login_ip', 'group_id')
            ->where('email', $email)->first();
    }

    /**
     * Creates a new user.
     *
     * @param AddNewUserRequest $request The request object containing the user data.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return User The newly created user.
     * 27/12/2023
     * version:1
     */
    public static function createNewUser(AddNewUserRequest $request): User
    {

        $strHashedPassword = Hash::make($request->password);
        return self::create([
            'name' => $request->addName,
            'email' => $request->addEmail,
            'password' => $strHashedPassword,
            'is_active' => $request->status,
            'group_id' => $request->group,
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);
    }

    /**
     * Updates a user with the given ID.
     *
     * @param UpdateUserRequest $request The request object containing the updated user data.
     * @param string $id The ID of the user to be updated.
     * @throws Some_Exception_Class [Description of exception]
     * @return void
     * 27/12/2023
     * version:1
     */
    public static function updateUser(UpdateUserRequest $request, string $id): void
    {
        self::where('id', $id)->update(['name' => $request->name, 'email' => $request->email, 'group_id' => $request->group]);
    }

    /**
     * Retrieves a single User from the database based on the provided ID.
     *
     * @param string $id The ID of the User to retrieve.
     * @return User|null The retrieved User, or null if no User with the specified ID exists.
     * 27/12/2023
     * version:1
     */
    public static function getSingleUser(string $id): ?User
    {
        return self::where('id', $id)->first();
    }

    /**
     * Updates the password for a user.
     *
     * @param ChangePasswordRequest $request The request object containing the new password.
     * @param string $id The ID of the user whose password should be changed.
     * @throws Some_Exception_Class Description of the exception that can be thrown.
     * @return void
     * 27/12/2023
     * version:1
     */
    public static function changePassword(ChangePasswordRequest $request, string $id): void
    {

        self::where('id', $id)->update(['password' => Hash::make($request->password)]);
    }

    /**
     * Change the active status of a record by ID.
     *
     * @param string $id The ID of the record to be modified.
     * @throws \Exception If the record with the given ID does not exist.
     * @return void
     * 27/12/2023
     * version:1
     */
    public static function changeActive(string $id): void
    {
        $currentActive = self::where('id', $id)->first()->is_active;
        self::where('id', $id)->update(['is_active' => !$currentActive]);
    }

    /**
     * Deletes a user from the database based on the given ID.
     *
     * @param string $id The ID of the user to be deleted.
     * @throws \Some_Exception_Class If there is an error deleting the user.
     * @return void
     *  27/12/2023
     * version:1
     */
    public static function deleteUser(string $id): void
    {
        self::where('id', $id)->update(['is_delete' => 1]);
    }
}
