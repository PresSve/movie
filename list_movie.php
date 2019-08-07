<?php 
require_once '../config/db.php' ;
require_once '../config/tables.php' ;
session_start();
if(!isset($_SESSION['user']) ||  $_SESSION['user']['type'] !== 'admin' ) {
 header ('Location : login.php');
}

 $sql = "SELECT
          m. `name`,
          g. `name` AS 'ganre' ,
          m. `summ`,
          m. `year`,
          m. `country`,
          m. `duration`,
          m. `image`,
          m. `rating`,
          m. `quality`
        FROM `".TABLE_MOVIES."`  m 
        LEFT JOIN `".TABLE_GENRE."` g ON
        m.`genre_id` = g.`id`
 ";
 $movies = [];
   if ($result = mysqli_query( $conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $movies[]= $row;
        }
   }
// showResult($movies);
 function showResult($data){
      echo "<pre>";
      print_r($data);
      echo "</pre>";
 }
?>

 <html>
   <head>
   </head>
     <body>
          <table border="1">
            <tr>
                <th>NAME</th>
                <th>GANRE</th>
                <th>SUMM</th>
                <th>YEAR</th>
                <th>COUNTRY</th>
                <th>DURATION</th>
                <th>IMAGE</th>
                <th>RATING</th>
                <th>QUALITY</th>
                <th>Action</th>
            </tr>
            <?php for($i = 0; $i < count($movies); $i++) : ?>
            <tr>
                <td><?=$movies[$i]['name']?></td>
                <td><?=$movies[$i]['name']?></td>
                <td><?=$movies[$i]['summ']?></td>
                <td><?=$movies[$i]['year']?></td>
                <td><?=$movies[$i]['country']?></td>
                <td><?=$movies[$i]['duration']?></td>
                <td><?=$movies[$i]['image']?></td>
                <td><?=$movies[$i]['rating']?></td>
                <td><?=$movies[$i]['quality']?></td>
                <td>
                  <a href="editmovies.php?id=<?=$movies[$i]['id']?>">Edit</a>
                </td>
            </tr>
            <?php endfor?>
          </table>

     </body>
 
 </html>