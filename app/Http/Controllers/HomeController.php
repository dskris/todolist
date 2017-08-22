<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\task;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                if(request()->has('priority')){

            $tasks = Task::where('priority', request('priority'))->paginate(10);
        }else{
             $tasks = Task::where('username', Auth::user()->name)->orderBy('id','desc')->paginate(10);
        }

        return view('tasks.index')->with('storedTasks', $tasks);    }
}
