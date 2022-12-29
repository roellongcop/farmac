<?php

namespace app\controllers;

use app\helpers\App;
use app\models\Announcement;
use app\models\Article;
use app\models\Backup;
use app\models\Event;
use app\models\File;
use app\models\Ip;
use app\models\Log;
use app\models\Notification;
use app\models\Queue;
use app\models\Role;
use app\models\Session;
use app\models\Setting;
use app\models\Theme;
use app\models\User;
use app\models\UserMeta;
use app\models\Video;
use app\models\VisitLog;
use app\models\Visitor;
use app\models\search\DashboardSearch;
/**
 * BackupController implements the CRUD actions for Backup model.
 */
class DashboardController extends Controller
{
    public function actionFindByKeywords($keywords='')
    {
        $identity = App::identity();
        $array = [
            'video' => Video::findByKeywords($keywords, ['title', 'link']),
            'event' => Event::findByKeywords($keywords, ['title']),
            'article' => Article::findByKeywords($keywords, ['title', 'menu', 'category'], 10, [
                'parent_id' => 0
            ]),
            'announcement' => Announcement::findByKeywords($keywords, ['title']),
            'file' => File::findByKeywords($keywords, ['name', 'extension', 'token']),
            'ip' => Ip::findByKeywords($keywords, ['name', 'description']),
            'log' => Log::findByKeywords($keywords, ['method', 'action', 'controller', 'table_name', 'model_name']),
            'notification' => Notification::findByKeywords($keywords, ['message']),
            'role' => Role::findByKeywords($keywords, ['name']),
            'session' => Session::findByKeywords($keywords, ['id', 'expire', 'ip', 'browser', 'os', 'device']),
            'setting' => Setting::findByKeywords($keywords, ['name', 'value']),
            'user' => User::findByKeywords($keywords, ['username', 'email']),
            'user-meta' => UserMeta::findByKeywords($keywords, ['name', 'value']),
            'visit-log' => VisitLog::findByKeywords($keywords, ['ip']),
            'visitor' => Visitor::findByKeywords($keywords, ['expire', 'cookie', 'ip', 'browser', 'os', 'device', 'location'])
        ];

        $data = [];

        foreach ($array as $controllerId => $keywords) {
            if ($identity->can('index', $controllerId)) {
                $data = array_merge($data, $keywords);
            }
        }


        $data = array_unique($data);
        $data = array_values($data);
        sort($data);

        return $this->asJson($data);
    }

    /**
     * Lists all Backup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DashboardSearch();

        if (($queryParams = App::queryParams()) != null) {
            $dataProviders = $searchModel->search(['DashboardSearch' => $queryParams]);

            if ($searchModel->keywords) {
                return $this->render('search_result', [
                    'dataProviders' => $dataProviders,
                    'searchModel' => $searchModel,
                ]);
            }
            else {
                return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel
        ]);
    }

    public function actionInActiveData()
    {
        # dont delete; use in condition if user has access to in-active data
    }
}