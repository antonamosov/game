@extends('layouts.admin')

@section('panel-heading')
    Packs
@endsection

@section('heading-buttons')
    <a class="btn btn-sm btn-primary" href="/admin/packs/create">Create</a>
@endsection

@section('content')
    <table class="table table-bordered table-striped table-condensed">

        <tr class="head">

            <th>Name</th>
            <th>Price ($)</th>
            <th>Price (Coins)</th>
            <th>Categories</th>
            <th>Image</th>

        </tr>

        @foreach ($packs as $pack)
            <tr>
                <td>{{ $pack->name }}</td>
                <td>{{ $pack->price }}</td>
                <td>{{ $pack->coins_price }}</td>
                <td>
                    @foreach ($pack->Categories as $category)
                        <p>{{ $category->name }}</p>
                    @endforeach
                </td>
                <td><img src="{{ $pack->image()->url('') }}"></td>
            </tr>
        @endforeach
    </table>
@endsection
