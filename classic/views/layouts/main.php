<?php $this->renderPartial('//partials/header', $this->data); // changed v2.16 ?>
    <?php
    if (Utility::hasFlash('error')) {
        foreach (Utility::getFlash('error') as $message) {

            echo '<div class="alert alert-error">
                                    <button class="close" data-dismiss="alert">×</button>
                                    ' . $message . '
                                </div>';
        }
    }
    ?>
    <?php
    if (Utility::hasFlash('success')) {
        foreach (Utility::getFlash('success') as $message) {

            echo '<div class="alert alert-success">
                                    <button class="close" data-dismiss="alert">×</button>
                                    ' . $message . '
                                </div>';
        }
    }
    ?>
    <?php echo Settings::value('ad3'); ?>
    <?php echo $content ?>
<?php $this->renderPartial('//partials/footer', $this->data); // changed v2.16 ?>
