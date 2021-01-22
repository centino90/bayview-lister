// require('./bootstrap');
require('alpinejs');

const searchInp = document.getElementById('searchInp')
const txtarea = document.querySelector('.txtarea')
const tbldate = document.querySelector('.table-date')

const fetchOnDateChange = async (e) => {
    const spinner = document.querySelector('.table-spinner')
    spinner.classList.remove('hidden')
    const val = e.target.value;
    console.log(val)
    const data = await fetch(`/tableSearchByDate?d=${val}`, {
        method: "GET"
    });
    const res = await data.json()

    spinner.classList.add('hidden')
    const table = document.querySelector('.certification-table')
    const ctbody = document.createElement('tbody')
    table.appendChild(ctbody)
    const tbody = table.querySelector('tbody')
    const caption = table.querySelector('.caption-btm')
    const captTop = table.querySelector('.caption-top')
    const cc = captTop.querySelectorAll('.counter span')
    console.log(res)
    if (res[0].length < 1) {
        caption.textContent = 'Empty Results! There is no certification recorded on this day'
        tbody.innerHTML = ''
        cc[0].textContent = res[1][0].sess_am
        cc[1].textContent = res[1][0].sess_pm
        cc[2].textContent = res[1][0].count

    } else {
        caption.textContent = ''
        tbody.innerHTML = ''
        cc[0].textContent = res[1][0].sess_am
        cc[1].textContent = res[1][0].sess_pm
        cc[2].textContent = res[1][0].count

        res[0].forEach(re => {
            tbody.innerHTML += `
                                <tr class="hover:bg-blue-100 border-t-2 border-solid border-blue-100">
                                    <td class="hover:bg-blue-400 hover:text-white pl-3 py-3 capitalize">${re.FullName}</td> 
                                    <td class="py-3 hover:bg-blue-400 hover:text-white capitalize">${re.issue}</td> 
                                    <td class="py-3 hover:bg-blue-400 hover:text-white capitalize">${re.category}</td>
                                    <td class="py-3 hover:bg-blue-400 hover:text-white capitalize">${re.purpose}</td> 
                                    <td class="py-3 hover:bg-blue-400 hover:text-white capitalize">${re.issue_date}</td> 
                                    <td class="py-3 hover:bg-blue-400 hover:text-white capitalize pr-3">${re.session}</td>
                                </tr>
                            `
        })
    }
}

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
        let idel = document.createElement('div')
        let hid = document.createElement('div')

        pl.classList.add('flex', 'flex-row', 'gap-x-2')
        p.classList.add('capitalize')
        p.innerHTML = `${val.FullName} ${val.issue_date}`
        hid.classList.add('hidden', 'hid')
        hid.innerHTML = `   <span class="id">${val.id}</span>
                        <span class="fullname">${val.FullName}</span>
                        <span class="fname">${val.fname}</span>
                        <span class="mname">${val.mname}</span>
                        <span class="lname">${val.lname}</span>
                        <span class="issue">${val.issue}</span>
                        <span class="category">${val.category}</span>
                        <span class="purpose">${val.purpose}</span>
                        <span class="issue_date">${val.issue_date}</span>
                        <span class="session">${val.session}</span>
                        `
        i.classList.add('view-more', 'hover:opacity-50', 'cursor-pointer')
        idel.classList.add('delete-more')
        i.innerHTML = '<svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>'
        const csrf = document.querySelector('meta[name="csrf-token"]')
        const token = csrf.getAttribute('content')
        idel.innerHTML = `
                                <form action="/deleteRecord" method="POST">
                                <input type="hidden" name="_token" value="${token}">
                                <input type"text" name="id" hidden readonly value=${val.id}>
                                <button type="button" value="Submit Delete" class="hover:opacity-50">
                                    <svg class="w-5 h-5 pointer-events-none" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                </button>
                                </form>
                            `
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

    const delBtn = document.querySelectorAll('.delete-more button')
    delBtn.forEach(btn => {
        btn.addEventListener('click', promptPassword)
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

const promptPassword = async (e) => {
    const prompt = window.prompt('Enter your confirmation password', '')
    const uid = document.querySelector('meta[name="user-id"]').getAttribute('content')

    if (prompt != null) {
        if (prompt == '') {
            alert('Input is Empty. Please try again')
            return
        }
        const passwordSearch = await fetch(`/confirmPassword?pwd=${prompt}&uid=${uid}`, {
            method: "GET"
        })
        const res = await passwordSearch.json()

        if (res.length >= 1) {
            furtherConfirmDelete(e.target.parentNode)
        } else {
            alert('Password did not match')
        }
    }
}

const viewMore = (e) => {
    const wrap = document.querySelector('body')
    const pgwrp = document.querySelector('.page-wrapper')
    const modal = document.createElement('div')
    const mHead = document.createElement('header')
    const mBody = document.createElement('main')
    const mFoot = document.createElement('footer')

    const hid = e.target.nextSibling
    console.log(hid.querySelector('.mname').textContent)

    const fdetails = hid.querySelectorAll('.id, .fullname, .fname, .mname, .lname, .issue, .category, .purpose, .issue_date, .session')
    let xmname = ''
    if (hid.querySelector('.mname').textContent != 'null' && hid.querySelector('.mname').textContent != '') {
        xmname = `${hid.querySelector('.mname').textContent}.`
    }

    let fd = upCaseLetterOfEachWord(fdetails) //receives an array and returns an array that is uppercased
    const csrf = document.querySelector('meta[name="csrf-token"]')
    const token = csrf.getAttribute('content')

    mHead.innerHTML = ` <h1 class="flex gap-x-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Full Details
                    </h1>
                    <i class="remove-view cursor-pointer hover:bg-yellow-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </i>`
    mBody.innerHTML = ` <form class="modal-form flex flex-col gap-y-2" action="/updateRecord" method="POST">
                    <input type="hidden" name="_token" value="${token}">
                    <input type="text" maxlength="100" name="id" class="hidden id p-2 border-solid border-2 outline-none pointer-events-none" readonly hidden value="${fd[0]}">
                    <div class="w-1/2 ml-auto">
                        <i class="edit-modal py-1 px-2 flex flex-row justify-center items-center gap-x-2 bg-white hover:bg-yellow-300 cursor-pointer">
                        <svg class="w-6 h-6 pointer-events-none" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                        <p class="pointer-events-none">Edit this record</p>
                        </i>
                    </div> 
                    <div class="modal-p-inputs cursor-not-allowed">
                        <div class="flex flex-col">
                        <label class="modal-label text-sm font-semibold text-gray-400">Name</label>
                        <input type="text" maxlength="50" name="fname" class="fname capitalize w-full p-2 mb-2 border-solid border-1 outline-none pointer-events-none" readonly value="${fd[2]} ${xmname} ${fd[4]}">
                        <label class="modal-label hidden text-sm font-semibold text-gray-400">Middle Initial</label>
                        <input type="text" maxlength="1" name="mname" class="mname capitalize w-full p-2  mb-2 border-solid border-1 outline-none pointer-events-none" readonly hidden value="${fd[3]}">
                        <label class="modal-label hidden text-sm font-semibold text-gray-400">Last Name</label>
                        <input type="text" maxlength="50" name="lname" class="lname capitalize w-full p-2 border-solid border-1 outline-none pointer-events-none" readonly hidden value="${fd[4]}">
                        </div>
                    </div> 
                    <div class="modal-p-inputs cursor-not-allowed">
                        <label class="text-sm font-semibold text-gray-400">Issue</label>
                        <select readonly name="issue" id="issue" class="modal-issue capitalize w-full p-2 border-solid border-1 outline-none pointer-events-none">
                            <option value="Food-Packs">Food Packs</option>
                            <option value="Travel-Pass">Travel Pass</option>
                            <option value="Work-Pass">Work Pass</option>
                            <option value="Loan">Loan</option>
                            <option value="Requirements-For-Job">Requirements for Job</option>
                            <option value="Health-Certificate">Health Certificate</option>
                            <option value="Lingap">Lingap</option>
                            <option value="OSAP">OSAP</option>
                            <option value="DWSD">DSWD</option>
                            <option value="Lingap-OSAP-DWSD">Lingap, OSAP, & DSWD</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="modal-p-inputs cursor-not-allowed">
                        <label class="text-sm font-semibold text-gray-400">Category</label>
                        <select name="category" readonly class="modal-category capitalize w-full p-2 border-solid border-1 outline-none pointer-events-none">
                        <option value="Normal">Normal</option>
                        <option value="BFAT">BFAT</option>
                        <option value="PWD">PWD</option>
                        <option value="Single-Parent">Single Parent</option>
                        <option value="Sr-Citizen">Sr Citizen</option>
                        <option value="Womens">Womens</option>
                        <option value="For-Listing">For Listing</option>
                        <option value="Other">Other</option>
                        </select>
                    </div>  
                    <div class="flex flex-wrap modal-p-inputs cursor-not-allowed">
                        <label class="text-sm font-semibold text-gray-400 w-full">Purpose</label>
                        <textarea class="p-2 border-solid border-1 border-grey-500 outline-none flex-1 w-full h-auto resize-none overflow-hidden pointer-events-none txtarea" name="purpose" rows="5" id="purpose" readonly>${fd[7]}</textarea>
                    </div> 
                    <div class="modal-p-inputs cursor-not-allowed">
                        <label class="text-sm font-semibold text-gray-400">Issued On</label>
                        <input type="date" name="issue_date" class="capitalize w-full p-2 border-solid border-1 outline-none pointer-events-none" readonly value="${fd[8]}">
                    </div> 
                    <div class="modal-p-inputs cursor-not-allowed">
                        <label class="text-sm font-semibold text-gray-400">Session</label>
                        <select name="session" readonly class="modal-session capitalize w-full p-2 border-solid border-1 outline-none pointer-events-none">
                        <option value="AM">Morning (AM)</option>
                        <option value="PM">Afternoon (PM)</option>
                        </select>
                    </div>  
                    <div class="submit hidden">
                        <input type="submit" class="capitalize w-full p-2 bg-yellow-200 font-semibold text-white outline-none pointer-events-none cursor-pointer hover:bg-yellow-400" readonly value="Commit changes">
                    </div>
                    </form>
                    `
    mFoot.innerHTML = '<h1></h1>'

    wrap.classList.add('overflow-y-hidden')
    modal.classList.add('modal', 'transition', 'duration-500', 'ease-in-out', 'w-96', 'h-auto', 'flex', 'flex-col', 'fixed', 'inset-x-0', 'top-5', 'shadow-2xl', 'bg-white', 'mx-auto', 'rounded-lg', 'rounded-t-none', 'z-2', 'overflow-y-scroll', 'max-h-screen')
    mHead.classList.add('flex-none', 'h-8', 'bg-yellow-300', 'px-3', 'py-5', 'flex', 'justify-between', 'items-center')
    mBody.classList.add('flex-1', 'bg-gray-100', 'flex', 'flex-col', 'gap-y-2', 'px-3', 'py-4')
    mFoot.classList.add('flex-none', 'h-8', 'bg-green-300', 'px-3', 'py-2')
    pgwrp.classList.add('opacity-50', 'z-1', 'pointer-events-none')

    modal.appendChild(mHead)
    modal.appendChild(mBody)
    modal.appendChild(mFoot)
    wrap.appendChild(modal)

    console.log(fd[5])
    console.log(fd[6])
    console.log(fd[9])
    mBody.querySelector(`.modal-issue option[value=${fd[5]}]`).selected = true //select category option based on db data
    mBody.querySelector(`.modal-category option[value=${fd[6]}]`).selected = true //select category option based on db data
    mBody.querySelector(`.modal-session option[value=${fd[9]}]`).selected = true //select category option based on db data

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
        const inputs = mBody.querySelectorAll('div input, div textarea, div select')
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
        const labels = mBody.querySelectorAll('.modal-label')
        const inputP = mBody.querySelectorAll('.modal-p-inputs')
        inputs.forEach(inp => {
            if (inp.classList.contains('lname') && inp.hasAttribute('hidden')) {
                inp.removeAttribute('hidden')
                const mname = mBody.querySelector('.mname')
                const lname = mBody.querySelector('.lname')
                const fname = mBody.querySelector('.fname')
                const wrds = fname.value.split(" ")
                let count = 0;
                let lastind;
                for (let i = 0; i < wrds.length; i++) {
                    if (wrds[i].length == 2 && wrds[i].includes('.') || wrds[i].length == 0 && wrds[i] == '') {
                        // mname.value = wrds[i].slice(0, 1)
                        console.log(wrds[i].length)
                        lastind = i
                    } else if (lastind === undefined) {
                        if (count == 0) fname.value = ''
                        fname.value += `${wrds[i]} `
                        count++
                    } else if (lastind !== undefined && wrds[i] != lastind) {
                        // lname.value += `${wrds[i]} `
                    }
                }

            } else {
                inp.removeAttribute('hidden')
            }

            if (inp.hasAttribute('readonly')) {
                inp.removeAttribute('readonly')
                labels.forEach(el => {
                    if (el.textContent == 'Name') {
                        el.textContent = 'First Name'
                        return
                    }
                    el.classList.remove('hidden')
                })
            } else {
                inp.setAttribute('readonly', '')
            }
            inp.classList.toggle('pointer-events-none')
            inp.classList.toggle('border-blue-500')
            inp.classList.toggle('focus:ring')
            inputP.forEach(el => el.classList.toggle('cursor-not-allowed'))
        })
    })

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
const unfocusSearchDiv = e => {
    e.stopPropagation()
    const parentDiv = e.target.parentNode.parentNode
    parentDiv.classList.remove('border-2')
    parentDiv.classList.remove('border-solid')
    parentDiv.classList.remove('border-blue-500')
    parentDiv.classList.remove('shadow-xl')
}


//pure functions
const upCaseLetterOfEachWord = (arr) => {
    let fd = []
    for (let i = 0; i < arr.length; i++) {
        if (arr[i].textContent == 'null' && !arr[i].classList.contains('mname')) arr[i].textContent = 'N/A'
        else if (arr[i].textContent == 'null' && arr[i].classList.contains('mname')) arr[i].textContent = ''
        let words = arr[i].textContent.split(" ");
        // for (let j = 0; j < words.length; j++) {
        //     // if (words[j].length == 1) words[j] = `${words[j]}`
        //     words[j] = words[j][0].toUpperCase() + words[j].substr(1);
        // }
        words = words.join(" ");
        fd.push(words)
    }

    return fd
}

const furtherConfirmDelete = (form) => {
    const conf = confirm('Are you sure')
    if (conf) form.submit()
    else return false
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

//event listeners
searchInp.addEventListener('input', receiveVal)
searchInp.addEventListener('focus', focusSearchDiv, true)
searchInp.addEventListener('blur', unfocusSearchDiv, true)
txtarea.addEventListener('keydown', resizeTxtArea)
tbldate.addEventListener('change', fetchOnDateChange)