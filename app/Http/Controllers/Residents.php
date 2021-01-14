<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\ResidentsModel;

class Residents extends Controller
{
    public function index()
    {
        $min = 10;
        $data = ResidentsModel::getRecordsByTen($min);
        return view('posts.index', ['records' => $data]);
    }

    public function searchOnInput(Request $request)
    {
        $s = $request->get('s');
        $min = 10;
        $data = ResidentsModel::getRecsBySearch($s, $min);
        return json_encode($data);
    }

    public function insertRecord(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|max:100',
            'mname' => 'required|max:1',
            'lname' => 'required|max:100'
        ]);

        if(ResidentsModel::createRecord([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname
        ])) {

            $request->session()->flash('success', 'Task was successful!');

        }
        return redirect()->route('home');
    }
}
