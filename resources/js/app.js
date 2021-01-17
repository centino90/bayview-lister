// require('./bootstrap');

const searchInp = document.getElementById('searchInp')
const txtarea = document.querySelector('.txtarea')

const fetchOnInput = async (e) => {
    const val = e.target.value;
    const searchOut = document.getElementById('searchOutput')
    searchOut.classList.add('text-sm')

    searchOut.innerHTML = 'Searching output...'
    if(val == '') {
        searchOut.innerHTML = ''
        return
    }

    const data = await fetch(`/searchOnInput?s=${val}`, {
        method: "GET"
    });
    const res = await data.json()

    searchOut.classList.remove('text-sm')
    if(searchOut) searchOut.innerHTML = '';
    let head = document.createElement('span')
    head.classList.add('text-sm', 'text-gray-400')
    head.innerHTML = 'Search Results: '
    searchOut.appendChild(head)

    res.forEach(val => {

        let pl = document.createElement('li')
        let p = document.createElement('p')
        let i = document.createElement('i')
        let hid = document.createElement('div')

        pl.classList.add('flex', 'flex-row', 'gap-x-2')
        p.classList.add('capitalize')
        p.innerHTML = `${val.FullName} ${val.created_at}`
        hid.classList.add('hidden', 'hid')
        hid.innerHTML = `   <span class="fullname">${val.FullName}</span>
                            <span class="issue">${val.issue}</span>
                            <span class="purpose">${val.purpose}</span>
                            <span class="create-date">${val.created_at}</span>`
        i.classList.add('view-more')
        i.innerHTML = '<svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>'

        pl.appendChild(p)
        pl.appendChild(i)
        pl.appendChild(hid)
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
}

const receiveVal = (e) => {
    let lastInd = sessionToArray(e.timeStamp)
    let curTime = lastInd[1]
    let prevTime = lastInd[0]
    let relTime = curTime - prevTime
    if(relTime > 100) {
        fetchOnInput(e)
    }
}

const sessionToArray = (timestamp) => {
    let arr;
    if(sessionStorage.getItem("reqTime") === null){
        arr = []
    } else {
        arr = JSON.parse(sessionStorage.getItem("reqTime"))
    }
    arr.push(timestamp)
    let sliced = arr.slice(-2)
    sessionStorage.setItem("reqTime", JSON.stringify(sliced))

    return sliced;
}



const viewMore = (e) => {
    const wrap  = document.querySelector('body')
    const pgwrp = document.querySelector('.page-wrapper')
    const modal = document.createElement('div')
    const mHead = document.createElement('header')
    const mBody = document.createElement('main')
    const mFoot = document.createElement('footer')

    const hid = e.target.nextSibling
    const fdetails = hid.querySelectorAll('.fullname, .issue, .purpose, .create-date')

    let fd = upCaseLetterOfEachWord(fdetails) //receives an array and returns an array that is uppercased

    mHead.innerHTML = ` <h1 class="flex gap-x-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Full Details
                        </h1>
                        <i class="remove-view">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </i>`               
    mBody.innerHTML = ` <div>
                            <label class="text-sm font-semibold text-gray-400">Name</label>
                            <p class="capitalize">${fd[0]}</p>
                        </div> 
                        <div>
                            <label class="text-sm font-semibold text-gray-400">Issue</label>
                            <p class="capitalize">${fd[1]}</p>
                        </div> 
                        <div>
                            <label class="text-sm font-semibold text-gray-400">Purpose</label>
                            <p class="capitalize">${fd[2]}</p>
                        </div> 
                        <div>
                            <label class="text-sm font-semibold text-gray-400">Issued At</label>
                            <p class="capitalize">${fd[3]}</p>
                        </div> `
    mFoot.innerHTML = '<h1></h1>'

    wrap.classList.add('overflow-y-hidden')
    modal.classList.add('transition', 'duration-500', 'ease-in-out', 'w-96', 'h-auto', 'flex', 'flex-col', 'fixed', 'inset-x-0', 'top-5', 'shadow-xl', 'bg-white', 'mx-auto', 'rounded-lg', 'rounded-t-none', 'z-2')
    mHead.classList.add('flex-none', 'h-8', 'bg-yellow-300', 'px-3', 'py-2', 'flex', 'justify-between', 'items-center')
    mBody.classList.add('flex-1', 'bg-gray-100', 'flex', 'flex-col', 'gap-y-2', 'px-3', 'py-4')
    mFoot.classList.add('flex-none', 'h-8', 'bg-green-300', 'px-3','py-2')
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

}

const upCaseLetterOfEachWord = (arr) => {
    let fd = []
    for (let i = 0; i < arr.length; i++) {
        if(arr[i].textContent == 'null') arr[i].textContent = 'N/A'
        let words = arr[i].textContent.split(" ");
        for (let j=0;j<words.length;j++) {
            if(words[j].length == 1) words[j] = `${words[j]}.`
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
      e.target.style.height = (e.target.scrollHeight)+'px';
    }, 0);
  }

searchInp.addEventListener('input', receiveVal)
txtarea.addEventListener('keydown', resizeTxtArea)

