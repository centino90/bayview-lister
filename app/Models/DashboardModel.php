<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DashboardModel extends Model
{
    use HasFactory;

    public static function dailyCertificationReport($class)
    {
        $qry = Db::select('CALL getDailyCertificationReport(?)', [$class]);

        return $qry;
    }

    public static function countRows()
    {
        $qry = Db::select('SELECT COUNT(*) AS count FROM residents');

        return $qry;
    }

}
