<?php
function find_user_by_email($conn, $email) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function find_user_by_login($conn, $login) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ? OR admin_id = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ss", $login, $login);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function create_user($conn, $name, $email, $password, $role = 'general_user') {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hash, $role);
    return mysqli_stmt_execute($stmt);
}

function get_user($conn, $id) {
    $stmt = mysqli_prepare($conn, "SELECT id,name,email,role,phone,address,status,created_at FROM users WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

function update_user_profile($conn, $id, $name, $phone, $address) {
    $stmt = mysqli_prepare($conn, "UPDATE users SET name=?,phone=?,address=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssi", $name, $phone, $address, $id);
    return mysqli_stmt_execute($stmt);
}

function count_users($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) total FROM users");
    return (int)mysqli_fetch_assoc($result)['total'];
}
?>
