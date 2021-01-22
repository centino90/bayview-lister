export const upCaseLetterOfEachWord = (arr) => {
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

export const furtherConfirmDelete = (form) => {
    const conf = confirm('Are you sure')
    if (conf) form.submit()
    else return false
}

export const sessionToArray = (timestamp) => {
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