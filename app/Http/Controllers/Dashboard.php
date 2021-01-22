<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DashboardModel;


class Dashboard extends Controller
{
    public function index()
    {
        $class = 'countAllByRow';
        $dailyRecs = DashboardModel::dailyCertificationReport($class);
        $totalCount = DashboardModel::countRows();

        $data = [
            'title' => 'Dashboard',
            'daily' => $dailyRecs[0],
            'total' => $totalCount[0]
        ];

        return view('pages.dashboard', $data);
    }
}
