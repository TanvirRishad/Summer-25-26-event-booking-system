<?php
function payment_action($conn) {
    require_role('general_user');
    $id=(int)($_GET['id']??0);
    $booking=get_booking($conn,$id);
    if(!$booking || (int)$booking['user_id']!==current_user_id()){
        flash('error','Booking not found.'); redirect(app_url('page=my_bookings'));
    }
    if($_SERVER['REQUEST_METHOD']==='POST'){
        verify_csrf();
        $method=trim($_POST['method']??'card');
        if(update_booking_paid($conn,$id,$method)){
            flash('success','Payment completed and booking confirmed.');
            redirect(app_url('page=my_bookings'));
        }
        flash('error','Payment could not be completed.');
    }
    require 'views/payment/index.php';
}
?>
