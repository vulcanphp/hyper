<?php

namespace views;

use core\model;
use core\request;
use core\utils\form;
use models\department;
use models\student;
use models\subject;

class home
{
    protected model $model;

    function __construct()
    {
        $this->model = match (request()->get('active', 'student')) {
            'department' => new department(),
            'subject' => new subject(),
            default => new student(),
        };
    }

    function index()
    {
        $students = $this->model->get()->paginate(4);
        return template('table', ['paginator' => $students]);
    }

    function create(request $request)
    {
        $form = new form(request: $request, model: $this->model);

        if ($request->method === 'POST') {
            if ($form->validate() && $form->save()) {
                session()->set('success', 'Model has been created.');
            } else {
                session()->set('error', 'Failed to create model.');
            }
            return redirect('/');
        }

        return template('form', ['form' => $form]);
    }

    function edit(request $request, int $id)
    {
        $student = $this->model->find($id);

        $form = new form(request: $request, model: $student);

        if ($request->method === 'POST') {
            if ($form->validate() && $form->save()) {
                session()->set('success', 'Model has been saved.');
            } else {
                session()->set('error', 'Failed to save model.');
            }
            return redirect('/');
        }

        return template('form', ['form' => $form]);
    }

    function delete(request $request, int $id)
    {
        $model = $this->model->find($id);

        if ($model->remove()) {
            session()->set('success', 'Model has been saved.');
        } else {
            session()->set('error', 'Failed to save model.');
        }

        return redirect('/?active=' . $request->get('active', 'student'));
    }
}
