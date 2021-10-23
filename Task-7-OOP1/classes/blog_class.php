<?php
require "db_class.php";
class blog {
    private $title;
    private $content;
    private $image;


    public function __construct($t="",$c="",$i="")
    {
        # code...
        $this->title = $t;
        $this->content = $c;
        $this->image = $i;
        
    }

    public function add()
    {
        # code...
        $db_obj = new DataBase;
        $sql    = "insert into blog (title,content,image) values ('$this->title','$this->content','$this->image')";
        $res    = $db_obj->query($sql);
        return $res;
    }
    public function display()
    {
        # code...
        $db_obj = new DataBase;
        $sql    = "select * from blog";
        $res    = $db_obj->query($sql);
        return $res;
    }
    public function delete($id)
    {
        # code...
        $db_obj = new DataBase;
        $sql    = "delete from blog where id = $id";
        $res    = $db_obj->query($sql);
        return $res;
    }

    public function update($id)
    {
        # code...
        $db_obj = new DataBase;
        $sql    = "update blog set title = '$this->title',set content = '$this->content',set image = '$this->image'";
        $res    = $db_obj->query($sql);
        return $res;
    }

}




















?>