<?php
if (session_status() === PHP_SESSION_NONE) {
    session_name("admin_session");
    session_start();
}
if (!isset($_SESSION['user_id'])) {
  header("Location: /HealthyTrack/Admin/");
  exit;
}
?>