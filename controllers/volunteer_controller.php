<?php
function volunteer_dashboard_action($conn) {
    require_role('volunteer');
    $logistics=get_logistics($conn);
    $refunds=get_refunds($conn);
    $inquiries=get_inquiries($conn);
    require 'views/volunteer/dashboard.php';
}

function volunteer_logistics_action($conn) {
    require_role('volunteer');
    if($_SERVER['REQUEST_METHOD']==='POST'){ verify_csrf(); update_logistics($conn,(int)$_POST['id'],trim($_POST['status'])); }
    $logistics=get_logistics($conn);
    require 'views/volunteer/logistics.php';
}

function volunteer_refunds_action($conn) {
    require_role('volunteer');
    if($_SERVER['REQUEST_METHOD']==='POST'){ verify_csrf(); update_refund($conn,(int)$_POST['id'],trim($_POST['status']),current_user_id()); }
    $refunds=get_refunds($conn);
    require 'views/volunteer/refunds.php';
}

function volunteer_inquiries_action($conn) {
    require_role('volunteer');
    if($_SERVER['REQUEST_METHOD']==='POST'){ verify_csrf(); answer_inquiry($conn,(int)$_POST['id'],trim($_POST['answer']),current_user_id()); }
    $inquiries=get_inquiries($conn);
    require 'views/volunteer/inquiries.php';
}
?>
