<?php
session_start();
// two different arrays here. $items_array and $cart_items. $items_array is for purchasable
// products and $cart_items is for items placed in the cart.
echo "browse items page";
$count = 0;
//print_r ($_POST);

//initializing items if not in session

if(!isset($items_array)) {
   // we could look into a local "products" folder for images and pull all in
   // for now, use these dummy products
   $items_0 = array("name" => "Item 0", "price" => "12.50", "image" => "stock.jpg", "code" => "0");
   $items_1 = array("name" => "Item 1", "price" => "50", "image" => "stock.jpg", "code" => "1");
   $items_2 = array("name" => "Item 2", "price" => "10", "image" => "stock.jpg", "code" => "2");
   $items_3 = array("name" => "Item 3", "price" => "5.50", "image" => "stock.jpg", "code" => "3");
   $items_array = array($items_0, $items_1, $items_2, $items_3);
   $_SESSION["loaded"] = true;
} 
// check for submit. 
if(!empty($_POST["submit"])) {
   switch($_POST["submit"]) {
      case "Buy":
         echo "in add!";
         if(($_POST["code"]) >= 0) {
            $code_to_add = $items_array[$_POST["code"]];
            //pull the item's array values and make copy running into reference errors
            $item_to_add = array($code_to_add["code"]=>array('name'=>$code_to_add["name"], 'code'=>$code_to_add["code"], 'price'=>$code_to_add["price"])); 

            // now add to cart in session
            if(!empty($_SESSION["cart_items"])) {
               //existing cart. check if item exists
               //tbd
               //add item to existing cart
               $_SESSION["cart_items"] = array_merge($_SESSION["cart_items"], $item_to_add);
            } else {
               //new cart. put item_to_add in it
               $_SESSION["cart_items"] = $item_to_add;
            }
         } else {
            // empty code. this shouldn't happen
            echo "error empty code.";
         }
      break;
      case "remove":
         //if no code, whole cart goes?
         //check for empty cart first
         if(!empty($_SESSION["cart_items"])) {
            // go through by index. if index at code isn't null, remove
            foreach($_SESSION["cart_items"] as $index => $val_item) {
               if($_POST["code" == $index]) {
                  unset($_SESSION["cart_items"], $index);
               }
            }
            // remove cart if now empty.
            if(empty($_SESSION["cart_items"])) {
               unset($_SESSION["cart_items"]);
            }
         }
      break;
      case "Clear":
         //remove from session
         unset($_SESSION["cart_items"]);
      break; 
   } // end switch         
} // end action
               
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (! empty($_POST["action"]) && $_POST["action"]== "add") {
      if(empty($_SESSION["cart"])) {
         $cart = array($_POST["code"]);
         $_SESSION["cart"] = $cart;
         echo "cart was empty. now :$cart";
      } else {
         echo "cart was NOT empty. was" .  $_SESSION["cart"];
         $cart = $_SESSION["cart"];
         echo "and now is $cart";
         array_push($cart, $_POST["code"]);
         echo "and now is $cart";
      }
   }
}
*/

/*
From the assignment: On the browse items page, the user sees a list of items they can add to their cart and purchase. Again, the kind of items and the formatting of this page is up to you.

You should provide a button or link to add an item to the cart. Doing so should store that item in some way to the session, and then keep the user on the browse page. 
*/
?>
<!DOCTYPE html>
   <head>
      <meta charset="utf-8">
      <title>Browse Items</title>
      <meta name="description" content="For the CS313 Shopping cart assignment in week 3">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="week03.css">
   </head>
   <header class="header">
      <div class="container nav">
         Nav here.
      </div>
   </header>
   <body >
      <div class="container">
         <div class="column browse row">
            <?php 
               if(sizeof($items_array)>0) {
                  foreach($items_array as $key=>$item) {               
            ?>
            <div class="item form">
               <form method="POST" action="<?$_SERVER['SCRIPT_FILENAME']?>">
                  <p>Item <?=$item["name"]?> here</p><br/>
                  <p>$<?=$item["price"]?>   
                  <input type="hidden" name="code" value="<?=$item['code']?>"/>
                  <input type="submit" name="submit" value="Buy"/>
               </form>
            </div>
            <?php
                  }
               } else {
                  echo sizeof($items_array);
            ?>
            <div class="item">
               Item <?=$count++?> here
            </div>
            <div class="item">
               Item <?=$count++?> here
            </div>
            <?php 
               }
            ?>
            <div class="cart">
               Cart has <?=sizeof($_SESSION["cart_items"])?> items. 
               <?php
                if(sizeof($_SESSION["cart_items"])>0) {?>
                  <a href="view_cart.php">View</a> 
                  <form method="post" action="<?$_SERVER['SCRIPT_FILENAME']?>">
                  <input type="submit" name="submit" value="Clear"/>
                <?}?>
            </div>
         </div>
      </div>

      
      
   </body>
</html>

