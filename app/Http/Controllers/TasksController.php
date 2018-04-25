<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Task;

class TasksController extends Controller
{
    
    public function index()
    {
        //$data = [];
        if (\Auth::check()) {
            
            $tasks = Task::all();
            return view('tasks.index', ['tasks' => $tasks,]);
            
            /*$user = \Auth::user();
            $task = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            $data += $this->counts($user);
            return view('tasks.show', $data);*/
        }else {
            return view('welcome');
        }
        //
        
        //
    }
    
    public function show($id)
    {
        //$data = [];
        if (\Auth::check()) {
            $task = Task::find($id);
            if (\Auth::user()->id == $task->user_id) {
                
                return view('tasks.show', ['task' => $task,]);
            } else {
                return redirect('/');
            }
            
        }else {
            return redirect('/');
        }

        //$task = Task::find($id);
        
        //return view('tasks.show', ['task' => $task,]);
    }
    
    public function create()
    {
        $task = new Task;
        
        return view('tasks.create', ['task' => $task,]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            
            'status' => 'required|max:10',
            'content' => 'required|max:191',
            ]);
        
        $task = new Task;
        $request->user()->tasks()->create([
                'content' => $request->content,
                'status' => $request->status,
            ]);
        
        
        
        return redirect('/');
    }
    
    public function edit($id)
    {
        if (\Auth::check()) {
            $task = Task::find($id);
            if (\Auth::user()->id == $task->user_id) {
                
                return view('tasks.edit', ['task' => $task,]);
            } else {
                return redirect('/');
            }
            
        }else {
            return redirect('/');
        }
        //$task = Task::find($id);
        
        //return view('tasks.edit', ['task' => $task,]);
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
            ]);
        
        $task = Task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }
    
    public function destroy($id)
    {
        $task = \App\Task::find($id);
        
        if (\Auth::user()->id === $task->user_id) {
            $task->delete();
        }
        
        return redirect('/');
    }
    
    
}
