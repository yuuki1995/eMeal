<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "emeal");

if (isset($_POST["upload"])){
    include 'db.php';
    $nickname = $_SESSION['user'];
    $recipeId = $_POST['recipeId'];
    $query = "SELECT * FROM recipe WHERE recipeId = '$recipeId'";
    $result = mysqli_query($connect,$query);
    $row = mysqli_fetch_array($result);
    $recipeimg = $row['img'];
    
    $recipename = $_POST['recipename'];
    $date = date('Y-m-d');
    $size = $_POST['size'];
    $category = $_POST['category'];
    $purpose = $_POST['purpose'];
    $detail = $_POST['detail'];
    
    if (empty($recipename)|| empty($detail)|| $_POST['size']=='NULL'|| $_POST['category']=='NULL'|| $_POST['purpose']=='NULL'){
        echo 'Empty inputs!';
        header("Refresh: 1; url=../recipeUpload.php");
        exit();  
    }else if(!empty($_FILES['imageUpload']['tmp_name'])){
        unlink('../'.$recipeimg);
        $imagename = $_FILES['imageUpload']['name'];
        $imagetmpname = $_FILES['imageUpload']['tmp_name'];
        $target_folder = "../uploadImage/recipeUpload/";
        $target_file = $target_folder . basename($imagename);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $imgname = $nickname.$recipename.'.'.$imageFileType;
        rename($imagename,$imgname);
        $path = "uploadImage/recipeUpload/".$imgname;
        move_uploaded_file($imagetmpname, $target_folder.$imgname);
    }else{
        $path = $recipeimg;
    }
    
    $sql = "UPDATE `recipe` SET `recipeName` = '$recipename', `recipeTime` = '$date', `recipeContent` = '$detail', `recipeCategory` = '$category', `recipeSize` = '$size', `Purpose` = '$purpose', `img` = '$path' WHERE `recipe`.`recipeId` = '$recipeId'";
    mysqli_query($connect, $sql);
    header("Location:../recipeinfo.php?recipe=$recipeId");
}
?>