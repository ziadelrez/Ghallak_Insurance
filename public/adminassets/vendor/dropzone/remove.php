<?php

if (!isset($_REQUEST["file_name"]) && !isset($_REQUEST["form_id"]) && !isset($_REQUEST["unique"]) ) {
    exit();
}

unlink(__DIR__."/".$_REQUEST["file_name"]);
return true;
?>