@extends('layouts.app')

@section('content')
<div class="flex justify-center items-start flex-wrap gap-x-3 gap-y-5 px-3">
    <div class="flex-auto bg-white p-6 rounded-lg">
        <h1 class="text-lg font-semibold flex items-center gap-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
            </svg>
            {{$title}}
        </h1>

        <div class="cards w-full flex flex-wrap justify-center gap-x-6 gap-y-6 mt-8">
            <a href="{{route('records')}}">
                <div class="w-96 bg-blue-200 flex flex-col card card-daily hover:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50">
                    <div class="w-full pl-4 py-3 flex flex-col gap-y-3">
                        <p class="text-2xl bg-white opacity-75 shadow-md text-center">Certifications generated today</p>
                        <h1 class="ml-3 card-circle text-7xl font-semibold text-purple-700 rounded-full h-24 w-24 flex items-center justify-center bg-white">{{$daily->count}}</h1>
                    </div>
                    <div class="w-full px-4 py-2 bg-red-100 text-sm font-semibold flex gap-x-2 items-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path>
                        </svg>
                        Proceed to Records
                    </div>
                </div>
            </a>
            <a href="{{route('reports')}}">
                <div class="w-96 bg-blue-200 flex flex-col card card-total hover:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-opacity-50">
                    <div class="w-full pl-4 py-3 flex flex-col gap-y-3">
                        <p class="text-2xl bg-white opacity-75 shadow-md text-center">Total Certifications Generated</p>
                        <h1 class="ml-3 card-circle text-7xl font-semibold text-purple-700 rounded-full h-24 w-24 flex items-center justify-center bg-white">{{$total->count}}</h1>
                    </div>
                    <div class="w-full px-4 py-2 bg-red-100 text-sm font-semibold flex gap-x-2 items-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                        Proceed to Reports
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection