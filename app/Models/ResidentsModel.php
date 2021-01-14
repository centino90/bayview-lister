<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ResidentsModel extends Model
{
    use HasFactory;

    public static function getRecordsByTen($lim)
    {

        $qry = DB::select("SELECT * FROM residents LIMIT ?", [$lim]);
        return $qry;
    }
    public static function getRecsBySearch($s, $lim)
    {
        $qry = DB::select(" SELECT full_name(fname, mname, lname) 
                                AS FullName, created_at 
                            FROM residents 
                            WHERE fname LIKE ?
                                OR lname LIKE ?
                                OR CONCAT(fname, ' ',mname, ' ' , lname) LIKE ?
                                OR CONCAT(fname, mname, lname) LIKE ?  
                            LIMIT ?"
                            , ['%' . $s . '%', '%' . $s . '%', '%' . $s . '%', '%' . $s . '%', $lim]
                        );

        return $qry;
    }
    public static function createRecord($array)
    {

        $qry = DB::insert(" INSERT INTO 
                                residents (fname, mname, lname) 
                            VALUES (?, ?, ?)"
                            , [$array['fname'], $array['mname'], $array['lname']]
                        );
        return $qry;
    }
}
