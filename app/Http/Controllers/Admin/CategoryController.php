<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;
use Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<i class="fas fa-2x fa-eye text-primary show-category" data-id="'.$row->id.'"></i> <i class="fas fa-2x fa-trash text-danger delete-category" data-id="'.$row->id.'"></i>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('admin.category.index');
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
        $this->validate($request,[
            'name' => 'required',
            'img' => 'required',
        ]);
        
        $input = $request->all();
        
        if ($request->hasFile('img')):
            $imageName = time().'-'.$request->file('img')->getClientOriginalName();
            $thumbnailImage = Image::make($request->file('img'));
            $thumbnailPath = public_path() . '/upload/category/thumbnail/';
            $originalPath = public_path() . '/upload/category/';
            $thumbnailImage->save($originalPath . $imageName);
            $thumbnailImage->resize(350, 350);
            $thumbnailImage->save($thumbnailPath . $imageName);
        else:
            $imageName = null;
        endif;

        Category::create([
            'name' => $input['name'],
            'img' => $imageName,
        ]);
        return response()->json(array('status' => TRUE, 'message' => 'Category add successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        if(!empty($category->img)) {
            $categoryImages = $category->img;
        } else {
            $categoryImages = '';
        }
        
        $html = view('admin.category.edit', compact('category', 'categoryImages'))->render();
        return response()->json(array('status' => TRUE, 'data' => $html));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request,[
            'name' => 'required',
        ]);
        
        $input = $request->all();
        if ($request->hasFile('img')):
            $imageName = time().'-'.$request->file('img')->getClientOriginalName();
            $thumbnailImage = Image::make($request->file('img'));
            $thumbnailPath = public_path() . '/upload/category/thumbnail/';
            $originalPath = public_path() . '/upload/category/';
            $thumbnailImage->save($originalPath . $imageName);
            $thumbnailImage->resize(350, 350);
            $thumbnailImage->save($thumbnailPath . $imageName);
        else:
            $imageName = null;
        endif;

        unset($input['_method']);
        unset($input['update_id']);
        $category->update($input);
        return response()->json(array('status' => TRUE, 'message' => 'Category update successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(array('status' => TRUE, 'message' => 'Delete successfully.'));
    }

    /**
     * API - Get category list
     */
    public function getCategory(Request $request)
    {
        $data = Category::latest()->get();
        return response()->json(array('status' => TRUE, 'data' => $data));
    }
}
