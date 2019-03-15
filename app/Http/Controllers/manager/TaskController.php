<?php

namespace App\Http\Controllers\manager;

use Illuminate\Support\Facades\Auth;
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
    public function index()
    {
        $tasks = tasks::query()->with('users')->get();
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
            'developer_name' => 'string',
            'developer_id' => 'integer'
        ]);

        $id = tasks::insertGetId([
            'name' => $request['name'],
            'description' => $request['description'],
            'deadline' => Carbon::parse($request['deadline']),
            'status' => $request['status'],
            'manager_id' => Auth::user()->id
        ]);

        $devs_id = explode(',', $request['developer_id']);
        $records = [];

        foreach ($devs_id as $dev_id) {
            $record = [
                'task_id' => $id,
                'user_id' => $dev_id
            ];

            $records[] = $record;
        }

        task_user::insert($records);

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
        $task = tasks::findOrFail($id)->with('users')->first();

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
        $task = tasks::findOrFail($id);
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
            'status' => 'string',
            'developer_name' => 'string',
            'developer_id' => 'integer'
        ]);

        if (isset($request['developer_name'])) {
            tasks::findOrFail($id)->update([
                'name' => $request['name'],
                'description' => $request['description'],
                'deadline' => Carbon::parse($request['deadline']),
                'status' => $request['status'],
                'developer_name' => $request['developer_name'],
                'developer_id' => $request['developer_id'],
                'updated_at' => Carbon::now()
            ]);
        } else {
            tasks::findOrFail($id)->update([
                'name' => $request['name'],
                'description' => $request['description'],
                'deadline' => Carbon::parse($request['deadline']),
                'status' => $request['status'],
                'updated_at' => Carbon::now()
            ]);
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
        $task = tasks::findOrFail($id);
        $task->delete();
        return redirect()->route('manager.task.index');
    }
}
