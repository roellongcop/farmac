<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Conclusion;
use app\models\search\ConclusionSearch;

/**
 * ConclusionController implements the CRUD actions for Conclusion model.
 */
class ConclusionController extends Controller 
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Conclusion::findByKeywords($keywords, ['conclusion'])
        );
    }

    /**
     * Lists all Conclusion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConclusionSearch();
        $dataProvider = $searchModel->search(['ConclusionSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Conclusion model.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Conclusion::controllerFind($id),
        ]);
    }

    /**
     * Creates a new Conclusion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Conclusion();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect($model->viewUrl);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Conclusion model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($id)
    {
        $originalModel = Conclusion::controllerFind($id);
        $model = new Conclusion();
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
     * Updates an existing Conclusion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Conclusion::controllerFind($id);

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect($model->viewUrl);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Conclusion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Conclusion::controllerFind($id);

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