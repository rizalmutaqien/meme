<div class="well">
    <?php if($memes): ?>
        <table class="table table-striped">
            <tr>
                <th class="text-center"><?php echo Yii::t('yii', 'Meme') ?></th>
                <th><?php echo Yii::t('yii', 'Title') ?></th>
                <th class="text-center"><?php echo Yii::t('yii', 'Likes') ?></th>
                <th class="text-center"><?php echo Yii::t('yii', 'Published?') ?></th>
                <th class="text-center"><?php echo Yii::t('yii', 'Approved?') ?></th>
                <th class="text-center"></th>
            </tr>
            <?php foreach($memes as $meme): ?>
            <tr>
                <td class="text-center"><img src="<?php echo $meme->thumb_url ?>" /></td>
                <td class="text-middle"><?php echo CHtml::encode($meme->title) ?></td>
                <td class="text-center text-middle"><?php echo CHtml::encode($meme->likes_count) ?></td>
                <td class="text-center text-middle"><?php echo $meme->is_published ?></td>
                <td class="text-center text-middle"><?php echo $meme->is_active ?></td>
                <td class="text-center text-middle">
                    <a class="ttip" title="<?php echo Yii::t('yii', $meme->is_published ? 'unpublish' : 'publish') ?>" href="<?php echo Yii::app()->createUrl('site/publish', array('id' => $meme->meme_id)) ?>"><i class="icon-eye-<?php echo $meme->is_published ? 'open' : 'close' ?>"></i></a>
                    <a class="ttip" title="<?php echo Yii::t('yii', 'download') ?>" href="<?php echo Yii::app()->createUrl('site/download', array('id' => $meme->meme_id)) ?>"><i class="icon-download"></i></a>
                    <a class="ttip" onclick="return confirm('Are you sure?')" title="<?php echo Yii::t('yii', 'delete') ?>" href="<?php echo Yii::app()->createUrl('site/delete', array('id' => $meme->meme_id)) ?>"><i class="icon-trash"></i></a>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
    <?php Yii::t('yii', 'You have not generated any meme.'); ?>
    <?php endif ?>
</div>