<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Reading existing passwords and encrypting
  $existingPasswords = readPasswords('passwords.txt');
  // Reading user's encrypted passwords
  $userPasswords = readUsers('users.csv');
  // Creating hashes before comparing.
  $hashedExistingPasswords = creatingHashes($existingPasswords);
  // Comparing passwords
  comparingPasswords($userPasswords, $hashedExistingPasswords);
}

function creatingHashes($existingPasswords) {
  $hashesArray = array();
  // 1 word password
  foreach ($existingPasswords as $existingPassword1) {
    $hashedPassword = hash('sha256', $existingPassword1);
    // Adding 1 word password to array
    array_push($hashesArray, trim($hashedPassword));
    // 2 word password
    foreach ($existingPasswords as $existingPassword2) {
      $combinedPassword1 = $existingPassword1 . $existingPassword2;
      $hashedPassword2 = hash('sha256', $combinedPassword1);
      // Adding 2 words password to array
      array_push($hashesArray, trim($hashedPassword2));
      // 3 word password
      foreach ($existingPasswords as $existingPassword3) {
        $combinedPassword2 = $existingPassword1 . $existingPassword2 . $existingPassword3;
        $hashedPassword3 = hash('sha256', $combinedPassword2);
        // Adding 2 words password to array
        array_push($hashesArray, trim($hashedPassword3));
      }
    }
  }
  return $hashesArray;
}

function readPasswords($fileName) {
  $passwords = array();
  
  // Comprobar si el archivo existe
  if (!file_exists($fileName)) {
      throw new Exception("El archivo no existe");
  }

  // Comprobar si el archivo se puede abrir
  if (!is_readable($fileName)) {
      throw new Exception("El archivo no se puede leer");
  }

  // Abre el archivo TXT
  $file = fopen($fileName, "r");
  
  // Itera por todas las líneas del archivo
  while (($linea = fgets($file)) !== false) {
      // Agrega al arreglo la palabras
      array_push($passwords, trim($linea));
  }

  // Cierra el archivo TXT
  fclose($file);

  return $passwords;
}

function readUsers($fileName) {
  // Open the CSV file for reading
  $fileOpened = fopen($fileName, 'r');

  // Check if the file was successfully opened
  if ($fileOpened !== false) {
      // Initialize an empty array to store the passwords
      $passwords = array();

      // Read each line of the CSV file
      while (($data = fgetcsv($fileOpened)) !== false) {
          if(count($data) >= 2){
              $username = $data[0];
              array_push($passwords, trim($data[1]));
          }
      }
      // Close the CSV file
      fclose($fileOpened);
    } else {
      echo 'Archivo no se ha podido abrir';
    }
    return $passwords;
}

function comparingPasswords($userPasswords, $hashedExistingPasswords) {
  echo '<h4>Comparando hashes:<h4>';
  // Iterating through user passwords
  foreach ($userPasswords as $userPassword) {
    foreach ($hashedExistingPasswords as $hashedPassword) {
      // Check the flag after the inner loop
      if ($hashedPassword == $userPassword) {
        echo 'Exito: ' . $hashedPassword . ' == ' . $userPassword . '<br>';
      }
    }
  }
}

?>
