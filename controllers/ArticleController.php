<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Article;
use app\models\search\ArticleSearch;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller 
{
    public function actionFindByKeywords($keywords='')
    {
        return $this->asJson(
            Article::findByKeywords($keywords, ['title', 'menu', 'category'], 10, [
                'parent_id' => 0
            ])
        );
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(['ArticleSearch' => App::queryParams()]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $slug
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionView($slug)
    {
        $model = Article::controllerFind($slug, 'slug');

        if ($model->parent_id == 0) {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        
        return $this->render('view-content', [
            'model' => $model,
        ]);
    }

    private function setPostData($post, $step)
    {
        if ($step == 'completed') {
            $post['Article']['record_status'] = Article::RECORD_ACTIVE;
        }

        return $post;
    }

    private function setRedirectLink($model, $step, $action='create')
    {
        switch ($step) {
            case 'general':
                $redirect = [$action, 'slug' => $model->slug, 'step' => 'content'];
                break;

            case 'content':
                $redirect = [$action, 'slug' => $model->slug, 'step' => 'sort'];
                break;

            case 'sort':
                $redirect = [$action, 'slug' => $model->slug, 'step' => 'completed'];
                break;

            case 'completed':
                $redirect = $model->viewUrl;
                break;

            default:
                $redirect = $model->viewUrl;
                break;
        }

        return $redirect;
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($slug='', $step='general')
    {
        $model = Article::findOrCreate(['slug' => $slug]);

        if ($model->isNewRecord && $step != 'general') {
            App::warning('Fill up General Information First');
            return $this->redirect(['create']);
        }

        $model->setInactive();
        $stepForms = Article::stepForms($step);

        if (($post = App::post()) != null) {
            $post = $this->setPostData($post, $step);

            if ($step == 'sort') {
                App::foreach($post['sort'], function($id, $index, $counter) {
                    Article::updateAll(['sort' => $counter], ['id' => $id]);
                });
                App::success('Successfully Sorted');
                return $this->redirect($this->setRedirectLink($model, $step));
            }

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Processed');
                return $this->redirect($this->setRedirectLink($model, $step));
            }
        }

        $model->flashErrors();

        return $this->render('create', [
            'model' => $model,
            'activeStep' => $stepForms[$step],
            'stepForms' => $stepForms,
        ]);
    }


    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($slug='', $step='general')
    {
        $model = Article::controllerFind($slug, 'slug');

        if ($model->isNewRecord && $step != 'general') {
            App::warning('Fill up General Information First');
            return $this->redirect(['create']);
        }

        $model->setInactive();
        $stepForms = Article::stepForms($step);

        if (($post = App::post()) != null) {
            $post = $this->setPostData($post, $step);

            if ($step == 'sort') {
                App::foreach($post['sort'], function($id, $index, $counter) {
                    Article::updateAll(['sort' => $counter], ['id' => $id]);
                });
                App::success('Successfully Sorted');
                return $this->redirect($this->setRedirectLink($model, $step));
            }

            if ($model->load($post) && $model->save()) {
                App::success('Successfully Processed');
                return $this->redirect($this->setRedirectLink($model, $step));
            }
        }

        $model->flashErrors();

        return $this->render('update', [
            'model' => $model,
            'activeStep' => $stepForms[$step],
            'stepForms' => $stepForms,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionDelete($slug)
    {
        $model = Article::controllerFind($slug, 'slug');

        if($model->delete()) {
            App::success('Successfully Deleted');
        }
        else {
            App::danger(json_encode($model->errors));
        }

        return $this->redirect(App::referrer());
        // return $this->redirect($model->indexUrl);
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

    public function actionCreateContent()
    {
        $model = new Article();

        if ($model->load(App::post()) && $model->save()) {
            App::success('Successfully Created');
        }
        else {
            App::danger($model->errorSummary);
        }

        return $this->redirect(App::referrer());
    }
}