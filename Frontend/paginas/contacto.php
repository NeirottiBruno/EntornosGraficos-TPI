<?php include('../componentes/encabezado.php'); ?>

<!-- Banner -->
<section class="position-relative" style="height: 420px; overflow: hidden;">
    <img src="../assets/imagen/banner.jpg" class="d-block w-100 h-100" alt="Banner principal" style="object-fit: cover; filter: brightness(0.7);">
    <div class="position-absolute top-50 start-50 translate-middle text-white text-center" style="padding: 2.5rem 2rem; border-radius: 1.5rem; width: 90%; max-width: 700px;">
        <h1 class="display-2 fw-bold mb-3" style="text-shadow: 2px 2px 8px #222; overflow: hidden;">Contacto</h1>
    </div>
</section>

<!-- Formulario + Datos -->
<section class="container my-5">
    <div class="row">
        <!-- Datos de contacto -->
        <div class="col-md-6 mb-4">
            <h2>Nuestros Datos</h2>
            <p><strong>Dirección:</strong> San Luis 1234, Rosario, Santa Fe</p>
            <p><strong>Teléfono:</strong> +54 341 123-4567</p>
            <p><strong>Email:</strong> contacto@plazashopping.com.ar</p>
            <p><strong>Horario:</strong> Lunes a Domingos de 10:00 a 22:00 hs</p>
        </div>

        <!-- Formulario -->
        <div class="col-md-6">
            <h2>Envianos tu consulta...</h2>
            <form action="../../Backend/enviarMail.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre y Apellido" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <textarea name="mensaje" rows="5" class="form-control" placeholder="Mensaje o consulta..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</section>

<!-- Mapa Google Maps -->
<section class="container-fluid p-0">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26785.77062545234!2d-60.681763919906345!3d-32.94516549056678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95b7ab10c3a2cb0f%3A0x5d19f654fdac9e11!2sGALERIA%20PLAZA%20SARMIENTO!5e0!3m2!1ses!2ar!4v1750107627898!5m2!1ses!2ar"
        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
    </iframe>
</section>

<?php include('../componentes/pie.php'); ?>
