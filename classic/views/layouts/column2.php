<?php $this->renderPartial('/partials/header', $this->data) ?>
<div class="span8">
    <?php echo $content ?>
</div> <!-- end span8 -->
<div class="span4">
    <div data-spy="affix" data-offset-top="30" class="span4 corgi_feed_well">
        <div class="sidebar_header">
            <div class="sidebar_title">
                <h4>Theme UI Features</h4>
            </div>
        </div>
        <hr class="feed_hr" />
        <div class="sidebar_interior">
            <i class="icon-ok"></i> Stacked Feed Layout
            <br/><br/>
            <i class="icon-ok"></i> Individual Feed Layout
            <br/><br/>
            <i class="icon-twitter"></i> Built with Bootstrap
            <br/><br/>
            <i class="icon-github"></i> Elusive Web Icons Included
            <br/><br/>
            <i class="icon-plus-sign"></i> Expandable Hidden Comment Area <span style="font-size:12px; color: #57ad68; font-weight:bold"> Click the comment links!</span>
            <br/><br/>
            <i class="icon-cogs"></i> Subtle Background Gradients
            <br/><br/>
            <i class="icon-plus-sign"></i> Expandable Heart Button
            <br/><br/>
            <i class="icon-hand-right"></i> Taller, Semi-Transparent Navbar
            <br/><br/>
            <i class="icon-fontsize"></i> Custom Brand Font
            <br/><br/>
            <i class="icon-view-mode"></i> Can be made responsive with one line of html
        </div>
    </div>
</div>
<?php $this->renderPartial('/partials/footer', $this->data) ?>