<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Manager;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function create(){
        $managers = Manager::all();
        return view('admin.projects.create', compact('managers'));
    }
    public function store(StoreProjectRequest $request){
        try{
            Project::create($request->validated());

            return redirect()
                ->route('admin.projects.create')
                ->with('success', 'Project created successfully!');
        }
        catch (\Exception $exception){
            return back()
                ->withErrors(['name' => ($exception->getMessage())])
                ->withInput();
        }

    }
}
