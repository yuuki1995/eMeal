<?php
include "includes/db.php";
session_start();
$connect = mysqli_connect("localhost", "root", "", "emeal");  

$nickname = $_SESSION['user'];
$query = "SELECT * FROM user WHERE userNickname = '$nickname'";
$result = mysqli_query($connect,$query);
$row = mysqli_fetch_array($result);
$uId = $row['userId'];
$profileimg = $row['userProfilepic'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>eMeal - Order history</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab88174f9a49214"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        <?php  if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){?>
        $(document).ready(function(){
          $("#sign").hide(); 
            $("#user").show();
        });
        <?php }?>
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
    <div class="clearfloat"></div>
    <div class="gray">
        <div class="tabbar">
            <ol class="breadcrumb">
                <li ><a href="userProfile.php">Profile</a></li>
                <li class="active">Personal profile</li>
            </ol>
        </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <div class="profile-menu">
                            <div class="leftprofile">
                                <img src="<?php echo $profileimg;?>" alt="profile image">
                            </div>
                            <div class="accounttab">
                                <p><a class="accountp" href="userProfile.php">Personal Profile</a></p>
                                <p><a class="accountp" href="userProfileEdit.php">Edit Profile</a></p>
                                <p><a class="accountp" href="recipeUpload.php">Upload Recipe</a></p>
                                <p><a class="accountp" href="viewRecipe.php">View Recipe</a></p>
                                <p><a class="accountp" href="viewhistory.php">Order History</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="profileorder">
                            <table class="orderhistory">
                                <tr>
                                    <th class="hiscol">Order ID</th>
                                    <th class="hiscol">Item</th>
                                    <th class="hiscol">Name</th>
                                    <th class="hiscol">Quantity</th>
                                    <th class="hiscol">Transaction ID</th>
                                    <th class="hiscol">Order Status</th>
                                </tr>
                                <?php
                                $query = "SELECT a.orderId, b.productImage, b.productName, a.quantity,a.transactionId, a.orderStatus FROM orders a, product b WHERE a.userId = $uId AND a.productId = b.productId";
                                $result = mysqli_query($connect, $query);
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>".$row['orderId']."</td>";
                                    echo "<td>".$row['productImage']."</td>";
                                    echo "<td>".$row['productName']."</td>";
                                    echo "<td>".$row['quantity']."</td>";
                                    echo "<td>".$row['transactionId']."</td>";
                                    echo "<td>".$row['orderStatus']."</td>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>   
            </div>
    </div>
    <div id="footer">
            <p>&copy;2018 eMeal Company. All Rights Reserved</p>
        </div>
</body>
</html>