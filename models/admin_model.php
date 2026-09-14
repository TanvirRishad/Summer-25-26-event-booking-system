<?php
function get_feedback($conn) {
    $sql = "SELECT f.*,u.name user_name,e.title FROM feedback f
        JOIN users u ON u.id=f.user_id JOIN events e ON e.id=f.event_id ORDER BY f.created_at DESC";
    return mysqli_fetch_all(mysqli_query($conn,$sql), MYSQLI_ASSOC);
}

function update_feedback($conn, $id, $status) {
    $stmt = mysqli_prepare($conn, "UPDATE feedback SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $status,$id);
    return mysqli_stmt_execute($stmt);
}

function get_attendance($conn) {
    $sql = "SELECT a.*,b.booking_code,e.title,u.name user_name FROM attendance a
        JOIN bookings b ON b.id=a.booking_id JOIN events e ON e.id=b.event_id
        JOIN users u ON u.id=b.user_id ORDER BY e.event_date DESC";
    return mysqli_fetch_all(mysqli_query($conn,$sql), MYSQLI_ASSOC);
}

function mark_attendance($conn, $booking_id, $status) {
    $stmt = mysqli_prepare($conn, "INSERT INTO attendance (booking_id,status) VALUES (?,?)
        ON DUPLICATE KEY UPDATE status=VALUES(status)");
    mysqli_stmt_bind_param($stmt, "is", $booking_id,$status);
    return mysqli_stmt_execute($stmt);
}
?>
