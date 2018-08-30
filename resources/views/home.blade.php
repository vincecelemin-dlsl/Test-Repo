@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Todos</h2>
    <form action="/todos/search" method="POST">
        {!! csrf_field() !!}
        <div class="input-group col-sm-offset-8">
            <input type="text" class="form-control" name="data" placeholder="Search for a task">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
    </form>
    <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Pending Tasks</a></li>
    <li><a data-toggle="tab" href="#menu1">Finished Tasks</a></li>
    </ul>

    <div class="tab-content" style="font-size: 1.25em">
        <div id="home" class="tab-pane fade in active">
            <table class="table table-striped">
                <thead>
                    <th>Description</th>
                    <th>Added On</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @if(count($pendings) == 0)
                    <tr>
                        <td colspan="3">You have nothing to do today!</td>
                    </tr>
                    @else
                        @foreach($pendings->all() as $pending)
                        <tr>
                            <td>{{$pending->description}}</td>
                            <td>{{$pending->added_on}}</td>
                            <td>
                            <form action="/todos/{{$pending->id}}" method="POST" style="margin-bottom: 4px">
                                {!! csrf_field() !!}
                                {!! method_field('PUT') !!}
                                <input type="hidden" name="type" value="finish">
                                <button class="btn btn-success" type="submit">Mark as Done</button>
                            </form>
                                
                            <form action="/todos/{{$pending->id}}" method="POST" style="margin-bottom: 4px">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div id="menu1" class="tab-pane fade">
            <table class="table table-striped">
                <thead>
                    <th>Description</th>
                    <th>Added On</th>
                    <th>Finished On</th>
                    <th>Action</th>
                </thead>

                <tbody>
                    @if(count($finisheds) == 0)
                    <tr>
                        <td colspan="4">You have not finished anything yet</td>
                    </tr>
                    @else
                        @foreach($finisheds->all() as $finished)
                        <tr>
                            <td>{{$finished->description}}</td>
                            <td>{{$finished->added_on}}</td>
                            <td>{{$finished->finished}}</td>
                            <td>
                                <form action="/todos/{{$finished->id}}" method="POST" style="margin-bottom: 4px">
                                    {!! csrf_field() !!}
                                    {!! method_field('PUT') !!}
                                    <input type="hidden" name="type" value="redo">
                                    <button class="btn btn-success" type="submit">Mark as Undone</button>
                                </form>
                                
                                <form action="/todos/{{$finished->id}}" method="POST" style="margin-bottom: 4px">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
