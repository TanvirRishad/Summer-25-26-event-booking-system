<?php
function get_logistics($conn) {
    $sql="SELECT l.*,e.title FROM event_logistics l JOIN events e ON e.id=l.event_id ORDER BY e.event_date";
    return mysqli_fetch_all(mysqli_query($conn,$sql),MYSQLI_ASSOC);
}

function update_logistics($conn,$id,$status) {
    $stmt=mysqli_prepare($conn,"UPDATE event_logistics SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt,"si",$status,$id);
    return mysqli_stmt_execute($stmt);
}

function get_inquiries($conn) {
    $sql="SELECT i.*,u.name user_name,e.title FROM inquiries i
        JOIN users u ON u.id=i.user_id JOIN events e ON e.id=i.event_id ORDER BY i.created_at DESC";
    return mysqli_fetch_all(mysqli_query($conn,$sql),MYSQLI_ASSOC);
}

function answer_inquiry($conn,$id,$answer,$volunteer_id) {
    $stmt=mysqli_prepare($conn,"UPDATE inquiries SET answer=?,status='answered',handled_by=? WHERE id=?");
    mysqli_stmt_bind_param($stmt,"sii",$answer,$volunteer_id,$id);
    return mysqli_stmt_execute($stmt);
}
?>
