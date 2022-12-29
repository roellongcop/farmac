<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Concern;
use app\models\search\ConcernSearch;

/**
 * ConcernController implements the CRUD actions for Concern model.
 */
class ConcernController extends Controller 
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Concern::findByKeywords($keywords, ['name'])
        );
    }

    /**
     * Lists all Concern models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConcernSearch();
        $dataProvider = $searchModel->search(['ConcernSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Concern model.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        return $this->render('view', [
            'model' => Concern::controllerFind($slug, 'slug'),
        ]);
    }

    /**
     * Creates a new Concern model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Concern();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Concern model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($slug)
    {
        $originalModel = Concern::controllerFind($slug, 'slug');
        $model = new Concern();
        $model->attributes = $originalModel->attributes;

        if (($post = App::post()) != null) {
            $post['Concern']['rules'] = $post['Concern']['rules'] ?? null;

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Duplicated');
                return $this->redirect($model->viewUrl);
            }
        }

        $model->flashErrors();

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }

    /**
     * Updates an existing Concern model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug)
    {
        $model = Concern::controllerFind($slug, 'slug');

        if (($post = App::post()) != null) {
            $post['Concern']['rules'] = $post['Concern']['rules'] ?? null;

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Updated');
                return $this->redirect($model->viewUrl);
            }
        }

        $model->flashErrors();

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Concern model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = Concern::controllerFind($slug, 'slug');

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