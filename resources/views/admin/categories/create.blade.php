@extends('layouts.admin')

@section('panel-heading')
    Create category
@endsection

@section('content')
    <form action="/admin/categories" method="post" enctype="multipart/form-data">
        <div class="row form-group">
            <div class="col-md-2">
                <label for="name">Name</label>
            </div>
            <div class="col-md-10">
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-2">
                <label for="description">Description</label>
            </div>
            <div class="col-md-10">
                <input class="form-control" type="text" name="description" id="description" value="{{ old('description') }}">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-2">
                <label for="file">Image</label>
            </div>
            <div class="col-md-10">
                <input class="form-control" type="file" name="file" id="file">
            </div>
        </div>

        {{ csrf_field() }}

        <div class="row form-group">
            <div class="col-md-10 col-md-offset-2">
                <button class="btn btn-sm btn-primary" type="submit">Save</button>
            </div>
        </div>
    </form>
@endsection
