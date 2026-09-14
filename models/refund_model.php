<?php
function create_refund_request($conn, $booking_id, $user_id, $reason) {
    $stmt = mysqli_prepare($conn, "INSERT INTO refunds (booking_id,user_id,reason,status) VALUES (?,?,?,'requested')");
    mysqli_stmt_bind_param($stmt, "iis", $booking_id,$user_id,$reason);
    return mysqli_stmt_execute($stmt);
}

function get_user_refunds($conn, $user_id) {
    $stmt = mysqli_prepare($conn, "SELECT r.*,b.booking_code,e.title FROM refunds r
        JOIN bookings b ON b.id=r.booking_id JOIN events e ON e.id=b.event_id
        WHERE r.user_id=? ORDER BY r.created_at DESC");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
}

function get_refunds($conn) {
    $sql = "SELECT r.*,b.booking_code,e.title,u.name user_name FROM refunds r
        JOIN bookings b ON b.id=r.booking_id JOIN events e ON e.id=b.event_id
        JOIN users u ON u.id=r.user_id ORDER BY r.created_at DESC";
    return mysqli_fetch_all(mysqli_query($conn,$sql), MYSQLI_ASSOC);
}

function update_refund($conn, $id, $status, $volunteer_id) {
    $stmt = mysqli_prepare($conn, "UPDATE refunds SET status=?,handled_by=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sii", $status,$volunteer_id,$id);
    return mysqli_stmt_execute($stmt);
}
?>
