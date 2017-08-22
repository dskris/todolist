<?php

namespace App\Http\Controllers;

use App\task;
use Auth;
use Illuminate\Http\Request;
use Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        if(request()->has('priority')){

            $tasks = Task::where('priority', request('priority'))->where('username', Auth::user()->name)->paginate(10);
        }else{
             $tasks = Task::orderBy('id','desc')->where('username', Auth::user()->name)->paginate(10);
        }

        return view('tasks.index')->with('storedTasks', $tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'newTaskName' => 'required|min:5|max:50|alpha_num',
            'newTaskDescription' => 'required|min:5|max:50|alpha_num',]);


        $task = new Task;

        $task->name = $request->newTaskName;

        $task->username= Auth::user()->name;

        $task->description= $request->newTaskDescription;

        $task->priority = $request->newPriority;

        $task->save();

        Session::flash('success','Task inserted successfully.');

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit')->with('taskUnderEdit',$task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // make sure that the update is not empty
        $this->validate($request, ['updatedTaskName' => 'required|min:5|max:50|alpha_num', 
            'updatedTaskDescription' => 'required|min:5|max:1000']);


        $task=Task::find($id);

        $task->name=$request->updatedTaskName;

        $task->description=$request->updatedTaskDescription;

        $task->priority=$request->updatedPriority;

        $task->save();

        Session::flash('success', 'Task #'. $id.' has been successfully updated');

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        $task->delete();

        return redirect()->route('tasks.index');

         Session::flash('success', 'Task #'. $id.' has been successfully removed');

    }
}
