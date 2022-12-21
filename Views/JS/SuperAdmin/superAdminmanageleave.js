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
    const url0 = window.document.location.href.toString();
    let index = url0.indexOf('?');
    let url1 = "?type=leaveapplysearch&";
    let url2 = url0.substring(index+1);
    showResult(url1+url2);
    document.getElementById("search-btn").addEventListener("click",searchFunction);
    document.getElementById("I0").addEventListener("click",I0F);
    document.getElementById("I1").addEventListener("click",I1F);
    document.getElementById("I2").addEventListener("click",I2F);
    document.getElementById("I3").addEventListener("click",I3F);
    document.getElementById("applydatafirst").addEventListener("click",applydatafirst);
    document.getElementById("leavedatafirst").addEventListener("click",leavedatafirst);
}
function searchFunction(){
    let state;
    let sortBy;
    let content = document.getElementById("searchInput").value;
    let days= document.getElementById("searchdays").value;
    if(document.getElementById("I0").checked){
        state='0';
    }
    else if(document.getElementById("I1").checked){
        state='1';
    }
    else if(document.getElementById("I2").checked){
        state='2';
    }
    else if(document.getElementById("I3").checked){
        state='3';
    }
    if(document.getElementById("applydatafirst").checked){
        sortBy='1';
    }
    else if(document.getElementById("leavedatafirst").checked){
        sortBy='2';
    }
    const url0 = window.document.location.pathname;
    let url = url0+"?state="+state+"&sortBy="+sortBy+"&student_id="+content+"&days="+days;
    window.location.href=url;
}
function applydatafirst(){
    let searchBy;
    let sortBy = '1';
    let content = document.getElementById("searchInput").value;
    if(document.getElementById("I0").checked){
        state='0';
    }
    else if(document.getElementById("I1").checked){
        state='1';
    }
    else if(document.getElementById("I2").checked){
        state='2';
    }
    else if(document.getElementById("I3").checked){
        state='3';
    }
    const url0 = window.document.location.pathname;
    let url = url0+"?state="+state+"&sortBy="+sortBy+"&student_id="+content+"&days="+days;
    window.location.href=url;
}
function leavedatafirst(){
    let searchBy;
    let sortBy = '2';
    let content = document.getElementById("searchInput").value;
    let days= document.getElementById("searchdays").value;
    if(document.getElementById("I0").checked){
        state='0';
    }
    else if(document.getElementById("I1").checked){
        state='1';
    }
    else if(document.getElementById("I2").checked){
        state='2';
    }
    else if(document.getElementById("I3").checked){
        state='3';
    }
    const url0 = window.document.location.pathname;
    let url = url0+"?state="+state+"&sortBy="+sortBy+"&student_id="+content+"&days="+days;
    window.location.href=url;
}
function I0F(){
    let sortBy;
    let state = '0';
    let content = document.getElementById("searchInput").value;
    let days= document.getElementById("searchdays").value;
    if(document.getElementById("applydatafirst").checked){
        sortBy='1';
    }
    else if(document.getElementById("leavedatafirst").checked){
        sortBy='2';
    }
    const url0 = window.document.location.pathname;
    let url = url0+"?state="+state+"&sortBy="+sortBy+"&student_id="+content+"&days="+days;
    window.location.href=url;
}
function I1F(){
    let sortBy;
    let state = '1';
    let content = document.getElementById("searchInput").value;
    let days= document.getElementById("searchdays").value;
    if(document.getElementById("applydatafirst").checked){
        sortBy='1';
    }
    else if(document.getElementById("leavedatafirst").checked){
        sortBy='2';
    }
    const url0 = window.document.location.pathname;
    let url = url0+"?state="+state+"&sortBy="+sortBy+"&student_id="+content+"&days="+days;
    window.location.href=url;
}
function I2F(){
    let sortBy;
    let state = '2';
    let content = document.getElementById("searchInput").value;
    let days= document.getElementById("searchdays").value;
    if(document.getElementById("applydatafirst").checked){
        sortBy='1';
    }
    else if(document.getElementById("leavedatafirst").checked){
        sortBy='2';
    }
    const url0 = window.document.location.pathname;
    let url = url0+"?state="+state+"&sortBy="+sortBy+"&student_id="+content+"&days="+days;
    window.location.href=url;
}
function I3F(){
    let sortBy;
    let state = '3';
    let content = document.getElementById("searchInput").value;
    let days= document.getElementById("searchdays").value;
    if(document.getElementById("applydatafirst").checked){
        sortBy='1';
    }
    else if(document.getElementById("leavedatafirst").checked){
        sortBy='2';
    }
    const url0 = window.document.location.pathname;
    let url = url0+"?state="+state+"&sortBy="+sortBy+"&student_id="+content+"&days="+days;
    window.location.href=url;
}