function showResultdepart(url){
    let requestForResult = new XMLHttpRequest();
    requestForResult.onreadystatechange = function () {
        if (requestForResult.readyState == 4 && requestForResult.status == 200) {
            document.getElementById("depart").innerHTML = requestForResult.responseText;
        }
    }
    requestForResult.open('get',url);
    requestForResult.send(null);
}
function showResultclass(url){
    let requestForResult = new XMLHttpRequest();
    requestForResult.onreadystatechange = function () {
        if (requestForResult.readyState == 4 && requestForResult.status == 200) {
            document.getElementById("class").innerHTML = requestForResult.responseText;
        }
    }
    requestForResult.open('get',url);
    requestForResult.send(null);
}
function searchSTU(url){
    let department = document.getElementById("depart").value;
    let searchnumber = document.getElementById("searchnumber").value;
    if(!searchnumber){
        alert("请选择天数！");
        return false;
    }
    let class_name = document.getElementById("class").value;
    let url22 = "?type=lastndaynoleave&target=stu&depart="+department+"&class="+class_name+"&days="+searchnumber;
    let requestForResult = new XMLHttpRequest();
    requestForResult.onreadystatechange = function () {
        if (requestForResult.readyState == 4 && requestForResult.status == 200) {
            document.getElementById("result").innerHTML = requestForResult.responseText;
        }
    }
    requestForResult.open('get',url22);
    requestForResult.send(null);
}
window.onload = function() {
    let url1 = "?type=searchapplyentermax&target=depart";
    showResultdepart(url1)
    document.getElementById("depart").addEventListener("change",getclass);
    document.getElementById("search_btn").addEventListener("click",searchSTU);
}
function getclass(){
    let department = document.getElementById("depart").value;
    if(department=='NULL'){
        document.getElementById("class").disabled = "disabled";
        document.getElementById("class").value = "NULL";
    }
    else{
        document.getElementById("class").disabled = "";
    }
    let url1 = "?type=searchapplyentermax&target=class&depart="+department;
    showResultclass(url1);
}
