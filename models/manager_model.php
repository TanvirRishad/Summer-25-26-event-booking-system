<?php
function get_transportation($conn, $manager_id) {
    $stmt = mysqli_prepare($conn, "SELECT t.*,e.title FROM transportation t JOIN events e ON e.id=t.event_id
        WHERE e.manager_id=? ORDER BY e.event_date");
    mysqli_stmt_bind_param($stmt, "i", $manager_id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
}

function add_transportation($conn,$event_id,$type,$provider,$departure,$arrival) {
    $stmt=mysqli_prepare($conn,"INSERT INTO transportation(event_id,type,provider,departure,arrival) VALUES(?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt,"issss",$event_id,$type,$provider,$departure,$arrival);
    return mysqli_stmt_execute($stmt);
}

function create_notification($conn,$manager_id,$event_id,$message) {
    $stmt=mysqli_prepare($conn,"INSERT INTO notifications(manager_id,event_id,message) VALUES(?,?,?)");
    mysqli_stmt_bind_param($stmt,"iis",$manager_id,$event_id,$message);
    return mysqli_stmt_execute($stmt);
}

function get_notifications($conn,$manager_id) {
    $stmt=mysqli_prepare($conn,"SELECT n.*,e.title FROM notifications n JOIN events e ON e.id=n.event_id
        WHERE n.manager_id=? ORDER BY n.created_at DESC");
    mysqli_stmt_bind_param($stmt,"i",$manager_id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt),MYSQLI_ASSOC);
}
?>
