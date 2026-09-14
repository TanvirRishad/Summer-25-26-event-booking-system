<?php
function events_action($conn) {
    $events=get_events($conn,[
        'category'=>trim($_GET['category']??''),
        'date'=>trim($_GET['date']??''),
        'search'=>trim($_GET['search']??'')
    ]);
    require 'views/events/index.php';
}

function event_details_action($conn) {
    $id=(int)($_GET['id']??0);
    $event=get_event($conn,$id);
    if(!$event){ flash('error','Event not found.'); redirect(app_url('page=events')); }
    $seats=get_event_seats($conn,$id);
    require 'views/events/details.php';
}
?>
