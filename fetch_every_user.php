<?php
session_start();
include('partials/dbconnect.php');

//fetching every users except the current user

$current_user_id = $_SESSION['user_id'];

?>