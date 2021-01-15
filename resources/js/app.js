require('./bootstrap');

const searchInp = document.getElementById('searchInp')

console.log(searchInp)

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
                                <li>${val.FullName} ${val.created_at}</li>
                                `
    }) 

    console.log(res)

}

const receiveVal = (e) => {
    // console.log(e.target.value)
    // console.log(e.key)
    // console.log(e)
    let curTime = 0;
    let reqBelowOneSec = false;
    // let arr = [];
    // arr.push(e.timeStamp)
    setSession(e.timeStamp)
    // if(curTime = 0) {

    // }
    fetchOnInput(e)
}

const setSession = (timestamp) => {
    if(sessionStorage.getItem('reqTime')) {
        sessionToArray()
    } else {
    sessionStorage.setItem("reqTime", timestamp);
    }
    console.log('set')
}

const sessionToArray = () => {
    let sess = sessionStorage.getItem("reqTime")
    let arr = []
    if(sess.length <= 0) {
        arr = []
        console.log('true')
    } else {
        arr.push(JSON.stringify(sess))
        console.log('false')
    }
    let obj = JSON.parse(arr)
    sessionStorage.setItem("reqTime", obj)
    console.log('sessToArr')
}

searchInp.addEventListener('input', receiveVal)
// console.log('bot')

// const fetchUsers = async (content) => {
//     const data = await fetch('/', {
//         method: "POST", 
//         body: new URLSearchParams('content' + content)
//     });
//     const res = await data.text()
//     // tbody.innerHTML = res
//     console.log(res)
// }
