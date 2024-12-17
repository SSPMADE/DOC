//****ssp mod
function ToggleMenuFunction() {
    var x = document.getElementById("sspTogleNav");
    if (x.className === "navbar-collapseable") {
        x.className += " SSPresponsive";
    } else {
        x.className = "navbar-collapseable";
    }
}
//****ssp mod