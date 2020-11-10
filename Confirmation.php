<?php
	session_start();
        $total = 0;
        $perTotol = 0;

?>
<html>
<head>
	<title>Confirmation</title>
	<link rel="stylesheet" type="text/css" href="Contents/BookStore.css" />
</head>
<body>
    <h2>Thank you, please review your selection</h2>
    <table border="1">
        <tr><th>Title</th><th>Price</th><th>Copies</th><th>Total</th></tr>
        <?php
            if(!isset($_SESSION["cart"])){
                header("Location: BookSelection.php");
            }
            
            $cart = $_SESSION["cart"];
            for ($i=0; $i<count($cart); $i++){
                $title = $cart[$i]["title"];
                $price = $cart[$i]["price"];
                $copies = $cart[$i]["copies"];
                $perTotol = $price * $copies;
                     
                echo "<tr><td>$title</td>";
                echo "<td>$price</td>";
                echo "<td>$copies</td>";
                echo "<td>$perTotol</td></tr>";   
                
                $total += $perTotol;
            }  
           
            echo "<tr><td colspan='3'>Grand Total</td>";
            echo "<td>$total</td></tr>";
            
           
        ?>
    </table>
    </br></br>
    <form action="BookSelection.php" method="post">
        <input type='submit'  class='button' name='back' value='Back'/>
    </form>
</body>
</html>