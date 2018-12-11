@extends('layouts.admin')

@section('panel-heading')
    Questions
@endsection

@section('heading-buttons')
    <a class="btn btn-sm btn-primary" href="/admin/categories/{{ $category->id }}/questions/create">Create</a>
@endsection

@section('content')
    <table class="table table-bordered table-striped table-condensed">

        <tr class="head">

            <th>Title</th>
            <th>Type</th>
            <th>Category</th>
            <th>Answers</th>

        </tr>

        @foreach ($questions as $question)
            <tr>
                <td>{{ $question->title }}</td>
                <td>{{ $question->type }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    @foreach ($question->Answers as $answer)
                        <p>{{ $answer->title }} {{ $answer->right ? '(right)' : '' }}</p>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </table>
@endsection
