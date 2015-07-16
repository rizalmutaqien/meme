<div class="row">
    <div class="span6" style="float: none;margin: 0 auto;">
        <div class="corgi_feed_well">
            <div class="individual_feed_item">
                <div class="feed_item">
                    <h2 style="font-family: 'Oleo Script';font-size: 30px; text-shadow: 2px 2px #ddd;padding:10px 0 0 10px;text-align:center;color:#000;margin:0;">
                        <?php echo Yii::t('yii', 'Login') ?>
                    </h2>
                    <div class="feed_body offset1">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'login-form',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                            'htmlOptions' => array(
                                'class' => 'form-inline'
                            ),
                        ));
                        ?>

                        <div class="form-row">
                            <div>
                                <i class="icon-user"></i>
                                <?php echo $form->labelEx($model, 'username'); ?>
                            </div>
                            <div><?php echo $form->textField($model, 'username'); ?></div>
                            <div><?php echo $form->error($model, 'username'); ?></div>
                        </div>

                        <div class="form-row">
                            <div>
                                <i class="icon-key"></i>
                                <?php echo $form->labelEx($model, 'password'); ?>
                            </div>
                            <div><?php echo $form->passwordField($model, 'password'); ?></div>
                            <div><?php echo $form->error($model, 'password'); ?></div>
                        </div>

                        <div class="form-row">
                            <label><?php echo $form->checkBox($model, 'rememberMe'); ?> <?php echo Yii::t('yii', 'Remember me') ?></label>
                        </div>

                        <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-primary', 'style' => 'width: 70%;')); ?>
                        <div style="font-size: 12px;margin-right: 95px;margin-top: 6px;text-align: center;">
                            <a href="<?php echo Yii::app()->createUrl('site/forgot_password') ?>"><?php echo Yii::t('yii', 'Forgot Password?') ?></a>
                        </div>
                        <?php $this->endWidget(); ?>
                        
                        
                        
                        <h2 style="font-family: 'Oleo Script';font-size: 18px; padding-left:50px;color:#666666;margin:0;">- <?php echo Yii::t('yii', 'Or Login with') ?> -</h2>
                        
                        <a style="margin-left:25px;" class="social-signin signin-fb" href="<?php echo $this->createUrl('site/login?provider=facebook'); ?>"><i class="icon-facebook-sign"></i></a>
                        <a class="social-signin signin-gp" href="<?php echo $this->createUrl('site/login?provider=google'); ?>"><i class="icon-google-plus-sign"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>