<!DOCTYPE html>

<html>
    <head>
        <link href="bookstyle.css" type="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title>Book Information</title>
    </head>
    <body>

<?php
$dsn = 'mysql:host=localhost;dbname=bookcatalog';
     $username = 'php';
     $password = 'php';

// Create connection
$db = new PDO($dsn, $username, $password);

if(isset($_GET['book'])){
$book = $_GET['book'];    
}else{
    $order = "";
}

$showBook = "SELECT *
FROM (((((course
INNER JOIN coursebook ON course.courseID = coursebook.course)
INNER JOIN book ON coursebook.book = book.isbn13)
INNER JOIN publisher ON book.publisher = publisher.publisherID)
INNER JOIN authorbook ON book.isbn13 = authorbook.book)
INNER JOIN author ON author.authorID = authorbook.author)
WHERE coursebook.book = $book";

//Running Query
$rbook = $db->prepare($showBook);
$rbook->bindValue($book, $book);
$rbook->execute();

$bookinfo = $rbook->fetch();
$rbook->closeCursor();

$courseTitle = $bookinfo['courseTitle'];
$credit = $bookinfo['credit'];
$bookTitle = $bookinfo['bookTitle'];
$price = $bookinfo['price'];
$firstName = $bookinfo['firstName'];
$lastName = $bookinfo['lastName'];
$publisher = $bookinfo['publisher'];
$edition = $bookinfo['edition'];
$length = $bookinfo['length'];
$description = $bookinfo['description'];
$publishDate = $bookinfo['publishDate'];



?>

  
  <table>
    <tr id="first">
        <td id="image"><?php echo '<img src = "images/' . $book . '.jpg"></a>'; ?></td>
        <td id = "info"><?php echo "For Course: " .  $courseTitle . "(" . $credit . ")"; 
        echo "<br> Book Title: " .  $bookTitle;
        echo "<br> Price: " .  $price;
        echo "<br> Authors: " .  $firstName . " " . $lastName;
        echo "<br> Publisher: " .  $publisher;
        echo "<br> Edition: " .  $edition . "edition (" . $publishDate . ")" ;
        echo "<br> Length: " .  $length;
        echo "<br> ISBN-13: " .  $book;?></td>
    </tr>
    <tr id="desc"><td colspan="2"><?php echo "Product Description: <br>" .  $description;?></td></tr>
   
</table>
    </body> 
</html>

