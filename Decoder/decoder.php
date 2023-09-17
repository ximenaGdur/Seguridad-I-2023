<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Reading existing passwords and encrypting
  $existingPasswords = readPasswords('passwordsShort.txt');
  // Reading user's encrypted passwords
  $userPasswords = readUsers('users.csv');
  // Comparing passwords
  comparingPasswords($userPasswords, $existingPasswords);
}

function readPasswords($fileName) {
  $encriptedPasswords = array();
  
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
      // Agrega al arreglo la palabra
      array_push($passwords, $encriptedPasswords);
      echo $linea;
  }

  // Cierra el archivo TXT
  fclose($file);

  return $encriptedPasswords;
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
              array_push($passwords, $data[1]);

              echo 'Usuario: $username, Contraseña: $passwords<br>';
          }
      }
      // Close the CSV file
      fclose($fileOpened);
    } else {
        echo 'Arhivo no se ha podido abrir';
    }
    return $passwords;
}

function comparingPasswords($userPasswords, $existingPasswords) {
  // Iterating through user passwords
  foreach ($userPasswords as &$userPassword) {
    // Flag to check if the password was found
    $passwordFound = false;

    // 1 word password
    foreach ($existingPasswords as $existingPassword1) {
      $hashedPassword = hash('sha256', $existingPassword1);
      if ($userPassword == $hashedPassword) {
        $passwordFound = true;
        break;
      } else {
        // 2 word password
        foreach ($existingPasswords as $existingPassword2) {
          $combinedPassword1 = $existingPassword1 . $existingPassword2;
          $hashedPassword2 = hash('sha256', $combinedPassword1);
          if ($userPassword == $hashedPassword2) {
            $passwordFound = true;
            break 2;
          } else {
            // 3 word password
            foreach ($existingPasswords as $existingPassword3) {
              $combinedPassword2 = $existingPassword1 . $existingPassword2 . $existingPassword3;
              $hashedPassword3 = hash('sha256', $combinedPassword2);
              if ($userPassword == $hashedPassword3) {
                $passwordFound = true;
                break 3;
              }
            }
          }
        }
      }
    }
    // Check the flag after the inner loop
    if ($passwordFound) {
      echo 'EXITO';
    } else {
      echo 'FALLO';
    }
  }
}
?>
