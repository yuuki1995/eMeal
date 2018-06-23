<?php
    session_start();
    $con = mysqli_connect("localhost","root","","emeal");
    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            

                    $uid = $_SESSION["userId"];
                    $pid = $_GET["id"];
                    $deletecart_query = "DELETE FROM `cart` WHERE `pId` = '$pid' AND `uId` = '$uid'";
                    $delete_result = mysqli_query($con, $deletecart_query);
                    echo '<script>alert("Product has been Removed...!")</script>';
                    echo '<script>window.location="shoppingcart.php"</script>';
                }
          
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>eMeal - Shopping cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ab88174f9a49214"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        function fmoney(s, n) {
            n = n > 0 && n <= 20 ? n : 2;
            s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
            var l = s.split(".")[0].split("").reverse(),
            r = s.split(".")[1];
            t = "";
            for (i = 0; i < l.length; i++) {
                t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
            }
            return t.split("").reverse().join("") + "." + r;
            }
                <?php  if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){?>
        $(document).ready(function(){
            $("#sign").hide(); 
            $("#user").show();
        });
        <?php }?>
        $(document).ready(function(){
            $(".add").click(function(){
                var n=$(this).prev().val();
                var num=parseInt(n)+1;
                if(num==0){
                    return;
                }
                $(this).prev().val(num);
                var price = fmoney($(this).parent().parent().parent().find(".item_price").text(),2);
                var sum = num * price; $(this).parent().parent().parent().find(".item_total").text(fmoney(sum,2));
                getTotal();
            });
            
            $(".detail-page").find(".list_box").each(function(){
            var itemprice = $(this).children().children().find(".item_price").text();
            var number = $(this).children().children().find(".num").val();
            var price= fmoney(itemprice * number,2);
            $(this).children().children().find(".item_price").text(fmoney(itemprice,2));
            $(this).children().children().find(".item_total").text(price);
            });
            
            
            
            $(".min").click(function(){
                var n=$(this).next().val();
                var num=parseInt(n)-1;
                if(num==0){ return}
                $(this).next().val(num);
                var price = fmoney($(this).parent().parent().parent().find(".item_price").text(),2);
                var sum = num * price; $(this).parent().parent().parent().find(".item_total").text(fmoney(sum,2));
                getTotal();
            });
            
            $(".remove_btn").click(function(){
                $(this).parent().parent().parent().remove();
                getTotal();
            });
            
            function getTotal(){
                var priceTotal = 0;
                $(".detail-page").find(".list_box").each(function(){
                    priceTotal += parseFloat($(this).find(".item_total").text());
                })
                $("#price_total").text(fmoney(priceTotal,2));
            }
            getTotal();
        });
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
                    <li>Welcome, <a><?php echo $_SESSION['user']?></a>
                        <ul class="subnav2">
                            <li><a href="userProfile.php">Profile</a></li>
                            <li><a href="includes/logout.php">Log out</a></li>
                            <input class="uid" type="text" value="<?php echo $_SESSION["userId"]?>">
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
               <li><a href="shoppinggeneral.php">Shopping</a></li>
	           <li class="active">Cart</li>
            </ol>
        </div>
        <div class="cart-page">
            <div class="detail-page">

            <!--get_cartdetails-->
               <div class="list_title">
                    <div class="row">
                        <div class="col-md-2"><p>Item</p></div>
                        <div class="col-md-3"><p>Name</p></div>
                        <div class="col-md-1"><p>Price</p></div>
                        <div class="col-md-2"><p>Quantity</p></div>
                        <div class="col-md-2"><p>Total</p>
                    </div>
                    <div class="col-md-1"><p>Remove</p></div>
                </div>
            </div>
            
            <div id="get-cart"></div>
            <!--echo the entire shopping cart out-->
                
                <!--echo until here-->
                <a href="confirmpage.php" type="button" class="recipe-btn">Check out</a>
                <div class="clearfloat"></div>
            </div>
        </div>
        <div class="clearfloat"></div>
    </div>
    <div id="footer">
        <p>&copy;2018 eMeal Company. All Rights Reserved</p>
    </div>
    

</body>
</html>