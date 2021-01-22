<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordsModel;
use Illuminate\Support\Facades\Hash;

class Records extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Hong_Kong');
        $date = date("Y-m-d");
        $records = RecordsModel::getRecsByDate($date);
        $data = [
            'records' => $records,
            'title' => 'Records',
            'curdate' => date("Y-m-d")
        ];

        return view('pages.index', $data);
    }

    public function tableSearchByDate(Request $request)
    {
        $d = $request->get('d');
        $data = RecordsModel::getRecsByDate($d);

        return json_encode($data);
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
            'fname' => 'required|string|max:50',
            'mname' => 'alpha|max:1|nullable',
            'lname' => 'required|string|max:50',
            'issue' => 'required|string|max:50',
            'category' => 'required|max:30',
            'purpose' => 'max:300',
            'issueDate' => 'required|date',
            'session' => 'required|max:2'
        ]);

        if (RecordsModel::createRecord([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'issue' => $request->issue,
            'category' => $request->category,
            'purpose' => $request->purpose,
            'issueDate' => $request->issueDate,
            'session' => $request->session
        ])) {

            $request->session()->flash('success', 'Certification was Successfully Recorded!');
        } else {
            $request->session()->flash('failed', 'There was a problem with the request! Please Try Again');
        }
        return redirect()->route('records');
    }

    public function updateRecord(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|string|max:50',
            'fname' => 'required|string|max:50',
            'mname' => 'alpha|max:1|nullable',
            'lname' => 'required|string|max:50',
            'issue' => 'required|string|max:50',
            'category' => 'required|max:50',
            'purpose' => 'max:300',
            'issue_date' => 'required|date',
            'session' => 'required|max:2',
        ]);

        if (RecordsModel::updateRecord([
            'id' => $request->id,
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'issue' => $request->issue,
            'category' => $request->category,
            'purpose' => $request->purpose,
            'issue_date' => $request->issue_date,
            'session' => $request->session
        ])) {

            $request->session()->flash('success-edit', 'Certification was Updated Successfully!');
        } else {
            $request->session()->flash('failed', 'There was a problem with the request! Please Try Again');
        }
        return redirect()->route('records');
    }

    public function deleteRecord(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|string|max:50'
        ]);

        if (RecordsModel::deleteRecord([
            'id' => $request->id
        ])) {
            $request->session()->flash('success-delete', 'The Record of that certification was Deleted Successfully!');
        } else {
            $request->session()->flash('failed', 'There was a problem with the request! Please Try Again');
        }
        return redirect()->route('records');
    }

    public function confirmPassword(Request $request)
    {

        $pwd = $request->get('pwd');
        $uid = $request->get('uid');
        // $pwd = '123456789';
        // $uid = 5;

        $hashedPwd = RecordsModel::getConfirmationById($uid);

        if (Hash::check($pwd, $hashedPwd[0]->password)) {
            return json_encode([$hashedPwd[0]->password]);
        } else {
            return json_encode([]);
        }
    }
}
