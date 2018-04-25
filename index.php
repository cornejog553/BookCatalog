<!DOCTYPE html>

<html>
    <head>
        <link href="main.css" type="text/css" rel="stylesheet">
        <meta charset="UTF-8">
        <title>Book Catalog</title>
    </head>
    <body>

        <?php
     $dsn = 'mysql:host=localhost;dbname=bookcatalog';
     $username = 'php';
     $password = 'php';

// Create connection
$db = new PDO($dsn, $username, $password);

//Creating limit on data shown
$limit = 6;
$query = "SELECT * FROM coursebook";

$s = $db->prepare($query);
$s->execute();
$total_results = $s->rowCount();
$total_pages = ceil($total_results/$limit);

if (!isset($_GET['page'])) {
    $page = 1;
} else{
    $page = $_GET['page'];
}

//Getting Course information
$starting_limit = ($page-1)*$limit;
$show = "SELECT course.courseID, course.courseTitle, course.credit, coursebook.book, book.bookTitle, book.price
FROM ((course
INNER JOIN coursebook ON course.courseID = coursebook.course)
INNER JOIN book ON coursebook.book = book.isbn13)LIMIT $starting_limit, $limit";

//Setting Order of data
if(isset($_GET['order'])){
$order = $_GET['order'];    
}else{
    $order = "";
}

if ( $order == 'courseID' ) {
$show = "SELECT course.courseID, course.courseTitle, course.credit, coursebook.book, book.bookTitle, book.price
FROM ((course
INNER JOIN coursebook ON course.courseID = coursebook.course)
INNER JOIN book ON coursebook.book = book.isbn13)ORDER BY courseID LIMIT $starting_limit, $limit"; ;
}
else if ( $order == 'price' ) {
$show = "SELECT course.courseID, course.courseTitle, course.credit, coursebook.book, book.bookTitle, book.price
FROM ((course
INNER JOIN coursebook ON course.courseID = coursebook.course)
INNER JOIN book ON coursebook.book = book.isbn13)ORDER BY price LIMIT $starting_limit, $limit"; ;;
}

//Running Query
$r = $db->prepare($show);
$r->execute();

?>
<!-- Displaying Headers -->
<table>
    <th><a href="index.php?order=courseID">Course #</a></th>
    <th>Course Title</th>
    <th>Book Image</th>
    <th>Book Title</th>
    <th><a href="index.php?order=price">Price</a></th>


<?php 
//Displaying Data
while($res = $r->fetch(PDO::FETCH_ASSOC)):
?>
<tr>
    <td><?php echo ' <a href="https://www.cpp.edu/~cba/computer-information-systems/curriculum/quarter-courses.shtml">'. $res['courseID'] . '</a>'; ?></td>
    <td><?php echo $res['courseTitle']; ?>
    <?php echo "("; ?>
    <?php echo $res['credit']; ?>
    <?php echo ")"; ?> </td>
    <td><?php echo '<a href="book.php?book=' . $res['book'] .  '"><img src = "images/' . $res['book'] . '.jpg"/></a>'; ?></td>
    <td><?php echo $res['bookTitle']; ?></td>
    <td><?php echo $res['price']; ?></td>
</tr>

<?php
endwhile;?>
</table>

<!-- Pagination -->
<?php for ($page=1; $page <= $total_pages ; $page++):?>

<a href='<?php echo "?page=$page&order=$order"; ?>' class="links"><?php  echo $page; ?>
 </a>

<?php endfor; ?>

    </body>
</html>
