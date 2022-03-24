<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        <?php 
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $sql = "SELECT * FROM categories WHERE id=$id";
                $res = mysqli_query($conn, $sql);
                if($res == true){
                    $count = mysqli_num_rows($res);
                    if($count==1){
                        $row = mysqli_fetch_assoc($res);
                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    }
                    else{
                        $_SESSION['no-category'] = "<div class = 'error>Category not Found</div>";
                        header("location: ".SITEURL.'/admin/category.php');
                    }
                }
            }
            else{
                header("location: ".SITEURL.'/admin/category.php');
            }
        ?>
        <form action="" method = "POST" enctype="multipart/form-data">
            <table class = "tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name = "title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image != ""){
                                ?>
                                <img src="<?php echo SITEURL;?>/images/categories/<?php echo $current_image; ?>"  width="30px" height="30px">
                                <?php
                            }
                            else{
                                echo "<div class= 'error'>Image not Added</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td><input type="file" name = "image"></td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes"){echo "checked";}?> type="radio" name = "featured"  value = "Yes"> Yes
                        <input <?php if($featured == "No"){echo "checked";}?> type="radio" name = "featured"  value = "No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes"){echo "checked";}?> type="radio" name = "active"  value = "Yes"> Yes
                        <input <?php if($active == "No"){echo "checked";}?> type="radio" name = "active"  value = "No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name = "current_image" value="<?php echo $current_image?>">
                        <input type="hidden" name = "id" value="<?php echo $id?>">  
                        <input type="submit" name = "submit" value="Update" class = "btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>

<?php
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $title = $_POST['title'];  
        $current_image = $_POST['current_image'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

        if(isset($_FILES['image']['name'])){
            $image_name= $_FILES['image']['name'];
            if($image_name != ""){
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/categories/".$image_name;

                $upload = move_uploaded_file($source_path, $destination_path);

                if($upload==false) {
                    $_SESSION['upload'] = '<div class = "error">Failed to upload the image</div>';
                    header("location: ".SITEURL.'/admin/categories.php');    
                    die();
                }
                if($current_image != ""){
                    $remove_path = "../images/categories/".$current_image;
                    $remove = unlink($remove_path);
                    if($remove==false){
                        $_SESSION['failed-remove'] = '<div class = "error">Failed to remove the image</div>';
                        header("location: ".SITEURL.'/admin/categories.php');    
                        die();
                    }
                }
            }
            else{
                $image_name = $current_image;
            }
        }
        else{
            $image_name = $current_image;
        }

        $sql2 = "UPDATE categories SET 
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id=$id";

        $res2 = mysqli_query($conn, $sql2);

        if ($res2 == TRUE){
            $_SESSION['update'] = '<div class = "success">Category Updated Sucessfully</div>';
            header("location: ".SITEURL.'/admin/category.php');
        }
        else{
            $_SESSION['update'] = '<div class = "error">Failed to update Category</div>';
            header("location: ".SITEURL.'/admin/category.php');
        }

    }
?>
<?php include('partials/footer.php'); ?>