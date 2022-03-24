<?php
    include('../config/constants.php');
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name != ""){
            $path = "../images/categories/".$image_name;
            $remove = unlink($path);
            if($remove==false){
                $_SESSION['remove'] = "<div class='error'>Failed to remove Category Image.</div>";
                header('location'.SITEURL.'/admin/category.php');
                die();
            }
        }
        $sql = "DELETE FROM categories WHERE id=$id";
        $res = mysqli_query($conn, $sql);
        if ($res == TRUE) {
            $_SESSION['delete'] = " <div class = 'success'>
                                        Category Deleted Sucessfully
                                    </div>";
            header('location:'.SITEURL.'/admin/category.php');
        }
        else{
            $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Category</div>";
            header('location:'.SITEURL.'/admin/category.php');
        }
    }
    else{
        header('location'.SITEURL.'/admin/category.php');
    }
?>