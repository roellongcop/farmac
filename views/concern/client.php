<?php

use app\helpers\App;
use app\models\Concern;
use app\models\search\DashboardSearch;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ConcernSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Concerns';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = new DashboardSearch(); 
$this->params['wrapCard'] = false;
?>
<div class="concern-index-page">
    <div class="row">
        <div class="col-md-4">
            <?= App::foreach(Concern::all(), function($concern, $index) {
              
                return <<< HTML
                    <div class="col-md-4 mb-10">
                        <div data-toggle="tooltip" title="" class="card card-custom card-stretch bg-diagonal bg-diagonal-light-success app-border hazard-map-card">
                            <div class="card-body">
                                <a href="" class="h4 text-dark text-hover-success">
                                    type
                                </a>
                                <div class="d-flex my-5 justify-content-between align-items-center">
                                    <div class="">
                                        <div class="text-dark-50 mt-3" style="font-size: 14px;">
                                            <div>
                                                <p class="lead font-weight-bold display-3 text-success">
                                                    total
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <a href="" class="btn font-weight-bolder text-uppercase btn-outline-success btn-lg float-right">
                                            <i class="fa fa-plus-circle"></i> ADD RECORD
                                        </a>
                                    </div>
                                </div>

                                <div class="font-weight-bolder text-black-50 text-right" style="font-size:12px">
                                    <em>Last Updated: </em>
                                </div>
                            </div>
                        </div>
                    </div>
                HTML;
            }) ?>
        </div>

        <div class="col-md-8">
            <?= $this->render('_chatbot') ?>
        </div>
    </div>
</div>