<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use App\Todo;

class TodosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pending_todos = Auth::user()->todos->where('status', 'U')->where('visibility', '1');
        $finished_todos = Auth::user()->todos->where('status', 'F')->where('visibility', '1');

        $data = [
            'pendings' => $pending_todos,
            'finisheds' => $finished_todos
        ];

        return view('home')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'string',
            'option' => 'in:unfinished,finished'
        ]);

        $todo = new Todo;
        $todo->user_id = Auth::user()->id;
        $todo->description = $request['description'];
        if($request['option'] == 'unfinished') {
            $todo->status = 'U';
        } else {
            $todo->status = 'F';
            $todo->finished = date('Y-m-d H:i:s');
        }

        $todo->added_on = date('Y-m-d H:i:s');
        $todo->save();

        return redirect('/todos')->with('success', 'You have created a new task');
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
        if($request['type'] == 'finish') {
            $todo = Todo::find($id);
            $todo->status = 'F';
            $todo->finished = date('Y-m-d H:i:s');

            if($todo->save()) {
                return redirect('/todos')->with('success', 'Todo #'.$todo->id.' is done!');
            }
        } elseif($request['type'] == 'redo') {
            $todo = Todo::find($id);
            $todo->status = 'U';
            $todo->finished = null;

            if($todo->save()) {
                return redirect('/todos')->with('success', 'Todo #'.$todo->id.' is set as undone');
            }
        } else {
            return redirect('/todos')->with('error', 'Invalid fields');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->visibility = '0';

        if($todo->save()) {
            return redirect('/todos')->with('success', 'Todo #'.$todo->id.' has been successfully removed');
        }
    }

    public function search(Request $request) {
        if(empty(trim($request['data']))) {
            return redirect('/todos');
        } else {
            $todos = Todo::where('description', 'like', '%'.$request['data'].'%')->where('visibility', '1')->count();
            if($todos > 0) {

                $todos = Todo::where('description', 'like', '%'.$request['data'].'%')->where('visibility', '1')->get();
                $search = $request['data'];

                $data = [
                    'todos' => $todos,
                    'search' => $search
                ];

                return view('todos.search')->with($data);
            } else {
                return redirect('/todos')->with('error', 'No task with description '.$request['data']);
            }
        }
    }
}
