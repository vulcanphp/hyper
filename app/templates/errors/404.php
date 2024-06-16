<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="<?= public_url('resources/css/bootstrap.min.css') ?>" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 my-5 text-center">
                <h1 class="text-warning">Opps!</h1>
                <p>The Page, You Are Looking For Does Not Exists or Permanently Moved.</p>
                <a href="<?= url() ?>" class="btn btn-sm btn-warning">&larr; Back To Home</a>
            </div>
        </div>
    </div>
</body>

</html>