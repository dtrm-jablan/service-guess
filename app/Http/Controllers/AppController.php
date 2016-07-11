<?php namespace Determine\Service\Guess\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends BaseController
{
    //******************************************************************************
    //* Methods
    //******************************************************************************

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('welcome', ['indices' => []]);
    }
}
