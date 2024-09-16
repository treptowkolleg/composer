export default class Render {

    list(element, target, response) {
        let targetElement = document.getElementById(target);
        if (targetElement) {
            targetElement.innerHTML = "";
            for (let key in response) {
                targetElement.innerHTML += "<li class='list-group-item'>" + key + ": " + response[key] + "</li>";
            }
        }
    }

}