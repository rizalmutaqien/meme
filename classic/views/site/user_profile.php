<div class="row">
    <div class="span8">
        <div class="corgi_feed_well" style="margin-top: 30px">
            <div class="feed_stacked">
                <div class="feed_item meme">
                    <div class="feed_body">
                            <div class="clearfix" id="profile-header">
                                <div class="feed_profile_pic pull-left">
                                    <img src="<?php echo Yii::app()->user->getAvatar_url($user->user_id) ?>" alt="<?php echo CHtml::encode("{$user->first_name} {$user->last_name}") ?>" class="meta_image" />
                                </div>
                                
                                <h1><?php echo CHtml::encode($user->first_name . ' ' . $user->last_name) ?></h1>
                                
                                <div class="pull-right" style="margin-top:-5px;">
                                    <?php if(!Yii::app()->user->isGuest): ?>
                                        <?php if(User::isFollowing($user->user_id)): ?>
                                            <a class="btn btn-primary" href="<?php echo $this->createUrl('site/unfollow', array('id' => $user->user_id)); ?>"><i class="icon-group"></i> <?php echo Yii::t('yii', 'Unfollow') ?></a>
                                        <?php else: ?>
                                            <a class="btn btn-success" href="<?php echo $this->createUrl('site/follow', array('id' => $user->user_id)); ?>"><i class="icon-group"></i> <?php echo Yii::t('yii', 'Follow') ?></a>
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>
                            </div>
                            
                            <table class="table table-striped">
                                <tr>
                                    <th><?php echo Yii::t('yii', 'Joining date') ?></th>
                                    <td><?php echo date('d M Y', strtotime($user->created_at)) ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo Yii::t('yii', 'Full name') ?></th>
                                    <td><?php echo CHtml::encode("{$user->first_name} {$user->last_name}") ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo Yii::t('yii', 'No. of posts') ?></th>
                                    <td><?php echo $total_posts ?></td>
                                </tr>
                            </table>
                    </div>
                </div>
            </div>
        </div>
        
        <h1 style="font-family: 'Oleo Script'; text-shadow: 1px 1px #fff; font-size: 29px;"><?php echo Yii::t('yii', 'Posts:') ?></h1>
        <?php if ($memes): ?>
            <?php foreach ($memes as $i =>$meme): ?>
                <?php $this->renderPartial('//partials/meme', array('meme' => $meme, 'single' => false)) ?>
                <?php echo $i == 3 ? Settings::value('ad2') : ''; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <h4><?php echo Yii::t('yii', 'No meme found!') ?></h4>
        <?php endif; ?>
    </div>
    <div class="span4">
        <?php Yii::app()->plugin->beginBlock('sidebar') ?>
            <div class="corgi_feed_well">
                <div class="sidebar_header">
                    <div class="sidebar_title">
                        <h4><?php echo Yii::t('yii', 'Followers:') ?></h4>
                    </div>
                </div>
                <hr class="feed_hr" />
                <div class="sidebar_interior">
                    <?php if($followers = $user->followers(array('order' => 'followers.created_at DESC', 'with' => 'follower', 'scopes' => 'follower_visible'))): ?>
                        <div class="clearfix">
                            <?php foreach($followers as $follower): ?>
                                    <a class="ttip follow-user-avatar" title="<?php echo CHtml::encode($follower->follower->first_name . ' ' . $follower->follower->last_name) ?>" href="<?php echo Yii::app()->createUrl('site/profile', array('profile' => $follower->follower->username)) ?>"><img src="<?php echo Yii::app()->user->getAvatar_url($follower->follower->user_id); ?>" alt="<?php echo CHtml::encode($follower->follower->first_name . ' ' . $follower->follower->last_name) ?>" /></a> 
                            <?php endforeach ?>
                        </div>
                    <?php else: ?>
                        <small><em><?php echo Yii::t('yii', 'No followers') ?></em></small>
                    <?php endif ?>
                </div>
            </div>
        <?php Yii::app()->plugin->endBlock() ?>
        
        <?php Yii::app()->plugin->beginBlock('sidebar') ?>
            <div class="corgi_feed_well">
                <div class="sidebar_header">
                    <div class="sidebar_title">
                        <h4><?php echo Yii::t('yii', 'Following:') ?></h4>
                    </div>
                </div>
                <hr class="feed_hr" />
                <div class="sidebar_interior">
                    <?php if($followings = $user->followings(array('order' => 'followings.created_at DESC', 'with' => 'following', 'scopes' => 'following_visible'))): ?>
                        <div class="clearfix">
                            <?php foreach($followings as $following): ?>
                                    <a class="ttip follow-user-avatar" title="<?php echo CHtml::encode($following->following->first_name . ' ' . $following->following->last_name) ?>" href="<?php echo Yii::app()->createUrl('site/profile', array('profile' => $following->following->username)) ?>"><img src="<?php echo Yii::app()->user->getAvatar_url($following->following->user_id); ?>" alt="<?php echo CHtml::encode($following->following->first_name . ' ' . $following->following->last_name) ?>" /></a> 
                            <?php endforeach ?>
                        </div>
                    <?php else: ?>
                        <small><em><?php echo Yii::t('yii', 'No followings') ?></em></small>
                    <?php endif ?>
                </div>
            </div>
        <?php Yii::app()->plugin->endBlock() ?>
        
        <?php Yii::app()->plugin->beginBlock('sidebar') ?>
            <div class="corgi_feed_well">
                <div class="sidebar_header">
                    <div class="sidebar_title">
                        <h4><?php echo Yii::t('yii', 'Recent Likes:') ?></h4>
                    </div>
                </div>
                <hr class="feed_hr" />
                <div class="sidebar_interior">
                    <?php if($likes = $user->likes(array('limit' => 10, 'order' => 'likes.created_at DESC', 'with' => 'meme', 'scopes' => array('visible')))): ?>
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
        <?php echo Settings::value('ad1') ?>
        <?php Yii::app()->plugin->endBlock() ?>
        
        <?php Yii::app()->plugin->renderRegion('sidebar') ?>
    </div>
</div>

