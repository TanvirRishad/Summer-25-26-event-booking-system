<?php
function create_payment($conn, $booking_id, $amount, $method) {
    $stmt = mysqli_prepare($conn, "INSERT INTO payments (booking_id,amount,method,status) VALUES (?,?,?,'paid')");
    mysqli_stmt_bind_param($stmt, "ids", $booking_id,$amount,$method);
    return mysqli_stmt_execute($stmt);
}
?>
