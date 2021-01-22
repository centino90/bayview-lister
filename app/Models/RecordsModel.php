<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RecordsModel extends Model
{
    use HasFactory;

    public static function getRecordsByTen($lim)
    {

        $qry = DB::select("SELECT full_name(fname, mname, lname) AS FullName, issue, category, purpose, issue_date, session FROM residents WHERE issue_date = CURDATE() ORDER BY session, full_name(fname, mname, lname) ASC LIMIT ?", [$lim]);
        return $qry;
    }

    public static function getRecsBySearch($s, $lim)
    {
        $qry = DB::select('CALL searchRecords(?,?)',['%' . $s . '%', $lim]);
        
        return $qry;
    }

    public static function getRecsByDate($d)
    {
        $qry = DB::select("CALL getRecordsByDate(?, @sess_am, @sess_pm, @counter)", [$d]);
        $out = DB::select("SELECT @sess_am AS sess_am, @sess_pm AS sess_pm, @counter AS count");
        
        return [$qry, $out];
    }

    public static function createRecord($array)
    {

        $qry = DB::insert(" INSERT INTO 
                                residents (fname, mname, lname, issue, category, purpose, issue_date, session) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                            , [$array['fname'], $array['mname'], $array['lname'], $array['issue'], $array['category'], $array['purpose'], $array['issueDate'], $array['session']]
                        );
        return $qry;
    }
    
    public static function updateRecord($array)
    {
        $qry = DB::update(" UPDATE residents 
                                SET fname = ?, mname = ?, lname = ?, issue = ?, category = ?, purpose = ?, issue_date = ?, session = ?, updated_at = CURRENT_TIMESTAMP 
                            WHERE id = ?"
                            , [$array['fname'], $array['mname'], $array['lname'], $array['issue'], $array['category'], $array['purpose'], $array['issue_date'], $array['session'], $array['id']]
                        );

        return $qry;
    }

    public static function deleteRecord($array)
    {
        $qry = DB::delete(" DELETE FROM residents WHERE id = ?", [$array['id']]);

        return $qry;
    }

    public static function getConfirmationById($uid)
    {
        $qry = DB::select("SELECT password FROM users WHERE id = ?", [$uid]);

        return $qry;
    }
}
