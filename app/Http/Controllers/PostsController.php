<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::select('select * from posts order by id DESC');
        $data=[
            'posts'=>$posts
        ];
        return view('posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $att['title'] = $request->input('title');
        $att['content'] = $request->input('content');
        $att['user_id'] = auth()->user()->id;
        $att['views'] = 0;
        $att['created_at'] = now();
        $att['updated_at'] = now();
        DB::insert('insert into posts (title, content, user_id, views, created_at, updated_at) values (?, ?, ?, ?, ?, ?)', [$att['title'], $att['content'], $att['user_id'], $att['views'], $att['created_at'], $att['updated_at']]);
        return redirect()->route('posts.index');
        
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
        $post = DB::select('select * from posts where id = ?', [$id]);
        $data = [
            'post' => $post[0],
        ];
        return view('posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = DB::select('select * from posts where id = ?', [$id]);
        $data = [
            'post' => $post[0],
        ];
        return view('posts.edit', $data);        
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
        $att['title'] = $request->input('title');
        $att['content'] = $request->input('content');
        DB::update('update posts set title=?,content=? where id=?', 
        [$att['title'],$att['content'],$id]);

        return redirect()->route('posts.index'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('delete from posts where id = ?', [$id]);
        return redirect()->route('posts.index');
    }

}
