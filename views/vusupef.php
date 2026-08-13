<?php

require_once("controllers/cusupef.php");

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Perfil | Urban Paws
    </title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

</head>


<body>


<header class="hero-section">

    <div class="container">


        <a
            href="vusupef.php"
            class="logo-container"
        >

            <div class="logo-text">

                <span class="brand">
                    Urban<span>Paws</span>
                </span>

                <span class="tagline">
                    Mi espacio personal
                </span>

            </div>

        </a>


        <nav>

            <ul class="nav-links">


                <li>

                    <a
                        href="vusucli.php"
                        class="nav-link"
                    >
                        Inicio
                    </a>

                </li>


                <li>

                    <a
                        href="vusupef.php"
                        class="nav-link active"
                    >
                        Perfil
                    </a>

                </li>


            </ul>

        </nav>


    </div>

</header>



<main class="container">


    <!-- =========================
         PERFIL
         ========================= -->

    <section style="padding: 3rem 0;">


        <div class="section-title">

            <div class="icon-circle">
                P
            </div>

            Perfil

        </div>



        <div class="card">


            <div class="form-grid">


                <!-- NOMBRE -->

                <div>

                    <span class="form-label">
                        Nombre completo
                    </span>


                    <p>

                        <?= isset($dtOn["prinom"])
                            ? $dtOn["prinom"]
                            : "" ?>


                        <?= isset($dtOn["seconom"])
                            ? " " . $dtOn["seconom"]
                            : "" ?>


                        <?= isset($dtOn["priapel"])
                            ? " " . $dtOn["priapel"]
                            : "" ?>

                    </p>

                </div>



                <!-- CORREO -->

                <div>

                    <span class="form-label">
                        Correo electrónico
                    </span>


                    <p>

                        <?= isset($dtOn["emailu"])
                            ? $dtOn["emailu"]
                            : "" ?>

                    </p>

                </div>



                <!-- DOCUMENTO -->

                <div>

                    <span class="form-label">
                        Documento
                    </span>


                    <p>

                        <?= isset($dtOn["docu"])
                            ? $dtOn["docu"]
                            : "" ?>

                    </p>

                </div>



                <!-- TELEFONO -->

                <div>

                    <span class="form-label">
                        Teléfono
                    </span>


                    <p>

                        <?= isset($dtOn["teleu"])
                            ? $dtOn["teleu"]
                            : "" ?>

                    </p>

                </div>



                <!-- PERFIL -->

                <div>

                    <span class="form-label">
                        Perfil de usuario
                    </span>


                    <p>

                        <?= isset($dtOn["nomperf"])
                            ? $dtOn["nomperf"]
                            : "" ?>

                    </p>

                </div>



                <!-- ESTADO -->

                <div>

                    <span class="form-label">
                        Estado de cuenta
                    </span>


                    <span class="badge badge-active">

                        <?= isset($dtOn["estusr"])
                            ? $dtOn["estusr"]
                            : "" ?>

                    </span>

                </div>


            </div>



            <div
                style="
                    margin-top: 2rem;
                    display: flex;
                    gap: 1rem;
                    flex-wrap: wrap;
                "
            >


                <a
                    href="#datos-personales"
                    class="btn btn-primary"
                >
                    Datos personales
                </a>


                <a
                    href="#configuracion"
                    class="btn btn-outline"
                >
                    Configuración
                </a>


            </div>


        </div>


    </section>



    <!-- =========================
         DATOS PERSONALES
         ========================= -->

    <section
        id="datos-personales"
        style="padding-bottom: 2rem;"
    >


        <div class="card">


            <h2>
                Datos personales
            </h2>


            <p>
                Actualiza la información personal asociada a tu cuenta.
            </p>



            <form
                action="vusupef.php?iduser=<?= $iduser ?>&ope=save"
                method="post"
                style="margin-top: 1.5rem;"
            >


                <!-- ID USUARIO -->

                <input
                    type="hidden"
                    name="iduser"
                    value="<?= $iduser ?>"
                >


                <!-- ID UBICACION -->

                <input
                    type="hidden"
                    name="idubi"
                    value="<?= isset($dtOn["idubi"])
                        ? $dtOn["idubi"]
                        : "" ?>"
                >



                <div class="form-grid">


                    <!-- NOMBRE -->

                    <div>

                        <label
                            for="nombre"
                            class="form-label"
                        >
                            Nombre
                        </label>


                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            class="input-control"
                            placeholder="Nombre"
                            value="<?= isset($dtOn["prinom"])
                                ? $dtOn["prinom"]
                                : "" ?>"
                        >

                    </div>



                    <!-- APELLIDO -->

                    <div>

                        <label
                            for="apellido"
                            class="form-label"
                        >
                            Apellido
                        </label>


                        <input
                            type="text"
                            id="apellido"
                            name="apellido"
                            class="input-control"
                            placeholder="Apellido"
                            value="<?= isset($dtOn["priapel"])
                                ? $dtOn["priapel"]
                                : "" ?>"
                        >

                    </div>



                    <!-- CORREO -->

                    <div>

                        <label
                            for="correo"
                            class="form-label"
                        >
                            Correo electrónico
                        </label>


                        <input
                            type="email"
                            id="correo"
                            name="correo"
                            class="input-control"
                            placeholder="Correo electrónico"
                            value="<?= isset($dtOn["emailu"])
                                ? $dtOn["emailu"]
                                : "" ?>"
                        >

                    </div>



                    <!-- TELEFONO -->

                    <div>

                        <label
                            for="telefono"
                            class="form-label"
                        >
                            Teléfono
                        </label>


                        <input
                            type="tel"
                            id="telefono"
                            name="telefono"
                            class="input-control"
                            placeholder="Teléfono"
                            value="<?= isset($dtOn["teleu"])
                                ? $dtOn["teleu"]
                                : "" ?>"
                        >

                    </div>



                    <!-- DIRECCION -->

                    <div>

                        <label
                            for="direccion"
                            class="form-label"
                        >
                            Dirección
                        </label>


                        <input
                            type="text"
                            id="direccion"
                            name="direccion"
                            class="input-control"
                            placeholder="Dirección"
                            value="<?= isset($dtOn["nomubi"])
                                ? $dtOn["nomubi"]
                                : "" ?>"
                        >

                    </div>



                    <!-- DEPARTAMENTO -->

                    <div>

                        <label
                            for="depaubi"
                            class="form-label"
                        >
                            Departamento
                        </label>


                        <input
                            type="text"
                            id="depaubi"
                            name="depaubi"
                            class="input-control"
                            placeholder="Departamento"
                            value="<?= isset($dtOn["depaubi"])
                                ? $dtOn["depaubi"]
                                : "" ?>"
                        >

                    </div>


                </div>



                <div style="margin-top: 1.5rem;">


                    <button
                        type="submit"
                        class="btn btn-accent"
                    >
                        Guardar cambios
                    </button>


                </div>


            </form>


        </div>


    </section>



    <!-- =========================
         CONFIGURACION
         ========================= -->

    <section
        id="configuracion"
        style="padding-bottom: 3rem;"
    >


        <div class="card">


            <h2>
                Configuración y seguridad
            </h2>


            <p>
                Administra las opciones relacionadas con tu cuenta.
            </p>



            <div
                class="form-grid"
                style="margin-top: 1.5rem;"
            >


                <div>

                    <h3>
                        Contraseña
                    </h3>


                    <p>
                        Actualiza la contraseña de acceso a tu cuenta.
                    </p>


                    <a
                        href="#"
                        class="btn btn-outline"
                    >
                        Cambiar contraseña
                    </a>

                </div>



                <div>

                    <h3>
                        Estado de cuenta
                    </h3>


                    <p>
                        Consulta el estado actual de tu cuenta y sus permisos.
                    </p>


                    <a
                        href="#"
                        class="btn btn-outline"
                    >
                        Consultar estado
                    </a>

                </div>


            </div>


        </div>


    </section>


</main>



<footer class="footer">


    <div class="container">


        <div class="footer-bottom">


            <span>
                Urban Paws
            </span>


            <span>
                Mi espacio personal
            </span>


        </div>


    </div>


</footer>


</body>

</html>