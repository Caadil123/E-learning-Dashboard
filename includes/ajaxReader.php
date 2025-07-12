<?php
include 'functions.php';
if(isset($_POST['table']) && isset($_POST['id'])){
    $result = read_where($_POST['table'],"id=".$_POST['id']);
    if($result){
        echo json_encode($result[0]);
    }else{
        echo json_encode("No data found!");
    }
}

