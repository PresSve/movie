<?php

require_once 'header.php';

$genres =[];

$sql = "SELECT
        `id`,
        `name`
        FROM `".TABLE_GENRES."`
        WHERE 1
";

$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
        while ($row = mysqli_fetch_assoc($result)) {
            $genres[] = $row;
        }
$count = count($genres);

$qualitySel = ['SD', 'HD', 'FullHD', 'UltraHD'];
$countQuality = count($qualitySel);

$name = '';
$year = '';
$country = '';



if (isset($_POST['submit'])) {
    $errors = [];
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $genreId = isset($_POST['genre_id']) ? (int)($_POST['genre_id']) : 0;
    $summary = isset($_POST['summary']) ? trim($_POST['summary']) : '';
    $year = isset($_POST['year']) ? (int)($_POST['year']) : 0;
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';
    $duration = isset($_POST['duration']) ? (int)($_POST['duration']) : 0;
    $image = 'none';
    $quality = isset($_POST['quality']) ? trim($_POST['quality']) : '';
    $rating = isset($_POST['rating']) ? (int)($_POST['rating']) : 0;
    p($quality);
    if ($name) {
        $sql = "SELECT
            `id`,
            `name`
            FROM `".TABLE_MOVIES."`
            WHERE `name` = '".mysqli_real_escape_string($conn, $name)."'
        ";
        $result = (mysqli_query($conn, $sql));
        if (mysqli_num_rows($result)) {
        $errors[] = 'Movie exist in database';
        }
    }else {
        $errors[] = 'Please enter movie name';
    }

    if ($genreId <= 0) {
        $errors[] = 'Please select genre';
    }elseif ($genreId > $count) {
        $errors[] = 'Incorrect genre';
    }

    if (!$summary) {
        $errors[] = 'Please enter summary';
    }elseif (mb_strlen($summary) < 10) {
        $errors[] = "Summary must be more than 10 symbols";
    }elseif (mb_strlen($summary) > 250) {
        $errors[] = "Summary must be less than 250 symbols";
    }

    $valYear = mb_strlen((string)$year);
    if (!$year) {
        $errors[] = 'Please enter year';
    }elseif ($year > date('Y',time())) {
        $errors[] = "Incorrenct year";
    }elseif ($valYear < 4 || $valYear >4) {
        $errors[] = "Year must be 4 digits";
    }


    if (!$country) {
        $errors[] = 'Please enter country';
    }elseif (mb_strlen($country) < 2) {
        $errors[] = "Country must be more than 2 symbols";
    }elseif (mb_strlen($country) > 20) {
        $errors[] = "Country must be less than 20 symbols";
    }

    if (!$duration) {
        $errors[] = 'Please enter duration';
    }elseif ($duration < 40) {
        $errors[] = "Country must be more than 40 minutes";
    }elseif ($duration > 250) {
        $errors[] = "Country must be less than 250 minutes";
    }

    if (!$quality) {
        $errors[] = 'Please select quality';
    }

    if (!$rating) {
        $errors[] = 'Please select rating';
    }elseif ($rating < 0 || $rating > 10) {
        $errors[] = 'Incorrenct rating';
    }

    if (!count($errors)) {
        $sql = "INSERT INTO `".TABLE_MOVIES."`(
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
                      )VALUES(
                        '".mysqli_real_escape_string($conn, $genreId)."',
                        '".mysqli_real_escape_string($conn, $name)."',
                        '".mysqli_real_escape_string($conn, $summary)."',
                        '".mysqli_real_escape_string($conn, $year)."',
                        '".mysqli_real_escape_string($conn, $country)."',
                        '".mysqli_real_escape_string($conn, $duration)."',
                        '".mysqli_real_escape_string($conn, $image)."',
                        '".mysqli_real_escape_string($conn, $quality)."',
                        '".mysqli_real_escape_string($conn, $rating)."',
                        NOW(),
                        NOW()
                      )
        ";
        if (mysqli_query($conn, $sql)) {
            echo 'Successfully added';
        }else {
            $errors[] = 'Somethin gone wrong';
        }
    }
}


?>

<div class="container-fluid">
    <form action="" method="post">
        <select name="genre_id" id="">
            <option value="none" selected disabled hidden>Select genre</option> 
        <?php for ($i=0; $i < $count; $i++):?>
           <option value=<?=$genres[$i]['id']?>><?=$genres[$i]['name']?></option> 
        <?php endfor?>
        </select>
        <br>
        <br>
        <input type="text" name="name" placeholder="Name" value="<?=$name?>">
        <br>
        <br>
        <textarea name="summary" id="" cols="100" rows="5" placeholder="Summary" value="<?=$summary?>"></textarea>
        <br>
        <br>
        <input type="text" name="year" placeholder="Year" value="<?=$year?>">
        <br> 
        <br>
        <input type="text" name="country" placeholder="Country" value="<?=$country?>">
        <br>
        <br>
        <input type="number" name="duration" placeholder="Duration" value="<?=$duration?>">
        <span >Min</span>
        <br>
        <br>
        <input type="text" name="image" placeholder="Image">
        <br>
        <br>
        <select name="quality">
            <option value="none" selected disabled hidden>Select quality</option> 
            <?php for ($i=0; $i < $countQuality; $i++):?>
                <option value=<?=$qualitySel[$i]?>><?=$qualitySel[$i]?></option> 
            <?php endfor?>
        </select>
        <br>
        <br>
        <select name="rating">
            <option value="none" selected disabled hidden>Select rating</option> 
            <?php for ($i=0; $i <= 10; $i++):?>
                <option value=<?=$i?>><?=$i?></option> 
            <?php endfor?>
        </select>
        <br>
        <br>
        <input type="submit" value="Add" name="submit">


        <div class="alert alert-danger">
            <ul>
                <?php if(isset($errors) && count($errors)):?>
                    <?php for ($i=0; $i < count($errors); $i++):?>
                    <li><?=$errors["$i"]?></li>
                    <?php endfor?>
                <?php endif?>
            </ul>
        </div>
    </form>
</div>



<?php

require_once 'footer.php';

?>