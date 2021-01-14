require('./bootstrap');

const searchInp = document.getElementById('searchInp')

console.log(searchInp)

const fetchOnInput = async (val) => {
    
    const data = await fetch(`/searchOnInput?s=${val}`, {
        method: "GET"
    });
    const res = await data.json()

    const searchOut = document.getElementById('searchOutput')

    if(searchOut) searchOut.innerHTML = '';

    res.forEach(val => {
        searchOut.innerHTML += `
                                <li>${val.FullName} ${val.created_at}</li>
                                `
    }) 

   
    console.log(res)

}

const receiveVal = (e) => {
    console.log(e.target.value)
    fetchOnInput(e.target.value)
}

searchInp.addEventListener('input', receiveVal)
console.log('bot')

// const fetchUsers = async (content) => {
//     const data = await fetch('/', {
//         method: "POST", 
//         body: new URLSearchParams('content' + content)
//     });
//     const res = await data.text()
//     // tbody.innerHTML = res
//     console.log(res)
// }
