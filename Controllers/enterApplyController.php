<?php
function enterApply(){
    session_start();
    //获取post表单
    $student_id = $_POST["student_id"];
    $reason = $_POST["reason"];
    $return_date = $_POST["return_date"];
    $return_date_array=explode('T',$return_date);
    $return_date_array[1]=$return_date_array[1].":00";
    $return_date_array[0]=$return_date_array[0]." ";
    $return_date=$return_date_array[0].$return_date_array[1];
    $counselor_id = $_POST["counselor_id"];
    $manager_id = $_POST["manager_id"];
    $daily_health_id_1 = $_POST["daily_health_id_1"];
    $daily_health_id_2 = $_POST["daily_health_id_2"];
    $daily_health_id_3 = $_POST["daily_health_id_3"];
    $daily_health_id_4 = $_POST["daily_health_id_4"];
    $daily_health_id_5 = $_POST["daily_health_id_5"];
    $daily_health_id_6 = $_POST["daily_health_id_6"];
    $daily_health_id_7 = $_POST["daily_health_id_7"];
    $apply_date = $_POST['apply_date'];
    //连接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $applyenter="insert into admission_application (student_id,reason,return_date,counselor_id,manager_id,daily_health_id_1,daily_health_id_2,daily_health_id_3,daily_health_id_4,daily_health_id_5,daily_health_id_6,daily_health_id_7,apply_date,counselor_approval,manager_approval) values ('$student_id','$reason','$return_date','$counselor_id','$manager_id',$daily_health_id_1,$daily_health_id_2,$daily_health_id_3,$daily_health_id_4,$daily_health_id_5,$daily_health_id_6,$daily_health_id_7,'$apply_date',0,0)";
    if(!$mysqli->query($applyenter)){
        echo"<script>alert('申请失败！请重新填报！');history.back();</script>";
    }
    else {
        echo"<script>alert('申请成功！');window.location.href='/student';</script>";
    }
    $mysqli->close();
}

function searchenterApply(){
    session_start();
    if(!isset($_GET['days'])){
        $date_limit=" ";
    }
    else {
        $days=$_GET['days'];
        if($days==NULL){
            $date_limit=" ";
        }
        else{
            date_default_timezone_set('PRC');
            $currentDate= date("Y-m-d");
            $data_start=date("Y-m-d",strtotime("-".$days." days",strtotime($currentDate)));
            $date_limit=" and apply_date >=date('".$data_start."') ";
        }
    }
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
        $sortBy = "apply_date ASC";
    }
    else if($sortBy=='2'){
        $sortBy = "return_date ASC";
    }
    //链接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $getResultNums = "select count(1) as total from admission_application where".$id_part.$st.$au.$date_limit;
    $number = $mysqli->query($getResultNums)->fetch_assoc()['total'];
    if($number==0){
        echo '<tr><td colspan="10">对不起，没有搜索到匹配的结果呢:(<br>建议您换一个搜索状态或者是学生再进行搜索</td></tr>';
    }
    require_once './Controllers/dividePageModel2.php';
    global $sqlFirst,$pageNav;
    $dataPerPage = 3;
    pageDivide($number,$dataPerPage);
    $getCurrentPageData = "select * from admission_application where ".$id_part.$st.$au.$date_limit." order by ".$sortBy." limit $sqlFirst,$dataPerPage";
    $dataThisPage = $mysqli->query($getCurrentPageData);
    while ($data = mysqli_fetch_assoc($dataThisPage)){
        $arr = array();
        $arr[0] = intval($data['daily_health_id_1']);
        $arr[1] = intval($data['daily_health_id_2']);
        $arr[2] = intval($data['daily_health_id_3']);
        $arr[3] = intval($data['daily_health_id_4']);
        $arr[4] = intval($data['daily_health_id_5']);
        $arr[5] = intval($data['daily_health_id_6']);
        $arr[6] = intval($data['daily_health_id_7']);
        echo '<tr class="trclass1">';
        $daily_health_id_array_str = json_encode($arr);
        echo '<td  border-width="1px">'.$data['student_id'].'</td>';
        echo '<td border-width="1px">'.$data['reason'].'</td>';
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
        echo '<td border-width="1px">'.$data['manager_reason'].'</td>';
        echo '<td border-width="1px">'.$data['apply_date'].'</td>';
        echo '<td border-width="1px"><button id="lookdailyhealth" onclick="lookdailyhealth('.$daily_health_id_array_str.')">点击查看</button></td>';
        if($flag==2||$flag==3){
            echo '<td><button id="manageNow" onclick="opensubmitEnter(';
            echo $data['application_id'];
            echo ')" ';
            if($flag==2&&($data['counselor_approval']==2||$data['counselor_approval']==0||$data['manager_approval']!=0)){
                echo "disabled";
            }
            if($flag==3&&$data['counselor_approval']!=0){
                echo "disabled";
            }
            echo ' >进行审批</button></td>';
        }
        else{
            echo '<td><button disabled>不能审批</button></td>';
        }
        echo '</tr>';
    }
    echo '<tr><td colspan="10">'.$pageNav.'</td></tr>';
}
function submitmanageenterApply(){
    session_start();
    $authority=$_SESSION["authority"];
    $application_id=$_POST["application_id"];
    $shenpi=$_POST["shenpi"];
    $myreason=$_POST["myreason"];
    if($authority==3){
        $updateleavestate="update admission_application set counselor_approval = ".$shenpi.", counselor_reason = '".$myreason."' where application_id=".$application_id;
    }
    if($authority==2){
        $updateleavestate="update admission_application set manager_approval = ".$shenpi.", manager_reason = '".$myreason."' where application_id=".$application_id;
    }
    //链接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $result = $mysqli->query($updateleavestate);
    $mysqli->close();
    if(!$result){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
    }
    else{
        echo"<script>alert('审批成功！');history.back()</script>";
    }
}

function findMax(){
    $depart=$_GET['depart'];
    $class=$_GET['class'];
    $number=$_GET['number'];
    if($depart!='NULL'){
        $ad=" and student.department_name='".$depart."' ";
        if($class!='NULL'&&$class!=NULL){
            $ad=$ad."and student.class_name='".$class."' ";
        }
    }
    else{
        $ad=" ";
    }
    if($number!='NULL'&&$number!=NULL){
        $limt=" limit 0,".$number." ";
    }
    else{
        $limt=" ";
    }
    $get_max="select admission_application.student_id,name,count(1) as total from admission_application inner join student where admission_application.student_id=student.student_id ".$ad." group by student_id order by total DESC".$limt;
    //链接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $maxALL = $mysqli->query($get_max);
    if(mysqli_num_rows($maxALL)!=0){
        while ($data = mysqli_fetch_assoc($maxALL)){
            echo "<tr>";
            echo '<td border-width="1px">'.$data['student_id'].'</td>';
            echo '<td border-width="1px">'.$data['name'].'</td>';
            echo '<td border-width="1px">'.$data['total'].'</td>';
            echo '</tr>';
        }
    }
    else{
        echo "<tr><td colspan='3' border-width='1px'>没有找到符合条件的结果</td></tr>";
    }
    $mysqli->close();
}
