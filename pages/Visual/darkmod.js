function darkmd() {
    var element = document.body;
    element.classList.toggle("dark");
    var ycon =  document.querySelector(".icn");
    ycon.classList.toggle("icn2");
}

function rediri(){
    setTimeout(function(){ window.location = '../mapping/Adminpage.html'; }, 3000);
        var ycon =  document.querySelector(".custom-loader");
        ycon.classList.toggle("custom-loader2");
    
    }