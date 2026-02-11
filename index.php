<?php require_once __DIR__ . '/config/base.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final PhP</title>
    <link href="<?= BASE_URL ?>/public/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php require_once __DIR__ . '/view/plantillas/header.php'; ?>

    <div id="carouselExampleInterval" class="carousel slide d-none d-lg-block" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-inner">
                <div class="carousel-item active " data-bs-interval="3000">
                    <img src="<?= BASE_URL ?>/public/img/pollo_oscuro.png" class="d-block w-100 img-fluid" alt="Pollo asado" style="object-fit: cover; height: 60vh; min-height:250px; max-height:600px;">
                    <div class="carousel-caption d-none d-md-flex flex-column justify-content-center align-items-center top-0 bottom-0">
                        <h1 class="text-white">pollo al limón</h1>
                        <p>Solo con 8 ingredientes</p>
                        <a href="<?= BASE_URL ?>/view/ver.php?id=4" class="btn btn-outline-light btn-lg">Leer más</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="<?= BASE_URL ?>/public/img/spagueti_oscuro.png" class="d-block w-100 img-fluid" alt="Spagueti" style="object-fit: cover; height: 60vh; min-height:250px; max-height:600px;">
                    <div class="carousel-caption d-none d-md-flex flex-column justify-content-center align-items-center top-0 bottom-0">
                        <h5>Spagueti a la carbonara</h5>
                        <p>Solo con 4 ingredientes</p>
                        <a href="<?= BASE_URL ?>/view/ver.php?id=2" class="btn btn-outline-light btn-lg">Leer más</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="<?= BASE_URL ?>/public/img/crepes_oscuro.png" class="d-block w-100 img-fluid" alt="Crepes" style="object-fit: cover; height: 60vh; min-height:250px; max-height:600px;">
                    <div class="carousel-caption d-none d-md-flex flex-column justify-content-center align-items-center top-0 bottom-0">
                        <h5>Crepes</h5>
                        <p>Solo con 5 ingredientes</p>
                        <a href="<?= BASE_URL ?>/view/ver.php?id=8" class="btn btn-outline-light btn-lg">Leer más</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-5">
        <h2 class="text-center">Categorías</h2>
    </div>

    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <img src="<?= BASE_URL ?>/public/img/desayuno.png" class="card-img-top img-fluid" alt="Desayuno">
                    <div class="card-body">
                        <h5 class="card-title">Desayuno</h5>
                        <p class="card-text">Recetas deliciosas para comenzar el día con energía.</p>
                        <a href="<?= BASE_URL ?>/view/filtrar_categoria.php?categoria=Desayuno" class="btn btn-dark">Ver recetas</a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <img src="<?= BASE_URL ?>/public/img/comida.png" class="card-img-top img-fluid" alt="Comida">
                    <div class="card-body">
                        <h5 class="card-title">Comida</h5>
                        <p class="card-text">Recetas deliciosas para disfrutar de una comida completa.</p>
                        <a href="<?= BASE_URL ?>/view/filtrar_categoria.php?categoria=Comida" class="btn btn-dark">Ver recetas</a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <img src="<?= BASE_URL ?>/public/img/cena.jpg" class="card-img-top img-fluid" alt="Cena">
                    <div class="card-body">
                        <h5 class="card-title">Cena</h5>
                        <p class="card-text">Recetas deliciosas para disfrutar de una cena relajante.</p>
                        <a href="<?= BASE_URL ?>/view/filtrar_categoria.php?categoria=Cena" class="btn btn-dark">Ver recetas</a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <img src="<?= BASE_URL ?>/public/img/postre.png" class="card-img-top img-fluid" alt="Postres">
                    <div class="card-body">
                        <h5 class="card-title">Postres</h5>
                        <p class="card-text">Recetas deliciosas para terminar el día con dulzura.</p>
                        <a href="<?= BASE_URL ?>/view/filtrar_categoria.php?categoria=Postre" class="btn btn-dark">Ver recetas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MD XL XXL -->
    <h2 class="mb-4 text-center">Consejos de cocina</h2>

    <div class="container-fluid d-none d-sm-none d-md-block">
        <div class="container-fluid py-5 bg-dark">
            <h4 class="text-center text-light mb-5 fw-semibold" style="letter-spacing: 1px;">
                Técnicas básicas que marcan la diferencia
            </h4>

            <div class="row align-items-center justify-content-center">

                <!-- Texto -->
                <div class="col-6 d-flex justify-content-end">
                    <div class="pe-4 border-end" style="max-width: 420px; border-color: #d8d8d8 !important;">
                        <p class="text-light mb-4" style="font-size: 1.05rem; line-height: 1.7;">
                            Dora siempre los ingredientes (carne, verduras) antes de guisarlos: potencia el sabor.
                        </p>
                        <p class="text-light mb-4" style="font-size: 1.05rem; line-height: 1.7;">
                            No muevas demasiado la carne al sellarla; necesita contacto para formar costra.
                        </p>
                        <p class="text-light mb-0" style="font-size: 1.05rem; line-height: 1.7;">
                            Para evitar que el arroz quede pastoso, lávalo hasta que el agua salga clara.
                        </p>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="col-6 d-flex justify-content-start">
                    <img src="<?= BASE_URL ?>/public/img/carne-asada.png"
                        class="img-fluid rounded-3 shadow"
                        alt="carne asada"
                        style="max-height: 320px; object-fit: cover;">
                </div>

            </div>
        </div>

        <div class="container py-5">
            <h4 class="text-center mb-5 fw-semibold" style="letter-spacing: 1px;">
                Sabor y condimentos
            </h4>

            <div class="row align-items-center justify-content-center">

                <!-- Imagen -->
                <div class="col-6 d-flex justify-content-end">
                    <img src="<?= BASE_URL ?>/public/img/especias.png"
                        class="img-fluid rounded-3 shadow"
                        alt="especias"
                        style="max-height: 320px; object-fit: cover;">
                </div>

                <!-- Texto -->
                <div class="col-6 d-flex justify-content-start">
                    <div class="ps-4 border-start" style="max-width: 420px; border-color: #d8d8d8 !important;">
                        <p class="mb-4" style="font-size: 1.05rem; line-height: 1.7;">
                            Prueba la comida en cada etapa; ajustar a tiempo evita desastres.
                        </p>
                        <p class="mb-4" style="font-size: 1.05rem; line-height: 1.7;">
                            Añade un chorrito de limón o vinagre al final para realzar sabores.
                        </p>
                        <p class="mb-0" style="font-size: 1.05rem; line-height: 1.7;">
                            Tuesta ligeramente las especias antes de usarlas para intensificar su aroma.
                        </p>
                    </div>
                </div>

            </div>
        </div>


        <div class="container-fluid py-5 bg-dark">
            <h4 class="text-center text-light mb-5 fw-semibold" style="letter-spacing: 1px;">
                Trucos rápidos y útiles
            </h4>

            <div class="row align-items-center justify-content-center">

                <!-- Texto -->
                <div class="col-6 d-flex justify-content-end">
                    <div class="pe-4 border-end" style="max-width: 420px; border-color: #d8d8d8 !important;">
                        <p class="text-light mb-4" style="font-size: 1.05rem; line-height: 1.7;">
                            Si se te ha pasado la sal, añade una patata cruda para absorber el exceso.
                        </p>
                        <p class="text-light mb-4" style="font-size: 1.05rem; line-height: 1.7;">
                            Para evitar lágrimas al cortar cebolla, enfríala 10 minutos en la nevera.
                        </p>
                        <p class="text-light mb-4" style="font-size: 1.05rem; line-height: 1.7;">
                            Para que el ajo no repita, retira el germen interior.
                        </p>
                        <p class="text-light mb-0" style="font-size: 1.05rem; line-height: 1.7;">
                            Si una salsa queda muy líquida, espésala con un poco de maicena disuelta en agua fría.
                        </p>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="col-6 d-flex justify-content-start">
                    <img src="<?= BASE_URL ?>/public/img/salsita.png"
                        class="img-fluid rounded-3 shadow"
                        alt="salsita"
                        style="max-height: 320px; object-fit: cover;">
                </div>

            </div>
        </div>

        <div class="container py-5">
            <!-- Título -->
            <h4 class="text-center mb-5 fw-semibold" style="letter-spacing: 1px;">
                Repostería
            </h4>

            <div class="row align-items-center">
                <!-- Columna de imagen -->
                <div class="col-6 d-flex justify-content-end">
                    <img src="<?= BASE_URL ?>/public/img/ingredientes.jpg"
                        class="img-fluid rounded-3 shadow"
                        alt="ingredientes"
                        style="max-height: 320px; object-fit: cover;">
                </div>

                <!-- Columna de texto -->
                <div class="col-6 d-flex justify-content-start">
                    <div class="ps-4 border-start" style="max-width: 420px; border-color: #d8d8d8 !important;">
                        <p class="mb-4" style="font-size: 1.05rem; line-height: 1.6;">
                            Todos los ingredientes deben estar a temperatura ambiente para mejores resultados.
                        </p>
                        <p class="mb-4" style="font-size: 1.05rem; line-height: 1.6;">
                            No abras el horno en los primeros 20 minutos de un bizcocho.
                        </p>
                        <p class="mb-4" style="font-size: 1.05rem; line-height: 1.6;">
                            Tamiza la harina para obtener masas más esponjosas.
                        </p>
                        <p class="mb-0" style="font-size: 1.05rem; line-height: 1.6;">
                            Pesa los ingredientes: en repostería, la precisión es clave.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- SM XS -->
    <div class="container-fluid d-block d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none">
        <div class="container-fluid py-4 bg-dark">
            <h5 class="text-center text-light mb-3 fw-semibold" style="letter-spacing: 1px;">
                Técnicas básicas que marcan la diferencia
            </h5>

            <div class="row align-items-center justify-content-center">

                <!-- Texto -->
                <div class="col-12 d-flex justify-content-center">
                    <div class="pe-3">
                        <p class="text-light mb-3">
                            Dora siempre los ingredientes (carne, verduras) antes de guisarlos: potencia el sabor.
                        </p>
                        <p class="text-light mb-3">
                            No muevas demasiado la carne al sellarla; necesita contacto para formar costra.
                        </p>
                        <p class="text-light mb-0">
                            Para evitar que el arroz quede pastoso, lávalo hasta que el agua salga clara.
                        </p>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="col-12 d-flex justify-content-center mt-3">
                    <img src="<?= BASE_URL ?>/public/img/carne-asada.png"
                        class="img-fluid rounded-3 shadow"
                        alt="carne asada"
                        style="max-height: 320px; object-fit: cover;">
                </div>

            </div>
        </div>

        <div class="container py-4">
            <h4 class="text-center mb-3 fw-semibold" style="letter-spacing: 1px;">
                Sabor y condimentos
            </h4>

            <div class="row align-items-center justify-content-center">

                <!-- Texto -->
                <div class="col-12 d-flex justify-content-start">
                    <div class="pe-3">
                        <p class="mb-3">
                            Prueba la comida en cada etapa; ajustar a tiempo evita desastres.
                        </p>
                        <p class="mb-3">
                            Añade un chorrito de limón o vinagre al final para realzar sabores.
                        </p>
                        <p class="mb-0">
                            Tuesta ligeramente las especias antes de usarlas para intensificar su aroma.
                        </p>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="col-12 d-flex justify-content-center mt-3">
                    <img src="<?= BASE_URL ?>/public/img/especias.png"
                        class="img-fluid rounded-3 shadow"
                        alt="especias"
                        style="max-height: 320px; object-fit: cover;">
                </div>
            </div>
        </div>


        <div class="container-fluid py-4 bg-dark">
            <h4 class="text-center text-light mb-3 fw-semibold" style="letter-spacing: 1px;">
                Trucos rápidos y útiles
            </h4>

            <div class="row align-items-center justify-content-center">

                <!-- Texto -->
                <div class="col-12 d-flex justify-content-center">
                    <div class="pe-3">
                        <p class="text-light mb-3">
                            Si se te ha pasado la sal, añade una patata cruda para absorber el exceso.
                        </p>
                        <p class="text-light mb-3">
                            Para evitar lágrimas al cortar cebolla, enfríala 10 minutos en la nevera.
                        </p>
                        <p class="text-light mb-3">
                            Para que el ajo no repita, retira el germen interior.
                        </p>
                        <p class="text-light mb-0">
                            Si una salsa queda muy líquida, espésala con un poco de maicena disuelta en agua fría.
                        </p>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="col-12 d-flex justify-content-center mt-3">
                    <img src="<?= BASE_URL ?>/public/img/salsita.png"
                        class="img-fluid rounded-3 shadow"
                        alt="salsita"
                        style="max-height: 320px; object-fit: cover;">
                </div>

            </div>
        </div>

        <div class="container py-3">
            <!-- Título -->
            <h4 class="text-center mb-3 fw-semibold" style="letter-spacing: 1px;">
                Repostería
            </h4>

            <div class="row align-items-center">
            
                <!-- Columna de texto -->
                <div class="col-12 d-flex justify-content-center">
                    <div class="pe-3">
                        <p class="mb-3">
                            Todos los ingredientes deben estar a temperatura ambiente para mejores resultados.
                        </p>
                        <p class="mb-3">
                            No abras el horno en los primeros 20 minutos de un bizcocho.
                        </p>
                        <p class="mb-3">
                            Tamiza la harina para obtener masas más esponjosas.
                        </p>
                        <p class="mb-0">
                            Pesa los ingredientes: en repostería, la precisión es clave.
                        </p>
                    </div>
                </div>

                <!-- Columna de imagen -->
                <div class="col-12 d-flex justify-content-center mt-3">
                    <img src="<?= BASE_URL ?>/public/img/ingredientes.jpg"
                        class="img-fluid rounded-3 shadow"
                        alt="ingredientes"
                        style="max-height: 320px; object-fit: cover;">
                </div>

            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/view/plantillas/footer.php'; ?>

    <script src="<?= BASE_URL ?>/public/js/bootstrap.bundle.min.js"></script>
</body>

</html>