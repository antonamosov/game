<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\QuestionStoreRequest;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function index(Category $category)
    {
        return view('admin.questions.index', [
            'questions' => $category->Questions()->with('answers')->get(),
            'category' => $category
        ]);
    }

    public function create(Category $category)
    {
        return view('admin.questions.create', [
            'category' => $category
        ]);
    }

    public function store(Category $category, QuestionStoreRequest $request)
    {
        $question = $category->Questions()
            ->create($request->only([
                'title',
                'type',
            ]));

        if ($request->type === Question::TYPE_TEXT) {
            $question->Answers()->create([
                'title' => $request->text_answer,
                'right' => true,
            ]);
        }
        else {
            foreach ($request->answers as $key=> $answer) {
                $question->Answers()->create([
                    'title' => $answer,
                    'right' => $key > 2 ? true : false,
                ]);
            }
        }

        return redirect()->to("/admin/categories/{$category->id}/questions")->with([
            'status' => 'Question successfully created.'
        ]);
    }
}
