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
    public function index(Request $request)
    {
        $tasks = $this->getTasksQuery('name', 'DESC', 3);

        if ($request->ajax()) {

            $tasks = $this->getTasksQuery('name',$request->order, 3);

            return view('developer.task.load', compact('tasks'));
        }
        return view('developer.task.index', compact('tasks'));
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
            ->firstOrFail();

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
            ->firstOrFail();

        return view('developer.task.edit', compact('task'));
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
            ->firstOrFail();

        $task->update([
            'status' => $request['status']
        ]);
        return redirect()->route('developer.task.index');
    }

    public function getTasksQuery($column, $condition, $pages)
    {
        return tasks::query()->with('users')
            ->orderBy($column, is_null($condition) ? 'DESC' : $condition)->paginate($pages);
    }
}
