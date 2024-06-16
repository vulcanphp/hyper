<?php

$this->set('title', 'Table - Browse Data');
$this->layout('layout/master');

?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <a href="<?= url('create?active=' . request()->get('active', 'student')) ?>" class="btn btn-primary btn-sm mb-4"><?= __('+ Create') ?></a>
            <?php if ($paginator->hasData()) : ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-uppercase" scope="col"><?= __('ID') ?></th>
                            <th class="text-uppercase" scope="col"><?= __('Object') ?></th>
                            <th class="text-uppercase"><?= __('Action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paginator->getData() as $record) : ?>
                            <tr>
                                <td><?= $record->id ?></td>
                                <td><?= $record ?></td>
                                <td>
                                    <a href="<?= url($record->id . '/edit?active=' . request()->get('active', 'student')) ?>" class="btn btn-sm btn-warning"><?= __('Edit') ?></a>
                                    <a onclick="return confirm('Are you Sure?')" href="<?= url($record->id . '/delete?active=' . request()->get('active', 'student')) ?>" class="btn btn-sm btn-danger"><?= __('Delete') ?></a>
                                </td>
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