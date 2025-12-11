<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Manager;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        $employees = Employee::all();
        $projects = Project::all();
        $managers = Manager::all();
        return view('admin.dashboard',compact('employees','projects','managers'));
    }
}
