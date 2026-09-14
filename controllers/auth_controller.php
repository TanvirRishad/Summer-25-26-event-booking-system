<?php
function login_action($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        verify_csrf();
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = find_user_by_login($conn, $login);

        if ($user && $user['status'] === 'active' && password_verify($password,$user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']=$user['id'];
            $_SESSION['name']=$user['name'];
            $_SESSION['role']=$user['role'];
            $_SESSION['last_activity']=time();
            redirect(app_url('page='.role_dashboard($user['role'])));
        }
        flash('error','Invalid email or password.');
    }
    require 'views/auth/login.php';
}

function register_action($conn) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        verify_csrf();
        $name=trim($_POST['name']??'');
        $email=trim($_POST['email']??'');
        $password=$_POST['password']??'';
        $role=$_POST['role']??'general_user';
        $allowed_roles=['general_user','event_manager','volunteer'];

        if ($name==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($password)<6 || !in_array($role,$allowed_roles,true)) {
            flash('error','Enter valid information. Password must be at least 6 characters.');
        } elseif (find_user_by_email($conn,$email)) {
            flash('error','An account with this email already exists.');
        } elseif (create_user($conn,$name,$email,$password,$role)) {
            flash('success','Registration successful. Please log in.');
            redirect(app_url('page=login'));
        } else {
            flash('error','Registration failed.');
        }
    }
    require 'views/auth/register.php';
}

function logout_action() {
    $_SESSION=[];
    session_destroy();
    redirect(app_url('page=login'));
}
?>
