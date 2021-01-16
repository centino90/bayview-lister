@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-8/12 bg-white p-6 rounded-lg">
    @if ($message = Session::get('success'))
        <div class="text-green-400 text-sm p-2">
            It was a success
        </div>
    @endif
        <div class="w-100 border-solid border-2 border-blue-200 flex">
            <input id="searchInp" type="text" class="flex-1" placeholder="Enter name">
        </div>
        <ul id="searchOutput" class=""></ul>
        <form id="form" action="{{route('insertRecord')}}" method="post" class='flex flex-col gap-5 mb-4 mt-3 w-100'>
            @csrf
            <div class="max-h-10 flex-1 flex flex-col">
                <input class="border-solid border-2 border-grey-500 outline-none flex-1" type="text" name="fname" placeholder="fname" value="{{ old('fname') }}">
                @error('fname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="max-h-10 flex-1 flex flex-col">
                <input class="border-solid border-2 border-grey-500 outline-none flex-1" type="text" name="mname" placeholder="mname"  value="{{ old('mname') }}">
                 @error('mname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="max-h-10 flex-1 flex flex-col">
                <input class="border-solid border-2 border-grey-500 outline-none flex-1" type="text" name="lname" placeholder="lname"  value="{{ old('lname') }}">
                 @error('lname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="max-h-10 flex-1 flex flex-col">
                <input class="border-solid border-2 border-grey-500 outline-none flex-1" type="text" name="issue" placeholder="issue"  value="{{ old('issue') }}">
                 @error('issue')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="w-100 flex-1 flex">
                <textarea class="border-solid border-2 border-grey-500 outline-none flex-1 h-auto resize-none overflow-hidden txtarea" name="purpose" rows="5" placeholder="purpose" value="{{ old('lname') }}"></textarea>
                 @error('purpose')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="text-center w-25 p-2 border-solid border-2 border-red-100 bg-blue-200 text-white font-bold hover:bg-blue-500">Add New Resident</button>
        </form>
        <table class="table-auto text-left">
            <thead>
                <tr>
                    <!-- <th></th> -->
                    <th class="w-1/4">Fname</th>
                    <th class="w-1/4">Mname</th>
                    <th class="w-1/4">Lname</th>
                    <th class="w-1/4">Recorded_at</th>
                </tr>
            </thead>
            <tbody>
                @if ($records)
                    @foreach ($records as $record)
                        <tr>
                            <td>{{ $record->fname }}</td>
                            <td>{{ $record->mname }}</td>
                            <td>{{ $record->lname }}</td>
                            <td>{{ $record->created_at }}</td>
                        </tr>
                    @endforeach
                @else
                no
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection