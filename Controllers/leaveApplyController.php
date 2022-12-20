<?php
function leaveApply(){
    session_start();
    //获取post表单
    $student_id = $_POST["student_id"];
    $reason = $_POST["reason"];
    $destination = $_POST["destination"];

    $departure_date = $_POST["departure_date"];
    $departure_date_array=explode('T',$departure_date);
    $departure_date_array[1]=$departure_date_array[1].":00";
    $departure_date_array[0]=$departure_date_array[0]." ";
    $departure_date=$departure_date_array[0].$departure_date_array[1];


    $return_date = $_POST["return_date"];
    $return_date_array=explode('T',$return_date);
    $return_date_array[1]=$return_date_array[1].":00";
    $return_date_array[0]=$return_date_array[0]." ";
    $return_date=$return_date_array[0].$return_date_array[1];

    $counselor_id = $_POST["counselor_id"];
    $manager_id = $_POST["manager_id"];
    $apply_date = $_POST['apply_date'];
    $currentState = 1;
    //连接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $applyenter="insert into depart_application (student_id,reason,destination,departure_date,return_date,counselor_id,manager_id,apply_date,currentState) values ('$student_id','$reason','$destination','$departure_date','$return_date','$counselor_id','$manager_id','$apply_date','$currentState')";
    if(!$mysqli->query($applyenter)){
        echo"<script>alert('申请失败！请重新填报！');history.back();</script>";
    }
    else {
        echo"<script>alert('申请成功！');window.location.href='/student';</script>";
    }
    $mysqli->close();
}

function searchleaveApply(){
    session_start();
    $currentState = $_GET['state'];
    if(isset($_SESSION['teacher_id'])){
        $teacher_id=$_SESSION['teacher_id'];
        if($_SESSION['authority']==1){
            $flag=1;
            $au=" and 0=0 ";
            if($currentState==0){
                $st=" and (counselor_approval = 0 or (manager_approval = 0 and counselor_approval = 1 )) ";
            }
            if($currentState==1){
                $st=" and manager_approval = 1 ";
            }
            if($currentState==2){
                $st=" and (counselor_approval = 2 or manager_approval = 2 ) ";
            }
            if($currentState==3){
                $st=" and  0=0 ";
            }
        }
        else if($_SESSION['authority']==2){
            $flag=2;
            $au="and manager_id=".$teacher_id." ";
            if($currentState==0){
                $st=" and manager_approval = 0 ";
            }
            if($currentState==1){
                $st=" and manager_approval = 1 ";
            }
            if($currentState==2){
                $st=" and manager_approval = 2 ";
            }
            if($currentState==3){
                $st=" and  0=0  ";
            }
        }
        else if($_SESSION['authority']==3){
            $flag=3;
            $au="and counselor_id=".$teacher_id." ";
            if($currentState==0){
                $st=" and counselor_approval = 0 ";
            }
            if($currentState==1){
                $st=" and counselor_approval = 1 ";
            }
            if($currentState==2){
                $st=" and counselor_approval = 2 ";
            }
            if($currentState==3){
                $st=" and 0=0  ";
            }
        }
    }
    require './Controllers/dividePageModel.php';
    $sortBy = $_GET['sortBy'];
    $student_id = $_GET['student_id'];
    if($student_id==''){
        $id_part=" 0=0 ";
    }
    else {
        $student_id="'".$student_id."'";
        $id_part=" student_id = ".$student_id." ";
    }
    if($sortBy=='1'){
        $sortBy = "apply_date DESC";
    }
    else if($sortBy=='2'){
        $sortBy = "departure_date DESC";
    }
    //链接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $getResultNums = "select count(1) as total from depart_application where".$id_part.$st.$au;
    $number = $mysqli->query($getResultNums)->fetch_assoc()['total'];
    if($number==0){
        echo '<tr><td colspan="9">对不起，没有搜索到匹配的结果呢:(<br>建议您换一个搜索状态或者是学生再进行搜索</td></tr>';
        return false;
    }
    require_once './Controllers/dividePageModel.php';
    global $sqlFirst,$pageNav;
    $dataPerPage = 3;
    pageDivide($number,$dataPerPage);
    $getCurrentPageData = "select * from depart_application where ".$id_part.$st.$au." order by ".$sortBy." limit $sqlFirst,$dataPerPage";
    $dataThisPage = $mysqli->query($getCurrentPageData);
    while ($data = mysqli_fetch_assoc($dataThisPage)){
        echo '<tr class="trclass1">';
        echo '<td  border-width="1px">'.$data['student_id'].'</td>';
        echo '<td border-width="1px">'.$data['reason'].'</td>';
        echo '<td border-width="1px">'.$data['departure_date'].'</td>';
        echo '<td border-width="1px">'.$data['return_date'].'</td>';
        if($data['counselor_approval']==0){$temp = "尚未审批";}
        if($data['counselor_approval']==1){$temp = "已同意";}
        if($data['counselor_approval']==2){$temp = "已拒绝";}
        echo '<td border-width="1px">'.$temp.'</td>';
        echo '<td border-width="1px">'.$data['counselor_reason'].'</td>';
        if($data['manager_approval']==0){$temp = "尚未审批";}
        if($data['manager_approval']==1){$temp = "已同意";}
        if($data['manager_approval']==2){$temp = "已拒绝";}
        echo '<td border-width="1px">'.$temp.'</td>';
        echo '<td border-width="1px">'.$data['counselor_reason'].'</td>';
        echo '<td border-width="1px">'.$data['apply_date'].'</td>';
        if($flag==2||$flag==3){
            echo '<td><button id="manageNow" ';
            if($flag==2&&($data['counselor_approval']==2||$data['counselor_approval']==0)){
                echo "disabled";
            }
            echo ' >进行审批</button></td>';
        }
        else{
            echo '<td><button disabled>无权审批</button></td>';
        }
        echo '</tr>';
    }
    echo '<tr><td colspan="10">'.$pageNav.'</td></tr>';
}



