<?php
require_once 'header.php';

$sql = "SELECT
          `id`,
          `genre_id`,
          `name`,
          `summary`,
          `year`,
          `country`,
          `duration`,
          `image`,
          `quality`,
          `rating`,
          `added`,
          `modified`
          FROM `".TABLE_MOVIES."`
          WHERE 1
";

$movies = [];

$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
        while ($row = mysqli_fetch_assoc($result)) {
            $movies[] = $row;
        }
$count = count($movies);

?>

<div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Movies list
            <button><a href="movies_add.php">Add movie</a></button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <form action="" method="get">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Genre Id</th>
                      <th>Name</th>
                      <th>Summary</th>
                      <th>Year</th>
                      <th>Country</th>
                      <th>Duration</th>
                      <th>Image</th>
                      <th>Quality</th>
                      <th>Rating</th>
                      <th>Added</th>
                      <th>Modified</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Genre Id</th>
                        <th>Name</th>
                        <th>Summary</th>
                        <th>Year</th>
                        <th>Country</th>
                        <th>Duration</th>
                        <th>Image</th>
                        <th>Quality</th>
                        <th>Rating</th>
                        <th>Added</th>
                        <th>Modified</th>
                        <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php for ($i=0; $i < $count; $i++):?>
                      <tr>
                        <td><?=$movies[$i]['id']?></td>
                        <td><?=$movies[$i]['genre_id']?></td>
                        <td><?=$movies[$i]['name']?></td>
                        <td><?=$movies[$i]['summary']?></td>
                        <td><?=$movies[$i]['year']?></td>
                        <td><?=$movies[$i]['country']?></td>
                        <td><?=$movies[$i]['duration']?></td>
                        <td><?=$movies[$i]['image']?></td>
                        <td><?=$movies[$i]['quality']?></td>
                        <td><?=$movies[$i]['rating']?></td>
                        <td><?=$movies[$i]['added']?></td>
                        <td><?=$movies[$i]['modified']?></td>
                        <td>
                          <a href="movies_edit.php?id=<?php echo $movies[$i]['id']; ?>">Edit</a>
                          <a href="movies_delete.php?id=<?php echo $movies[$i]['id']; ?>" onClick="return confirm('Are you sure you want to delete?')">Delete</a>
                        </td>
                      </tr>
                    <?php endfor?>
                  </tbody>
                </table>
              </form>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

      </div>
      <!-- /.container-fluid -->


<?php
require_once 'footer.php';
?>