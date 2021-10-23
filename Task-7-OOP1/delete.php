<?php
require "classes/blog_class.php";
require "classes/validator.php";

$id = $_GET['id'];

$validator = new validator;
if($validator->validate($id,"is_int")) {
    $blog = new blog();
    $result = $blog->delete($id);
    if($result) {
        header("Location: display.php");
    }else {
        echo "Error try again";
    }

}


?>