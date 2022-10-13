<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Activity;
use App\Models\Task;

use Illuminate\Support\Facades\Route;


class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $activities = Activity::all();
        return view('home', ['activities' => $activities]);
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
        $activityName = $request->input('activity_name');
        $activity = new Activity();
        $activity->name = $activityName;
        $isStore = $activity->save();
        if($isStore) {
            return redirect('/');
        }
        dd($isStore);        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        $activity = Activity::updateOrCreate(
        [
            'id' => $id,
        ], 
        [
            'name' => $request->input('activity_name'),   
        ]);

        return redirect("/detail/$id");
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
        $activity = Activity::find($id);
        $tasks = Task::where('activity_id', $id)->get();
        
        $isDelete = $activity->delete() && Task::destroy($tasks);
        if($isDelete) {
            return redirect('/');
        }
    }
}