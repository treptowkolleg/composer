


const xhr = new XMLHttpRequest();

let charBtn = document.querySelector('#char-btn');


if(charBtn) {
    charBtn.addEventListener("click", getChars);
}

function getChars() {
    let url = charBtn.attributes.getNamedItem("data-url").value;
    let target = charBtn.attributes.getNamedItem("data-target").value;
    xhr.open("POST", url);
    xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8");
    const body = JSON.stringify({
        userId: 1,
        title: "Fix my bugs",
        completed: false
    });
    xhr.onload = () => {
        if (xhr.readyState === 4 && xhr.status === 201) {
            console.log(JSON.parse(xhr.responseText));
            let response = JSON.parse(xhr.responseText);
            let chars = document.querySelector(target);
            if (chars) {
                chars.innerHTML = "";
                for (let key in response) {
                    chars.innerHTML += "<li class='list-group-item'>" + key + ": " + response[key] + "</li>";
                }
            }
        } else {
            console.log(`Error: ${xhr.status}`);
        }
    };
    xhr.send(body);
}


