@extends('layouts.app')
@section('content')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex gap-x-3 text-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
        </svg>
        {{ $title }}
    </div>
</header>

<div class="flex justify-center items-start flex-wrap gap-x-3 gap-y-5 px-3 mt-5">
    <div class="max-w-md w-full bg-white p-6 rounded-lg transition-all">
        <div class="w-100 flex border-solid border-b-2 border-blue-200 items-center gap-x-2">
            <label for="searchInp"><svg class="w-5 h-5" fill="purple" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg></label>
            <input id="searchInp" type="search" class="flex-1 px-2 py-1 border-none" placeholder="Enter name">
        </div>
        <ul id="searchOutput" class="flex flex-col gap-y-2"></ul>
    </div>
    <div class="flex-auto bg-white p-6 rounded-lg bg-white">
        <h1 class="text-lg font-semibold flex items-center gap-x-2 mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
            </svg>
            {{$title}}
        </h1>
        @if ($message = Session::get('success'))
        <div class="text-green-600 text-sm flex gap-x-2 items-center bg-green-200 p-2 my-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{$message}}
        </div>
        @elseif ($message = Session::get('success-edit'))
        <div class="text-green-600 text-sm flex gap-x-2 items-center bg-green-200 p-2 my-2">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
            </svg>
            {{$message}}
        </div>
        @elseif ($message = Session::get('success-delete'))
        <div class="text-green-600 text-sm flex gap-x-2 items-center bg-green-200 p-2 my-2">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{$message}}
        </div>
        @elseif ($errors->any())
        <div class="text-red-500 text-sm flex flex-col bg-red-100 p-2 my-2">
            <div class="flex flex-wrap gap-x-2 items-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Your action not successfull. Please Try Again
            </div>
            <br>
            <ul class="flex flex-col">
                <b>Reminder:</b>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form id="form" action="{{route('insertRecord')}}" method="post" class='flex flex-col gap-y-5 mb-4'>
            @csrf

            <div class="text-sm">
                <i class="tracking-wide">Instruction: inputs that are labeled (*) are required.</i> <br>
                <i class="tracking-wide">After the required inputs are supplied, you can now proceed to 'Record Certification'</i>
            </div>

            <div class="flex-1 flex flex-col">
                <label for="fname" class="text-sm mb-1">First name *</label>
                <input class="capitalize pl-2 py-2 border-solid border-1 border-gray-300 outline-none flex-1" id="fname" type="text" name="fname" placeholder="" value="{{ old('fname') }}">
                @error('fname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="mname" class="text-sm mb-1">Middle name *</label>
                <input class="capitalize pl-2 py-2 border-solid border-1 border-gray-300 outline-none flex-1" id="mname" maxlength="1" type="text" name="mname" placeholder="" value="{{ old('mname') }}">
                @error('mname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="lname" class="text-sm mb-1">Last name *</label>
                <input class="capitalize pl-2 py-2 border-solid border-1 border-gray-300 outline-none flex-1" id="lname" type="text" name="lname" placeholder="" value="{{ old('lname') }}">
                @error('lname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="issue" class="text-sm mb-1">Issue *</label>
                <select name="issue" id="issue" class="px-1 py-2 border-solid border-1 border-gray-300 outline-none flex-1">
                    <option value="Food-Packs" {{ old('issue') == 'Food-Packs' ? 'selected' : '' }}>Food Packs</option>
                    <option value="Travel-Pass" {{ old('issue') == 'Travel-Pass' ? 'selected' : '' }}>Travel Pass</option>
                    <option value="Work-Pass" {{ old('issue') == 'Work-Pass' ? 'selected' : '' }}>Work Pass</option>
                    <option value="Loan" {{ old('issue') == 'Loan' ? 'selected' : '' }}>Loan</option>
                    <option value="Requirements-For-Job" {{ old('issue') == 'Requirements-For-Job' ? 'selected' : '' }}>Requirements for Job</option>
                    <option value="Health-Certificate" {{ old('issue') == 'Health-Certificate' ? 'selected' : '' }}>Health Certificate</option>
                    <option value="Lingap" {{ old('issue') == 'Lingap' ? 'selected' : '' }}>Lingap</option>
                    <option value="OSAP" {{ old('issue') == 'OSAP' ? 'selected' : '' }}>OSAP</option>
                    <option value="DWSD" {{ old('issue') == 'DWSD' ? 'selected' : '' }}>DSWD</option>
                    <option value="Lingap-OSAP-DWSD" {{ old('issue') == 'Lingap-OSAP-DWSD' ? 'selected' : '' }}>Lingap, OSAP, & DSWD</option>
                    <option value="Other" {{ old('issue') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('issue')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="category" class="text-sm mb-1">Category *</label>
                <select name="category" id="category" class="px-1 py-2 border-solid border-1 border-gray-300 outline-none flex-1">
                    <option value="Normal" {{ old('category') == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="BFAT" {{ old('category') == 'BFAT' ? 'selected' : '' }}>BFAT</option>
                    <option value="PWD" {{ old('category') == 'PWD' ? 'selected' : '' }}>PWD</option>
                    <option value="Single-Parent" {{ old('category') == 'Single-Parent' ? 'selected' : '' }}>Single Parent</option>
                    <option value="Sr-Citizen" {{ old('category') == 'Sr-Citizen' ? 'selected' : '' }}>Sr Citizen</option>
                    <option value="Womens" {{ old('category') == 'Womens' ? 'selected' : '' }}>Womens</option>
                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('category')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="w-100 flex-1 flex flex-wrap">
                <label for="purpose" class="text-sm w-full mb-1">Purpose</label>
                <textarea class="pl-2 py-2 border-solid border-1 border-gray-300 outline-none flex-1 h-auto resize-none overflow-hidden txtarea" name="purpose" rows="5" id="purpose" placeholder="Job Application, Travel from Davao to Digos, etc." value="{{ old('purpose') }}"></textarea>
                @error('purpose')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="issueDate" class="text-sm mb-1">Issue Date *</label>
                <input class="px-2 py-2 border-solid border-1 border-gray-300 outline-none flex-1 form-date flex w-60" id="issueDate" type="date" name="issueDate" placeholder="food packs, travel pass, etc." value="{{ old('issueDate') }}">
                @error('issueDate')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="session" class="text-sm mb-1">Session *</label>
                <select name="session" id="session" class="px-1 py-2 border-solid border-1 border-gray-300 outline-none flex-1">
                    <option value="AM" {{ old('session') == 'AM' ? 'selected' : '' }}>Morning (AM)</option>
                    <option value="PM" {{ old('session') == 'PM' ? 'selected' : '' }}>Afternoon (PM)</option>
                </select>
                @error('session')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="text-center w-25 p-2 border-solid border-2 border-red-100 bg-blue-300 text-white font-bold hover:bg-blue-500">Record Certification</button>


        </form>
        <table class="table-auto text-left border-solid border-2 border-blue-400 w-full text-sm bg-white certification-table">
            <caption class="caption-top border-solid border-2 border-b-0 border-blue-400 bg-gray-100">
                <div class="flex items-center gap-x-2 py-2 px-3 text-md font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Purok Certifications
                </div>
                <div class="flex justify-between py-2 px-3 flex-wrap">
                    <div class="flex items-center gap-x-2 pb-3 text-md font-semibold">
                        <input type="date" class="border-2 border-solid border-blue-400 py-1 px-1 w-40 bg-gray-50 outline-none table-date" value={{ $curdate }}>
                        <img class="table-spinner hidden w-8 h-8" src="{{asset('img/spinner.gif')}}" alt="spinner">
                    </div>
                    <div class="caption-counter flex gap-x-5 flex-wrap items-center">
                        @if($records[1][0])
                        <div class="counter p-2 text-sm bg-yellow-300 flex flex-row gap-x-2 font-semibold">
                            <h1>AM</h1>
                            <span class="rounded-full bg-white w-full h-full px-2">{{$records[1][0]->sess_am}}</span>
                        </div>
                        <div class="counter p-2 text-sm bg-blue-300 flex flex-row gap-x-2 font-semibold">
                            <h1>PM</h1>
                            <span class="rounded-full bg-white w-full h-full px-2">{{$records[1][0]->sess_pm}}</span>
                        </div>
                        <div class="counter p-2 text-sm bg-green-300 flex flex-row gap-x-2 font-semibold">
                            <h1>Total</h1>
                            <span class="rounded-full bg-white w-full h-full px-2">{{$records[1][0]->count}}</span>
                        </div>
                        @else
                        <div class="counter p-2 text-sm bg-yellow-300 flex flex-row gap-x-2 font-semibold">
                            <h1>AM</h1>
                            <span class="rounded-full bg-white w-full h-full px-2"></span>
                        </div>
                        <div class="counter p-2 text-sm bg-blue-300 flex flex-row gap-x-2 font-semibold">
                            <h1>PM</h1>
                            <span class="rounded-full bg-white w-full h-full px-2"></span>
                        </div>
                        <div class="counter p-2 text-sm bg-green-300 flex flex-row gap-x-2 font-semibold">
                            <h1>Total</h1>
                            <span class="rounded-full bg-white w-full h-full px-2"></span>
                        </div>
                        @endif
                    </div>
                </div>
            </caption>
            <caption style="caption-side:bottom" class="text-md pt-3 caption-btm">
                @if (!$records[0])
                Empty Results! There is no certification recorded today
                @endif
            </caption>
            <thead>
                <tr>
                    <!-- <th></th> -->
                    <th class="w-1/8 pl-3 py-2">Name</th>
                    <th class="w-1/8 py-2">Issue</th>
                    <th class="w-1/8 py-2">Category</th>
                    <th class="w-1/8 py-2">Purpose</th>
                    <th class="w-1/8 py-2">Issued_Date</th>
                    <th class="w-1/8 pr-3">Session</th>
                </tr>
            </thead>
            <tbody>
                @if ($records)
                @foreach ($records[0] as $record)
                <tr class="hover:bg-blue-100 border-t-2 border-solid border-blue-100">
                    <td class="hover:bg-blue-400 hover:text-white pl-3 py-3">{{ ucwords($record->FullName)}}</td>
                    <td class="hover:bg-blue-400 hover:text-white py-3">{{ ucwords($record->issue) }}</td>
                    <td class="hover:bg-blue-400 hover:text-white py-3">{{ ucwords($record->category) }}</td>
                    <td class="hover:bg-blue-400 hover:text-white py-3">@isset($record->purpose)
                        {{ ucwords($record->purpose) }}
                        @else
                        N/A
                        @endisset
                    </td>
                    <td class="hover:bg-blue-400 hover:text-white">{{ $record->issue_date }}</td>
                    <td class="hover:bg-blue-400 hover:text-white pr-3 py-3">{{ ucwords($record->session) }}</td>

                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection