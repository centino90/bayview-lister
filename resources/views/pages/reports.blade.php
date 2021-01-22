@extends('layouts.app')
@section('content')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex gap-x-3 text-lg">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
        </svg>  
        {{ $title }}
    </div>
</header>

<div class="flex justify-center items-start flex-wrap gap-x-3 gap-y-5 px-3 mt-5">
    <div class="flex-auto bg-white p-6 rounded-lg">

        <div class="flex flex-row rounded-lg p-2 bg-white flex-wrap justify-center items-start gap-x-5 gap-y-8">
            <div class="w-96 bg-white shadow-lg p-3">
                <h1 class="text-lg font-semibold flex justify-between mb-3">
                    This Day
                    <span class="font-normal"><?= date("l") ?></span>
                </h1>
                @if($dailyRow[0])
                <div class="mb-3">
                    <p class="underline font-semibold px-2">Total: {{$dailyRow[0]->count}}</p>
                </div>
                @endif
                @if($dailyIssue[0])
                <div class="bg-green-200 table w-full border-b-2 border-solid border-green-700">
                    <div class="table-row-group">
                        @foreach ($dailyIssue as $di)
                        <div class="table-row">
                            <div class="flex flex-row p-2 gap-x-3 table-cell border-t-2 border-l-2 border-r-2  border-solid border-green-700">
                                <div>{{$di->issue}}</div>
                            </div>
                            <div class="flex flex-row p-2 gap-x-3 table-cell border-t-2 border-r-2 border-solid border-green-700 text-center">
                                <div class="font-semibold">{{$di->count}}</div>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="w-96 bg-white shadow-lg p-3">
                <h1 class="text-lg font-semibold mb-3">This Week</h1>
                @if($weeklyRow[0])
                <div class="mb-3">
                    <p class="underline font-semibold px-2">Total: {{$weeklyRow[0]->count}}</p>
                </div>
                @endif
                @if($weeklyIssue[0])
                <div class="bg-green-200 table w-full border-b-2 border-solid border-green-700">
                    <div class="table-row-group">
                        @foreach ($weeklyIssue as $wi)
                        <div class="table-row">
                            <div class="flex flex-row p-2 gap-x-3 table-cell border-t-2 border-l-2 border-r-2  border-solid border-green-700">
                                <div>{{$wi->issue}}</div>
                            </div>
                            <div class="flex flex-row p-2 gap-x-3 table-cell border-t-2 border-r-2 border-solid border-green-700 text-center">
                                <div class="font-semibold">{{$wi->count}}</div>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="w-96 bg-white shadow-lg p-3">
                <h1 class="text-lg font-semibold flex justify-between mb-3">
                    This Month
                    <span class="font-normal"><?= date("F") ?></span>
                </h1>
                @if($monthlyRow[0])
                <div class="mb-3">
                    <p class="underline font-semibold px-2">Total: {{$monthlyRow[0]->count}}</p>
                </div>
                @endif
                @if($monthlyIssue[0])
                <div class="bg-green-200 table w-full border-b-2 border-solid border-green-700">
                    <div class="table-row-group">
                        @foreach ($monthlyIssue as $mi)
                        <div class="table-row">
                            <div class="flex flex-row p-2 gap-x-3 table-cell border-t-2 border-l-2 border-r-2  border-solid border-green-700">
                                <div>{{$mi->issue}}</div>
                            </div>
                            <div class="flex flex-row p-2 gap-x-3 table-cell border-t-2 border-r-2 border-solid border-green-700 text-center">
                                <div class="font-semibold">{{$mi->count}}</div>
                            </div>

                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection