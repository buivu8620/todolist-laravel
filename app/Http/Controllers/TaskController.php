<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Activity;

class TaskController extends Controller
{
    //
    public function getTaskByCategory(Request $request) {
        // dd($request->id);
        $activity = Activity::find($request->id);
        $tasks = Task::where('activity_id', $request->id)->get();
        return view('detail', ['tasks' => $tasks, 'activity' => $activity]);
    }


    public function store(Request $request) {
        $task = new Task();
        $task->name = $request->input('task_name');
        $task->status = $request->input('status');
        $task->activity_id = $request->input('activity_id');
        $isStore = $task->save();
        $activityId = $request->input('activity_id');
        if($isStore) {
            return redirect("/detail/$activityId");
        }
    }

    public function update(Request $request, $id) {
        $activityId = $request->input('activity_id');
        $task = Task::updateOrCreate(
            [
                'id' => $id,
            ], 
            [
                'name' => $request->input('task_name'),  
                'status' => $request->input('status'),
                'activity_id' => $request->input('activity_id'),
            ]);
    
            return redirect("/detail/$activityId");
    }

    public function destroy($id)
    {
        //
        $task = Task::find($id);
        $isDelete = $task->delete();
        if($isDelete) {
            return back();
        }
    }
}