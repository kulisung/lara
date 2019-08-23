<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersProFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public function index()
    public function UsersIndex ()
    {
        //
        $users = DB::select('select * from users order by username DESC');
        $usersdata=[
            'users'=>$users
        ];
        return view('UsersProfile.UsersIndex', $usersdata);
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
        //
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

    public function UsersEdit($username)
    {
        //
        $user = DB::select('select * from users where username = ?', [$username]);
        $data = [
            'user' => $user[0],
        ];
        return view('UsersProfile.UsersEdit', $data);
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

    public function UsersUpdate(Request $request, $username)
    {
        $att['name'] = $request->input('name');
        $att['user_level'] = $request->input('user_level');
        $att['email'] = $request->input('email');
        //$att['password'] = $request->input('password');
        $att['updated_at'] = now();
        DB::update('update users set name=?,user_level=?,email=?,updated_at=? where username=?', 
        [$att['name'],$att['user_level'],$att['email'],$att['updated_at'],$username]);

        return redirect()->route('UsersProfile.UsersIndex'); 
    }

    public function UsersResetPassword(Request $request, $username)
    {
        $att['password'] = bcrypt($request->input('password'));
        //$att['user_level'] = $request->input('user_level');
        //$att['email'] = $request->input('email');
        //$att['password'] = $request->input('password');
        $att['updated_at'] = now();
        DB::update('update users set password=?,updated_at=? where username=?', 
        [$att['password'],$att['updated_at'],$username]);

        return redirect()->route('UsersProfile.UsersIndex'); 
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($username)
    {
        //
        DB::delete('delete from users where username = ?', [$username]);
        return redirect()->route('UsersProfile.UsersIndex');
    }
}
