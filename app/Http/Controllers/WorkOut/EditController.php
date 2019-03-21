<?php

namespace App\Http\Controllers\WorkOut;

use App\ContentOfWork;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 모든 content_of_work 를 get 한다.
        $content_of_works = ContentOfWork::all();

        // view 와 pass를 load 한다. 
        return view('views.index')
            ->with('content_of_works', $content_of_works);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'subtitle_of_work' => 'required',
            'chapter_of_work' => 'required',
            'content_of_work' => 'required',
            'created_at' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('editor.main.list')
                         ->with('success','Content created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('editor.tool.editor');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('editor.tool.editor');
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
        $request->validate([
            'subtitle_of_work' => 'required',
            'chapter_of_work' => 'required',
            'content_of_work' => 'required',
            'created_at' => 'required',
        ]);

        $content_of_works->update($request->all());

        return redirect()->route('editor.main.list')
                         ->with('success','Content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content_of_works->delete();

        return redirect()->route('editor.main.list')
                         ->with('success','Content deleted successfully.');
    }
}
