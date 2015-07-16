<?php
/* @var $this GenerateController */

$this->breadcrumbs = array(
    'Generate',
);

Yii::app()->clientScript
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/fabric.js')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery-ui/js/jquery-ui-1.9.2.custom.min.js')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/chosen/chosen/chosen.jquery.min.js')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jQuery-File-Upload/js/jquery.iframe-transport.js')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jQuery-File-Upload/js/jquery.fileupload.js')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/bgrins-spectrum/spectrum.js')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.jcarousel.min.js')
        ->registerScriptFile(Yii::app()->theme->baseUrl . '/js/content-scroller/jquery.mCustomScrollbar.concat.min.js')
        ->registerCssFile(Yii::app()->theme->baseUrl . '/js/jcarousel-skins/tango/skin.css')
        ->registerCssFile(Yii::app()->theme->baseUrl . '/js/jQuery-File-Upload/css/jquery.fileupload-ui.css')
        ->registerCssFile(Yii::app()->theme->baseUrl . '/js/chosen/chosen/chosen.css')
        ->registerCssFile(Yii::app()->theme->baseUrl . '/js/jquery-ui/css/custom-theme/jquery-ui-1.10.0.custom.css')
        ->registerCssFile(Yii::app()->theme->baseUrl . '/js/bgrins-spectrum/spectrum.css')
        ->registerCssFile(Yii::app()->theme->baseUrl . '/js/content-scroller/jquery.mCustomScrollbar.css')
;
?>
<div class="row">
    <div class="span8">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'meme-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
        <div class="corgi_feed_well" id="meme-right">

            <h4><?php echo Yii::t('yii', 'Meme name:') ?></h4>
            
            <div class="control-group title-field-group <?php echo $model->hasErrors('title') ? 'error' : '' ?>">
                <?php echo CHtml::activeTextField($model, 'title', array('id' => 'title-field', 'style' => 'width: 100%;', 'placeholder' => Yii::t('yii', 'Name of your meme'))) ?>
                <span class="help-inline <?php echo $model->hasErrors('title') ? '' : 'hide' ?>"><?php echo implode('<br />', $model->getErrors('title')) ?></span>
            </div>

            <div id="meme-templates-wrap" class="clearfix text-center">
                <ul id="meme-templates" class="jcarousel-skin-tango">
                    <?php $templates = glob(Yii::getPathOfAlias('webroot.templates') . DIRECTORY_SEPARATOR . '*-thumb.png') ?>
                    <?php foreach ($templates as $template): ?>
                        <?php $file = basename($template) ?>
                        <li><a class="meme-template" href="<?php echo Yii::app()->request->baseUrl ?>/templates/<?php echo str_replace('-thumb', '', $file) ?>"><img src="<?php echo Yii::app()->request->baseUrl ?>/templates/<?php echo $file ?>" /></a></li>
                    <?php endforeach; ?>
                </ul>
                <span class="btn btn-success fileinput-button" style="font-size: 11px;">
                    <i class="icon-picture icon-white"></i>
                    <span><?php echo Yii::t('yii', 'Upload custom background...') ?></span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files[]">
                </span>

                    <button style="padding:4px 7px;" class="btn btn-mini btn-primary remove-bg-img" type="button"><?php echo Yii::t('yii', 'Remove backgound image') ?></button>
                <button id="bg-use-as-image" type="button" class="btn btn-mini btn-primary btn-check  <?php echo $remixMeme ? 'hide active' : '' ?>" data-toggle="button" style="padding:8px 7px;line-height:12px;"><i class="icon-btn-check"></i> Use as image</button>
            </div>

            <br>
            <!-- The global progress bar -->
            <div id="progress" class="progress progress-success progress-striped" style="display: none;">
                <div class="bar"></div>
            </div>
            <!-- The container for the uploaded files -->
            <!--<div id="files"></div>-->

            
            
            <div style="clear:both;"></div>

            <div id="meme-wrap" style="position: relative;margin: 0 auto;">
                <div class="pull-left">
                    <input type='text' id="meme-background" />
                    <span style="font-size: 11px;"><?php echo Yii::t('yii', 'Background Color') ?> </span>
                </div>

                <div class="pull-right" style="font-size: 11px;margin-bottom: 10px;">
                    <?php echo Yii::t('yii', 'Height') ?> <input id="height-spinner" name="value" value="450" style="width:50px" />
                </div>
                <div style="clear:both;"></div>
                
                <canvas id="c" width="450" height="<?php echo $remixMeme ? $remixMeme->height : 450 ?>" style="border:1px solid #aaa"></canvas>
                <div id="draw-toolbox">
                        <div class="draw-toolbox-heading">
                            <?php echo Yii::t('yii', 'tools') ?>
                        </div>
                    
                        <div class="clearfix">
                            <div id="draw-tools" class="is-vertical btn-group btn-group-vertical" data-toggle="buttons-radio" style="margin-top:3px;">
                                <button data-placement="left" type="button" title="Pencil draw" id="draw-pencil" class="btn btn-primary ttip"><i class="icon-pencil">&nbsp;</i></button>
                                <button data-placement="left" type="button" title="Select objects" id="draw-select" class="btn btn-primary ttip"><i class="icon-move">&nbsp;</i></button>
                            </div>

                            <div class="is-vertical btn-group btn-group-vertical" style="margin-top:3px;">
                                <button data-placement="left" class="btn btn-primary ttip" id="send-backwards" title="<?php echo Yii::t('yii', 'send backwards') ?>" type="button"><i class="icon-level-down"></i></button>
                                <button data-placement="left" class="btn btn-primary ttip" id="bring-forward" title="<?php echo Yii::t('yii', 'send forward') ?>" type="button"><i class="icon-level-up"></i></button>
                            </div>

                            <div class="is-vertical btn-group btn-group-vertical" style="margin-top:3px;">
                                <button data-placement="left" type="button" title="Circle" id="draw-circle" class="ttip btn btn-primary"><i class="icon-circle">&nbsp;</i></button>
                                <button data-placement="left" type="button" title="Square" id="draw-square" class="ttip btn btn-primary"><i class="icon-stop">&nbsp;</i></button>
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="draw-toolbox-heading pull-left">
                                <?php echo Yii::t('yii', 'stroke size') ?>
                            </div>
                            <div class="draw-toolbox-item pull-right">
                                <input value="1" id="draw-pencil-width" style="width:20px;margin-top:3px;" />
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="draw-toolbox-heading pull-left">
                                <?php echo Yii::t('yii', 'stroke color') ?>
                            </div>
                            <div class="draw-toolbox-item pull-right">
                                <input type='text' id="draw-stroke-color" style="margin-top:3px;" />
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="draw-toolbox-heading pull-left">
                                <?php echo Yii::t('yii', 'fill color') ?>
                            </div>
                            <div class="draw-toolbox-item pull-right">
                                <input type='text' id="draw-fill-color" style="margin-top:3px;" />
                            </div>
                        </div>
                    
                    
                        <div class="clearfix">
                            <div class="draw-toolbox-heading pull-left">
                                <?php echo Yii::t('yii', 'opacity') ?>
                            </div>
                            <div class="draw-toolbox-item pull-right">
                                <input value="100" id="opacity-spinner" style="width:20px;margin-top:3px;" />
                            </div>
                        </div>

                        <div class="draw-toolbox-item">
                            <button type="button" class="btn btn-danger hide draw-hide remove-object ttip" title="remove object" style="width:48px;"><i class="icon-trash"></i></button>
                        </div>
                </div>
            </div>
            
            <?php echo CHtml::activeHiddenField($model, 'image', array('id' => 'img-data')) ?>

            <div class="control-group <?php echo $model->hasErrors('publish') ? 'error' : '' ?>" style="margin-top:10px;text-align: right;">
                <?php echo CHtml::activeCheckBox($model, 'publish', array('style' => 'margin: 0;', 'checked' => 'checked')) ?>
                <?php echo $form->labelEx($model, 'publish', array('style' => 'display: inline;margin-top:2px;')); ?>
            </div>
            <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-primary', 'id' => 'save-btn', 'style' => 'width: 100%;')) ?>
        </div>

<?php $this->endWidget() ?>
    </div>
    <div class="span4">
        <div class="corgi_feed_well">
            <div class="sidebar_interior" id="meme-options">
                <div class="accordion" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a id="text-mode" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse-text">
                                <i class="icon-font"></i> <?php echo Yii::t('yii', 'Add Text') ?>
                                <i class="acc-down icon-double-angle-down pull-right"></i>
                                <i class="acc-up icon-double-angle-up pull-right hide"></i>
                            </a>
                        </div>
                        <div id="collapse-text" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <h4><?php echo Yii::t('yii', 'Text') ?></h4>
                                <textarea id="text-text"></textarea>

                                <h4><?php echo Yii::t('yii', 'Font Family') ?></h4>
                                <select id="text-font-family" data-placeholder="Choose a font" class="chzn-select">
                                    <option value="arial">Arial</option>
                                    <option value="helvetica" selected="">Helvetica</option>
                                    <option value="myriad pro">Myriad Pro</option>
                                    <option value="delicious">Delicious</option>
                                    <option value="verdana">Verdana</option>
                                    <option value="georgia">Georgia</option>
                                    <option value="courier">Courier</option>
                                    <option value="comic sans ms">Comic Sans MS</option>
                                    <option value="impact">Impact</option>
                                    <option value="monaco">Monaco</option>
                                    <option value="optima">Optima</option>
                                    <option value="hoefler text">Hoefler Text</option>
                                    <option value="plaster">Plaster</option>
                                    <option value="engagement">Engagement</option>
                                </select>

                                <h4><?php echo Yii::t('yii', 'Text Size') ?></h4>
                                <div id="text-font-size"></div>

                                <h4><?php echo Yii::t('yii', 'Text Style') ?></h4>
                                <p id="text-formats" class="ui-buttonset">
                                    <input type="checkbox" id="text-bold"><label for="text-bold" class="ui-button ui-widget ui-button-text-only ui-corner-left" role="button"><span class="ui-button-text"><?php echo Yii::t('yii', 'Bold') ?></span></label>
                                    <input type="checkbox" id="text-italic"><label for="text-italic" class="ui-button ui-widget ui-button-text-only" role="button"><span class="ui-button-text"><?php echo Yii::t('yii', 'Italic') ?></span></label>
                                    <input type="checkbox" id="text-underline"><label for="text-underline" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-right" role="button"><span class="ui-button-text"><?php echo Yii::t('yii', 'Underline') ?></span></label>
                                </p>

                                <div class="clearfix">
                                    <div class="pull-left">
                                        <h4><?php echo Yii::t('yii', 'Text Color') ?></h4>
                                        <input type='text' id="text-color" />
                                    </div>

                                    <div class="pull-left" style="margin-left: 10px;margin-top:45px;">
                                        <a href="javascript:;" class="btn btn-danger hide text-hide remove-object"><i class="icon-trash"></i> <?php echo Yii::t('yii', 'Remove') ?></a>
                                    </div>
                                </div>

                                <br>
                                <hr class="feed_hr" />
                                <a id="text-add" class="btn btn-primary"><?php echo Yii::t('yii', 'Add Text') ?></a>
                                <a class="btn btn-primary hide" id="text-done"><?php echo Yii::t('yii', 'Done') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a id="image-mode" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse-image">
                                <i class="icon-picture"></i> <?php echo Yii::t('yii', 'Add Images') ?>
                                <i class="acc-down icon-double-angle-down pull-right"></i>
                                <i class="acc-up icon-double-angle-up pull-right hide"></i>
                            </a>
                        </div>
                        <div id="collapse-image" class="accordion-body collapse">
                            <div class="accordion-inner">
                                <h4><?php echo Yii::t('yii', 'Preset Images') ?></h4>
                                <div id="image-preset">
                                    <?php $preset_images = glob(Yii::getPathOfAlias('webroot.addon_images') . DIRECTORY_SEPARATOR . '*-thumb.png') ?>
                                    <?php foreach ($preset_images as $img): ?>
                                        <?php $file = basename($img) ?>
                                        <a class="add-image" href="<?php echo Yii::app()->request->baseUrl ?>/addon_images/<?php echo str_replace('-thumb', '', $file) ?>"><img src="<?php echo Yii::app()->request->baseUrl ?>/addon_images/<?php echo $file ?>" /></a>
                                    <?php endforeach; ?>
                                </div>

                                <h4><?php Yii::t('yii', 'Custom Uploads') ?></h4>
                                <a href="javascript:;" class="btn btn-success" id="upimg"><i class="icon-upload-alt"></i> <?php echo Yii::t('yii', 'Upload...') ?></a>

                                <div id="image-list"></div>
                                <input type="file" class="hide" id="image-upload" name="ifile" />

                                <h4><?php echo Yii::t('yii', 'Image Filters') ?></h4>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Brightness"><?php echo Yii::t('yii', 'Brightness') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Grayscale"><?php echo Yii::t('yii', 'Grayscale') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Invert"><?php echo Yii::t('yii', 'Invert') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Noise"><?php echo Yii::t('yii', 'Noise') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Pixelate"><?php echo Yii::t('yii', 'Pixelate') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Blur"><?php echo Yii::t('yii', 'Blur') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="RemoveWhite"><?php echo Yii::t('yii', 'Remove White') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Sharpen"><?php echo Yii::t('yii', 'Sharpen') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Emboss"><?php echo Yii::t('yii', 'Emboss') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Sepia"><?php echo Yii::t('yii', 'Sepia') ?></button>
                                <button type="button" class="btn btn-primary disabled image-filter" data-toggle="button" data-filter="Sepia2"><?php echo Yii::t('yii', 'Sepia2') ?></button>

                                <br /><br />
                                <a href="javascript:;" class="btn btn-danger hide image-hide remove-object"><i class="icon-trash"></i> <?php echo Yii::t('yii', 'Remove') ?></a>
                                <a class="btn btn-primary btn-done hide image-hide"><?php echo Yii::t('yii', 'Done') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>

<script>
    $("#text-font-size").slider({
        range: "min",
        min: 15,
        max: 100,
        value: 40,
        slide: function(event, ui) {
            MEME.TEXT.addUpdate(true);
        }
    });


    $('#draw-pencil-width').spinner({
        value: 1,
        min: 1,
        max: 20,
        spin: function(event, ui) {
            canvas.freeDrawingBrush.width = ui.value;
            if (canvas.getActiveObject()) {
                
                if(canvas.getActiveObject().getStroke() == null) {
                    canvas.getActiveObject().setStroke('#' + $('#draw-stroke-color').spectrum('get').toHex());
                }
                canvas.getActiveObject().setStrokeWidth(ui.value);
                canvas.renderAll();
            }
            else if (canvas.getActiveGroup()) {
                for(var i = 0; i < canvas.getActiveGroup().getObjects().length; i++) {
                    if(canvas.getActiveGroup().getObjects()[i].getStroke() == null) {
                        canvas.getActiveGroup().getObjects()[i].setStroke('#' + $('#draw-stroke-color').spectrum('get').toHex());
                    }
                    (canvas.getActiveGroup().getObjects()[i]).setStrokeWidth(ui.value);
                }
                canvas.renderAll();
            }
        }
    });

    $('#text-formats').buttonset();

    var canvas = new fabric.Canvas('c', {selection: true});
    canvas.freeDrawingBrush = new fabric['PencilBrush'](canvas);

    var MEME = {
        hasBg: false,
        keysMoveAllowed: true,
        objects: {
            background: null,
            text: []
        },
        addImage: function(url) {
            fabric.Image.fromURL(url, function(img) {
                img.scaleToWidth(canvas.getWidth() * 0.2);
                img.set({top: canvas.getWidth() / 2 - img.getWidth() / 2, left: canvas.getHeight() / 2 - img.getHeight() / 2});
                canvas.add(img);
                MEME.makeSelected();
            });
        },
        useBgAsImage: false,
        addBackground: function(url) {
            if (MEME.useBgAsImage === true) {
                MEME.addImage(url);
                return;
            }
            canvas.setBackgroundImage(url, function() {
                canvas.renderAll();
                MEME.hasBg = true;
            }, {backgroundImageStretch: false});
        },
        backgroundColor: function(color) {
            canvas.backgroundColor = color;
            canvas.renderAll();
        },
        removeBackground: function() {
            canvas.setBackgroundImage('<?php echo Yii::app()->theme->baseUrl ?>/img/trans.png', canvas.renderAll.bind(canvas));
            MEME.hasBg = false;
        },
        addText: function(opts) {
            opts = opts || {};
            var options = _.extend({}, MEME.TEXT.defaults, opts);
            var text = options.text;
            delete options.text;

            var txt = new fabric.Text(text, options);
            canvas.add(txt);
            txt.center();
            MEME.objects.text.push(txt);
            MEME.makeSelected();
        },
        addCircle: function(fill, strokeWidth, stroke) {
            strokeWidth = strokeWidth || 0;
            stroke = stroke || '';
            var c = new fabric.Circle({
                radius: 20, strokeWidth: strokeWidth, stroke: stroke, fill: fill, top: 230, left: 230
            });
            canvas.add(c);
            c.center();
            MEME.makeSelected();
        },
        addSquare: function(fill, strokeWidth, stroke) {
            strokeWidth = strokeWidth || 0;
            stroke = stroke || '';
            var c = new fabric.Rect({
                strokeWidth: strokeWidth, stroke: stroke, fill: fill, width: 50, height: 50, top: 230, left: 230
            });
            canvas.add(c);
            c.center();
            MEME.makeSelected();
        },
        updateText: function(txt, opts) {
            opts = opts || {};
            var options = _.extend({}, MEME.TEXT.defaults, opts);
            txt.setOptions(options);
            canvas.renderAll();
        },
        done: function() {
//            canvas.deactivateAll().renderAll();
//            canvas.trigger('selection:cleared');
        },
        filters: {
            Brightness: new fabric.Image.filters.Brightness,
            Grayscale: new fabric.Image.filters.Grayscale,
            Invert: new fabric.Image.filters.Invert,
            Noise: new fabric.Image.filters.Noise,
            Pixelate: new fabric.Image.filters.Pixelate,
            RemoveWhite: new fabric.Image.filters.RemoveWhite,
            Sepia: new fabric.Image.filters.Sepia,
            Sepia2: new fabric.Image.filters.Sepia2,
            Blur: new fabric.Image.filters.Convolute({
                matrix:
                        [1 / 9, 1 / 9, 1 / 9,
                            1 / 9, 1 / 9, 1 / 9,
                            1 / 9, 1 / 9, 1 / 9]
            }),
            Sharpen: new fabric.Image.filters.Convolute({
                matrix:
                        [0, -1, 0,
                            -1, 5, -1,
                            0, -1, 0]
            }),
            Emboss: new fabric.Image.filters.Convolute({
                matrix: [1, 1, 1,
                    1, 0.7, -1,
                    -1, -1, -1]
            })
        },
        makeSelected: function(obj, delay) {
            obj = obj || null;
            delay = delay || 0;
            if(obj == null) {
                obj = canvas.getObjects()[canvas.getObjects().length-1];
            }
            
            if(delay) {
                setTimeout(function(){
                    canvas.setActiveObject(obj);
                }, delay);
            }
            else {
                canvas.setActiveObject(obj);
            }
        }
    };

    MEME.TEXT = {
        defaults: {
            text: '<?php echo Yii::t('yii', 'Type some text...') ?>',
            fontFamily: 'arial',
            fontSize: 40,
            fontWeight: '',
            fontStyle: '',
            textDecoration: '',
            fill: '#000000',
            lineHeight: 1.3
        },
        resetForm: function(btnTxt, opts) {
            btnTxt = btnTxt || '<?php echo Yii::t('yii', 'Add Text') ?>';
            opts = opts || {};
            opts = _.extend({}, MEME.TEXT.defaults, opts);
            $('#text-text').val(opts.text);
            $('#text-font-family').val(opts.fontFamily);
            $('#text-font-size').slider('value', opts.fontSize);
            $("#text-add").text(btnTxt);

            $("#text-bold").prop('checked', opts.fontWeight == 'bold' ? true : false);
            $("#text-italic").prop('checked', opts.fontStyle == 'italic' ? true : false);
            $("#text-underline").prop('checked', opts.textDecoration == 'underline' ? true : false);

            $("#text-bold").prop('checked') ? $("#text-bold").next().addClass('ui-state-active') : $("#text-bold").next().removeClass('ui-state-active');
            $("#text-italic").prop('checked') ? $("#text-italic").next().addClass('ui-state-active') : $("#text-italic").next().removeClass('ui-state-active');
            $("#text-underline").prop('checked') ? $("#text-underline").next().addClass('ui-state-active') : $("#text-underline").next().removeClass('ui-state-active');

            $("#text-color").spectrum("set", opts.fill);
            $("#text-add").show();
            $('#text-done').hide();
//            canvas.isDrawingMode = false;
        },
        load: function(txt) {
            var opts = {};
            opts.text = txt.getText();
            opts.fontFamily = txt.get('fontFamily');
            opts.fontSize = txt.get('fontSize');
            opts.fontWeight = txt.get('fontWeight');
            opts.fontStyle = txt.get('fontStyle');
            opts.textDecoration = txt.get('textDecoration');
            opts.fill = txt.get('fill');
            MEME.TEXT.resetForm(null, opts);
            $("#text-add").hide();

            if (!$('#collapse-text').hasClass('in')) {
                $('#text-mode').click();
            }
        },
        addUpdate: function(updateMode) {
            updateMode = updateMode || false;

            if (updateMode && (!canvas.getActiveObject() || (canvas.getActiveObject() && canvas.getActiveObject().type !== 'text'))) {
                return false;
            }

            var opts = {};
            opts.text = $('#text-text').val();
            opts.fontFamily = $('#text-font-family').val();
            opts.fontSize = $("#text-font-size").slider('value');
            opts.fontWeight = $("#text-bold").prop('checked') ? 'bold' : '';
            opts.fontStyle = $("#text-italic").prop('checked') ? 'italic' : '';
            opts.textDecoration = $("#text-underline").prop('checked') ? 'underline' : '';
            opts.fill = '#' + $("#text-color").spectrum("get").toHex();

            if (updateMode) {
                var txt = canvas.getActiveObject();
                MEME.updateText(txt, opts);
            }
            else {
                MEME.addText(opts);
            }
        }
    };

    MEME.TEXT.resetForm();
    MEME.backgroundColor('#ffffff');

    canvas.on('selection:created', function(event){
        MEME.keysMoveAllowed = true;
        $('.draw-hide').show();
    });

    canvas.on('object:selected', function(event) {
        MEME.keysMoveAllowed = true;
        var obj = event.target;
        if (obj.type === 'text') {
            MEME.TEXT.load(obj);
            $('#text-done').show();
            $('.text-hide').show();
        }
        else if (obj.type === 'path' || obj.type === 'circle' || obj.type === 'rect') {
            if (!$('#collapse-draw').hasClass('in')) {
                $('#draw-select').click();
            }

            $('.draw-hide').show();
        }
        else if (obj.type === 'image') {
            
            if (!$('#collapse-image').hasClass('in')) {
                $('#image-mode').click();
            }
//            MEME.makeSelected(obj, 300);

            $('.image-filter').removeClass('disabled');
            if (obj.appliedFilters) {
                _.each(obj.appliedFilters, function(filter) {
                    $('.image-filter[data-filter=' + filter + ']').addClass('active');
                });
            }
            $('.image-hide').show();
        }
        canvas.calcOffset();
        if (canvas.getActiveObject()) {
            canvas.getActiveObject().setCoords();
        }
        $('#draw-select').addClass('active');
    });

    canvas.on('selection:cleared', function(e) {
        MEME.TEXT.resetForm();
        $('.draw-hide').hide();
        $('.text-hide').hide();
        $('.image-hide').hide();
//        canvas.isDrawingMode = false;
        $('#draw-pencil').removeClass('active');
        $('#draw-select').removeClass('active');
        $('.image-filter').removeClass('active').addClass('disabled');
        
        MEME.keysMoveAllowed = false;
    });

    $("#text-done").click(function() {
        $("#text-add").show();
        MEME.done();
        $(this).hide()
    });

    $("#text-add").click(function() {
        MEME.TEXT.addUpdate();
    });


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
                    MEME.addBackground(file.url);
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

    $('#meme-background').spectrum({
        change: function(color) {
            MEME.backgroundColor(color.toRgbString()); // #ff0000
        }
    });

    $('#text-color').spectrum({
        change: function(color) {
            MEME.TEXT.addUpdate(true);
        }
    });

    $('#draw-stroke-color').spectrum({
        change: function(color) {
            var clr = '#' + color.toHex();
            canvas.freeDrawingBrush.color = clr;
            if (canvas.getActiveObject()) {
                canvas.getActiveObject().setStroke(clr);
                canvas.renderAll();
            }
        }
    });

    $('#draw-fill-color').spectrum({
        showAlpha: true,
        change: function(color) {
            if (canvas.getActiveObject()) {
                canvas.getActiveObject().setFill('#' + color.toHex());
                canvas.renderAll();
            }
            else if (canvas.getActiveGroup()) {
                for(var i = 0; i < canvas.getActiveGroup().getObjects().length; i++) {
                    (canvas.getActiveGroup().getObjects()[i]).setFill('#' + color.toHex());
                }
                canvas.renderAll();
            }
        }
    });

    $('#text-formats input').click(function() {
        MEME.TEXT.addUpdate(true);
    });

    $('#text-font-family').change(function() {
        MEME.TEXT.addUpdate(true);
    });

    $('#text-text').keyup(function() {
        MEME.TEXT.addUpdate(true);
    });

    $('#text-text').focusin(function() {
        MEME.keysMoveAllowed = false;
    });

    $('#text-text').focusout(function() {
        MEME.keysMoveAllowed = true;
    });

    $('#save-btn').click(function() {
        var errors = true;

        if ($.trim($('#title-field').val()).length == 0) {
            errors = false;
            $('.title-field-group').addClass('error');
            $('.title-field-group .help-inline').html('<?php echo Yii::t('yii', 'Title can not be blank.') ?>').removeClass('hide');
            $("html, body").animate({scrollTop: $('.title-field-group').offset().top - 100}, 400);
        }

        if (errors) {
            canvas.deactivateAll();
            canvas.renderAll();
            $('#img-data').val(canvas.toDataURL());
            $(this).parents('form').submit();
        }
        return false;
    });

    $('.meme-template').click(function() {
        var bg = $(this).attr('href');
        MEME.addBackground(bg);
        return false;
    });

    $('#meme-templates').jcarousel({
    });

    $('#draw-pencil').click(function() {
        canvas.isDrawingMode = true;
        canvas.calcOffset();
    });

    $('#draw-select').click(function() {
        canvas.isDrawingMode = false;
        canvas.calcOffset();
    });

    $('#text-mode').click(function() {
        canvas.isDrawingMode = false;
        MEME.done();
    });

    $('#image-mode').click(function() {
        canvas.isDrawingMode = false;
        MEME.done();
    });

    $('.remove-object').click(function() {
        if (canvas.getActiveObject()) {
            canvas.remove(canvas.getActiveObject());
        }
        else if (canvas.getActiveGroup()) {
            for(var i = 0; i < canvas.getActiveGroup().getObjects().length; i++) {
                canvas.remove(canvas.getActiveGroup().getObjects()[i]);
            }
            canvas.discardActiveGroup().renderAll();
        }
    });

    $('#send-backwards').click(function() {
        if (canvas.getActiveObject()) {
            canvas.sendBackwards(canvas.getActiveObject());
        }
        else if (canvas.getActiveGroup()) {
            alert('<?php echo Yii::t('yii', 'Only single object allowed!') ?>');
        }
    });

    $('#bring-forward').click(function() {
        if (canvas.getActiveObject()) {
            canvas.bringForward(canvas.getActiveObject());
        }
        else if (canvas.getActiveGroup()) {
            alert('<?php echo Yii::t('yii', 'Only single object allowed!') ?>');
        }
    });

    $('body').keypress(function(e) {

        if (MEME.keysMoveAllowed && (e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40 || e.keyCode == 37)) {
            var obj = canvas.getActiveObject() || canvas.getActiveGroup();

            if (obj == null) {
                return false;
            }

            var x = obj.getLeft();
            var y = obj.getTop();

            if (e.keyCode == 38) { // top
                y -= 1;
            }
            else if (e.keyCode == 39) { // right
                x += 1;
            }
            else if (e.keyCode == 40) { // bottom
                y += 1;
            }
            else if (e.keyCode == 37) { // left
                x -= 1;
            }

            obj.setLeft(x);
            obj.setTop(y);

            canvas.renderAll();

            return false;
        }

        return true;
    });

    $('#opacity-spinner').spinner({
        min: 1,
        max: 100,
        spin: function(event, ui) {
            if (canvas.getActiveObject()) {
                canvas.getActiveObject().setOpacity(ui.value/100);
                canvas.renderAll();
            }
            else if (canvas.getActiveGroup()) {
                canvas.getActiveGroup().setOpacity(ui.value/100);
                canvas.renderAll();
            }
        }
    });

    $('#height-spinner').spinner({
        min: 450,
        spin: function(event, ui) {
            canvas.setHeight(ui.value);
        }
    });

    document.getElementById('image-upload').addEventListener('change', function(evt) {
        var files = evt.target.files; // FileList object

        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // Render thumbnail.
                    var span = document.createElement('span');
                    span.innerHTML =
                            '<a href="javascript:;" class="add-image"><img class="image-thumb" src="' + e.target.result + '" title="' + escape(theFile.name) + '"/></a>'
                            ;
                    $("#image-list .mCSB_container").append(span);
                    $("#image-list").mCustomScrollbar("update");
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    }, false);

    $('.image-filter').mouseup(function() {
        if ($(this).hasClass('disabled')) {
            return false;
        }
        var checked = !$(this).hasClass('active');
        var filter = $(this).data('filter');
        var obj = canvas.getActiveObject();

        if (obj && obj.type == 'image') {
            obj.appliedFilters = obj.appliedFilters || [];

            if (checked) {
                obj.filters[obj.filters.length] = MEME.filters[filter];
                obj.appliedFilters.push(filter);
                obj.appliedFilters = _.uniq(obj.appliedFilters);
            }
            else {
                obj.filters = _.without(obj.filters, MEME.filters[filter]);
                obj.appliedFilters = _.without(obj.appliedFilters, filter);
            }
            obj.applyFilters(canvas.renderAll.bind(canvas));
        }
    });

    $(document).on('click', '.add-image', function() {
        if ($(this).attr('href') !== 'javascript:;') {
            var src = $(this).attr('href');
        }
        else {
            var src = $(this).find('img').attr('src');
        }

        MEME.addImage(src);

        return false;
    });

    $('#upimg').click(function() {
        $('#image-upload').click();
    });

    $("#image-preset,#image-list").mCustomScrollbar({
        scrollButtons: {
            enable: true,
            scrollSpeed: 90
        },
        theme: "dark"
    });

    $('#draw-circle').click(function() {
        var fill = '#' + $('#draw-fill-color').spectrum("get").toHex();
        var stroke = '#' + $('#draw-stroke-color').spectrum("get").toHex();
        var strokeWidth = $('#draw-pencil-width').spinner('value');
        MEME.addCircle(fill, strokeWidth, stroke);
        $('#draw-select').click();
    });

    $('#draw-square').click(function() {
        var fill = '#' + $('#draw-fill-color').spectrum("get").toHex();
        var stroke = '#' + $('#draw-stroke-color').spectrum("get").toHex();
        var strokeWidth = $('#draw-pencil-width').spinner('value');
        MEME.addSquare(fill, strokeWidth, stroke);
        $('#draw-select').click();
    });

    $('.btn-done').click(function() {
        MEME.done();
    });

    $('#bg-use-as-image').click(function() {
        MEME.useBgAsImage = !$(this).hasClass('active');
    });
    
    $('.remove-bg-img').click(function(){
        MEME.removeBackground();
    });

<?php if ($remixMeme): ?>
        MEME.addBackground('<?php echo $remixMeme->url_orignal ?>');
        MEME.useBgAsImage = true;
<?php endif ?>

    $(window).scroll(function(){
        var mTop = $('#meme-wrap').offset().top;
        var sTop = $(this).scrollTop();
        var h = $('#draw-toolbox').height();
        var mh = $('#meme-right').height();
        if((sTop > mTop - 40) && (sTop < (mh - h + 40))) {
            $('#draw-toolbox').css('top', (sTop - h - 40) + 'px');
        }
        else if(sTop < mTop) {
            $('#draw-toolbox').css('top', '0px');
        }
        else if(sTop < mTop - 40) {
            $('#draw-toolbox').css('top', (mTop - h - sTop) +'px');
        }
    });
    
    var meme_width = $('#c').width();
    var meme_height = $('#c').height();
    
    $(window).resize(function(){
        if($('body').width() <= 340) {
            var new_width = 300;
            var new_height = new_width*meme_height/meme_width;
            $('canvas').width(new_width).height(new_height);
            $('.canvas-container').width(new_width).height(new_height);
            $('.is-vertical').removeClass('btn-group-vertical').addClass('pull-left');
        }
        else {
            var new_width = 450;
            var new_height = new_width*meme_height/meme_width;
            $('canvas').width(new_width).height(new_height);
            $('.canvas-container').width(new_width).height(new_height);
            $('.is-vertical').addClass('btn-group-vertical').removeClass('pull-left');
        }
    });
    
    $(function(){
        $(window).resize();
    });
</script>