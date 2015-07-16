<?php
Yii::app()->clientScript->scriptMap=array(
	'jquery.min.js'=>false,
);
?><!DOCTYPE html>
<html lang="en" xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Muhammad Mahad Azad">
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />  
		
		<?php if($this->og_title): ?>
            <meta property="og:title" content="<?php echo $this->og_title ?>" />
        <?php endif ?>
        <?php if($this->og_url): ?>
            <meta property="og:url" content="<?php echo $this->og_url ?>" />
        <?php endif ?>
        <meta property="og:type" content="website" />
        <?php if($this->og_image): ?>
            <meta property="og:image" content="<?php echo $this->og_image ?>" />
        <?php endif ?>
        <?php if($this->og_description): ?>
            <meta property="og:description" content="<?php echo $this->og_description ?>" />
        <?php endif ?>
        <?php echo is_array($this->extra) ? implode(PHP_EOL, $this->extra) : $this->extra; echo PHP_EOL;?>
		
        <!-- Le styles -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-responsive.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,600|Oleo+Script' rel='stylesheet' type='text/css'>
        <link href='<?php echo Yii::app()->theme->baseUrl; ?>/css/corgi.css' rel='stylesheet' type='text/css'>
        <link href='<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.10.0.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/underscore-min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/corgi.js" type="text/javascript"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/html5shiv.js"></script>
        <![endif]-->
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php if($this->pageDescription): ?>
             <meta name="description" content="<?php echo $this->pageDescription ?>">
        <?php endif ?>
        
        <?php if($this->pageKeywords): ?>
             <meta name="keywords" content="<?php echo $this->pageKeywords ?>">
        <?php endif ?>
    </head>
    <body>
        <div id="fb-root"></div>
        <script>
        window.fbAsyncInit = function()
        {
            FB.init( {
                appId  : '<?php echo Yii::app()->params['hauth']['config']['providers']['Facebook']['keys']['id'] ?>',
                status : true,
                cookie : true,
                xfbml  : true
            } );
        };
    
        ( function( d )
        {
            var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement('script'); js.id = id; js.async = true;
            js.src = "//connect.facebook.net/en_US/all.js";
            ref.parentNode.insertBefore(js, ref);
        }( document ) );
        </script>
        <?php echo Yii::app()->plugin->onBodyStart(new CEvent($this)) ?>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="<?php echo Yii::app()->homeUrl ?>"><?php echo Yii::app()->name ?></a>
                    <div class="nav-collapse collapse">
                        <?php
                        Yii::app()->plugin->addMenuItem('top-menu', array('label' => Yii::t('yii', 'Home'), 'url' => Yii::app()->homeUrl));
                        // changed v2.16
                        Yii::app()->plugin->addMenuItem('top-menu', array('label' => Yii::t('yii', 'Create Meme'), 'url' => array('/generate/index')));
                        Yii::app()->plugin->addMenuItem('top-menu', array('label' => Yii::t('yii', 'My Memes'), 'url' => array('site/mymemes'), 'visible' => !Yii::app()->user->isGuest));
                        
                        $headerPages = Page::model()->position('header')->active()->findAll();
                        if($headerPages) {
                            foreach($headerPages as $page) {
                                Yii::app()->plugin->addMenuItem('top-menu', array(
                                    'label' => Yii::t('yii', $page->title),
                                    'url' => array(Yii::app()->createUrl('site/cms', array('slug' => $page->slug))),
                                ));
                            }
                        }
                        
                        Yii::app()->plugin->addMenuItem('top-menu', array('label' => Yii::t('yii', 'Contact'), 'url' => array('/site/contact')));
                        Yii::app()->plugin->addMenuItem('top-menu', array('label' => Yii::t('yii', 'Login'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest));
                        Yii::app()->plugin->addMenuItem('top-menu', array('label' => Yii::t('yii', 'Register'), 'url' => array('/site/register'), 'visible' => Yii::app()->user->isGuest));
                        Yii::app()->plugin->addMenuItem('top-menu', array(
                                    'label' => '<i class="icon-cog icon-white"></i> ' . Yii::t('dict', 'My Account'),
                                    'url' => '#',
                                    'visible' => !Yii::app()->user->isGuest,
                                    'itemOptions' => array('class' => 'dropdown', 'id' => 'my-account'),
                                    'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'),
                                    'submenuOptions' => array('class' => 'dropdown-menu'),
                                    'items' => array(
                                        array('label' => '<i class="icon-user"></i> ' . Yii::t('dict', 'My Profile'), 'url' => array('/site/update_profile')),
                                        array('label' => '<i class="icon-key"></i> ' . Yii::t('dict', 'Change Password'), 'url' => array('/site/change_password')),
                                        array('label' => '<i class="icon-off"></i> ' . Yii::t('dict', 'Logout'), 'url' => array('/site/logout')),
                                    )
                        ));
                        
                        Yii::app()->plugin->renderMenu('top-menu', array(
                            'encodeLabel' => false,
                            'htmlOptions' => array(
                                'class' => 'nav pull-right',
                            ),
                        ));
                        ?>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">
            