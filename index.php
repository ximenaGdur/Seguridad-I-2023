<!DOCTYPE html>
<html lang="en">

<head></head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
  <title>Registro de usuarios</title>
</head>

<body>
  <main>
    <form action="login.php" method="post">
      <h1>Ingrese los siguientes datos:</h1>
      <div>
        <label for="email">Usuario:</label>
        <input type="email" name="email" id="email">
      </div>
      <div>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password">
      </div>
      <button type="submit">Registrar</button>
    </form>
  </main>
</body>

</html>
