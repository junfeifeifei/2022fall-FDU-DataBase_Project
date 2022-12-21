function showResult(url){
    let requestForResult = new XMLHttpRequest();
    requestForResult.onreadystatechange = function () {
        if (requestForResult.readyState == 4 && requestForResult.status == 200) {
            document.getElementById("result").innerHTML = requestForResult.responseText;
        }
    }
    requestForResult.open('get',url);
    requestForResult.send(null);
}
window.onload = function() {
    let url1 = "?type=StuOS";
    showResult(url1);
}