<?php
require "config.php";
echo "EXCEL";
// include the autoloader, so we can use PhpSpreadsheet
require_once('/var/www/html/mpls/vendor/autoload.php');

# Create a new Xls Reader
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

// Tell the reader to only read the data. Ignore formatting etc.
$reader->setReadDataOnly(true);

// Read the spreadsheet file.
$spreadsheet = $reader->load(__DIR__ . '/table2.xlsx');

$sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
$data = $sheet->toArray();
#print_r($data);

for ($i=0; $i<count($data); $i++) {
    $q_id=$data[$i][0];
    $answer_id=$data[$i][1];
    $answer=$data[$i][2];
    $correct_bit=$data[$i][3];
    echo $q_id." ".$answer."<br>";
    $conn->query("INSERT into answers (question_id, answer_id, answer, correct) VALUES ('$q_id', '$answer_id', '$answer', '$correct_bit')");
}

?>
