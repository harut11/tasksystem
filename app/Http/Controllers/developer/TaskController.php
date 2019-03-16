<?php

namespace App\Http\Controllers\developer;

use App\Models\tasks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = tasks::query()->with('users')->get();
        return view('developer.task.index', compact('tasks'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = tasks::query()->where('id', $id)->with('users')
            ->first();

        return view('developer.task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = tasks::query()->where('id', $id)->with('users')
            ->join('task_user', 'tasks.id', '=', 'task_user.task_id')
            ->where('user_id', auth()->id())
            ->first();

        if (isset($task)) {
            return view('developer.task.edit', compact('task'));
        } else {
            return redirect()->route('developer.task.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'string'
        ]);

        $task = tasks::query()->where('id', $id)->with('users')
            ->join('task_user', 'tasks.id', '=', 'task_user.task_id')
            ->where('user_id', auth()->id())
            ->first();

        if(isset($task)) {
            $task->update([
                'status' => $request['status']
            ]);
            return redirect()->route('developer.task.index');
        }
        return redirect()->route('developer.task.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
