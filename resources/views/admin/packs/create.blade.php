@extends('layouts.admin')

@section('panel-heading')
    Create pack
@endsection

@section('content')
    <form action="/admin/packs" method="post" enctype="multipart/form-data">
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
                <label for="price">Price ($)</label>
            </div>
            <div class="col-md-10">
                <input class="form-control" type="text" name="price" id="price" value="{{ old('price') }}">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-2">
                <label for="coins_price">Price (coins)</label>
            </div>
            <div class="col-md-10">
                <input class="form-control" type="text" name="coins_price" id="coins_price" value="{{ old('coins_price') }}">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-2">
                <label for="categories">Categories</label>
            </div>
            <div class="col-md-10">
                <select class="form-control" name="categories[]" id="categories" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
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
