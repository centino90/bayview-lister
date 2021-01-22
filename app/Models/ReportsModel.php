<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportsModel extends Model
{
    use HasFactory;

    public static function getDailyReport($class)
    {
        $qry = DB::select("CALL getDailyCertificationReport(?)", [$class]);

        return $qry;
        //countAllByIssue
        //countAllByName
    }
    public static function getWeeklyReport($class)
    {
        $qry = DB::select("CALL getWeeklyCertificationReport(?)", [$class]);
        return $qry;
    }
    public static function getMonthlyReport($class)
    {
        $qry = DB::select("CALL getMonthlyCertificationReport(?)", [$class]);
        return $qry;
    }
}
