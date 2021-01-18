@extends('layouts.app')
@section('content')
<div class="flex justify-center items-start flex-wrap gap-x-3 gap-y-5 px-3">
    <div class="max-w-md w-full bg-white p-6 rounded-lg transition-all">
        <div class="w-100 flex border-solid border-b-2 border-blue-200 items-center gap-x-2">
            <label for="searchInp"><svg class="w-5 h-5" fill="purple" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg></label>
            <input id="searchInp" type="search" class="flex-1 px-2 py-1 focus:outline-none" placeholder="Enter name">
        </div>
        <ul id="searchOutput" class="flex flex-col gap-y-2"></ul>
    </div>
    <div class="flex-auto bg-white p-6 rounded-lg">
        <h1 class="text-lg font-semibold flex items-center gap-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
            </svg>
            {{$title}}
        </h1>
        @if ($message = Session::get('success'))
        <div class="text-green-500 text-sm flex gap-x-2 items-center bg-green-100 p-2 my-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{$message}}
        </div>
        @elseif ($message = Session::get('success-edit'))
        <div class="text-green-500 text-sm flex gap-x-2 items-center bg-green-100 p-2 my-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{$message}}
        </div>
        @elseif ($errors->any())
        <div class="text-red-400 text-sm flex flex-col bg-red-50 p-2 my-2">
            <div class="flex gap-x-2 items-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            Certification was not Recorded due to <b>Invalid Inputs!</b> Please Try Again
            </div>
            <br>
            <ul class="flex flex-col">
                <b>Reminder:</b>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
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
                <i class="tracking-wide">After the required inputs are supplied, you can now proceed to 'Record Certification'</i>
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
                <input class="pl-2 py-2 border-solid border-2 border-grey-500 outline-none flex-1" id="mname" maxlength="1" type="text" name="mname" placeholder="" value="{{ old('mname') }}">
                @error('mname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="lname" class="text-sm mb-1">Last name *</label>
                <input class="pl-2 py-2 border-solid border-2 border-grey-500 outline-none flex-1" id="lname" type="text" name="lname" placeholder="" value="{{ old('lname') }}">
                @error('lname')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex-1 flex flex-col">
                <label for="issue" class="text-sm mb-1">Issue *</label>
                <input class="pl-2 py-2 border-solid border-2 border-grey-500 outline-none flex-1" id="issue" type="text" name="issue" placeholder="food packs, travel pass, etc." value="{{ old('issue') }}">
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
            <div class="flex-1 flex flex-col">
                <label for="issueDate" class="text-sm mb-1">Issue Date *</label>
                <input class="px-2 py-2 border-solid border-2 border-grey-500 outline-none flex-1" id="issueDate" type="date" name="issueDate" placeholder="food packs, travel pass, etc." value="{{ old('issueDate') }}">
                @error('issueDate')
                <div class="text-red-500 mt-1 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" class="text-center w-25 p-2 border-solid border-2 border-red-100 bg-blue-300 text-white font-bold hover:bg-blue-500">Record Certification</button>
        </form>
        <table class="table-auto text-left border-solid border-2 border-blue-400 w-full text-sm">
            <caption class="border-solid border-2 border-b-0 border-blue-400">
                <div class="flex items-center gap-x-2 py-2 px-3 text-md font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
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
                    <th class="w-1/4">Issued On</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>{{ ucwords($record->FullName)}}</td>
                    <td>{{ ucwords($record->issue) }}</td>
                    <td>@isset($record->purpose)
                        {{ ucwords($record->purpose) }}
                        @else
                        N/A
                        @endisset
                    </td>
                    <td>{{ $record->issue_date }}</td>
                </tr>
                @endforeach
                @else
                <p class="text-center ">Empty results! This table have no data to show</p>
                @endif
            </tbody>
        </table>
    </div>
</div>
<script>
    const searchInp = document.getElementById('searchInp')
    const txtarea = document.querySelector('.txtarea')

    const fetchOnInput = async (e) => {
        const val = e.target.value;
        const searchOut = document.getElementById('searchOutput')
        searchOut.classList.add('text-sm', 'pt-2')

        searchOut.innerHTML = 'Searching output...'
        if (val == '') {
            searchOut.innerHTML = ''
            return
        }

        const data = await fetch(`/searchOnInput?s=${val}`, {
            method: "GET"
        });
        const res = await data.json()

        searchOut.classList.remove('text-sm', 'pt-2')
        if (searchOut) searchOut.innerHTML = '';
        let head = document.createElement('span')
        head.classList.add('text-sm', 'text-gray-400', 'pt-2')
        head.innerHTML = 'Search Results: '
        searchOut.appendChild(head)

        res.forEach(val => {

            let pl = document.createElement('li')
            let p = document.createElement('p')
            let i = document.createElement('i')
            let idel = document.createElement('i')
            let hid = document.createElement('div')

            pl.classList.add('flex', 'flex-row', 'gap-x-2')
            p.classList.add('capitalize')
            p.innerHTML = `${val.FullName} ${val.issue_date}`
            hid.classList.add('hidden', 'hid')
            hid.innerHTML = `   <span class="id">${val.id}</span>
                            <span class="fullname">${val.FullName}</span>
                            <span class="issue">${val.issue}</span>
                            <span class="purpose">${val.purpose}</span>
                            <span class="issue_date">${val.issue_date}</span>`
            i.classList.add('view-more')
            idel.classList.add('delete-more')
            i.innerHTML = '<svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>'
            idel.innerHTML = ' <svg class="w-5 h-5 pointer-events-none" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>'

            pl.appendChild(p)
            pl.appendChild(i)
            pl.appendChild(hid)
            pl.appendChild(idel)
            searchOut.appendChild(pl)
        })

        const lis = searchOut.querySelectorAll('li > p')
        lis.forEach(el => {
            let re = new RegExp(val, 'i')
            let inn = el.innerHTML.replace(re, `<span class="text-green-400" style="background-color: yellow">${val}</span>`)
            el.innerHTML = inn

        })

        const viewBtn = document.querySelectorAll('.view-more')
        viewBtn.forEach(btn => {
            btn.addEventListener('click', viewMore)
        })

        const delBtn = document.querySelectorAll('.delete-more')
        delBtn.forEach(btn => {
            btn.addEventListener('click', deleteMore)
        })
    }

    const receiveVal = (e) => {
        let lastInd = sessionToArray(e.timeStamp)
        let curTime = lastInd[1]
        let prevTime = lastInd[0]
        let relTime = curTime - prevTime
        if (relTime > 100) {
            fetchOnInput(e)
        }
    }

    const sessionToArray = (timestamp) => {
        let arr;
        if (sessionStorage.getItem("reqTime") === null) {
            arr = []
        } else {
            arr = JSON.parse(sessionStorage.getItem("reqTime"))
        }
        arr.push(timestamp)
        let sliced = arr.slice(-2)
        sessionStorage.setItem("reqTime", JSON.stringify(sliced))

        return sliced;
    }

    const deleteMore = () => {
        console.log('delete')
    }

    const viewMore = (e) => {
        const wrap = document.querySelector('body')
        const pgwrp = document.querySelector('.page-wrapper')
        const modal = document.createElement('div')
        const mHead = document.createElement('header')
        const mBody = document.createElement('main')
        const mFoot = document.createElement('footer')

        const hid = e.target.nextSibling
        const fdetails = hid.querySelectorAll('.id, .fullname, .issue, .purpose, .issue_date')

        let fd = upCaseLetterOfEachWord(fdetails) //receives an array and returns an array that is uppercased

        mHead.innerHTML = ` <h1 class="flex gap-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Full Details
                        </h1>
                        <i class="remove-view">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </i>`
        mBody.innerHTML = ` <form class="modal-form flex flex-col gap-y-2" action="/updateRecord" method="POST">
                        @csrf
                        <input type="text" maxlength="100" name="id" class="hidden id p-2 border-solid border-2 outline-none pointer-events-none" readonly hidden value="${fd[0]}">
                        <div class="w-1/2 ml-auto">
                            <i class="edit-modal py-1 px-2 flex flex-row justify-center items-center gap-x-2 bg-white hover:bg-yellow-300 cursor-pointer">
                            <svg class="w-6 h-6 pointer-events-none" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                            <p class="pointer-events-none">Edit this record</p>
                            </i>
                        </div> 
                        <div>
                            <label class="text-sm font-semibold text-gray-400">Name</label>
                            <div class="flex flex-col gap-y-2">
                            <input type="text" maxlength="50" name="fname" class="fname capitalize w-full p-2 border-solid border-2 outline-none pointer-events-none" readonly value="${fd[1]}">
                            <input type="text" maxlength="1" name="mname" class="mname capitalize w-full p-2 border-solid border-2 outline-none pointer-events-none" readonly hidden>
                            <input type="text" maxlength="50" name="lname" class="lname capitalize w-full p-2 border-solid border-2 outline-none pointer-events-none" readonly hidden>
                            </div>
                        </div> 
                        <div>
                            <label class="text-sm font-semibold text-gray-400">Issue</label>
                            <input type="text" name="issue" class="capitalize w-full p-2 border-solid border-2 outline-none pointer-events-none" readonly value="${fd[2]}">
                        </div> 
                        <div class="flex flex-wrap">
                            <label class="text-sm font-semibold text-gray-400 w-full" for="purpose">Purpose</label>
                            <textarea class="p-2 border-solid border-2 border-grey-500 outline-none flex-1 w-full h-auto resize-none overflow-hidden pointer-events-none txtarea" name="purpose" rows="5" id="purpose" readonly>${fd[3]}</textarea>
                        </div> 
                        <div>
                            <label class="text-sm font-semibold text-gray-400">Issued On</label>
                            <input type="date" name="issue_date" class="capitalize w-full p-2 border-solid border-2 outline-none pointer-events-none" readonly value="${fd[4]}">
                        </div> 
                        <div class="submit hidden">
                            <input type="submit" class="capitalize w-full p-2 bg-yellow-200 font-semibold text-white outline-none pointer-events-none cursor-pointer hover:bg-yellow-400" readonly value="Commit changes">
                        </div>
                        </form>
                        `
        mFoot.innerHTML = '<h1></h1>'

        wrap.classList.add('overflow-y-hidden')
        modal.classList.add('modal', 'transition', 'duration-500', 'ease-in-out', 'w-96', 'h-auto', 'flex', 'flex-col', 'fixed', 'inset-x-0', 'top-5', 'shadow-2xl', 'bg-white', 'mx-auto', 'rounded-lg', 'rounded-t-none', 'z-2', 'overflow-y-scroll', 'max-h-screen')
        mHead.classList.add('flex-none', 'h-8', 'bg-yellow-300', 'px-3', 'py-2', 'flex', 'justify-between', 'items-center')
        mBody.classList.add('flex-1', 'bg-gray-100', 'flex', 'flex-col', 'gap-y-2', 'px-3', 'py-4')
        mFoot.classList.add('flex-none', 'h-8', 'bg-green-300', 'px-3', 'py-2')
        pgwrp.classList.add('opacity-50', 'z-1', 'pointer-events-none')

        modal.appendChild(mHead)
        modal.appendChild(mBody)
        modal.appendChild(mFoot)
        wrap.appendChild(modal)

        const revViewBtn = document.querySelector('.remove-view')
        revViewBtn.addEventListener('click', () => {
            modal.remove()
            wrap.classList.remove('overflow-y-hidden')
            pgwrp.classList.remove('pointer-events-none', 'opacity-50', 'z-1')
        })

        const editBtn = document.querySelector('.edit-modal')
        editBtn.addEventListener('click', (e) => {
            const modalForm = document.querySelector('.modal-form')
            const submitBtn = document.querySelector('.submit')
            const inputs = mBody.querySelectorAll('div input, div textarea')
            const txtarea = document.querySelector('.modal-form .txtarea')

            submitBtn.classList.toggle('hidden')
            if (txtarea.textContent.includes('N/A')) txtarea.textContent = ''
            if (e.target.textContent.includes('Edit this record')) {
                e.target.innerHTML = `
                                <svg class="w-6 h-6 pointer-events-none" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                <p class="pointer-events-none">Cancel Edit</p>
                                `
            } else {
                e.target.innerHTML = ''
                e.target.innerHTML = `
                                <svg class="w-6 h-6 pointer-events-none" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                <p class="pointer-events-none">Edit this record</p>
                                `
            }
            inputs.forEach(inp => {
                if (inp.classList.contains('mname') && inp.hasAttribute('hidden')) {
                    inp.removeAttribute('hidden')
                    const mname = mBody.querySelector('.mname')
                    const lname = mBody.querySelector('.lname')
                    const fname = mBody.querySelector('.fname')
                    const wrds = fname.value.split(" ")
                    let count = 0;
                    let lastind;
                    for (let i = 0; i < wrds.length; i++) {
                        if (wrds[i].length = 2 && wrds[i].includes('.')) {
                            mname.value = wrds[i].slice(0, 1)
                            lastind = i
                        }
                        else if (lastind === undefined) {
                            if(count == 0) fname.value = ''
                            fname.value += `${wrds[i]} `
                            count++
                        } 
                        else if(lastind !== undefined && wrds[i] != lastind) {
                            lname.value += `${wrds[i]} `
                        }
                    }

                } else {
                    inp.removeAttribute('hidden')
                }

                if (inp.hasAttribute('readonly')) {
                    inp.removeAttribute('readonly')
                } else {
                    inp.setAttribute('readonly', '')
                }
                inp.classList.toggle('pointer-events-none')
                inp.classList.toggle('border-blue-500')
                inp.classList.toggle('focus:ring')
            })
        })

    }

    const upCaseLetterOfEachWord = (arr) => {
        let fd = []
        for (let i = 0; i < arr.length; i++) {
            if (arr[i].textContent == 'null') arr[i].textContent = 'N/A'
            let words = arr[i].textContent.split(" ");
            for (let j = 0; j < words.length; j++) {
                if (words[j].length == 1) words[j] = `${words[j]}.`
                words[j] = words[j][0].toUpperCase() + words[j].substr(1);
            }
            words = words.join(" ");
            fd.push(words)
        }

        return fd
    }

    const resizeTxtArea = (e) => {
        setTimeout(() => {
            e.target.style.height = 'auto';
            e.target.style.height = (e.target.scrollHeight) + 'px';
        }, 0);
    }

    const focusSearchDiv = (e) => {
        e.stopPropagation()
        const parentDiv = e.target.parentNode.parentNode
        parentDiv.classList.add('border-2')
        parentDiv.classList.add('border-solid')
        parentDiv.classList.add('border-blue-500')
        parentDiv.classList.add('shadow-xl')
    }

    searchInp.addEventListener('input', receiveVal)
    // searchInp.addEventListener('focus', focusSearchDiv, true)
    searchInp.addEventListener('blur', focusSearchDiv)
    txtarea.addEventListener('keydown', resizeTxtArea)
</script>
@endsection