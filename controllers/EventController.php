<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Event;
use app\models\search\EventSearch;
use app\widgets\Detail;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller 
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Event::findByKeywords($keywords, ['title'])
        );
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(['EventSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $token
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($token)
    {
        $model = Event::controllerFind($token, 'token');

        if (App::isAjax()) {
            $response['status'] = 'success';
            $response['model'] = $model;

           
            $response['form'] = $this->renderAjax(
                App::identity('isClient')? '_detail-client': '_form-ajax', [
                'model' => $model
            ]);

            $response['isClient'] = App::identity('isClient');

            return $this->asJson($response);
        }

        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event(['color' => 'info']);

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');

            return $this->redirect(App::referrer());
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Duplicates a new Event model.
     * If duplication is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionDuplicate($token)
    {
        $originalModel = Event::controllerFind($token, 'token');
        $model = new Event();
        $model->attributes = $originalModel->attributes;

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Duplicated');

            return $this->redirect(App::referrer());
        }

        return $this->render('duplicate', [
            'model' => $model,
            'originalModel' => $originalModel,
        ]);
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $token
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($token)
    {
        $model = Event::controllerFind($token, 'token');

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Updated');
            return $this->redirect(App::referrer());
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $token
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($token)
    {
        $model = Event::controllerFind($token, 'token');

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

    public function actionLoad()
    {
        $events = App::foreach(Event::all(), function($event) {
            return [
                'id' => $event->token,
                'title' => $event->title,
                'description' => $event->description,
                'className' => "fc-event-light fc-event-solid-{$event->color}",
                'start' => date('Y-m-d H:i:s', strtotime($event->start)),
                'end' => date('Y-m-d H:i:s', strtotime($event->end)),
            ];
        }, false);

        return $this->asJson([
            'status' => 'success',
            'events' => $events
        ]);
    }

    public function actionCalendarClient()
    {
        return $this->render('calendar-client', [
            'model' => new Event()
        ]);
    }


    public function actionCalendar()
    {
        return $this->render('calendar', [
            'model' => new Event()
        ]);
    }
}