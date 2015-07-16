<?php $memeUrl = $meme->post_url ?>
<div class="corgi_feed_well">
    <div class="feed_stacked">
        <div class="feed_item meme">
            <div class="feed_body">
                <div class="row">
                    <div class="feed_profile_pic">
                        <a href="<?php echo Yii::app()->createUrl('site/profile', array('profile' => $meme->user->username)) ?>"><img src="<?php echo Yii::app()->user->getAvatar_url($meme->user_fk) ?>" alt="<?php echo CHtml::encode("{$meme->user->first_name} {$meme->user->last_name}") ?>" title="<?php echo CHtml::encode("{$meme->user->first_name} {$meme->user->last_name}") ?>" class="meta_image ttip" /></a>
                    </div>
                    <span class="timesago"><?php echo Yii::app()->format->formatTimeago($meme->created_at) ?></span>
                    <div class="feed_text text-center">
                        <h3><a href="<?php echo $memeUrl ?>"><?php echo CHtml::encode($meme->title) ?></a></h3>
                        <?php
                            // changed v2.16
                            $isGif = substr($meme->file, -3) == 'gif';
                            if($single):
                        ?>
                            <a href="<?php echo $memeUrl ?>"><img class="meme-img" src="<?php echo $isGif ? $meme->url_orignal : $meme->url ?>" alt="<?php echo CHtml::encode($meme->title) ?>" /></a>
                        <?php else: ?>
                            <a href="<?php echo $memeUrl ?>" class="<?php echo $isGif ? 'play-gif' : '' ?>" style="position:relative;">
                                <img class="meme-img" data-src-orignal="<?php echo $meme->url_orignal ?>" src="<?php echo $meme->url ?>" alt="<?php echo CHtml::encode($meme->title) ?>" />
                                <?php if($isGif): ?>
                                    <i class="icon-play" style="color: rgba(0, 0, 0, 0.3);font-size: 70px;left: 40%;position: absolute;text-decoration: none;top: -100%;"></i>
                                <?php endif ?>
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <hr class="feed_hr">
            <div class="meme-menu">
                <div class="social-share clearfix" data-url="<?php echo $memeUrl ?>" data-text="<?php echo CHtml::encode($meme->title) ?>" data-title="share"></div>
                <a class="meme-menu-btn ttip like-btn <?php echo Meme::hasLiked($meme) ? 'liked' : '' ?>  <?php echo Yii::app()->user->isGuest ? 'login-modal" data-toggle="modal" data-target="#login-modal"' : '"' ?> title="<span style='white-space:nowrap;'><?php echo $meme->likes_count . ' ' . Yii::t('yii', 'like(s)') ?></span>" data-meme-id="<?php echo $meme->meme_id ?>" href="javascript:;"><i class="icon-heart-empty"></i></a>
                <a class="fb-comment-btn meme-menu-btn" data-meme-id="<?php echo $meme->meme_id ?>" href="<?php echo $memeUrl ?>"><i class="icon-comments"></i></a>
                <?php
                    // added v2.16
                    if(!$isGif):
                ?>
                    <a class="meme-menu-btn ttip" title="<span style='white-space:nowrap;'><?php echo Yii::t('yii', 'Remix this') ?></span>" data-meme-id="<?php echo $meme->meme_id ?>" href="<?php echo Yii::app()->createUrl('generate/index', array('meme' => $meme->meme_id)) ?>"><i class="icon-random"></i></a>
                <?php endif ?>
                <?php if($meme->user_fk == Yii::app()->user->id): ?>
                    <a class="delete-meme-btn meme-menu-btn ttip" title="<?php echo Yii::t('yii', 'delete') ?>" data-meme-id="<?php echo $meme->meme_id ?>" href="<?php echo Yii::app()->createUrl('site/delete', array('id' => $meme->meme_id)) ?>"><i class="icon-trash"></i></a>
                <?php endif ?>
            </div>
            <?php if(!Yii::app()->user->isGuest && !Meme::hasFlagged($meme->meme_id)): ?>
                <a class="ttip mark-flag no-underline" title="<?php echo Yii::t('yii', 'mark as inappropriate') ?>" href="<?php echo Yii::app()->createUrl('site/flag', array('id' => $meme->meme_id)) ?>"><i class="icon-flag"></i> Report</a>
            <?php endif ?>
        </div>
    </div>
</div>

<div id="login-modal" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="modal-body" id="login-modal-content" style="margin-left:45px;">

    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn">Close</a>
    </div>
</div>

<?php 
    $js = <<<JS
    $('.fb-comment-btn').click(function(){
        if(!$(this).hasClass('fb-comments-init')) {
            var href = $(this).attr('href');
            var uniqid = 'fb-comments-' + _.uniqueId();
            $(this).parent().parent().append('<div id="'+ uniqid +'"><div class="fb-comments" data-href="' + href + '" data-width="620" data-num-posts="10"></div></div>');
            FB.XFBML.parse(document.getElementById(uniqid));
            $(this).addClass('fb-comments-init');
        }
        else {
            $(this).parent().parent().find('.fb-comments').toggle();
        }
        var comments = $(this).parent().parent().find('.fb-comments');   
        $("html, body").animate({ scrollTop: comments.offset().top - 100}, 400);
            
        return false;
    });
JS;
    Yii::app()->clientScript->registerScript('fb-comment-btn', $js, CClientScript::POS_END);
    
    if($single) {
    
        $this->extra[] = '<link rel="image_src" href="' . $meme->url . '" />';
        $this->og_image = $meme->url;
        $this->og_url = $memeUrl;
        $this->og_title = CHtml::encode($meme->title);
    
        Yii::app()->clientScript->registerScript('fb-comment-btn-click', <<<JS
                $('.fb-comment-btn').parent().parent().append('<div id="fb-comments-1"><div class="fb-comments" data-href="' + $('.fb-comment-btn').attr('href') + '" data-width="620" data-num-posts="10"></div></div>');
                $('.fb-comment-btn').addClass('fb-comments-init');
JS
    , CClientScript::POS_END);
    }
    
    $url = Yii::app()->createUrl('/site');
    
    if(!Yii::app()->user->isGuest) {
        $js = <<<JS
        $('.like-btn').click(function(){
            if($(this).hasClass('liking')) {
                return false;
            }

            $(this).addClass('liking');
            var self = this;
            var isLiked = $(this).hasClass('liked');
            var meme_id = $(this).data('meme-id');
            var url =  '$url' + (isLiked ? '/memeunlike' : '/memelike');

            $.get(url, {id: meme_id}, function() {
                $(self).removeClass('liking');
            }, 'json');

            if(isLiked) {
                $(this).removeClass('liked');
            }
            else {
                $(this).addClass('liked');
            }
        });
JS;
        Yii::app()->clientScript->registerScript('like-btn', $js, CClientScript::POS_END);
    }
    else {
        Yii::app()->clientScript->registerScript('login-modal', <<<JS
                $.get('$url/login', function(content){
                    $('#login-modal-content').html(content);
                });
JS
        , CClientScript::POS_END);
    }
    
    
    Yii::app()->clientScript->registerScript('mark-flag', <<<JS
        $('.mark-flag').click(function(){
            var href = $(this).attr('href');
            var self = this;
            $.get(href,function(){
                $(self)
                    .fadeOut();
            });
            return false;
        });
JS
    , CClientScript::POS_END);
    
    // added v2.16
    Yii::app()->clientScript->registerScript('play-gif', <<<JS
        $('.play-gif').click(function(){
            if($(this).hasClass('play-gif')) {
                var img = $(this).find('img');
                var src = $(img).data('src-orignal');

                img.attr('src', src);
                $(this).removeClass('play-gif');
                $(this).find('.icon-play').remove();
                return false;
            }
        });
JS
    , CClientScript::POS_END);
?>