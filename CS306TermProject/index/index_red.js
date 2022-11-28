function rname(action) {
    let loc = document.getElementById("tbl").innerHTML;
    loc = loc.replace(loc.charAt(0),loc.charAt(0).toLowerCase());
    window.location.href= "http://localhost/CS306TermProject/CS306TermProject/"+action+"/"+action+".php?id="+loc;
}

