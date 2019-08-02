<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;
    public function model(array $row)
    {
    //    $fail_message = ' ';
    //    if ($data->count()) {
    //        foreach ($data as $key => $value) {
    //            foreach ($users as $userkey => $user) {
    //                if ( $value->username != $user['username']) {
                        return new User([
                        //
                            'username' => $row[0],
                            'name'     => $row[1],
                            'email'    => $row[2], 
                            //'password' => bcrypt($row[3]),
                            'password' => Hash::make($row[3]),
                        ]);
    //                } else {
    //                    $fail_message .= $value->username.' ';
    //                }
    //            }
    //        }
    //        if ($fail_message != ' ') {
    //            return back()->with('fail','Duplicate LoginID: '.$fail_message);
    //        }
    //        if(!empty($arr)) {
    //            User::insert($arr);
    //        }
    //    }
    //    return back()->with('success','Insert Record successfully.');
    }

}
