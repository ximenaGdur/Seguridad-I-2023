<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo 'Probando...';
    // Open the CSV file for reading
    /*
    $fileName = $_POST["fileName"];
    $fileOpened = fopen($fileName, 'r');

    // Check if the file was successfully opened
    if ($fileOpened !== false) {
        // Initialize an empty array to store the passwords
        $passwords = [];

        // Read each line of the CSV file
        while (($data = fgetcsv($fileOpened)) !== false) {
            if(count($data) >= 2){
                $username = $data[0]
                
            }
        }

        // Close the CSV file
        fclose($fileOpened);

        // Display the CSV data
        echo '<pre>';
        print_r($csvData);
        echo '</pre>';
      */
}

// function readTxt($txtFile){
//     // Abre el archivo TXT
//     $archivo = fopen($txtFile, "r");
//     // Itera por todas las líneas del archivo
//     foreach ($archivo as $linea) {
//     // Imprime la línea del archivo
//     echo $linea;
//     }
//     // Cierra el archivo TXT
//     fclose($archivo);
//}

?>
