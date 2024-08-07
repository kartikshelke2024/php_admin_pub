<?php
session_start();
session_destroy();
//session_unset(); // unset all the sessions
echo '<script type="text/javascript">window,location = "login";</script>';
?>