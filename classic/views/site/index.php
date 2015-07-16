<div class="row">
    <div class="span8">
        <?php
        if (empty($single)) {
            $this->widget('zii.widgets.CMenu', array(
                'id' => 'meme-tabs',
                'htmlOptions' => array(
                    'class' => 'clearfix',
                ),
                'items' => array(
                    array('label' => Yii::t('yii', 'Latest'), 'url' => array('site/index', 'action' => 'latest'), 'active' => (Yii::app()->request->url == Yii::app()->homeUrl || Yii::app()->request->url == '/latest')),
                    array('label' => Yii::t('yii', 'Featured'), 'url' => array('site/index', 'action' => 'featured'), 'visible' => $has_featured_posts),
                    array('label' => Yii::t('yii', 'Trending'), 'url' => array('site/index', 'action' => 'trending'), 'visible' => $has_trending_posts),
                    array('label' => Yii::t('yii', 'Popular'), 'url' => array('site/index', 'action' => 'popular')),
                ),
            ));
        }
        ?>
        <?php if ($memes): ?>
            <?php
            if ($pagination) {
                $this->widget('MyLinkPager', array(
                    'pages' => $pages,
                    'header' => '',
                ));
            }
            ?>

            <?php foreach ($memes as $i => $meme): ?>
                <?php $this->renderPartial('//partials/meme', array('meme' => $meme, 'single' => $single)) ?>
                <?php echo $i == 3 ? Settings::value('ad2') : ''; ?>
            <?php endforeach; ?>
            <?php
            if ($pagination) {
                $this->widget('MyLinkPager', array(
                    'pages' => $pages,
                    'header' => '',
                ));
            }
            ?>
        <?php else: ?>
            <h4><?php echo Yii::t('yii', 'No meme found!') ?></h4>
        <?php endif ?>
    </div>
    <div class="span4">
        <?php Yii::app()->plugin->beginBlock('sidebar') ?>
        <!-- TOP USERS -->
        <div class="corgi_feed_well">
            <div class="sidebar_header">
                <div class="sidebar_title">
                    <h4><?php echo Yii::t('yii', 'Top Users') ?></h4>
                </div>
            </div>
            <hr class="feed_hr" />
            <div class="sidebar_interior">
                <?php if ($top_users): ?>
                    <div id="top-users" class="clearfix">
                        <?php foreach ($top_users as $user): ?>
                            <a class="ttip top-user-avatar" title="<?php echo CHtml::encode($user->first_name . ' ' . $user->last_name) ?>" href="<?php echo Yii::app()->createUrl('site/profile', array('profile' => $user->username)) ?>"><img src="<?php echo Yii::app()->user->getAvatar_url($user->user_id); ?>" alt="<?php echo CHtml::encode($user->first_name . ' ' . $user->last_name) ?>" /></a>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <?php Yii::app()->plugin->endBlock() ?>
        
        <?php Yii::app()->plugin->beginBlock('sidebar') ?>
        <!-- TOP LIKES -->
        <div class="corgi_feed_well">
            <div class="sidebar_header">
                <div class="sidebar_title">
                    <h4><?php echo Yii::t('yii', 'Top Likes:') ?></h4>
                </div>
            </div>
            <hr class="feed_hr" />
            <div class="sidebar_interior">
                <?php if($likes = MemeLike::model()->findAll(array('group' => 't.meme_fk', 'limit' => 10, 'order' => 't.created_at DESC', 'with' => 'meme', 'scopes' => array('visible')))): ?>
                    <div class="clearfix">
                        <?php foreach($likes as $like): ?>
                            <a class="meme-sidebar" href="<?php echo $like->meme->post_url ?>"><img src="<?php echo $like->meme->thumb_url ?>" title="<?php CHtml::encode($like->meme->title) ?>" /></a>
                        <?php endforeach ?>
                    </div>
                <?php else: ?>
                    <small><em><?php echo Yii::t('yii', 'No likes') ?></em></small>
                <?php endif ?>
            </div>
        </div>
        <?php Yii::app()->plugin->endBlock() ?>

        <?php Yii::app()->plugin->beginBlock('sidebar') ?>
        <!-- TOP WEEKLY LIKES -->
            <div class="corgi_feed_well">
                <div class="sidebar_header">
                    <div class="sidebar_title">
                        <h4><?php echo Yii::t('yii', 'Top Weekly Likes:') ?></h4>
                    </div>
                </div>
                <hr class="feed_hr" />
                <div class="sidebar_interior">
                    <?php if($likes = MemeLike::model()->weekly()->visible()->findAll(array('group' => 't.meme_fk', 'limit' => 10, 'order' => 't.created_at DESC', 'with' => 'meme'))): ?>
                        <div class="clearfix">
                            <?php foreach($likes as $like): ?>
                                <a class="meme-sidebar" href="<?php echo $like->meme->post_url ?>"><img src="<?php echo $like->meme->thumb_url ?>" title="<?php CHtml::encode($like->meme->title) ?>" /></a>
                            <?php endforeach ?>
                        </div>
                    <?php else: ?>
                        <small><em><?php echo Yii::t('yii', 'No likes') ?></em></small>
                    <?php endif ?>
                </div>
            </div>
            <?php echo Settings::value('ad1'); ?>
        <?php Yii::app()->plugin->endBlock() ?>
        
        
       <!--SINGLE MEME-->
       <?php if (!empty($single) && isset($memes[0])): ?>
            <?php Yii::app()->plugin->beginBlock('sidebar') ?>
                <div class="corgi_feed_well">
                    <div class="sidebar_header">
                        <div class="sidebar_title">
                            <h4><?php echo Yii::t('yii', 'Remixes:') ?></h4>
                        </div>
                    </div>
                    <hr class="feed_hr" />
                    <div class="sidebar_interior">
                        <?php if ($remixes = $memes[0]->remixes(array('limit' => 10, 'order' => 'remixes.created_at DESC', 'scopes' => array('visible_remixes')))): ?>
                            <div class="clearfix">
                                <?php foreach ($remixes as $remix): ?>
                                    <a class="meme-sidebar" href="<?php echo Yii::app()->createUrl('site/index', array('id' => $remix->meme_id)) ?>"><img src="<?php echo $remix->thumb_url ?>" title="<?php CHtml::encode($remix->title) ?>" /></a>
                                <?php endforeach ?>
                            </div>
                        <?php else: ?>
                            <small><em><?php echo Yii::t('yii', 'No remixes') ?></em></small>
                        <?php endif ?>
                    </div>
                </div>
            <?php Yii::app()->plugin->endBlock() ?>

            <?php if (($remix_of = $memes[0]->remix_of) && $remix_of->is_active && $remix_of->is_published): ?>
                <?php Yii::app()->plugin->beginBlock('sidebar') ?>
                    <div class="corgi_feed_well">
                        <div class="sidebar_header">
                            <div class="sidebar_title">
                                <h4><?php echo Yii::t('yii', 'Remix of:') ?></h4>
                            </div>
                        </div>
                        <hr class="feed_hr" />
                        <div class="sidebar_interior">
                            <div class="clearfix text-center">
                                <a class="meme-sidebar" style="float:none;" href="<?php echo Yii::app()->createUrl('site/index', array('id' => $remix_of->meme_id)) ?>"><img style="width: auto;" src="<?php echo $remix_of->thumb_url ?>" title="<?php CHtml::encode($remix_of->title) ?>" /></a>
                            </div>
                        </div>
                    </div>
                <?php Yii::app()->plugin->endBlock() ?>
            <?php endif ?>
        <?php endif ?>
       
       <?php Yii::app()->plugin->renderRegion('sidebar') ?>
    </div>
</div>

