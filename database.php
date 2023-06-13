<?php

// CSCI 355/655
// Summer 2022
// Final Project
// Redwanul Haque


// user information
$servername = "";
$username = "";
$password = "";
$dbname = "";


// create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Inserting the form into source database
$source_name = $_REQUEST['source_name'];
$source_url = $_REQUEST['source_url'];
$source_begin = $_REQUEST['source_begin'];
$source_end = $_REQUEST['source_end'];

$sql = "INSERT INTO source (source_name,source_url,source_begin, source_end)
    VALUES ('$source_name','$source_url','$source_begin','$source_end')";

mysqli_query($conn, $sql);


$sql = "SELECT source_id FROM source";
$resultttt = $conn->query($sql);

$source_idd = array();
if ($resultttt->num_rows > 0) {
    while($row = $resultttt->fetch_assoc()) {
         $source_idd = $row["source_id"];
    }
} else {
    echo "0 results";
}


//getting data from the website
$file = file_get_contents($source_url);

$dom = new domDocument();
$paragraphs = array();
@$dom->loadHTML($file);

foreach($dom->getElementsByTagName('p') as $node) {
    $node->nodeValue = strtoupper($node->nodeValue);
    $node->nodeValue = preg_replace('/[^a-z0-9]+/i', ' ', $node->nodeValue);
    $paragraphs = $node->nodeValue;
}

$data = array();
$data = explode(" ", $paragraphs);

$source_begin = strtoupper($source_begin);
$source_end = strtoupper($source_end);

if($source_begin == "" && $source_end == "" || $source_begin != "" && $source_end == "" || $source_begin == "" && $source_end != "") {

    if ($source_begin == "") {
        $input = 0;
    } else {
        $input = array_search($source_begin, $data);
    }

    if ($source_end == "") {
        $end = end($data);
        $output = array_search($end, $data);
    } else {
        $output = array_search($source_end, $data);
    }

    $arraytotal = array();
    $slice = array_slice($data, $input, $output);
    $arraytotal = array_count_values($slice);
    arsort($arraytotal);

    foreach ($arraytotal as $x => $x_value) {
        //Inserting the word into word database
        $sql = "INSERT INTO occurrence (source_id, word, freq) VALUES ('$source_idd' , '$x', '$x_value')";
        mysqli_query($conn, $sql);
    }
}

elseif($source_begin != "" && $source_end != "") {

    $input = array_search($source_begin, $data);

    $output = array_search($source_end, $data);


    $arraytotal = array();
    $slicefirst = array_slice($data, $input, $output);
    $output = array_search($source_end, $slicefirst);
    $slicesecond = array_slice($slicefirst, 0, $output+1);
    $arraytotal = array_count_values($slicesecond);
    arsort($arraytotal);

    foreach ($arraytotal as $x => $x_value) {
        //Inserting the word into word database
        $sql = "INSERT INTO occurrence (source_id, word, freq) VALUES ('$source_idd' , '$x', '$x_value')";
        mysqli_query($conn, $sql);
    }
}

$success = "<h1 align='center' style='color:#000000; line-height: -100px; margin-top: 350px; font-size: 60px;'> Data Added Successfully! </h1>";
echo $success;

$aftermessage = "<h1 align='center' style='color:#000000; line-height: -100px; margin-top: 80px; font-size: 60px;'> Check Report </h1>";
echo $aftermessage;


mysqli_close($conn);

?>






