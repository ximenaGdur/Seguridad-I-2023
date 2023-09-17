<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Geting user input
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {
      // Encrypting password with SHA-256
      $hashedPassword = hash('sha256', $password);
      // Creating user string
      $userString = $username . ',' . $hashedPassword;

      // Saving to csv file
      saveCSV('users.csv', $userString);
    }
}

function saveCSV($fileName, $data){
    $file= fopen($fileName, 'a'); // 'a' for append mode
    if ($file=== false) {
        die('No se pudo abrir el archivo CSV para escritura.');
    }
    // Write the user data to the CSV file
    if (fwrite($file, $data . "\n") === false) {
      die('No se puede abrir el archivo.');
    }

    fclose($file);
    echo 'Los datos se han guardado correctamente en ' . $fileName;
}

?>
