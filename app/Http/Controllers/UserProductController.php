<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\ProductModule\Entities\Category;
use Modules\ProductModule\Entities\Product;
use Modules\ProductModule\Entities\ProductPhotos;

class UserProductController extends Controller
{




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();
        $categoryArr = array();
        foreach ($categories as $category){
            $categoryArr[$category->id] = $category->name ;
        }

        return view('products.create' , ['categories' => $categoryArr ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $currentCategory = $request->input('category_id') ;
        $product->is_active =  0 ;
        $category = Category::find($currentCategory);
        $category->products()->save($product);

        if ($file = $request->file('photo')){
            $name = time() . $file->getClientOriginalName() ;
            $file->move('productImages' , $name);
            $photo = new ProductPhotos();
            $photo->path = $name;
        }
        $product->photo()->save($photo);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
