<?php

$this->set('title', 'Table - Browse Data');
$this->layout('layout/master');

?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <a href="<?= $route . '/create' ?>" class="btn btn-primary btn-sm mb-4">+ Create</a>
            <?php if ($paginator->hasData()) : ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <?php foreach (array_keys($paginator->getData()[0]->toArray()) as $column) : ?>
                                <th class="text-uppercase" scope="col"><?= str_replace(['-', '_'], ' ', $column) ?></th>
                            <?php endforeach ?>
                            <th class="text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paginator->getData() as $record) : ?>
                            <tr>
                                <?php foreach ($record->toArray() as $value) : ?>
                                    <td><?= is_array($value) ? json_encode($value) : $value ?></td>
                                <?php endforeach ?>
                                <td><a href="<?= $route . '/' . $record->id . '/edit' ?>" class="btn btn-sm btn-warning">Edit</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if ($paginator->hasLinks()) : ?>
                <?= $paginator->getLinks() ?>
            <?php endif; ?>
        </div>
    </div>
</div>