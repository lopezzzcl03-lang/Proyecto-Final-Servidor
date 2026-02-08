<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final PhP</title>
    <link href="/FinalPhP/public/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php require_once __DIR__ . '/view/plantillas/header.php'; ?>

        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-inner">
                    <div class="carousel-item active " data-bs-interval="3000">
                        <img src="/FinalPhP/public/img/pollo_oscuro.png" class="d-block w-100 img-fluid" alt="Pollo asado" style="object-fit: cover; height: 600px;">
                        <div class="carousel-caption d-flex flex-column justify-content-center align-items-center top-0 bottom-0">
                            <h1 class="text-white">pollo a la naranja</h1>
                            <p>Solo con 8 ingredientes</p>
                            <button type="button" class="btn btn-outline-light btn-lg">Leer más</button>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="/FinalPhP/public/img/spagueti_oscuro.png" class="d-block w-100 img-fluid" alt="Spagueti" style="object-fit: cover; height: 600px;">
                        <div class="carousel-caption d-flex flex-column justify-content-center align-items-center top-0 bottom-0">
                            <h5>Spagueti a la carbonara</h5>
                            <p>Solo con 4 ingredientes</p>
                            <button type="button" class="btn btn-outline-light btn-lg">Leer más</button>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="/FinalPhP/public/img/crepes_oscuro.png" class="d-block w-100 img-fluid" alt="Crepes" style="object-fit: cover; height: 600px;">
                        <div class="carousel-caption d-flex flex-column justify-content-center align-items-center top-0 bottom-0">
                            <h5>Crepes</h5>
                            <p>Solo con 5 ingredientes</p>
                            <button type="button" class="btn btn-outline-light btn-lg">Leer más</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php require_once __DIR__ . '/view/plantillas/footer.php'; ?>

    <script src="/FinalPhP/public/js/bootstrap.bundle.min.js"></script>
</body>
</html>