<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Answer;
use DataTables;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Question::with(['getUser' => function ($query) {
                $query->select('id', 'name');
            }, 'getAnswer' => function ($query) {
                $query->select('id', 'question_id', 'answer');
            }, 'getCategory' => function ($query) {
                $query->select('id', 'name');
            }])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('added_by', function ($row) {
                    return $row->getUser->name;
                })
                ->editColumn('category_id', function ($row) {
                    return $row->getCategory->name;
                })
                ->addColumn('answer', function ($row) {
                    $answer = $row->getAnswer;
                    return view('admin.datatable.answer', compact('answer'));
                })
                // ->addColumn('action', function ($row) {
                //     $btn = '<i class="fas fa-2x fa-eye text-primary show-category" data-id="'.$row->id.'"></i> <i class="fas fa-2x fa-trash text-danger delete-category" data-id="'.$row->id.'"></i>';
                //     return $btn;
                // })
                ->editColumn('status', function ($row) {
                    $id = $row->id;
                    $status = $row->status;
                    return view('admin.datatable.status', compact('id', 'status'));
                })
                ->make(true);
        } else {
            return view('admin.question.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }

    /**
    * Question status change.
    */
    public function statusChange($id)
    {
        $question = Question::find($id);
        $question->status = $question->status ? 0 : 1;
        if ($question->save()) {
            return response()->json(['status' => TRUE, 'message' => 'Question status change successfully.']);
        }
    }
}
