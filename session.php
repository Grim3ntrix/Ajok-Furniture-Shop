<?php
session_start();
// Check if the user is authenticated as a seller or a user
$isAuthenticatedSeller = isset($_SESSION['SellerID']);
$isAuthenticatedUser = isset($_SESSION['id']);

// Handle logout action
if (isset($_GET['logout'])) {
  // Destroy the session and log out the user
  session_destroy();
  // Redirect to a desired page after logout
  header('Location: index.php');
  exit();
}
?>