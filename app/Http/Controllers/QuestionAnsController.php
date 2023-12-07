<?php

namespace App\Http\Controllers;

use Auth;
use DataTables;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionAnsController extends Controller
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
            }])->where('added_by', Auth::user()->id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('category_id', function ($row) {
                    return $row->getCategory->name;
                })
                ->addColumn('answer', function ($row) {
                    $answer = $row->getAnswer;
                    return view('user.datatable.datatable_ans', compact('answer'));
                })
                ->addColumn('action', function ($row) {
                    $btn = '<i class="fas fa-2x fa-trash text-danger delete-question" data-id="'.$row->id.'"></i>';
                    return $btn;
                })
                ->editColumn('status', function ($row) {
                    $id = $row->id;
                    $status = $row->status;
                    return view('admin.datatable.status', compact('id', 'status'));
                })
                ->make(true);
        } else {
            $category = Category::where('status', 1)->get();
            return view('user.question_answer', compact('category'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'question' => 'required',
            'category' => 'required',
        ]);

        $question = Question::create([
            'question' => $request->question,
            'added_by' => Auth::user()->id,
            'category_id' => $request->category,
        ]);

        if(!empty($request->answer)) {
            foreach ($request->answer as $ans) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $ans,
                ]);       
            }
        }

        return response()->json(array('status' => TRUE, 'message' => 'Questin & answer add successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return response()->json(array('status' => TRUE, 'message' => 'Question delete successfully.'));
    }
}
