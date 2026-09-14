<?php
function manager_dashboard_action($conn) {
    require_role('event_manager');
    $events=get_events($conn,['search'=>'']);
    $mine=array_filter($events,fn($e)=>(int)$e['manager_id']===current_user_id());
    $performance=manager_performance($conn,current_user_id());
    require 'views/manager/dashboard.php';
}

function manager_transport_action($conn) {
    require_role('event_manager');
    if($_SERVER['REQUEST_METHOD']==='POST'){ verify_csrf(); add_transportation($conn,(int)$_POST['event_id'],trim($_POST['type']),trim($_POST['provider']),trim($_POST['departure']),trim($_POST['arrival'])); }
    $transport=get_transportation($conn,current_user_id());
    $events=array_filter(get_events($conn),fn($e)=>(int)$e['manager_id']===current_user_id());
    require 'views/manager/transportation.php';
}

function manager_notifications_action($conn) {
    require_role('event_manager');
    if($_SERVER['REQUEST_METHOD']==='POST'){ verify_csrf(); create_notification($conn,current_user_id(),(int)$_POST['event_id'],trim($_POST['message'])); }
    $notifications=get_notifications($conn,current_user_id());
    $events=array_filter(get_events($conn),fn($e)=>(int)$e['manager_id']===current_user_id());
    require 'views/manager/notifications.php';
}

function manager_performance_action($conn) {
    require_role('event_manager');
    $performance=manager_performance($conn,current_user_id());
    require 'views/manager/performance.php';
}
?>
