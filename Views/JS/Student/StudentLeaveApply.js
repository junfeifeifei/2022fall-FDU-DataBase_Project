function submitTest(){
    var reason = document.getElementById("reason").value;
    var destination = document.getElementById("destination").value;
    var return_date = document.getElementById("return_date").value;
    var departure_date = document.getElementById("departure_date").value;
    if(reason==""){
        alert("请输入离校理由！");
        return false;
    }
    if(destination==""){
        alert("请输入离校目的地！");
        return false;
    }
    if(departure_date==""){
        alert("请选择离校时间！");
        return false;
    }
    if(return_date==""){
        alert("请选择返校时间！");
        return false;
    }
}