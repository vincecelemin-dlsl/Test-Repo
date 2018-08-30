@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create a new Todo</h2>
        
        <form action="/todos" method="POST">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="tododes">Description</label>
                <input type="text" class="form-control" name="description" id="tododes" placeholder="Learn Laravel">
            </div>

            <fieldset class="form-group">
                <legend>Set As</legend>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="option" id="unfinished" value="unfinished" checked>
                    Unfinished
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="option" id="finished" value="finished">
                    Finished
                    </label>
                </div>
            </fieldset>
            
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection