import Core from "./core/core.js";
import Http from "./core/http.js";



const core = new Core();
const http = new Http();

let ajaxElements = core.findBy(".ajax");
ajaxElements.forEach(element => {
    element.addEventListener("click", function() { http.request(element) } );
})



