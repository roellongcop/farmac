<?php

namespace app\widgets;

class DatePicker extends BaseWidget
{
    public $form;
    public $model;
    public $attribute;
    public $options = [
        'rtl' => false,
        'todayBtn' => "linked",
        'clearBtn' => true,
        'todayHighlight' => true,
        'templates' => [
            'leftArrow' => '<i class="la la-angle-left"></i>',
            'rightArrow' => '<i class="la la-angle-right"></i>'
        ],
        'endDate' => "today",
        'autoclose' => true
    ];

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('date-picker/active-input', [
            'form' => $this->form,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => json_encode($this->options),
        ]);
    }
}
