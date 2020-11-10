<?php
	session_start();
	include "BookList.php";    

?>
<?php 
    $copies = $_POST["copies"];
    $copiesArr = [];
    $copyErrorMsg = "";
    $bookCart = [];

    if(isset($_POST["buy"])){
        $bookTitles = array_keys($bookList);
        $bookPrices = array_values($bookList);
        for($i=0;$i<count($copies);$i++){
            if((int)$copies[$i] != 0){
                array_push($bookCart, array(
                            "title" => $bookTitles[$i],
                            "price" => $bookPrices[$i],
                            "copies" => $copies[$i]));
                
            }
            $copiesArr[] = $copies[$i];
        }
        
        if(count($bookCart) ==0 ){
            $copyErrorMsg = "At least one book's number of copies should greater than 0!";
        }
        else{
            $copyErrorMsg="";
            $_SESSION["cart"] = $bookCart;
            $_SESSION["copies"] = $copiesArr;
            header("Location: Confirmation.php");
        }           
    }
    

?>
<html>
<head>
    <title>Algonquin College Bookstore</title>
    <link rel="stylesheet" type="text/css" href="Contents/BookStore.css" />
</head>
<body>
    <h3>Enter the number of copies for books you want to buy and click Buy button</h3>
    <p class="error" style="color:red;"><?php echo $copyErrorMsg; ?></p>
    <form action="BookSelection.php" method="post">
        <br/>
        <table border="1">
             <tr><th><a href="BookSelection.php?sort=title">Title</a></th><th><a href="BookSelection.php?sort=price">Price</a></th><th>Copies</th></tr>
            <?php

                $titleDesc = false;
                $priceDesc = false;
                if($_SESSION["titleDesc"] == null){
                    $_SESSION["titleDesc"]=$titleDesc;
                }
                if($_SESSION["priceDesc"] == null){
                    $_SESSION["priceDesc"]=$priceDesc;
                }
            
                // sort by title
                if($_GET["sort"] == "title" && $_SESSION["titleDesc"]==false){  
                    ksort($bookList);  
                    $titleDesc = true;
                    $_SESSION["titleDesc"] = $titleDesc;
                }
                elseif ($_GET["sort"] == "title" && $_SESSION["titleDesc"]==true) {
                       
                        ksort($bookList);
                        $bookList = array_reverse($bookList);
                        $titleDesc = false;
                        $_SESSION["titleDesc"] = $titleDesc;   
                }
                
                // sort by price
                if($_GET["sort"] == "price" && $_SESSION["priceDesc"]==false){
                        asort($bookList);
                        $priceDesc = true;
                        $_SESSION["priceDesc"] = $priceDesc;
                    }
                elseif ($_GET["sort"] == "price" && $_SESSION["priceDesc"]==true) {
                    asort($bookList);
                    $bookList = array_reverse($bookList);
                    $priceDesc = true;
                    $_SESSION["priceDesc"] = $priceDesc;
                }
                
                // display table      
                $j = 0;
                foreach ($bookList as $book => $price){
                    echo "<tr>";
                    print("<td>$book</td>
                           <td>$price</td>");
                        
                    if(isset($_SESSION['copies'])){
                        $copiesArr = $_SESSION['copies'];
                        
                        ?>
                        <td><input type='text' name='copies[]' value="<?php echo $copiesArr[$j]; ?>"/></td>
                        <?php
                        $j = $j+1;
                    }
                    else {
                        ?>
                        <td><input type='text' name='copies[]' value=""/></td>
                        <?php
                    }
                    echo "</tr>";
                }
            ?>
        </table>
        <br/>
        <input type='submit'  class='button' name='buy' value='buy'/>
    </form>
</body>

</html>