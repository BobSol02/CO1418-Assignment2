<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Page</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php
        include "databaselogin.php";
        include "header.php";
        //include "addToCart.php";
    ?>
    <main class="mainContent" id="itemMain">
        <div id="product">
            <?php
            if(isset($_GET["id"])) {
                //print_r($_SESSION);
                $id = str_replace("_", " ", $_GET["id"]);
                $stmt = $pdo->prepare("SELECT * FROM tbl_products WHERE product_id = :_product_id");
                $stmt->bindParam(":_product_id", $id);
                $stmt->execute();
                $product = $stmt->fetch();
                if($product)
                    echo
                        "<img src=\"",$product["product_image"],"\" alt=\"",$product["product_title"],"\" width=\"240px\" height=\"240px\">",
                        "<p><b>",$product["product_title"],"</b></p>",
                        "<p>",$product["product_desc"],"</p>",
                        "<p>£",$product["product_price"],"</p>",
                        "<button class='addToCart' id=",$_GET["id"],">Add to Cart</button>";
                else{
                    echo "No such product exists";
                    header("Location: 404.php");
                }
            }
            else{
                header("Location: 404.php");
            }
            ?>
        </div>
        <div class="reviews">
            <form id="submit" method="post" style="display: none">
                <span>Write new review:</span>
                </br>
                <label for="title">Review Title:</label>
                <input type="text" id="title" name="title" required>
                </br>
                <textarea id="review" name="review" required></textarea>
                </br>
                <label for="rating">Rating:</label>
                <select id="rating" name="rating">
                    <option value="1">Bad</option>
                    <option value="2">Mediocre</option>
                    <option value="3">Average</option>
                    <option value="4">Good</option>
                    <option value="5">Excellent</option>
                </select>
                </br>
                <input type="submit" value="Submit Review">
            </form>
            <?php
                if(isSet($_SESSION["userid"])&&isSet($_GET["id"])) {
                    echo
                        "<script>",
                            "document.getElementById('submit').style.display = '';",
                        "</script>";
                    if(isSet($_POST["review"])) {
                        $stmt = $pdo->prepare("INSERT INTO tbl_reviews (user_id, product_id, review_title, review_desc, review_rating)
                        VALUES (:user_id, :product_id, :review_title, :review_desc, :review_rating)");
                        $stmt->bindParam(":user_id", $_SESSION["userid"]);
                        $stmt->bindParam(":product_id", $_GET["id"]);
                        $stmt->bindParam(":review_title", $_POST["title"]);
                        $stmt->bindParam(":review_desc", $_POST["review"]);
                        $stmt->bindParam(":review_rating", $_POST["rating"]);
                        $stmt->execute();
                        header("Refresh:0");
                    }
                }
            ?>
            <table id="existing_reviews">
                <?php
                    $stmt = $pdo->prepare("SELECT * FROM tbl_reviews WHERE product_id = :_product_id");
                    $stmt->bindParam(":_product_id", $_GET["id"]);
                    $stmt->execute();
                    if($stmt->rowCount() > 0) {
                        echo "<div id='average'>Average Rating:</div>";
                        echo "<br/>";
                        echo
                            "<tr>",
                                "<th>Review Title</th>",
                                "<th>Review Description</th>",
                                "<th>Rating</th>",
                                "<th>Time of Submission</th>",
                            "</tr>";
                        $total = 0;
                        $count = 0;
                        while($row = $stmt->fetch()) {
                            $rating = intval($row["review_rating"]);
                            $ratingComment = "";
                            if($rating == 1) {
                                $ratingComment = "Bad Quality.";
                            }
                            else if($rating == 2) {
                                $ratingComment = "Mediocre Quality.";
                            }
                            else if($rating == 3) {
                                $ratingComment = "Average Quality.";
                            }
                            else if($rating == 4) {
                                $ratingComment = "Good Quality.";
                            }
                            else if($rating == 5) {
                                $ratingComment = "Excellent Quality.";
                            }
                            echo
                                "<tr>",
                                    "<td>",$row["review_title"],"</td>",
                                    "<td><p>",$row["review_desc"],"</p></td>",
                                    "<td>",$ratingComment,"</td>",
                                    "<td>",$row["review_timestamp"],"</td>",
                                "<tr>";
                            $total+=$rating;
                            $count++;
                        }
                        $average = intval($total/$count);
                        $averageComment = "";
                        if($average == 1) {
                            $averageComment = "Bad Quality.";
                        }
                        else if($average == 2) {
                            $averageComment = "Mediocre Quality.";
                        }
                        else if($average == 3) {
                            $averageComment = "Average Quality.";
                        }
                        else if($average == 4) {
                            $averageComment = "Good Quality.";
                        }
                        else if($average == 5) {
                            $averageComment = "Excellent Quality.";
                        }
                        echo
                            "<script type='text/javascript'>",
                                "document.getElementById('average').innerText +=' ",$averageComment,"';",
                            "</script>";
                    }
                    else
                        echo "<tr><td>No reviews yet</td></tr>";
                ?>
            </table>
        </div>
    </main>
    <?php
        if(isSet($_SESSION["userid"])){
            echo "<script type='text/javascript' src='addToCartSession.js'></script>";
        }
        else{
            echo "<script type='text/javascript' src='addToCart.js'></script>";
        }
        check();
        include "footer.php";
    ?>
</body>
</html>