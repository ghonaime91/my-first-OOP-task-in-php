<?php
require "classes/blog_class.php";
require "classes/validator.php";

$id = $_GET['id'];

$validator = new validator;
if($validator->validate($id,"is_int")) {
    $blog = new blog();
    #fetch old data
    $result = $blog->display();
    $res_arr = mysqli_fetch_assoc($result);
    
}


if($_SERVER['REQUEST_METHOD'] == "POST"){

    $validator    = new validator;
    $title       =  $validator->clear_input($_POST['title']); 
    $content     =  $validator->clear_input($_POST['content']);


    $errors = [];

    # title validation
    if($validator->validate($title,"is_empty")) {
        $errors['title'] = "required";
    } elseif (!($validator->validate($title,"is_string"))) {
        $errors['title'] = "must be a string";
    } 

    # content validation
    if($validator->validate($content,"is_empty")) {
        $errors['content'] = "required";
    } elseif ($validator->validate($content,"is_short",50)) {
        $errors['content'] = "must be > 50 char";
    } 

    # image validation
    if(!empty($_FILES['image']['name'])) {
        $img_tmp  = $_FILES['image']['tmp_name'];
        $img_name = $_FILES['image']['name'];
        $img_size = $_FILES['image']['size'];
        $img_type = $_FILES['image']['type'];

        $allowed_ext  = ['jpeg','jpg','png'];
        $arr_img_type = explode('/',$img_type);
        if(in_array($arr_img_type[1],$allowed_ext)) {
            $final_name = rand(1,50).time().".".$arr_img_type[1];
            $final_path = "./uploads/".$final_name;
            move_uploaded_file($img_tmp,$final_path);
        } else {
            $errors['image'] = "invalid extension";
        }

    } else {
        $errors['image'] = "required";
    }
    # if there any error
    if(count($errors) > 0 ) {
        foreach ($errors as $key => $value) {
            echo "* ".$key." is ".$value."<br>";
        }
    } else {
        $blog = new blog($title,$content,$final_name);
        $result = $blog->add();
        if($result) {
            header("Location: display.php");
        } else {
            echo "Error try again";
        }

        



    }

    
}






?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Blog</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Blog</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">



            <div class="form-group">
                <label for="exampleInputEmail1">title</label>
                <input type="text" name="title" value=<?php echo $res_arr['title']?> >
            </div>


            <div class="form-group">
                <label for="exampleInputEmail1">Content</label>
                <textarea name="content" id="" cols="80" rows="4"><?php echo $res_arr['content']?></textarea>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Image</label>
                <input type="file" name="image" value = <?php echo $res_arr['image']?> >
                
            </div>






            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>











    
</body>

</html>
