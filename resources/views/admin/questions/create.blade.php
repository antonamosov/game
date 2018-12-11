@extends('layouts.admin')

@section('panel-heading')
    Create question ({{ $category->name }} category)
@endsection

@section('header-scripts')
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="/js/custom.js"></script>
@endsection

@section('content')
    <form action="/admin/categories/{{ $category->id }}/questions" method="post">
        <div class="row form-group">
            <div class="col-md-2">
                <label for="title">Title</label>
            </div>
            <div class="col-md-10">
                <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}">
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-2">
                <label for="type">Type</label>
            </div>
            <div class="col-md-10">
                <select class="form-control" name="type" id="type">
                    <option
                            @if (old('type') === \App\Models\Question::TYPE_SELECT)
                                    selected="selected"
                            @endif
                            value="{{ \App\Models\Question::TYPE_SELECT }}">
                        {{ \App\Models\Question::TYPE_SELECT }}
                    </option>
                    <option
                            @if (old('type') === \App\Models\Question::TYPE_TEXT)
                                    selected="selected"
                            @endif
                            value="{{ \App\Models\Question::TYPE_TEXT }}">
                        {{ \App\Models\Question::TYPE_TEXT }}
                    </option>
                </select>
            </div>
        </div>

        <div id="type-select">
            <div class="row form-group">
                <div class="col-md-2">
                    <label for="answer-1">Answer 1</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control" name="answers[0]" id="answer-1">

                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2">
                    <label for="answer-2">Answer 2</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control" name="answers[1]" id="answer-2">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2">
                    <label for="answer-3">Answer 3</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control" name="answers[2]" id="answer-3">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-2">
                    <label for="answer-4">Right Answer 4</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control" name="answers[3]" id="answer-4">
                </div>
            </div>
        </div>

        <div id="type-text" style="display: none;">
            <div class="row form-group">
                <div class="col-md-2">
                    <label for="text_answer">Answer</label>
                </div>
                <div class="col-md-10">
                    <input class="form-control" name="text_answer" id="text_answer" value="{{ old('text_answer') }}">
                </div>
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
