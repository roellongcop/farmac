<?php

namespace app\widgets;

use yii\widgets\DetailView;
 
class Detail extends BaseWidget
{
    public $model;
    public $attributes;
    public $formatter = ['class' => 'app\components\FormatterComponent'];
    public $options = ['class' => 'table table-striped table-bordered detail-view ow-anywhere'];
    

    public function init() 
    {
        // your logic here
        parent::init(); 
        
    }
  
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return DetailView::widget([
            'model' => $this->model,
            'attributes' => $this->attributes ?: ($this->model->detailColumns ?? ['id']),
            'formatter' => $this->formatter,
            'options' => $this->options,
        ]);
    }
}
