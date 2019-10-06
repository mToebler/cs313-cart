<?php 
session_start();

echo "view cart page";

print_r($_SESSION["cart_items"]);

if(!empty($_POST["submit"])) {
   switch($_POST["submit"]) {
      case "Remove":
         //check for empty cart first
         if(!empty($_SESSION["cart_items"])) {
            // go through each. if post"value" and val_item"code" same, unset
            foreach($_SESSION["cart_items"] as $index => $val_item) {
               // echo "considering" . $index . "with " . $val_item . "with code " .$val_item['code'] . "against " . $_POST['index']; //. " " . $val_item['code']. "at index:" . $index;
               if($_POST["index"] == $index) {
                  // echo "removing" . $_POST['code']. " " . $val_item['code']. "at index:" . $index;
                  //unset($_SESSION["cart_items"], $index);
                  unset($_SESSION["cart_items"], $index);
                  break;
               }
            }
            // remove cart if now empty.
            // if(empty($_SESSION["cart_items"])) {
            //    unset($_SESSION["cart_items"]);
            // }
         }
      break;
      case "Clear":
         //remove from session
         unset($_SESSION["cart_items"]);
      break; 
   }
}

?>
<!DOCTYPE html>
   <head>
      <meta charset="utf-8">
      <title>View Shopping Cart</title>
      <meta name="description" content="For the CS313 Shopping cart assignment in week 3">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="week03.css">
   </head>
   <header class="header">
      <div class="container nav">
         --Nav here.--
      </div>
   </header>
   <body>
      <div class="container">
         <div class="column cart">
            <?php 
               if(sizeof($_SESSION["cart_items"])>0) {
                  foreach($_SESSION["cart_items"] as $key=>$item) {               
            ?>
            <div class="item form">
               <form method="POST" action="<?$_SERVER['SCRIPT_FILENAME']?>">
                  <p>Item <?=$item["name"]?> here</p><br/>
                  <p>$<?=$item["price"]?></p>
                  <input type="hidden" name="index" value="<?=$key?>"/>
                  <input type="submit" name="submit" value="Remove"/>
               </form>
            </div>
            <?php 
                  }
               }
            ?>
         </div>
            Cart has <?=sizeof($_SESSION["cart_items"])?> items. 
            <?php
               if(sizeof($_SESSION["cart_items"])>0) {?>
               <form method="post" action="<?$_SERVER['SCRIPT_FILENAME']?>">
               <input type="submit" name="submit" value="Clear"/>
               </form>
               <a href="check_out.php">Check out</a>
            <?}?>
            <a href="browse_items.php">Continue browsing</a> 
      </div>
   </body>
</html>