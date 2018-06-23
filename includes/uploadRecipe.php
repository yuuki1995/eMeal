<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "emeal");

if (isset($_POST["upload"])){
    include 'db.php';
    
    $nickname = $_SESSION['user'];
    $query = "SELECT * FROM user WHERE userNickname = '$nickname'";
    $result = mysqli_query($connect,$query);
    $row = mysqli_fetch_array($result);
    $userid = $row['userId'];

    $recipename = $_POST['recipename'];
    $date = date('Y-m-d');
    $size = $_POST['size'];
    $category = $_POST['category'];
    $purpose = $_POST['purpose'];
    $detail = $_POST['detail'];
    
    if (empty($recipename)|| empty($detail)|| $_POST['size']=='NULL'|| $_POST['category']=='NULL'|| $_POST['purpose']=='NULL'|| empty($_FILES['imageUpload']['tmp_name'])){
        echo 'Empty inputs!';
        header("Refresh: 1; url=../recipeUpload.php");
        exit();  
    }else{
        $imagename = $_FILES['imageUpload']['name'];
        $imagetmpname = $_FILES['imageUpload']['tmp_name'];
        $target_folder = "../uploadImage/recipeUpload/";
        $target_file = $target_folder . basename($imagename);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $imgname = $nickname.$recipename.'.'.$imageFileType;
        rename($imagename,$imgname);
        $path = "uploadImage/recipeUpload/".$imgname;
        move_uploaded_file($imagetmpname, $target_folder.$imgname);
    
        $sql = "INSERT INTO `recipe` (`recipeName`, `recipeTime`, `recipeContent`, `recipeCategory`, `recipeSize`, `userId`, `Purpose`, `img`) VALUES ('$recipename', '$date', '$detail', '$category', '$size', '$userid', '$purpose', '$path')";

        mysqli_query($connect, $sql);
        $recipeId = mysqli_insert_id($connect);
        header("Location:../recipeinfo.php?recipe=$recipeId");
    }
}
?>