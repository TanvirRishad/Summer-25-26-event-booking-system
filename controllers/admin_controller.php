<?php
function admin_dashboard_action($conn) {
    require_role('admin');
    $stats=[
        'users'=>count_users($conn),
        'events'=>(int)mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM events"))['c'],
        'bookings'=>count_bookings($conn),
        'revenue'=>booking_revenue($conn)
    ];
    require 'views/admin/dashboard.php';
}

function admin_feedback_action($conn) {
    require_role('admin');
    if($_SERVER['REQUEST_METHOD']==='POST'){ verify_csrf(); update_feedback($conn,(int)$_POST['id'],trim($_POST['status'])); }
    $feedback=get_feedback($conn);
    require 'views/admin/feedback.php';
}

function admin_attendance_action($conn) {
    require_role('admin');
    if($_SERVER['REQUEST_METHOD']==='POST'){ verify_csrf(); mark_attendance($conn,(int)$_POST['booking_id'],trim($_POST['status'])); }
    $attendance=get_attendance($conn);
    require 'views/admin/attendance.php';
}

function admin_revenue_action($conn) {
    require_role('admin');
    $revenue=booking_revenue($conn);
    $payments=mysqli_fetch_all(mysqli_query($conn,"SELECT p.*,b.booking_code,e.title,u.name user_name
        FROM payments p JOIN bookings b ON b.id=p.booking_id JOIN events e ON e.id=b.event_id
        JOIN users u ON u.id=b.user_id ORDER BY p.paid_at DESC"),MYSQLI_ASSOC);
    require 'views/admin/revenue.php';
}
?>
