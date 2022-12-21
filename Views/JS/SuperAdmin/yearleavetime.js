function showResult(url){
    let requestForResult = new XMLHttpRequest();
    requestForResult.onreadystatechange = function () {
        if (requestForResult.readyState == 4 && requestForResult.status == 200) {
            document.getElementById("leavetimeresult").innerHTML = requestForResult.responseText;
        }
    }
    requestForResult.open('get',url);
    requestForResult.send(null);
}
window.onload = function() {
    document.getElementById("search-btn").addEventListener("click",searchFunction);
}
function searchFunction(){
    let content = document.getElementById("searchInput").value;
    let url = "?type=searchleavetime&student_id="+content;
    showResult(url);
}