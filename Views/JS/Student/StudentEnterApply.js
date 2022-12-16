function submitTest(){
    var reason = document.getElementById("reason").value;
    var return_date = document.getElementById("return_date").value;
    if(reason==""){
        alert("请输入返校理由！");
        return false;
    }
    if(return_date==""){
        alert("请选择返校时间！");
        return false;
    }
}