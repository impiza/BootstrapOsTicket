
    </div>
    </div>
    </main>
    <footer class="footer">
        <div class="container">
          <div class="row justify-content-between">
            <div class="text-center">
            <?php echo __('Copyright &copy;'); ?> <?php echo date('Y'); ?> <?php
            echo Format::htmlchars((string) $ost->company ?: 'osTicket.com'); ?> - <?php echo __('All rights reserved.'); ?>
            </div>
            <div class="text-center" ><?php echo __('Powered by'); ?>
			    <a href="http://www.osticket.com" target="_blank"> <img alt="osTicket" src="scp/images/osticket-grey.png" class="osticket-logo"> </a>
		    </div>
          </div>
        </div>
    </footer>
<div id="overlay"></div>
<div id="loading">
    <h4><?php echo __('Please Wait!');?></h4>
    <p><?php echo __('Please wait... it will take a second!');?></p>
</div>
<?php
if (($lang = Internationalization::getCurrentLanguage()) && $lang != 'en_US') { ?>
    <script type="text/javascript" src="ajax.php/i18n/<?php
        echo $lang; ?>/js"></script>
<?php } ?>
<script type="text/javascript">
    getConfig().resolve(<?php
        include INCLUDE_DIR . 'ajax.config.php';
        $api = new ConfigAjaxAPI();
        print $api->client(false);
    ?>);
</script>
<!-- Theme js assets -->
<script type="text/javascript" src="<?php echo THEME_PATH; ?>js/popper.min.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo THEME_PATH; ?>js/bootstrap.min.js" crossorigin="anonymous"></script>
<?php if ($ismaterial) { ?>
    <script type="text/javascript" src="<?php echo MATERIAL_PATH; ?>js/bootstrap-material-design.min.js" crossorigin="anonymous"></script>
    <script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
<?php } ?>
<!-- END THEME JS ASSETS -->
</body>
</html>
