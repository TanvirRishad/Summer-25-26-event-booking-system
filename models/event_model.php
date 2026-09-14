<?php
function get_events($conn, $filters = []) {
    $sql = "SELECT e.*, u.name manager_name,
            (SELECT COUNT(*) FROM event_seats s WHERE s.event_id=e.id AND s.status='available') available_seats
            FROM events e LEFT JOIN users u ON u.id=e.manager_id WHERE 1=1";
    $types = ''; $params = [];

    if (!empty($filters['category'])) {
        $sql .= " AND e.category=?";
        $types .= 's'; $params[] = $filters['category'];
    }
    if (!empty($filters['date'])) {
        $sql .= " AND DATE(e.event_date)=?";
        $types .= 's'; $params[] = $filters['date'];
    }
    if (!empty($filters['search'])) {
        $sql .= " AND (e.title LIKE ? OR e.location LIKE ?)";
        $types .= 'ss';
        $term = '%' . $filters['search'] . '%';
        $params[] = $term; $params[] = $term;
    }
    $sql .= " ORDER BY e.event_date ASC";

    $stmt = mysqli_prepare($conn, $sql);
    if ($types) mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
}

function get_event($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT e.*, u.name manager_name FROM events e
        LEFT JOIN users u ON u.id=e.manager_id WHERE e.id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function get_event_seats($conn, $event_id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM event_seats WHERE event_id=? ORDER BY seat_number");
    mysqli_stmt_bind_param($stmt, "i", $event_id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
}

function create_event($conn, $manager_id, $title, $description, $category, $location, $event_date, $price, $capacity) {
    mysqli_begin_transaction($conn);
    try {
        $stmt = mysqli_prepare($conn, "INSERT INTO events
            (manager_id,title,description,category,location,event_date,price,capacity)
            VALUES (?,?,?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "isssssdi", $manager_id,$title,$description,$category,$location,$event_date,$price,$capacity);
        mysqli_stmt_execute($stmt);
        $event_id = mysqli_insert_id($conn);

        $seat_stmt = mysqli_prepare($conn, "INSERT INTO event_seats (event_id,seat_number,status) VALUES (?,?, 'available')");
        for ($i=1; $i <= $capacity; $i++) {
            $seat = 'S-' . str_pad($i, 3, '0', STR_PAD_LEFT);
            mysqli_stmt_bind_param($seat_stmt, "is", $event_id, $seat);
            mysqli_stmt_execute($seat_stmt);
        }
        mysqli_commit($conn);
        return $event_id;
    } catch (Throwable $e) {
        mysqli_rollback($conn);
        return false;
    }
}
?>
