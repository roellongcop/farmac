<?php

namespace app\widgets;

 
class Youtube extends BaseWidget
{
    public $videoId;

    public function init() 
    {
        // your logic here
        parent::init();
        
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('youtube', [
            'videoId' => $this->videoId
        ]);
    }
}
