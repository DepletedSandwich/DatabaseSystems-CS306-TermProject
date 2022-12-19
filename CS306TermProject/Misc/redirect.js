function rname(action) {
    let loc = document.getElementById("tblname").innerHTML;
    loc = loc.replace(loc.charAt(0),loc.charAt(0).toLowerCase());
    window.location.href= "http://localhost/CS306TermProject/CS306TermProject/"+action+"/"+action+".php?id="+loc;
}
function redirectadmin(){
    window.location.href = "http://localhost/CS306TermProject/CS306TermProject/admin/admin.php";
}
function redirect_table_index(tablename){
    window.location.href = "http://localhost/CS306TermProject/CS306TermProject/index/index.php?id="+tablename;
}
function redirect_logout(){
    window.location.href = "http://localhost/CS306TermProject/welcome.php";
}
