<?php
function pageDivideStu($dataTotal,$displayPerPage,$url=''){
    #$page 当前页码
    #$sqlFirst mysql数据库起始项
    #$pageNav 分页导航内容
    $GLOBALS["$displayPerPage"]=$displayPerPage;
    global $page,$sqlFirst,$pageNav,$_SERVER;
    if(isset($_GET['page'])){
        $page=$_GET['page'];
    }else $page=1;

    #如果$url使用默认,即空值,则赋值为本页URL
    if(!$url){ $url=$_SERVER["REQUEST_URI"];}

    #URL分析
    $parse_url=parse_url($url);
    $url_query=$parse_url["query"]; //取出在问号?之后内容
    if($url_query){
        #函数执行一个正则表达式的搜索和替换。（删除page参数的部分）
        $url_query=preg_replace("/(&?)(page=$page)/","",$url_query);
        #保留处理page以外的所有参数
        $url = str_replace($parse_url["query"],$url_query,$url);
        if($url_query){      #如果还有参数拼接&page
            $url .= "&page";
        }
        else $url .= "page";#如果没有参数直接拼接page
    }
    else $url .= "?page";   #如果没有参数拼接?page

    #页码计算
    $lastPage=ceil($dataTotal/$displayPerPage);
    //最后页,总页数,向上舍入为最接近的整数
    $page=min($lastPage,$page);
    $prePage=$page-1; //上一页
    $nextPage=($page==$lastPage ? 0 : $page+1); //下一页
    $sqlFirst=($page-1)*$displayPerPage;        //数据库取数据起始index

    #开始分页导航内容
    $pageNav = "显示第 ".($dataTotal?($sqlFirst+1):0)."-".min($sqlFirst+$displayPerPage,$dataTotal)." 条记录，共 <B>$dataTotal</B> 条记录";
    if($lastPage<=1) return false; //如果只有一页则跳出
    if($page!=1) $pageNav .=" <a href='javascript:showResult(\"$url=1\")'>首页</a> "; else $pageNav .=" 首页 ";
    if($prePage) $pageNav .=" <a href= 'javascript:showResult(\"$url=$prePage\")'>前页</a> "; else $pageNav .=" 前页 ";
    if($nextPage) $pageNav .=" <a href= 'javascript:showResult(\"$url=$nextPage\")'>后页</a> "; else $pageNav .=" 后页 ";
    if($page!=$lastPage) $pageNav.=" <a href= 'javascript:showResult(\"$url=$lastPage\")'>尾页</a> "; else $pageNav .=" 尾页 ";

    #下拉跳转列表,循环列出所有页码
    $pageNav .="　到第 <select class='select' name='topage' size='1' onchange='showResult(\"$url=\"+this.value)'>\n";
    for($i=1;$i<=$lastPage;$i++){
        if($i==$page) $pageNav .="<option value='$i' selected>$i</option>\n";
        else $pageNav .="<option value='$i'>$i</option>\n";
    }
    $pageNav .="</select> 页，共 $lastPage 页";
}

function findstu(){
    //链接数据库
    $mysqli = mysqli_connect("localhost","root","1234","admission");
    if(!$mysqli){
        echo"<script>alert('数据库访问失败！请重新尝试！');history.back()</script>";
        exit;
    }
    $getNUmber="select count(1) as total_stu from student where not exists (select * from log where log.student_id =student.student_id and log.log_leave_campus_name is NULL)";
    $number = $mysqli->query($getNUmber)->fetch_assoc()['total_stu'];
    if($number==0){
        echo '<tr><td colspan="10">当前无不在校学生！</td></tr>';
    }
    global $sqlFirst,$pageNav;
    $dataPerPage=5;
    pageDivideStu($number,$dataPerPage);
    $getdatra="select student.student_id,student.name,student.phone_number,student.email,student.idnumber,student.class_name,student.department_name from student where not exists (select * from log where log.student_id =student.student_id and log.log_leave_campus_name is NULL) limit ".$sqlFirst.",".$dataPerPage;
    $dataThisPage = $mysqli->query($getdatra);
    while ($data = mysqli_fetch_assoc($dataThisPage)){
        $getId="select counselor_id from class where class_name = '".$data['class_name']."' and department_name = '".$data['department_name']."'";
        $counselor_id = $mysqli->query($getId)->fetch_assoc()['counselor_id'];
        $getId2="select manager_id from department where department_name = '".$data['department_name']."'";
        $manager_id = $mysqli->query($getId2)->fetch_assoc()['manager_id'];
        $getId3="select case when MAX(log_leave_time) is null then '该学生没有进出校记录' else MAX(log_leave_time) end as ld from log where student_id = ".$data['student_id'];
        $leave_date = $mysqli->query($getId3)->fetch_assoc()['ld'];
        echo '<tr>';
        echo '<td  border-width="1px">'.$data['student_id'].'</td>';
        echo '<td border-width="1px">'.$data['name'].'</td>';
        echo '<td border-width="1px">'.$data['phone_number'].'</td>';
        echo '<td border-width="1px">'.$data['email'].'</td>';
        echo '<td border-width="1px">'.$data['idnumber'].'</td>';
        echo '<td border-width="1px">'.$data['class_name'].'</td>';
        echo '<td border-width="1px">'.$data['department_name'].'</td>';
        echo '<td border-width="1px">'.$counselor_id.'</td>';
        echo '<td border-width="1px">'.$manager_id.'</td>';
        echo '<td border-width="1px">'.$leave_date.'</td>';
        echo '</tr>';
    }
    echo '<tr><td colspan="10">'.$pageNav.'</td></tr>';
}