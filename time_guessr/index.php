<?php
// point d'entré demarre et redirige

session_start();
header("Location: /src/home.php");
exit();
