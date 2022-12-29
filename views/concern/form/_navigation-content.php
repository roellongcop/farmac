<?php

use app\helpers\Html;
?>
<li class="dd-item dd3-item" data-id="<?= end($data_id) ?>-exist">
    <div class="dd-handle dd3-handle"> 
    	<i class="flaticon-squares"></i>
    </div>
    <div class="dd3-content">
        <div class="d-flex justify-content-between align-items-center">
            <div class="ml-3 w-85p">
                <input data-id="label" 
                    required
                    value="<?= $rule['label'] ?? '' ?>" 
                	type="text" 
                	class="form-control"  
                	placeholder="Label">
            </div>
            <div>
                <a href="#!" class="btn btn-danger btn-sm btn-icon mr-2 btn-remove-menu">
                    <i class="fa fa-trash"></i>
                </a>
            </div>
        </div>
    </div>
    <?= Html::if($rule['sub'] ?? '', function($rules) use($data_id) {
        return Html::tag('ol', 
            $this->render('_navigation', [
                'data_id' => $data_id,
                'rules' => $rules,
            ]),
            ['class' => 'dd-list']
        );
    }) ?>
</li>