<?php
function booking_action($conn) {
    require_login();
    $event_id=(int)($_GET['event_id']??$_POST['event_id']??0);
    $event=get_event($conn,$event_id);
    if(!$event){ flash('error','Event not found.'); redirect(app_url('page=events')); }

    if($_SERVER['REQUEST_METHOD']==='POST'){
        verify_csrf();
        $seat_id=(int)($_POST['seat_id']??0);
        $promo_code=trim($_POST['promo_code']??'');
        $promo=get_valid_promo($conn,$promo_code);
        $promo_id=$promo ? (int)$promo['id'] : 0;
        $amount=calculate_booking_amount($event['price'],$promo);
        if($seat_id<=0 || ($promo_code!=='' && !$promo)){
            flash('error',$promo_code!=='' && !$promo ? 'Promotional code is invalid or expired.' : 'Invalid booking information.');
        } else {
            $booking_id=create_booking($conn,current_user_id(),$event_id,$seat_id,$promo_id,$amount);
            if($booking_id){
                redirect(app_url('page=payment&id='.$booking_id));
            }
            flash('error','Seat is unavailable or booking failed.');
        }
    }
    $seats=get_available_seats($conn,$event_id);
    require 'views/booking/index.php';
}

function my_bookings_action($conn) {
    require_role('general_user');
    $bookings=get_user_bookings($conn,current_user_id());
    require 'views/general_user/bookings.php';
}

function cancel_booking_action($conn) {
    require_role('general_user');
    verify_csrf();
    $id=(int)($_GET['id']??0);
    if(cancel_booking($conn,$id,current_user_id())) flash('success','Booking cancelled.');
    else flash('error','Unable to cancel booking.');
    redirect(app_url('page=my_bookings'));
}
?>
