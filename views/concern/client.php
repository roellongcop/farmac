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
<div class="concern-index-page" id="help-desk" v-cloak>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-custom card-stretch gutter-b">
                <div class="card-header p-5">
                    <div class="input-group input-group-lg input-group-solid">
                        <input type="text" class="form-control pl-4 search-input" placeholder="Search...">
                        <div class="input-group-append">
                            <span class="input-group-text pr-3">
                                <span class="svg-icon svg-icon-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                        </g>
                                    </svg>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    <div class="navi navi-hover navi-active navi-link-rounded navi-bold navi-icon-center navi-light-icon overflow-auto space-list">
                        <div>
                            <div>
                                <div class="navi-item my-2">
                                    <a href="#" class="navi-link space-item active">
                                        <span class="navi-icon mr-4">
                                            <div class="symbol symbol-35 symbol-circle symbol-light-primary mr-3">
                                                <span class="symbol-label">t</span>
                                            </div>
                                        </span>
                                        <span class="navi-text">test public <div class="text-muted">Public <small class="text-danger font-weight-bold">&nbsp; (Blocked) </small>
                                            </div>
                                        </span>
                                        <!---->
                                    </a>
                                </div>
                                <div class="navi-item my-2">
                                    <a href="#" class="navi-link space-item">
                                        <span class="navi-icon mr-4">
                                            <div class="symbol symbol-35 symbol-circle symbol-light-primary mr-3">
                                                <span class="symbol-label">o</span>
                                            </div>
                                        </span>
                                        <span class="navi-text">ok <div class="text-muted">Private <small class="text-danger font-weight-bold">&nbsp; (Blocked) </small>
                                            </div>
                                        </span>
                                        <!---->
                                    </a>
                                </div>
                                <div class="navi-item my-2">
                                    <a href="#" class="navi-link space-item">
                                        <span class="navi-icon mr-4">
                                            <div class="symbol symbol-35 symbol-circle symbol-light-primary mr-3">
                                                <span class="symbol-label">
                                                    <img src="/assets/images/1d/1d8686_default-image_200.png" class="img-fluid img-circle">
                                                </span>
                                            </div>
                                        </span>
                                        <span class="navi-text">developer <div class="text-muted">Personal
                                                <!---->
                                            </div>
                                        </span>
                                        <!---->
                                    </a>
                                </div>
                                <div class="navi-item my-2">
                                    <a href="#" class="navi-link space-item">
                                        <span class="navi-icon mr-4">
                                            <div class="symbol symbol-35 symbol-circle symbol-light-primary mr-3">
                                                <span class="symbol-label">
                                                    <img src="/assets/images/9a/9a781a_Farma-C3.png-JAK23Bp7x7-1672208477-zc-dqLRtJS-1672229809.png" class="img-fluid img-circle">
                                                </span>
                                            </div>
                                        </span>
                                        <span class="navi-text">General Group <div class="text-muted">Public
                                                <!---->
                                            </div>
                                        </span>
                                        <!---->
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <?= $this->render('_chatbot') ?>
        </div>
    </div>
</div>