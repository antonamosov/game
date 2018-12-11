@extends('layouts.admin')

@section('panel-heading')
    Users
@endsection

@section('content')
    <table class="table table-bordered table-striped table-condensed">

        <tr class="head">

            <th>id</th>
            <th>email</th>
            <th>name</th>

        </tr>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->name }}</td>
            </tr>
        @endforeach
    </table>
@endsection
