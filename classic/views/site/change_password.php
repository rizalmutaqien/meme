<div class="well">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'change-password-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
            ));
    ?>

    <fieldset>
        <legend><?php echo Yii::t('yii', 'Change Password') ?></legend>

        <div class="alert">
            <button class="close" data-dismiss="alert">×</button>
            <?php echo Yii::t('yii', 'Fields with * are required.') ?>
        </div>

        <?php if($mode == 'change' && User::model()->findByPk(Yii::app()->user->id)->password): ?>
            <?php $error = $form->error($formModel, 'old_password', array('class' => 'help-block')); ?>
            <div class="control-group <?php echo strip_tags($error) ? 'error' : '' ?>">
                <?php echo $form->labelEx($formModel, 'old_password', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->passwordField($formModel, 'old_password', array('class' => 'input-xlarge')); ?>
                    <?php echo $error; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php $error = $form->error($formModel, 'password', array('class' => 'help-block')); ?>
        <div class="control-group <?php echo strip_tags($error) ? 'error' : '' ?>">
            <?php echo $form->labelEx($formModel, 'password', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->passwordField($formModel, 'password', array('class' => 'input-xlarge')); ?>
                <?php echo $error; ?>
            </div>
        </div>

        <?php $error = $form->error($formModel, 'password2', array('class' => 'help-block')); ?>
        <div class="control-group <?php echo strip_tags($error) ? 'error' : '' ?>">
                <?php echo $form->labelEx($formModel, 'password2', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->passwordField($formModel, 'password2', array('class' => 'input-xlarge')); ?>
                <?php echo $error; ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::submitButton(Yii::t('yii', 'Update'), array('class' => 'btn btn-primary')); ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>