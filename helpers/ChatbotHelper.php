<?php

namespace app\helpers;

use app\helpers\ArrayHelper;
use app\models\Concern;

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
}