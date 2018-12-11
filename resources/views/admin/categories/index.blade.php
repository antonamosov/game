@extends('layouts.admin')

@section('panel-heading')
    Categories
@endsection

@section('heading-buttons')
    <a class="btn btn-sm btn-primary" href="/admin/categories/create">Create</a>
@endsection

@section('content')
    <table class="table table-bordered table-striped table-condensed">

        <tr class="head">

            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th></th>

        </tr>

        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td><img src="{{ $category->image()->url('') }}"></td>
                <td><a href="/admin/categories/{{ $category->id }}/questions">Questions</a></td>
            </tr>
        @endforeach
    </table>
@endsection
