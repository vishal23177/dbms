<?php
require 'vendor/autoload.php';


if (isset($_POST['export'])) {
    $conn = new mysqli('localhost', 'root', '', 'test');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM culturalsregisters";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the headers for the columns
        $headers = ['Event ID', 'Roll no', 'Name', 'Dept', 'Section', 'Year of Study', 'Phonenumber', 'Mail ID'];
        $columnIndex = 'A';

        foreach ($headers as $header) {
            $sheet->setCellValue($columnIndex . '1', $header);
            $columnIndex++;
        }

        // Fill the spreadsheet with data
        $rowNum = 2; // Starting row for data
        while ($row = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $rowNum, $row['eventid']);
            $sheet->setCellValue('B' . $rowNum, $row['rollno']);
            $sheet->setCellValue('C' . $rowNum, $row['name']);
            $sheet->setCellValue('D' . $rowNum, $row['dept']);
            $sheet->setCellValue('E' . $rowNum, $row['section']);
            $sheet->setCellValue('F' . $rowNum, $row['yearofstudy']);
            $sheet->setCellValue('G' . $rowNum, $row['phonenumber']);
            $sheet->setCellValue('H' . $rowNum, $row['mailid']);
            $rowNum++;
        }

        // Write the file to a specified directory on the server
        $writer = new Xlsx($spreadsheet);
        $filename = 'culturals_data.xlsx';
        $filepath = 'C:\\path\\to\\save\\' . $filename; // Update this path as per your requirement

        try {
            $writer->save($filepath);
            echo 'Data exported successfully to ' . $filepath;
        } catch (Exception $e) {
            echo 'Error saving the Excel file: ' . $e->getMessage();
        }

        exit;
    } else {
        echo 'No records found.';
    }

    $conn->close();
}
?>
