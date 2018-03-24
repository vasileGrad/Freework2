<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Category;
use DB;

class CategoryController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = DB::table('category')->orderBy('category.id','desc')->paginate(5);

        return view('adminPages.Categories.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('adminPages.Categories.addCategory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'title'         => 'required|max:255'
        )); 

        $category = new Category;
        $category->categoryName = $request->title;

        $category->save();

        Session::flash('success', 'The category was successfully saved!');

        return redirect()->route('categories.show', $category->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // find an item by the id that it's past in the url
        $category = Category::find($id);  // also deep linking for the categories
        // render the view and it's gonna pass in a variable called post which is equal to $post
        return view('adminPages.Categories.showCategory')->withCategory($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        return view('adminPages.Categories.editCategory')->withCategory($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the data
        $this->validate($request, array(
            // rules 
            'categoryName' => 'required|max:255'
        ));

        $category = Category::find($id);
        $category->categoryName = $request->input('categoryName');
        $category->save();

        // Set flash data with success message
        Session::flash('success', 'This category was successfully updated!');
        // redirect with flash data to posts.show
        return redirect()->route('categories.show', $category->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        Session::flash('success', 'The skill was successfully deleted!');

        return redirect()->route('categories.index');
    }

    /**
     * Find specific category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCategories()
    {
        $categories = DB::table('category')->orderBy('category.id','desc')->paginate(5);

        return view('adminPages.Categories.findCategory', compact('categories'));
    }

    /**
     * Find specific category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findCategory(Request $request)
    {
        $search = $request->input('search');
        if($search != '')
            $keyword_category = $search;
        else
            $keyword_category = '';

        $categories = DB::table('category')->where('category.categoryName', 'LIKE', '%'.$keyword_category.'%')->orderBy('category.id','desc')->paginate(5);

        return view('adminPages.Categories.findCategory', compact('categories'));
    }
}
