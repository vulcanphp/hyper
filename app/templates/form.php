<?php

$this->set('title', 'Form - Create and Update Data');
$this->layout('layout/master');

?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <form action="" method="post" enctype="multipart/form-data">
                <?= csrf() ?>
                <?= $form->render(class: [
                    'groupClass' => 'mb-2',
                    'labelClass' => 'mb-1 d-block',
                    'inputClass' => 'form-control',
                    'inputErrorClass' => 'is-invalid',
                    'checkboxClass' => 'd-flex align-items-center gap-1',
                    'checkboxErrorClass' => 'text-danger',
                    'textareaClass' => 'form-control',
                    'textareaErrorClass' => 'is-invalid',
                    'selectClass' => 'form-control',
                    'selectErrorClass' => 'is-invalid',
                    'radioClass' => 'me-2',
                    'radioErrorClass' => 'text-danger',
                    'errorListClass' => 'alert alert-danger py-1 list-unstyled mt-1',
                    'errorListItemClass' => 'small'
                ]); ?>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>