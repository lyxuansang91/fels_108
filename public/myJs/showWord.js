function showDiv(e){
    var strdisplay = e.options[e.selectedIndex].value;
    var x = document.getElementsByClassName("category");
    for(i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById('category' + strdisplay).style.display = "table-row-group";
    document.getElementById('pagination' + strdisplay).style.display = "table-row-group";
}
