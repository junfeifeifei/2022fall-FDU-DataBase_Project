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
let array = [];
function lookdailyhealth(array){
    let payBoxObj=document.getElementById('dailyhealthddd');
    payBoxObj.style.transform="translateY(-150px)";
    payBoxObj.style.opacity="1";
}

function closedailyhelth(){
    let payBoxObj=document.getElementById('dailyhealthddd');
    payBoxObj.style.transform="translateY(150px)";
    payBoxObj.style.opacity="0";
}
