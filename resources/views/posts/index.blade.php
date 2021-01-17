@extends('layouts.app')
@section('content')
<div class="flex justify-center items-start flex-wrap gap-x-3 gap-y-5 px-3">
    <div class="max-w-md w-full bg-white p-6 rounded-lg">
        <div class="w-100 border-solid border-2 border-blue-200 flex mb-2">
            <input id="searchInp" type="text" class="flex-1 pl-2 py-1 focus:outline-none focus:ring focus:border-blue-300" placeholder="Enter name">
        </div>
        <ul id="searchOutput" class="flex flex-col gap-y-2"></ul>
    </div>
    <div class="flex-auto bg-white p-6 rounded-lg">
    <h1 class="text-lg font-semibold flex items-center gap-x-2">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
        {{$title}}
    </h1>
    @if ($message = Session::get('success'))
        <div class="text-green-500 text-sm flex gap-x-2 align-center bg-green-100 p-2 mb-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{$message}}
        </div>
    @elseif ($errors->any())
        <div class="text-red-400 text-sm flex gap-x-2 align-center bg-red-50 p-2 mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            Certification was not Recorded due to <b>Invalid Inputs!</b> Please Try Again
        </div>
    @else 
        <div class="text-green-400 text-sm p-2">
            {{$message}}
        </div>
    @endif
        <form id="form" action="{{route('insertRecord')}}" method="post" class='flex flex-col gap-y-5 mb-4'>
            @csrf
          
            <div class="text-sm">
            <i class="tracking-wide">Instruction: inputs that are labeled (*) are required.</i> <br>
            <i class="tracking-wide">After the required inputs are supplied, you can now proceed to submission</i>
            </div>
      
            <div class="flex-1 flex flex-col">
                <label for="fname" class="text-sm mb-1">First name *</label>
                <input class="pl-2 py-2 border-solid border-2 border-grey-500 outline-none flex-1" id="fname" type="text" name="fname" placeholder="" value="{{ old('fname') }}">
                @error('fname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="mname" class="text-sm mb-1">Middle name *</label>
                <input class="pl-2 py-2 border-solid border-2 border-grey-500 outline-none flex-1" id="mname" maxlength="1" type="text" name="mname" placeholder=""  value="{{ old('mname') }}">
                 @error('mname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="lname" class="text-sm mb-1">Last name *</label>
                <input class="pl-2 py-2 border-solid border-2 border-grey-500 outline-none flex-1" id ="lname" type="text" name="lname" placeholder=""  value="{{ old('lname') }}">
                 @error('lname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="issue" class="text-sm mb-1">Issue *</label>
                <input class="pl-2 py-2 border-solid border-2 border-grey-500 outline-none flex-1" id="issue" type="text" name="issue" placeholder="food packs, travel pass, etc."  value="{{ old('issue') }}">
                 @error('issue')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="w-100 flex-1 flex flex-wrap">
                <label for="purpose" class="text-sm w-full mb-1">Purpose</label>
                <textarea class="pl-2 py-2 border-solid border-2 border-grey-500 outline-none flex-1 h-auto resize-none overflow-hidden txtarea" name="purpose" rows="5" id="purpose" placeholder="Job Application, Travel from Davao to Digos, etc." value="{{ old('purpose') }}"></textarea>
                 @error('purpose')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="text-center w-25 p-2 border-solid border-2 border-red-100 bg-blue-200 text-white font-bold hover:bg-blue-500">Add New Resident</button>
        </form>
        <table class="table-auto text-left border-solid border-2 border-blue-400 w-full text-sm">
        <caption class="border-solid border-2 border-b-0 border-blue-400">
            <div class="flex items-center gap-x-2 py-2 px-3 text-md font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>  
            Purok Certifications
            </div>
        </caption>
        @if ($records)  
            <thead>
                <tr>
                    <!-- <th></th> -->  
                    <th class="w-1/4 py-2">Name</th>
                    <th class="w-1/4">Issue</th>
                    <th class="w-1/4">Purpose</th>
                    <th class="w-1/4">Issued At</th>
                </tr>
            </thead>
            <tbody> 
                    @foreach ($records as $record)
                        <tr>
                            <td>{{ ucwords($record->fname)}} {{ ucwords($record->mname)}} {{ ucwords($record->lname)}}</td>
                            <td>{{ ucwords($record->issue) }}</td>
                            <td>@isset($record->purpose) 
                                    {{ ucwords($record->purpose) }}
                                @else
                                    N/A
                                @endisset
                            </td>
                            <td>{{ $record->created_at }}</td>
                        </tr>
                    @endforeach
                @else
                    <p class="text-center ">Empty results! This table have no data to show</p>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection