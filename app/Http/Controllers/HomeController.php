<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
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
            }])->where('status', 1);

            if(isset($request->category_id)){
                $data->where('category_id', $request->category_id);
            }

            if(isset($request->date)){
                $data->where('created_at', 'like', $request->date."%");
            }

            $data = $data->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('question', function ($row) {
                    return view('user.datatable.home_datatable_question_ans', compact('row'));
                })
                ->make(true);
        } else {
            $category = Category::where('status', 1)->get();
            return view('user.welcome', compact('category'));
        }
    }
}
