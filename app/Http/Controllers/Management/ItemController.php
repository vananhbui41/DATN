<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Management\CategoryController;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return view('management.item.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('management.item.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:items|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric'
        ]);
        //if a user does not uploade an image, use noimge.png for the item
        $imageName = "noimage.png";

        //if a user upload image
        if($request->image){
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpeg,png,jpg,heic|max:5000'
            ]);
            $imageName = date('mdYHis').uniqid().'.'.$request->image->extension();
            $request->image->move(public_path('item_images'), $imageName);
        }
        //save information to items table
        $item = new Item();
        $item->name = $request->name;
        $item->price = $request->price;
        $item->image = $imageName;
        $item->description = $request->description;
        $item->category_id = $request->category_id;
        $item->save();
        $request->session()->flash('status', $request->name. ' được tạo thành công');
        return redirect('/management/items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $categories = Category::all();
        return view('management.item.edit')->with('item',$item)->with('categories',$categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // information validation
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric'
        ]);
        $item = Item::find($id);
        // validate if a user upload image
        if($request->image){
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpeg,png,jpg,heic|max:5000'
            ]);
            if($item->image != "noimage.png"){
                $imageName = $item->image;
                unlink(public_path('item_images').'/'.$imageName);
            }
            $imageName = date('mdYHis').uniqid().'.'.$request->image->extension();
            $request->image->move(public_path('item_images'), $imageName);
        }else{
            $imageName = $item->image;
        }

        $item->name = $request->name;
        $item->price = $request->price;
        $item->image = $imageName;
        $item->description = $request->description;
        $item->category_id = $request->category_id;
        $item->save();
        $request->session()->flash('status', $request->name. ' được sửa thành công');
        return redirect('/management/items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if($item->image != "noimage.png"){
            unlink(public_path('item_images').'/'.$item->image);
        }
        $itemName = $item->name;
        $item->delete();
        Session()->flash('status', $itemName. ' đã được xóa');
        return redirect('/management/items');
    }
}
