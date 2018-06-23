<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "emeal");  
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>eMeal - Upload recipe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab88174f9a49214"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript">
       $(document).ready(function(){
           $("#user").hide();
       });
        <?php  if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){?>
        $(document).ready(function(){
          $("#sign").hide(); 
            $("#user").show();
        });
        <?php }?>
    </script>
    <script>
        function F_Open_file(id){
            document.getElementById(id).click();
        }
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#recipeImg')
                        .attr('src', e.target.result);
                }; reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>
<body>
    <div id="navigation">
        <div id="title">
            <div class="addthis_inline_share_toolbox_20fu"></div>
            <p>e<span>MEAL</span></p>
            <div id="sign">
                <ul>
                    <li><a href="login.html">Sign in</a></li>
                    <li><a href="signup.php">Sign up</a></li>
                </ul>
            </div>
            <div id="user">
                <ul>
                    <li>
                        <?php 
                        $sql = "SELECT * FROM user";
                        $result = mysqli_query($connect, $sql);
                        while($row = mysqli_fetch_array($result)){
                        if($_SESSION['user']== $row['userEmail'])
                            {
                                $_SESSION['user']=$row['userNickname'];
                            }
                        }
                        ?>
                        Welcome, <a><?php echo $_SESSION['user']?></a>
                            <ul class="subnav2">
                                <li><a href="userProfile.php">Profile</a></li>
                                <li><a href="includes/logout.php">Log out</a></li>
                            </ul>
                    </li>                
                </ul>
            </div>
        </div>
        <div id="get_nav"></div>
        <div id="shoppingcart">
           <a href="shoppingcart.php">
            <img src="img/713b83a7ab70e1a79d66d49efc33aff6.png">
            <p>Shopping cart</p>
            </a>
        </div>

    </div>
    <div class="gray">
        <div class="tabbar">
            <ol class="breadcrumb">
                <li><a href="userProfile.php">Profile</a></li>
                <li class="active">Upload recipe</li>
            </ol>
        </div>
        <form method="POST" action="includes/uploadRecipe.php" enctype="multipart/form-data">
        <div class="detail-page">
            <table class="upload-page">
                <tr>
                    <td class="lefttab">Recipe Name:</td>
                    <td><input class="info" type="text" name="recipename" placeholder="Enter your recipe name" onfocus="this placeholder=''" onblur="this.placeholder='Please enter a recipe name'"></td>
                </tr>
                <tr>
                    <td class="lefttab">Recipe picture:</td>
                    <td>
                        <img id="recipeImg" src="img/icons8-plus-40.png" alt="recipe image" onclick="F_Open_file('imageUpload')">
                        <input id="imageUpload" type="file" accept="image/gif, image/jpeg, image/png" name="imageUpload" onchange="readURL(this);"></td>
                </tr>
                <tr>
                    <td class="lefttab">Author:</td>
                    <td><div class="info">
                        <?php echo $_SESSION['user']?>
                        </div></td>
                </tr>
                <tr>
                    <td class="lefttab">Date:</td>
                    <td><div class="info">
                        <?php date_default_timezone_set('Australia/Brisbane');
                        echo date('Y-m-d');
                        ?>
                        </div></td>
                </tr>
                <tr>
                    <td class="lefttab">Size:</td>
                    <td><select name="size" class="info">
                        <option value="NULL">-- Please select --</option>
                        <?php
                        $sql = "SELECT * FROM size";
                        $result = mysqli_query($connect, $sql);
                        while ($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row["sizeTitle"]."'>".$row["sizeTitle"]."</option>";
                        }
                        ?>
                        </select></td>
                </tr>
                <tr>
                    <td class="lefttab">Category:</td>
                    <td><select name="category" class="info">
                        <option value="NULL">-- Please select --</option>
                        <?php
                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($connect, $sql);
                        while ($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row["category"]."'>".$row["category"]."</option>";
                        }
                        ?>
                        </select></td>
                </tr>
                <tr>
                    <td class="lefttab">Purpose:</td>
                    <td><select name="purpose" class="info">
                        <option value="NULL">-- Please select --</option>
                        <?php
                        $sql = "SELECT * FROM purpose";
                        $result = mysqli_query($connect, $sql);
                        while ($row = mysqli_fetch_array($result)){
                            echo "<option value='".$row["purposeName"]."'>".$row["purposeName"]."</option>";
                        }
                        ?>
                        </select></td>
                </tr>
                <tr>
                    <td class="lefttab">Details:</td>
                    <td><textarea class="up-recipe" name="detail" maxlength="10000" placeholder="Enter your recipe details here..." onfocus="this placeholder=''" onblur="this.placeholder='Please enter your recipe details'"></textarea></td>
                </tr>
            </table>
            <input class="infosave" type="submit" value="Upload" name="upload">
        </div>
        </form>
        <div class="clearfloat"></div>
    </div>
    <div id="footer">
            <p>&copy;2018 eMeal Company. All Rights Reserved</p>
        </div>
</body>
</html>