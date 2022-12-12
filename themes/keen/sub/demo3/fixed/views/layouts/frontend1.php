<?php

use app\assets\frontend\AppAsset;
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= Url::image(App::setting('image')->favicon, ['w' => 16]) ?>" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?> 
</head>
<body >
<?php $this->beginBody() ?>
	<div id="wrapper">
	    <?= $this->render('frontend/header') ?>
	    	<section id="inner-headline">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<h2 class="pageTitle"><?= $this->title ?></h2>
						</div>
					</div>
				</div>
			</section>
			<section id="content">
			
				<div class="container">
	    			<?= $content ?>
	    		</div>
	    	</section>
	    <?= $this->render('frontend/footer') ?>
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>