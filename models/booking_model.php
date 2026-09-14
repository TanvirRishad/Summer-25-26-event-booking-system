<?php
function get_booking($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT b.*, e.title,e.event_date,e.location,e.price,u.name user_name
        FROM bookings b JOIN events e ON e.id=b.event_id JOIN users u ON u.id=b.user_id WHERE b.id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function get_user_bookings($conn, $user_id) {
    $stmt = mysqli_prepare($conn, "SELECT b.*,e.title,e.event_date,e.location,e.price
        FROM bookings b JOIN events e ON e.id=b.event_id WHERE b.user_id=? ORDER BY b.created_at DESC");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
}

function get_available_seats($conn, $event_id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM event_seats WHERE event_id=? AND status='available' ORDER BY seat_number");
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
}

function get_valid_promo($conn, $code) {
    $code = trim($code);
    if ($code === '') return null;
    $stmt = mysqli_prepare($conn, "SELECT * FROM promotional_codes
        WHERE code=? AND status='active' AND expires_at >= NOW()
        AND (usage_limit IS NULL OR used_count < usage_limit) LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $code);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function calculate_booking_amount($event_price, $promo) {
    $amount = (float)$event_price;
    if ($promo) {
        if ($promo['discount_type'] === 'percent') {
            $amount -= $amount * ((float)$promo['discount_value'] / 100);
        } else {
            $amount -= (float)$promo['discount_value'];
        }
    }
    return max(0, round($amount, 2));
}

function create_booking($conn, $user_id, $event_id, $seat_id, $promo_id, $amount) {
    mysqli_begin_transaction($conn);
    try {
        $seat_stmt = mysqli_prepare($conn, "SELECT id FROM event_seats WHERE id=? AND event_id=? AND status='available' FOR UPDATE");
        mysqli_stmt_bind_param($seat_stmt, "ii", $seat_id, $event_id);
        mysqli_stmt_execute($seat_stmt);
        if (!mysqli_fetch_assoc(mysqli_stmt_get_result($seat_stmt))) {
            throw new Exception('Seat is no longer available.');
        }

        $booking_code = 'BK' . strtoupper(bin2hex(random_bytes(4)));
        $promo_value = $promo_id > 0 ? $promo_id : null;
        $stmt = mysqli_prepare($conn, "INSERT INTO bookings
            (booking_code,user_id,event_id,seat_id,promo_id,total_amount,status)
            VALUES (?,?,?,?,?,?,'pending')");
        mysqli_stmt_bind_param($stmt, "siiiid", $booking_code, $user_id, $event_id, $seat_id, $promo_value, $amount);
        mysqli_stmt_execute($stmt);
        $booking_id = mysqli_insert_id($conn);

        $update = mysqli_prepare($conn, "UPDATE event_seats SET status='booked' WHERE id=? AND status='available'");
        mysqli_stmt_bind_param($update, "i", $seat_id);
        mysqli_stmt_execute($update);
        if (mysqli_stmt_affected_rows($update) !== 1) {
            throw new Exception('Seat could not be reserved.');
        }

        if ($promo_value !== null) {
            $promo_stmt = mysqli_prepare($conn, "UPDATE promotional_codes SET used_count=used_count+1 WHERE id=?");
            mysqli_stmt_bind_param($promo_stmt, "i", $promo_value);
            mysqli_stmt_execute($promo_stmt);
        }

        mysqli_commit($conn);
        return $booking_id;
    } catch (Throwable $e) {
        mysqli_rollback($conn);
        return false;
    }
}

function update_booking_paid($conn, $booking_id, $method) {
    mysqli_begin_transaction($conn);
    try {
        $stmt = mysqli_prepare($conn, "UPDATE bookings SET status='confirmed' WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        mysqli_stmt_execute($stmt);

        $booking = get_booking($conn, $booking_id);
        $pay = mysqli_prepare($conn, "INSERT INTO payments (booking_id,amount,method,status) VALUES (?,?,?,'paid')");
        mysqli_stmt_bind_param($pay, "ids", $booking_id,$booking['total_amount'],$method);
        mysqli_stmt_execute($pay);

        mysqli_commit($conn);
        return true;
    } catch (Throwable $e) {
        mysqli_rollback($conn);
        return false;
    }
}

function cancel_booking($conn, $booking_id, $user_id) {
    $stmt = mysqli_prepare($conn, "SELECT seat_id FROM bookings WHERE id=? AND user_id=? AND status IN ('pending','confirmed')");
    mysqli_stmt_bind_param($stmt, "ii", $booking_id,$user_id);
    mysqli_stmt_execute($stmt);
    $booking = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if (!$booking) return false;

    mysqli_begin_transaction($conn);
    try {
        $stmt = mysqli_prepare($conn, "UPDATE bookings SET status='cancelled' WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        mysqli_stmt_execute($stmt);
        $seat = mysqli_prepare($conn, "UPDATE event_seats SET status='available' WHERE id=?");
        mysqli_stmt_bind_param($seat, "i", $booking['seat_id']);
        mysqli_stmt_execute($seat);
        mysqli_commit($conn);
        return true;
    } catch (Throwable $e) {
        mysqli_rollback($conn);
        return false;
    }
}

function count_bookings($conn) {
    $r = mysqli_query($conn, "SELECT COUNT(*) total FROM bookings");
    return (int)mysqli_fetch_assoc($r)['total'];
}

function booking_revenue($conn) {
    $r = mysqli_query($conn, "SELECT COALESCE(SUM(amount),0) total FROM payments WHERE status='paid'");
    return (float)mysqli_fetch_assoc($r)['total'];
}

function manager_performance($conn, $manager_id) {
    $stmt = mysqli_prepare($conn, "SELECT e.id,e.title,e.event_date,
        COUNT(b.id) bookings, COALESCE(SUM(CASE WHEN p.status='paid' THEN p.amount ELSE 0 END),0) revenue
        FROM events e LEFT JOIN bookings b ON b.event_id=e.id
        LEFT JOIN payments p ON p.booking_id=b.id
        WHERE e.manager_id=? GROUP BY e.id ORDER BY e.event_date DESC");
    mysqli_stmt_bind_param($stmt, "i", $manager_id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
}
?>
