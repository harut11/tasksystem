<?php

namespace App\Http\Controllers\manager;

use Carbon\Carbon;
use App\Models\tasks;
use App\Models\task_user;
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

            $tasks = $this->getTasksQuery('name', $request->order, 3);

            return view('manager.task.load', compact('tasks'));
        }
        return view('manager.task.tasks', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|min:5|max:255',
            'description' => 'min:10',
            'deadline' => 'required|date_format:"Y/m/d h:i A"',
            'status' => 'string',
            'developers' => isset($request['developers']) ? 'required' : ''
        ]);

        $id = tasks::insertGetId([
            'name' => $request['name'],
            'description' => $request['description'],
            'deadline' => Carbon::parse($request['deadline']),
            'status' => $request['status'] === 'assigned' && empty($request['developers'])
                ? 'created' : $request['status'],
            'manager_id' => auth()->id(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if (isset($request['developers']) && !empty($request['developers'])) {
            $this->changePivot('insert', $id, $request);
        }

        return redirect()->route('manager.task.index');
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

        return view('manager.task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = tasks::query()->where('id', $id)
            ->where('manager_id', auth()->id())
            ->with('users')
            ->firstOrFail();

        return view('manager.task.edit', compact('task'));
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
            'name' => 'required|min:5|max:255',
            'description' => 'min:10',
            'deadline' => 'required|date_format:"Y/m/d h:i A"',
            'status' => 'string'
        ]);

        $task = tasks::query()->where('id', $id)
            ->where('manager_id', auth()->id())
            ->first();

        if (isset($task)) {
            $task->update([
                'name' => $request['name'],
                'description' => $request['description'],
                'deadline' => Carbon::parse($request['deadline']),
                'status' => $request['status'],
                'updated_at' => Carbon::now()
            ]);

            if (isset($request['developers']) && !empty($request['developers'])
                && ($task->status === 'assigned' || $task->status === 'created')) {
                task_user::query()->where('task_id', $id)->delete();
                $this->changePivot('insert', $id, $request);

                return redirect()->route('manager.task.index');
            } else if (!isset($request['developers']) && $task->status === 'assigned') {
                task_user::query()->where('task_id', $id)->delete();

                $task->update([
                    'status' => 'created'
                ]);

                return redirect()->route('manager.task.index');
            }
        }
        return redirect()->route('manager.task.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = tasks::query()->where('id', $id)
            ->where('manager_id', auth()->id())
            ->firstOrFail();

        $task->delete();
        return redirect()->route('manager.task.index');
    }

    public function changePivot($action, $id, $request) {
        $records = [];

        foreach ($request['developers'] as $key => $value) {
            $record = [
                'task_id' => $id,
                'user_id' => $value
            ];

            $records[] = $record;
        }

        task_user::$action($records);
    }

    public function getTasksQuery($column, $condition, $pages)
    {
        return tasks::query()->with('users')
            ->orderBy($column, is_null($condition) ? 'DESC' : $condition)->paginate($pages);
    }
}
