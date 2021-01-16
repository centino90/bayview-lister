require('./bootstrap');

const searchInp = document.getElementById('searchInp')
const viewBtn = document.querySelectorAll('.view-more')

const fetchOnInput = async (e) => {
    const val = e.target.value;
    const searchOut = document.getElementById('searchOutput')

    if(val == '') {
        searchOut.innerHTML = ''
        return
    }

    const data = await fetch(`/searchOnInput?s=${val}`, {
        method: "GET"
    });
    const res = await data.json()


    if(searchOut) searchOut.innerHTML = '';
    res.forEach(val => {
        searchOut.innerHTML += `
                                <li class="flex flex-row gap-x-2">
                                <p>${val.FullName} ${val.created_at}</p>
                                <i class="view-more">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </i>
                                </li>
                                `
    }) 
   
    const lis = searchOut.querySelectorAll('li > p')
    lis.forEach(el => {
        let re = new RegExp(val, 'i')
        let inn = el.innerHTML.replace(re, `<span style='color: green; background-color: yellow'>${val}</span>`)
        el.innerHTML = inn
        
    })

    addEventToView()
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
    console.log('qwe')
}

const addEventToView = () => {
    viewBtn.forEach(btn => {
        btn.addEventListener('click', viewMore)
        console.log(btn)
    })
}
searchInp.addEventListener('input', receiveVal)


addEventToView()

