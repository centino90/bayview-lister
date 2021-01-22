<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportsModel;

class Reports extends Controller
{
    public function index()
    {
        $countByRow = 'countAllByRow';
        $countByIssue = 'countAllByIssue';
        $countByName = 'countAllByName';
        //daily
        $dailyRow = ReportsModel::getDailyReport($countByRow);
        $dailyIssue = ReportsModel::getDailyReport($countByIssue);
        $dailyName = ReportsModel::getDailyReport($countByName);
        //weekly
        $weeklyRow = ReportsModel::getWeeklyReport($countByRow);
        $weeklyIssue = ReportsModel::getWeeklyReport($countByIssue);
        $weeklyName = ReportsModel::getWeeklyReport($countByName);
        //monthly
        $monthlyRow = ReportsModel::getMonthlyReport($countByRow);
        $monthlyIssue = ReportsModel::getMonthlyReport($countByIssue);
        $monthlyName = ReportsModel::getMonthlyReport($countByName);

        $data = [
            'title' => 'Reports',
            'dailyRow' => $dailyRow,
            'dailyIssue' => $dailyIssue,
            'dailyName' => $dailyName,
            'weeklyRow' => $weeklyRow,
            'weeklyIssue' => $weeklyIssue,
            'weeklyName' => $weeklyName,
            'monthlyRow' => $monthlyRow,
            'monthlyIssue' => $monthlyIssue,
            'monthlyName' => $monthlyName
        ];

        return view('pages.reports', $data);
    }
}
