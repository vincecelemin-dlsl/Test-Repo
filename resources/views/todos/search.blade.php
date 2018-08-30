@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tasks containing '{{$search}}'</h2>

    <table class="table table-striped" style="font-size:1.25em">
        <thead>
            <tr>
                <th>Description</th>
                <th>Status</th>
                <th>Added On</th>
                <th>Finished On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($todos->all() as $todo)
                <tr>
                    <td>{{$todo->description}}</td>
                    @if($todo->status == 'U')
                    <td>Unfinished</td>
                    <td>{{$todo->added_on}}</td>
                    <td>N/A</td>
                    <td>
                    <form action="/todos/{{$todo->id}}" method="POST" style="margin-bottom: 4px">
                        {!! csrf_field() !!}
                        {!! method_field('PUT') !!}
                        <input type="hidden" name="type" value="finish">
                        <button class="btn btn-success" type="submit">Mark as Done</button>
                    </form>
                        
                    <form action="/todos/{{$todo->id}}" method="POST" style="margin-bottom: 4px">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <button type="submit" class="btn btn-danger">Remove</button>
                    </form>
                    </td>

                    @else
                    <td>Finished</td>
                    <td>{{$todo->added_on}}</td>
                    <td>{{$todo->finished}}</td>

                    <td>
                            <form action="/todos/{{$todo->id}}" method="POST" style="margin-bottom: 4px">
                                {!! csrf_field() !!}
                                {!! method_field('PUT') !!}
                                <input type="hidden" name="type" value="redo">
                                <button class="btn btn-success" type="submit">Mark as Undone</button>
                            </form>
                            
                            <form action="/todos/{{$todo->id}}" method="POST" style="margin-bottom: 4px">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection