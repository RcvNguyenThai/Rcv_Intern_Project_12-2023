<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AddNewUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\ChangePasswordRequest;

/**
 * User controller for crud users in the app
 * 27/12/2023
 * version:3
 */
class UserController extends Controller
{

    /**
     * Retrieves a paginated list of users and the total number of users.
     *
     * @param Request $request The HTTP request object.
     *
     * @return View The view containing the user data and total number of users.
     *  27/12/2023
     * version:5
     */
    public function index(UserSearchRequest $request): View
    {

        $strQuery = http_build_query($request->all());
        // iPerPage
        $perPage = $request->input('perPage', 5);

        if ($perPage >= 50) {
            $perPage = 50;
        }

        $nameParam = $request->input('name');
        $emailParam = $request->input('email');
        $groupParam = $request->input('group');
        $statusParam = $request->input('status');

        $users = User::getUserWithQuery($nameParam, $emailParam, $statusParam, $groupParam, $perPage);


        $this->_transformUser($users);

        $users->withQueryString();


        $arrGroups = Group::getAll();


        $arrGroupTransform = $this->_transformGroup($arrGroups);

        $nameParam = $request->input('name');
        $emailParam = $request->input('email');

        // other ways to do this
        // $users->appends(['perPage' => $request->perPage]);

        return view('pages.users.index', compact("users", "perPage", 'arrGroupTransform', 'nameParam', 'emailParam', 'strQuery'));
    }


    /**
     * Store a new user.
     *
     * @param AddNewUserRequest $request the request for adding a new user.
     * @throws Some_Exception_Class description of exception
     * @return redirect to the admin user route with a success message
     * * 27/12/2023
     * version:3
     */
    public function store(AddNewUserRequest $request): RedirectResponse
    {

        User::createNewUser($request);

        return redirect()->route('admin.user.get')->with('success', 'Successfully add new user!');
    }

    /**
     * Edit a user and return the view.
     *
     * @param Request $request The request object.
     * @param mixed $id The ID of the user.
     * @throws Some_Exception_Class If something goes wrong.
     * @return View The view of the updated user.
     * 27/12/2023
     * version:2
     */
    public function edit(Request $request, $id): View
    {
        $user = User::getSingleUser($id);
        $group = Group::getAll();
        $arrGroupTransform = $this->_transformGroup($group);

        return view('pages.users.edit.user-update', compact('user', 'arrGroupTransform', "id"));
    }


    /**
     * Update a user.
     *
     * @param UpdateUserRequest $request The request object containing the user data.
     * @param mixed $id The ID of the user to update.
     * @return RedirectResponse The redirect response after the user has been updated.
     * 27/12/2023
     * version:2
     */
    public function update(UpdateUserRequest $request, $id): RedirectResponse
    {
        User::updateUser($request, $id);
        return redirect()->route("admin.user.get")->with("success", "Successfully update user!");

    }


    /**
     * Change the password for a user.
     *
     * @param ChangePasswordRequest $request The request containing the new password.
     * @param int $id The ID of the user.
     * @throws Some_Exception_Class Description of any exceptions thrown.
     * @return RedirectResponse The redirect response to the admin user page with a success message.
     * 27/12/2023
     * version:2
     */
    public function changePassword(ChangePasswordRequest $request, $id): RedirectResponse
    {
        User::changePassword($request, $id);
        return redirect()->route("admin.user.get")->with("success", "Successfully change password user!");
    }


    /**
     * Change the active status of a user.
     *
     * @param int $id The ID of the user whose active status will be changed.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return RedirectResponse The redirect response after changing the active status.
     * 27/12/2023
     * version:2
     */
    public function changeActive($id): RedirectResponse
    {
        User::changeActive($id);
        return redirect()->route("admin.user.get")->with("success", "Successfully change active status user!");
    }

    /**
     * Deletes a user.
     *
     * @param Request $request the request object
     * @param mixed $id the user ID
     * @return RedirectResponse the redirect response
     * 27/12/2023
     * version:1
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        User::deleteUser((string) $id);
        return redirect()->route("admin.user.get")->with("delete", "Delete  user succesfully!");

    }


    /**
     * Transforms the given users by adding additional attributes.
     *
     * @param User $users The users to be transformed.
     * @throws \Exception If an error occurs during the transformation.
     * @return void
     * 27/12/2023
     * version:1
     */
    private function _transformUser($users): void
    {
        $users->map(function ($user) {
            $user->group_name = $user->group->name; // append the group name attribute
            $user->active_name = $user->is_active === 1 ? 'Hoạt động' : 'Không hoạt động';
            return $user;
        });
    }

    /**
     * Transforms a Group object into an array.
     *
     * @param Group $groups The Group object to transform.
     * @return array The transformed array.
     * 27/12/2023
     * version:1
     */
    private function _transformGroup($groups): array
    {

        $collection = collect($groups);
        $plucked = $collection->pluck('id', 'name');
        $plucked->prepend('', '--- Chọn nhóm ---');
        return $plucked->all();
    }



}
