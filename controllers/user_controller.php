<?php
function user_dashboard_action($conn) {
    require_role('general_user');
    $bookings=get_user_bookings($conn,current_user_id());
    $user=get_user($conn,current_user_id());
    require 'views/general_user/dashboard.php';
}

function profile_action($conn) {
    require_role('general_user');
    if($_SERVER['REQUEST_METHOD']==='POST'){
        verify_csrf();
        if(update_user_profile($conn,current_user_id(),trim($_POST['name']??''),trim($_POST['phone']??''),trim($_POST['address']??''))){
            flash('success','Profile updated.');
        }
    }
    $user=get_user($conn,current_user_id());
    require 'views/general_user/profile.php';
}

function availability_action($conn) {
    require_role('general_user');
    $events=get_events($conn,[
        'category'=>trim($_GET['category']??''),
        'date'=>trim($_GET['date']??''),
        'search'=>trim($_GET['search']??'')
    ]);
    require 'views/general_user/availability.php';
}

function refund_action($conn) {
    require_role('general_user');
    if($_SERVER['REQUEST_METHOD']==='POST'){
        verify_csrf();
        $booking_id=(int)$_POST['booking_id'];
        $reason=trim($_POST['reason']??'');
        if(create_refund_request($conn,$booking_id,current_user_id(),$reason)){
            flash('success','Refund request submitted.');
        } else flash('error','Could not submit refund request.');
    }
    $bookings=get_user_bookings($conn,current_user_id());
    $refunds=get_user_refunds($conn,current_user_id());
    require 'views/general_user/refunds.php';
}
?>
