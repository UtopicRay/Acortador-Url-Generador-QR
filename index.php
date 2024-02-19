<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Acortador de URLs</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main>
    <h1>Acortador de URLs y Generador de QR</h1>
    <section>
        <form method="post" class="form" action="generate.php">
            <label for="acortador">Introduzca la URL</label>
            <input id="acortador" name="acortador" type="text" placeholder="https\\examples">
            <button type="submit" class="button">Confirmar</button>
        </form>
    </section>
    <img src="qrcode.png" alt="QR-Generado">
    <section>
        <h2> Como usar el Acortador de urls</h2>
        <article class="pasos">
            <div class="columns">
                <h2>
                    Paso 1
                </h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus iure molestias quaerat quo,
                    reiciendis tenetur voluptate. Animi assumenda atque autem consequuntur corporis dolorem eos est
                    eveniet fugit hic in ipsam, laborum maiores molestias placeat possimus quibusdam quidem saepe sed
                    voluptates?</p>
            </div>
            <div class="columns">
                <h2>Paso 2</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad aliquid assumenda blanditiis
                    consequatur, dolores ducimus earum eius ex excepturi in ipsa ipsam laudantium magni molestias
                    mollitia natus necessitatibus nemo officia perspiciatis placeat possimus quam quibusdam quos
                    repellendus, tempora tempore voluptate.</p>
            </div>
            <div class="columns">
                <h2>Paso 3</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur atque commodi dolorem eligendi
                    error laboriosam nostrum officia quas quo quod sequi, suscipit voluptas, voluptatem? Aperiam
                    consequatur dignissimos ea explicabo hic id inventore, iusto laborum molestiae numquam officia porro
                    quasi quia.</p>
            </div>
        </article>
    </section>
</main>
</body>
</html>