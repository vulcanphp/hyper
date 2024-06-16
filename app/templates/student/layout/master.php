<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="<?= public_url('resources/css/bootstrap.min.css') ?>" rel="stylesheet">
</head>

<body>

    <?= $this->template('student/layout/header') ?>

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

    <?= $this->template('student/layout/footer') ?>

    <script src="<?= public_url('resources/js/bootstrap.min.js') ?>"></script>
</body>

</html>