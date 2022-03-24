<?php
    include('../config/constants.php');
    $id = $_GET['id'];
    $sql = "DELETE FROM admin WHERE ID=$id";
    $res = mysqli_query($conn, $sql);
    if ($res == TRUE) {
        $_SESSION['delete'] = " <div class = 'success'>
                                    Admin Deleted Sucessfully
                                </div>";
        header('location:'.SITEURL.'/admin/admin.php');
    }
    else{
        $_SESSION['delete'] = "<div class = 'error'>Failed to Delete Admin</div>";
        header('location:'.SITEURL.'/admin/admin.php');
    }
?>