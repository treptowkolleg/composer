import Core from "./core.js";
import Render from "../action/render.js";

export default class Http {

    xhr
    core
    render

    constructor() {
        this.xhr = new XMLHttpRequest();
        this.core = new Core();
        this.render = new Render();
    }

    request(element) {
        let url = this.core.getAttribute(element,"data-url");
        let target = this.core.getAttribute(element,"data-target");
        let func = this.core.getAttribute(element,"data-func");
        let bodyContent = this.core.getAttribute(element,"data-body");

        let body = JSON.stringify({});
        if(bodyContent) {
            body = bodyContent;
        }

        this.xhr.open("POST", url);
        this.xhr.setRequestHeader("Content-Type", "application/json; charset=UTF-8")

        this.xhr.onload = () => {
            if (this.xhr.readyState === 4 && this.xhr.status === 201) {
                console.log(JSON.parse(this.xhr.responseText));
                let response = JSON.parse(this.xhr.responseText);
                this.render[func](element,target,response);
            } else {
                console.log(`Error: ${this.xhr.status}`)
            }
        }
        this.xhr.send(body)
    }

}