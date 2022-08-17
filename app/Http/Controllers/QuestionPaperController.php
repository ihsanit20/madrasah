<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionPaperResource;
use App\Models\QuestionPaper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionPaperController extends Controller
{
    public function index()
    {
        $collections = QuestionPaper::query();

        return Inertia::render('QuestionPaper/Index', [
            'data' => [
                'collections'   => QuestionPaperResource::collection($collections->paginate()->appends(request()->input())),
                'filters'       => $this->getFilterProperty(),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('QuestionPaper/Create', [
            'data' => $this->data(new QuestionPaper())
        ]);
    }

    public function store(Request $request)
    {
        $questionPaper = QuestionPaper::create($this->validatedData($request));

        return redirect()
            ->route('question-papers.show', $questionPaper->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(QuestionPaper $questionPaper)
    {
        return Inertia::render('QuestionPaper/Show', [
            'data' => [
                'questionPaper' => $this->formatedData($questionPaper)
            ]
        ]);
    }

    public function edit(QuestionPaper $questionPaper)
    {
        return Inertia::render('QuestionPaper/Edit', [
            'data' => $this->data($questionPaper)
        ]);
    }

    public function update(Request $request, QuestionPaper $questionPaper)
    {
        $questionPaper->update($this->validatedData($request, $questionPaper->id));

        return redirect()
            ->route('question-papers.show', $questionPaper->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(QuestionPaper $questionPaper)
    {
        $questionPaper->delete();

        return redirect()
            ->route('question-papers.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function data($questionPaper)
    {
        return [
            'questionPaper' => $this->formatedData($questionPaper),
        ];
    }

    protected function formatedData($questionPaper)
    {
        QuestionPaperResource::withoutWrapping();

        return new QuestionPaperResource($questionPaper);
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    protected function validatedData($request, $id = '')
    {
        return $request->validate([
            //
        ]);
    }

}