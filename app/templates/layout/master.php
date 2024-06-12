<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

    <?= $this->template('layout/header') ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <?php if (session()->has('success')) : ?>
                    <p class="alert alert-success"><?= session()->get('success') ?></p>
                    <?php session()->delete('success') ?>
                <?php endif ?>

                <?php if (session()->has('error')) : ?>
                    <p class="alert alert-error"><?= session()->get('error') ?></p>
                    <?php session()->delete('error') ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <?= $content ?>

    <?= $this->template('layout/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>