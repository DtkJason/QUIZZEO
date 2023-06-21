<?php

require "classes.php";

$member = new Admin();

$member->updateOwnerQuizz($_GET["id"]);
$member->deleteMember($_GET["id"]);
