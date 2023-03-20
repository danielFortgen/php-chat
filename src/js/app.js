
/** define app class with funtions */
class App {

    /** ready function, gets triggered, when window is loaded */
    ready(){

         /** log text to JavaScript console */
        console.log('app.js is ready!'); 
        this.updateScroll();
    }

    updateScroll(){
        var element = document.getElementById("chatView");
        if(element){
            element.scrollTop = element.scrollHeight;
        }
        console.log('updateScroll', element); 
    }

    copyToClipboard(textToCopy) {
        var tempInput = document.createElement("input");
        tempInput.type = "text";
        tempInput.value = textToCopy;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert("Text has been copied to clipboard!");
      }
};

/** create the app */
const app = new App();

window.app = app;

/** wait till document ready */
window.addEventListener('load', ()=>{

    /** trigger app.ready() when window is loaded */
    app.ready();

});
