<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Video;
use app\models\search\VideoSearch;

/**
 * VideoController implements the CRUD actions for Video model.
 */
class VideoController extends Controller 
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Video::findByKeywords($keywords, ['title', 'link'])
        );
    }

    /**
     * Lists all Video models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (App::identity('isClient')) {
            $queryParams = App::queryParams();
            array_unshift($queryParams, 'client');

            return $this->redirect($queryParams);
        }
        
        $searchModel = new VideoSearch();
        $dataProvider = $searchModel->search(['VideoSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionClient()
    {
        $searchModel = new VideoSearch([
            'searchAction' => ['video/client'],
        ]);
        $dataProvider = $searchModel->search(['VideoSearch' => App::queryParams()]);

        return $this->render('client', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Video model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => Video::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Video();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Video model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $originalModel = Video::controllerFind($slug, 'slug');
        $model = new Video();
        $model->attributes = $originalModel->attributes;

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Duplicated');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }

    /**
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = Video::controllerFind($slug, 'slug');

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect($model->viewUrl);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Video model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = Video::controllerFind($slug, 'slug');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect($model->indexUrl);
    }

    public function actionChangeRecordStatus()
    {
        return $this->changeRecordStatus();
    }

    public function actionBulkAction()
    {
        return $this->bulkAction();
    }

    public function actionPrint()
    {
        return $this->exportPrint();
    }

    public function actionExportPdf()
    {
        return $this->exportPdf();
    }

    public function actionExportCsv()
    {
        return $this->exportCsv();
    }

    public function actionExportXls()
    {
        return $this->exportXls();
    }

    public function actionExportXlsx()
    {
        return $this->exportXlsx();
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}