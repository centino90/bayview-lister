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

        $qry = DB::select("SELECT full_name(fname, mname, lname) AS FullName, issue, purpose, issue_date FROM residents ORDER BY issue_date DESC, full_name(fname, mname, lname) ASC LIMIT ?", [$lim]);
        return $qry;
    }
    public static function getRecsBySearch($s, $lim)
    {
        $qry = DB::select('CALL searchRecords(?,?)',['%' . $s . '%', $lim]);
        // $qry = DB::select(" SELECT full_name(fname, mname, lname) 
        //                         AS FullName
        //                         , created_at 
        //                     FROM residents 
        //                     WHERE fname LIKE ?
        //                         OR mname LIKE ?
        //                         OR lname LIKE ?
        //                         OR CONCAT(fname, ' ', mname, ' ' , lname) LIKE ?
        //                         OR CONCAT(fname, mname, lname) LIKE ?  
        //                     LIMIT ?"
        //                     , ['%' . $s . '%', '%' . $s . '%','%' . $s . '%', '%' . $s . '%', '%' . $s . '%', $lim]
        //                 );

        return $qry;
    }
    public static function createRecord($array)
    {

        $qry = DB::insert(" INSERT INTO 
                                residents (fname, mname, lname, issue, purpose, issue_date) 
                            VALUES (?, ?, ?, ? ,?, ?)"
                            , [$array['fname'], $array['mname'], $array['lname'], $array['issue'], $array['purpose'], $array['issueDate']]
                        );
        return $qry;
    }
    
    public static function updateRecord($array)
    {
        $qry = DB::update(" UPDATE residents 
                                SET fname = ?, mname = ?, lname = ?, issue = ?, purpose = ?, issue_date = ?, updated_at = CURRENT_TIMESTAMP 
                            WHERE id = ?"
                            , [$array['fname'], $array['mname'], $array['lname'], $array['issue'], $array['purpose'], $array['issue_date'], $array['id']]
                        );

        return $qry;
    }
}
