<?php
$this->breadcrumbs = array(
    Yii::t('yii', 'Forgot Password'),
);
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'forgot-password-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<fieldset>
    <legend><?php echo Yii::t('yii', 'Forgot Password') ?></legend>

    <div class="alert">
        <button class="close" data-dismiss="alert">×</button>
        <?php echo Yii::t('yii', 'Fields with * are required.') ?>
    </div>

    <?php $error = $form->error($model, 'email', array('class' => 'help-block')); ?>
    <div class="control-group <?php echo strip_tags($error) ? 'error' : '' ?>">
        <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'email', array('class' => 'input-xlarge')); ?>
            <?php echo $error; ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::submitButton(Yii::t('yii', 'Change'), array('class' => 'btn btn-primary')); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>
