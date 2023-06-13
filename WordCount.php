<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="WordCount.css">
    <title>Word Count</title>
</head>

<body style='background: linear-gradient(#DAD4E4, #F0D6D3);'>

    <?php

    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";

    // create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $id = $_GET['source_id'];
    $query = mysqli_query($conn, "SELECT * FROM source where source_id = '$id'");

    $name = "";
    while($row = mysqli_fetch_array($query))
    {
        $name = '<h1>Source Name: ' . $row['source_name'] . '</h1>';
        echo $name;
    }


    ?>


    <div id="this-table">
        <table>
            <tr>
                <th> Word </th>
                <th> Frequency </th>
                <th> Percentage </th>
            </tr>

            <?php
            $id = $_GET['source_id'];
            $query = mysqli_query($conn, "SELECT * FROM occurrence where source_id = '$id'");

            $x = array();
            $sum = 0;
            while($row = mysqli_fetch_array($query))
            {
                $x[] = $row['freq'];
                $sum += $row['freq'];
            }

            $id = $_GET['source_id'];
            $query = mysqli_query($conn, "SELECT * FROM occurrence where source_id = '$id'");


            while($row = mysqli_fetch_array($query))
            {
                ?>
                <tr>
                    <td><?php echo $row["word"]; ?> </td>
                    <td><?php echo $row["freq"]; ?> </td>
                    <td><?php echo round(($row["freq"] / $sum) * 100, 2) . " %"; ?> </td>
                </tr>
                <?php
            }

            ?>
        </table>
    </div>
</body>
</html>
