<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $result = \App\Task::where('user_id', '=', Auth::user()->id)->orderBy('id', 'desc')->get();
      return $this->sendResponse($result, 'tasks', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $result = Task::create([
        'user_id'     => Auth::id(),
        'name'        => $request->name,
        'description' => $request->description,
        'target_date' => $request->target_date,
        'completed'   => $request->completed
      ]);

      return $this->sendResponse([$result], 'tasks', null);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $result = \App\Task::find($id)->get();
      return $this->sendResponse($result, 'tasks', null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $task = Task::where('id', $request->id)->first();
        $task->completed = $request->completed;
        if ($task->completed) {
          $task->completed_at = date('Y-m-d');
        }
        $task->save();

        return $this->sendResponse([$task], 'tasks', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Task::where('id', $id)->delete();
        return $this->sendResponse([$result], 'tasks', null);
    }
}
