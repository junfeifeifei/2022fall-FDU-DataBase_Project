function submitTest(){
    var health_state = document.getElementById("health_state").value;
    var record_location = document.getElementById("record_location").value;
    var temperature = document.getElementById("temperature").value;
    if(health_state==0){
        alert("请选择健康状态！");
        return false;
    }
    if(record_location==""){
        alert("请输入填报地点！");
        return false;
    }
    if(temperature==""){
        alert("请输入体温！");
        return false;
    }
}