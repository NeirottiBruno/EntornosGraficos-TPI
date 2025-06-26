<?php
include('../componentes/encabezado.php');
include('../../Backend/bd.php');
?>
    <head>
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color:rgb(81, 81, 79);
      color: white;
      margin: 0;
      padding: 20px;
    }

    .contenedor_cont {
      display: flex;
      gap: 20px;
      margin: 100
    }

    .izquierda_cont p {
      margin-bottom: 10px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .fila_cont {
      display: flex;
      gap: 10px;
    }

    input, textarea {
      padding: 10px;
      border: none;
      width: 100%;
      box-sizing: border-box;
    }

    textarea {
      height: 100px;
    }

    .checkbox-container {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .redes img {
      width: 30px;
      margin-right: 10px;
    }
  </style>
    </head>
    <body>

    <div class="contenedor_cont">
    <div class="izquierda_cont">
      <p><strong>Av. Zeballos 1133 </strong><br>Rosario, Santa Fe, Argentina</p>
      <p>administracion@plazashoppingrosario.com</p>
      <p><strong>Seguinos en nuestras Redes Sociales</strong></p>
      <div class="redes">
        <img src="../assets/imagen/inst.png" alt="Instagram">
        <img src="../assets/imagen/face.png" alt="Facebook">
      </div>
    </div>
   
      <form action="enviar.php" method="post">
        <div class="fila_cont">
          <input type="text" placeholder="Nombre">
          <input type="text" placeholder="Apellido">
        </div>
        <div class="fila_cont">
          <input type="email" placeholder="Email">
          <input type="tel" placeholder="Teléfono">
        </div>
        <textarea placeholder="Mensaje"></textarea>

        <div class="checkbox-container">
          <input class="form-check-input"  type="checkbox" id="newsletter">
          <label for="newsletter">Quiero suscribirme al newsletter</label>
        </div>

        <button type="submit" class="btn btn-dark btn-sm mt-3 w-100">Enviar</button>
      </form>
    
  </div>
    </body>
<?php include '../componentes/pie.php'; ?>