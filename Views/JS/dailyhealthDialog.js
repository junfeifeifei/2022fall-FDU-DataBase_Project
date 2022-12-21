function showxxResult(url){
    let requestForResult = new XMLHttpRequest();
    requestForResult.onreadystatechange = function () {
        if (requestForResult.readyState == 4 && requestForResult.status == 200) {
            document.getElementById("dailyhealthddd111").innerHTML = requestForResult.responseText;
        }
    }
    requestForResult.open('get',url);
    requestForResult.send(null);
}
function lookdailyhealth(array){
    let payBoxObj=document.getElementById('dailyhealthddd');
    payBoxObj.style.transform="translateY(-150px)";
    payBoxObj.style.opacity="1";
    let url1 = "?type=last7daydailyhealth&m1="+array[0]+"&m2="+array[1]+"&m3="+array[2]+"&m4="+array[3]+"&m5="+array[4]+"&m6="+array[5]+"&m6="+array[6];
    showxxResult(url1);
}

function closedailyhelth(){
    let payBoxObj=document.getElementById('dailyhealthddd');
    payBoxObj.style.transform="translateY(150px)";
    payBoxObj.style.opacity="0";
}
