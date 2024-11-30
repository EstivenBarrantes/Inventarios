<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link rel="preload" href="css/normalize.css" as="style">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/inicio.css" as="style">
    <link href="css/inicio.css" rel="stylesheet">
</head>

<body>
    <header>
        <h1 class="titulo">logistics software <span>somos la solución</span></h1>
    </header>

    <div class="nav-bg">
        <nav class="navegación-principal  contenedor">
            <a href="../LOGINPORROLESY/index.php">Inicio sesion</a>
            <a href="../LOGINPORROLESY/inicio.php">Inicio</a>
            <a href="../LOGINPORROLESY/nosotros.php">Nosotros</a>
            <a href="../LOGINPORROLESY/contacto.php">Contactos</a>
        </nav>
    </div>

    <section>
        <h2> Contacto</h2>

        <form class="formulario">
            <fieldset>

                <legend>Contactanós llenando todos los campos</legend>
                <div class="contenedor-campos">
                    <div class="campo">

                        <label>Nombres</label>
                        <input class="input-text" type="text" placeholder="Tu Nombre">

                    </div>

                    <div class="campo">

                        <label>Teléfono</label>
                        <input class="input-text" type="tel" placeholder="Tu Teléfono">

                    </div>

                    <div class="campo">

                        <label>Correo</label>
                        <input class="input-text" type="email" placeholder="Tu Correo">

                    </div>

                    <div class="campo">

                        <label>Mensaje</label>
                        <textarea class="input-text"></textarea>

                    </div>
                </div><!--contenedor-campos-->

                <div class="alinear-derecha flex">

                    <input class="boton w-sm-100" type="submit" value="Enviar">

                </div>

            </fieldset>
        </form>
    </section>
    </main>

    <footer class="footer">
        <P>Todos los derechos reservados. Estiven Barrantes freelancer</P>
    </footer>


</body>

</html>