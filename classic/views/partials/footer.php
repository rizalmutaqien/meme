        </div>
        <br/><br/>
        <div class="corgi_footer">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div>
                            <?php
                            $pages = array(
                                'encodeLabel' => false,
                                'htmlOptions' => array(
                                ),
                            );
                            $pages['items'] = array(
                                    array('label' => Yii::t('yii', 'Home'), 'url' => Yii::app()->homeUrl),
                                    array('label' => Yii::t('yii', 'Create Meme'), 'url' => array('/generate')),
                                );

                            $footerPages = Page::model()->position('footer')->active()->findAll();
                            if($footerPages) {
                                foreach($footerPages as $page) {
                                    $pages['items'][] = array(
                                        'label' => Yii::t('yii', $page->title),
                                        'url' => Yii::app()->createUrl('site/cms', array('slug' => $page->slug)),
                                    );
                                }
                            }

                            $pages['items'][] = array('label' => Yii::t('yii', 'Contact'), 'url' => array('/site/contact'));
                            $this->widget('zii.widgets.CMenu', $pages);
                            ?>
                        </div>
                        <div class="corgi_copyright">
                            &copy; <?php echo date('Y') . ' ' . Yii::app()->name ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Le javascript
        ================================================== -->
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/bootstrap.js"></script>
        <script>
            $('.ttip').tooltip({html: true});
        </script>
        <?php echo Yii::app()->plugin->onBodyEnd(new CEvent($this)) ?>
    </body>
</html>