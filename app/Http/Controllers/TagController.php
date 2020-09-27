<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\str;
use function GuzzleHttp\Psr7\str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('created_at','DESC')->paginate(5);
        return view('admin.tag.tag',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.tag-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $this->validate($request,[
           'name'=>'required|unique:tags,name',
        ]);

        $tag = Tag::create([
            'name'=>$request->name,
            'slug'=>str::slug($request->name,'-'),
            'description'=>$request->description
        ]);

        Session::flash('success','Tag Created Successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return view('admin.tag.tag-show',compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tag.tag-edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        if ($tag){
            //Validation
            $this->validate($request,[
                'name'=>'required|unique:tags,name',
            ]);

            $tag -> name = $request->name;
            $tag ->slug = str::slug($request->name,'-');
            $tag ->description = $request->description;
            $tag -> save();

            Session::flash('success','Tag Updated Successfully');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if ($tag){
            $tag ->delete();

            Session::flash('success','Tag Deleted Successfully');
        }
        return redirect()->back();
    }
}
