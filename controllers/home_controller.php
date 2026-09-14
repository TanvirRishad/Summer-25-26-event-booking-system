<?php
function home_action($conn) {
    $events = array_slice(get_events($conn),0,6);
    require 'views/home/index.php';
}
?>
