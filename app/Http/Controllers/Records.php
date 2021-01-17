<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordsModel;

class Records extends Controller
{
    public function index()
    {
        $min = 10;
        $records = RecordsModel::getRecordsByTen($min);

        $data = [
            'records' => $records,
            'title' => 'Records'
        ];

        return view('posts.index', $data);
    }

    public function searchOnInput(Request $request)
    {
        $s = $request->get('s');
        $min = 10;
        $data = RecordsModel::getRecsBySearch($s, $min);
        return json_encode($data);
    }

    public function insertRecord(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|max:100',
            'mname' => 'required|max:1',
            'lname' => 'required|max:100',
            'issue' => 'required|max:100',
            'purpose' => 'max:300'
        ]);

        if(RecordsModel::createRecord([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'issue' => $request->issue,
            'purpose' => $request->purpose
        ])) {

            $request->session()->flash('success', 'Certification was Successfully Recorded!');

        } else {
            $request->session()->flash('failed', 'There was a problem with the request! Please Try Again');
        }
        return redirect()->route('records');
    }
}
