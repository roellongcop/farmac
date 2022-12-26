<?php

namespace app\widgets;

class DateTimePicker extends BaseWidget
{
    public $form;
    public $model;
    public $attribute;
    public $options = [];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('date-time-picker/active-input', [
            'form' => $this->form,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => json_encode($this->options),
        ]);
    }
}
