
function opensubmitLeave(id){
    let payBoxObj=document.getElementById('payBox');
    let application_idObj=document.getElementById('application_id');
    application_idObj.value=id;
    payBoxObj.style.transform="translateY(-200px)";
    payBoxObj.style.opacity="1";
}

function closesubmitLeave(){
    let payBoxObj=document.getElementById('payBox');
    payBoxObj.style.transform="translateY(200px)";
    payBoxObj.style.opacity="0";
}

function leaveTest(){
    if(document.getElementById("agree").checked){
        result='1';
    }
    else if(document.getElementById("disagree").checked){
        result='2';
    }
    else {
        alert("请完善选择同意与否！");
        return false;
    }
    let myreason = document.getElementById("myreason").value;
    if (myreason==" "||myreason==""||myreason==NULL){
        alert("请写理由！");
        return false;
    }
    return true;
}