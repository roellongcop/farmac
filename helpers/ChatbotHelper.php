<?php

namespace app\helpers;

use app\helpers\ArrayHelper;
use app\models\Concern;
use yii\db\Query;

class ChatbotHelper
{
    const CONCERN_PATTERN = '/concern-';

    public static function changingConcern($message)
    {
        return str_contains($message, self::CONCERN_PATTERN);
    }

    public static function getConcernId($message)
    {
        $explode = explode(self::CONCERN_PATTERN, $message);

        return $explode[1] ?? 0;
    }

    public static function getQuestions($concern_id=[])
    {
        $concern_id = $concern_id ?: $_SESSION['concern_id'];

        $concern = Concern::findOne($concern_id);

        $questions = [];

        if ($concern) {
            foreach ($concern->rules as $rule) {
                $questions[] = [
                    'label' => $rule['label'],
                    'expected_answers' => array_keys(ArrayHelper::index($rule['sub'], 'label')),
                    'status' => 'pending',
                    'answer' => ''
                ]; 
            }
        }

        return $questions;
    }

    public static function getActiveQuestion($questions=[])
    {
        $questions = $questions ?: $_SESSION['questions'];

        foreach ($questions as $question) {
            if ($question['status'] == 'pending') {
                return $question;
            }
        }

        return false;
    }


    public static function updateQuestions($message='', $questions=[], $activeQuestion=[])
    {
        $questions = $questions ?: $_SESSION['questions'];
        $activeQuestion = $activeQuestion ?: $_SESSION['activeQuestion'];

        foreach ($questions as &$question) {
            if ($question['label'] == $activeQuestion['label']) {
                $question['status'] = 'completed';
                $question['answer'] = $message;
            }
        }

        return $questions;
    }

    public static function predict($query='')
    {
        $keywords = explode(' ', trim($query));
        $condition = [];
        $orderBy = [];

        if (count($keywords) == 1) {
            $condition = ['LIKE', 'name', trim($query)];
            $rawQuery = (new Query())
                ->select(['COUNT("*")'])
                ->where(['LIKE', 'name', trim($query)])
                ->createCommand()
                ->rawSql;

            $orderBy = ["({$rawQuery})" => SORT_DESC];
        }
        else {
            $condition = ['or'];
            $orders = [];
            foreach ($keywords as $keyword) {
                $condition[] = ['LIKE', 'name', trim($keyword)];

                $rawQuery = (new Query())
                    ->select(['COUNT("*")'])
                    ->where(['LIKE', 'name', trim($keyword)])
                    ->createCommand()
                    ->rawSql;

                $orders[] = "({$rawQuery})";
            }

            $orderByQuery = implode(' + ', $orders);

            $orderBy = ["({$orderByQuery})" => SORT_DESC];
        }

        $orderBy['LENGTH(name)'] = SORT_ASC;

        $training = Concern::find()
            ->where($condition)
            ->orderBy($orderBy)
            ->limit(3)
            ->all();


        if ($training) {
            $predict = App::foreach($training, fn ($t) => Html::tag('a', $t->name, [
                'href' => '#',
                'data-message' => $t->name,
                'data-hidden_message' => self::CONCERN_PATTERN . $t->id,
                'class' => 'btn btn-outline-success btn-pill mb-1 btn-hidden-message',
            ]));
            return $predict;
        }
    }
}