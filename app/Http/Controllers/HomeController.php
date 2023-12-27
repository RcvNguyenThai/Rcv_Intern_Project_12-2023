<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

/**
 * Home controller for display the home page when login succesfully
 * 25/12/2023
 * version:1
 */
class HomeController extends Controller
{

    /**
     * Retrieves the index view.
     *
     * @return View
     * 25/12/2023
     * version:1
     */
    public function index(): View
    {
        return view("pages.home.home");
    }
}
