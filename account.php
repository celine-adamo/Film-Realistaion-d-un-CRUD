<?php session_start();

require 'function.php'; ?>

<?php require_once "header.php"; ?>

<h1>Votre compte </h1>

<?php debug($_SESSION); ?>

<?php require_once "footer.php"; ?>