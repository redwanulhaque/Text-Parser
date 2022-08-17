<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="ParseReport.css">
    <title>Parsed Record Data</title>
</head>

<body>
    <h1> Parsed Data Record </h1>
    <?php
    $servername = "mars.cs.qc.cuny.edu";
    $username = "hare4344";
    $password = "23874344";
    $dbname = "hare4344";

    // create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    ?>

    <table border='1' width='90%' align='center' style='margin-top: 40px'>
        <tr>
            <th id="a"> Source ID </th>
            <th id="b"> Source Name </th>
            <th id="c"> Source Url </th>
            <th id="d"> Source Begin </th>
            <th id="e"> Source End </th>
            <th id="f"> Parsed DTM </th>
            <th id="g" width='8%'> Word </th>
        </tr>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM source");

        while($row = mysqli_fetch_array($query))
        {
            ?>
            <tr>
                <td><?php echo $row["source_id"]; ?></td>
                <td><?php echo $row["source_name"]; ?></td>
                <td><?php echo $row["source_url"]; ?></td>
                <td><?php echo $row["source_begin"]; ?></td>
                <td><?php echo $row["source_end"]; ?></td>
                <td><?php echo $row["parsed_dtm"]; ?></td>
                <td><a href="WordCount.php?source_id=<?php echo $row["source_id"]; ?>">LINK</a></td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>
