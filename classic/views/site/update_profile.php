<?php
Yii::app()->clientScript
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui/js/jquery-ui-1.9.2.custom.min.js')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jQuery-File-Upload/js/jquery.iframe-transport.js')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jQuery-File-Upload/js/jquery.fileupload.js')
        ->registerCssFile(Yii::app()->theme->baseUrl . '/js/jQuery-File-Upload/css/jquery.fileupload-ui.css')
;
?>
<div class="well">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'update-profile-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'enctype' => 'multipart-form/data',
        ),
    ));
    
    echo $form->hiddenField($model, 'avatar', array(
        'id' => 'avatar'
    ));
    ?>

    <fieldset>
        <legend class="clearfix">
            <i class="icon-user"></i> <?php echo Yii::t('yii', 'Update Profile') ?>
            <a class="btn btn-success pull-right" href="<?php echo Yii::app()->createUrl('site/profile', array('profile' => $user->username)) ?>">View your profile</a>
        </legend>

        <div class="alert">
            <button class="close" data-dismiss="alert">×</button>
            <?php echo Yii::t('yii', 'Fields with * are required.') ?>
        </div>

        <div class="control-group">
            <label class="control-label">Username</label>
            <div class="controls">
                <input readonly="readonly" class="input-xlarge" value="<?php echo CHtml::encode($user->username) ?>" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Email</label>
            <div class="controls">
                <input readonly="readonly" class="input-xlarge" value="<?php echo CHtml::encode($user->email) ?>" />
            </div>
        </div>

        <?php $error = $form->error($model, 'first_name', array('class' => 'help-block')); ?>
        <div class="control-group <?php echo strip_tags($error) ? 'error' : '' ?>">
            <?php echo $form->labelEx($model, 'first_name', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'first_name', array('class' => 'input-xlarge')); ?>
                <?php echo $error; ?>
            </div>
        </div>

        <?php $error = $form->error($model, 'last_name', array('class' => 'help-block')); ?>
        <div class="control-group <?php echo strip_tags($error) ? 'error' : '' ?>">
            <?php echo $form->labelEx($model, 'last_name', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'last_name', array('class' => 'input-xlarge')); ?>
                <?php echo $error; ?>
            </div>
        </div>

        <div class="clearfix">
            <span class="btn btn-success fileinput-button pull-left">
                <i class="icon-picture icon-white"></i>
                <span><?php echo Yii::t('yii', 'Upload Avatar...') ?></span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="fileupload" type="file" name="files[]">
            </span>
            
            <div id="avatar-preview" class="pull-left" style="width:32px;height:32px;margin-left:10px;">
                <img src="<?php echo Yii::app()->user->avatar_url ?>" />
            </div>
        </div>

        <br>
        <!-- The global progress bar -->
        <div id="progress" class="progress progress-success progress-striped" style="display: none;">
            <div class="bar"></div>
        </div>
        <!-- The container for the uploaded files -->
        <!--<div id="files"></div>-->

        <div class="form-actions">
            <?php echo CHtml::submitButton(Yii::t('yii', 'Update'), array('class' => 'btn btn-primary')); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>

<script>

    $('#fileupload').fileupload({
        url: '<?php echo Yii::app()->createUrl('generate/upload_bg') ?>',
        dataType: 'json',
        done: function(e, data) {
            if(data.result.error == 1) {
                $('#progress').removeClass('progress-success').addClass('progress-danger');
            }
            else if(data.result.files) {
                $.each(data.result.files, function(index, file) {
                    $('#progress').removeClass('progress-danger').addClass('progress-success');
                    $('#progress').fadeOut();
                    $('#avatar').val(file.name);
                    $('#avatar-preview').html('<img src="'+ file.thumbnail_url + '" width="32" height="32" />');
                });
            }
        },
        progressall: function(e, data) {
            $('#progress').show();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                    'width',
                    progress + '%'
                    );
        }
    });
</script>
