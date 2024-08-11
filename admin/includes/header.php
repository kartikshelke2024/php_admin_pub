
<?php
session_start();
if(!isset($_SESSION['admin_id']))
{
  echo 'No direct access allowed <br>';
//   header('login.php');
header("Location:login.php");

  die();
}
?>

<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=$base_path?>admin/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$base_path?>admin/assets/vendor/fonts/circular-std/style.css" >
    <link rel="stylesheet" href="<?=$base_path?>admin/assets/libs/css/style.css">
    <link rel="stylesheet" href="<?=$base_path?>admin/assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <!-- <link rel="stylesheet" href="<?=$base_path?>admin/assets/vendor/charts/chartist-bundle/chartist.css"> -->
    <!-- <link rel="stylesheet" href="<?=$base_path?>admin/assets/vendor/charts/morris-bundle/morris.css"> -->
    <link rel="stylesheet" href="<?=$base_path?>admin/assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <!-- <link rel="stylesheet" href="<?=$base_path?>admin/assets/vendor/charts/c3charts/c3.css"> -->
    <link rel="stylesheet" href="<?=$base_path?>admin/assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <title>Sunglide lubricants</title>
    <!-- jquery 3.3.1 -->
    <script src="<?=$base_path?>admin/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="<?=$base_path?>admin/assets/libs/js/commonScript.js"></script>
</head>