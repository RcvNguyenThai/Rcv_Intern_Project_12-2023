<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


/**
 * AuthController for login and logout operations.
 * 
 * 22/12/2023   
 * version:1
 */
class AuthController extends Controller
{
    /**
     * Retrieves the index view for the authentication login page.
     *
     * @return \Illuminate\Contracts\View\View The index view for the authentication login page.
     * 25/12/2023   
     * version:1
     */
    public function index(): View
    {
        return view('pages.auth.login');
    }



    /**
     * Create a new login.
     *
     * @param LoginRequest $request The login request.
     * @throws Some_Exception_Class Description of the exception.
     * @return redirect()
     * 25/12/2023
     * version:1
     */
    public function create(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        $exist_user = User::getExistUser($credentials['email']);


        if (!$exist_user) {
            return $this->_returnError();
        }

        if ($exist_user->lock_time > now()) {

            return $this
                ->_returnError("Your account is locked for $exist_user->lock_time .Please wait until expired time.");
        }

        // update the attempt_time:

        if ($exist_user->attempt_time >= 5) {
            // lock for 5 minutes
            User::lockUser($exist_user);
        }

        if (Auth::attempt($credentials, $remember)) {
            User::unlockUser($exist_user);
            User::resetAttemptTime($exist_user);
            $user = User::getUserForSession($credentials['email']);
            User::updateAfterLogin($user, $request);

            session()->put('userInfor', [
                'name' => $user->name,
                'email' => $user->email,
                'group_id' => $user->group_id
            ]);


            return redirect()->intended('admin');
        }

        User::updateAttemptTime($exist_user);

        return $this->_returnError();

    }



    /**
     * Logs out a user
     *
     * @param Request $request The request object containing the user's email and password.
     * @return redirect
     * 22/12/2023
     * version:2
     */
    public function destroy(Request $request)
    {
        $this->_deleteRememberToken();

        Auth::logout();

        // //remove all session data
        $request->session()->invalidate();

        return redirect("/");
    }

    /**
     * Deletes the remember token of the authenticated user.
     *
     *  @return void
     * 22/12/2023
     * version:2
     */
    private function _deleteRememberToken(): void
    {
        $user = Auth::user();

        if ($user) {
            $user->forceFill([
                'remember_token' => null,
            ])->save();
        }

        Session::forget('userInfo');

    }

    /**
     * Register a new user.
     *
     * @return View
     * 22/12/2023
     * version:1
     */
    public function register(): View
    {
        return view('auth.register');
    }


    /**
     * A private function that returns an error message.
     *
     * @param string $message The error message to be returned. Defaults to 'Wrong email or password.'
     * @return void
     * 22/12/2023
     * version:1
     */
    private function _returnError(string $message = 'Wrong email or password.')
    {
        return redirect()->back()->with('login_error', $message);
    }
}
