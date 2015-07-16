<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('yii', 'Contact Us');
?>
<div class="well">
    <?php if (Yii::app()->user->hasFlash('contact')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('contact'); ?>
        </div>
    <?php else: ?>

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'contact-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            ),
        ));
        ?>

        <fieldset>
            <legend><?php echo Yii::t('yii', 'Contact Us') ?></legend>

            <?php echo $form->errorSummary($model); ?>


            <div class="control-group">
                <?php echo $form->labelEx($model, 'name', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'name'); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'email'); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>

            
            <div class="control-group">
                <?php echo $form->labelEx($model, 'subject', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128)); ?>
                    <?php echo $form->error($model, 'subject'); ?>
                </div>
            </div>

            
            <div class="control-group">
                <?php echo $form->labelEx($model, 'body', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50)); ?>
                    <?php echo $form->error($model, 'body'); ?>
                </div>
            </div>

            <?php if (CCaptcha::checkRequirements()): ?>
            
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'verifyCode', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <div>
                            <?php $this->widget('CCaptcha'); ?>
                        </div>
                        <?php echo $form->textField($model, 'verifyCode', array('style' => 'margin:5px 0;')); ?>
                        
                        <div class="alert alert-info"><?php echo Yii::t('yii', 'Please enter the letters as they are shown in the image above. Letters are not case-sensitive.') ?></div>
                        <?php echo $form->error($model, 'verifyCode'); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-actions">
                <?php echo CHtml::submitButton(Yii::t('yii', 'Submit'), array('class' => 'btn-large btn-primary')); ?>
            </div>
        </fieldset>
        <?php $this->endWidget(); ?>


    <?php endif; ?>
</div>