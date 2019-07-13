<?php
/*********************************************************************
    index.php

    Helpdesk landing page. Please customize it to fit your needs.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>
<div class="col-md-12 mt-4">
    <?php if($cfg && ($page = $cfg->getLandingPage()))
        echo $page->getBodyWithImages();
    else
        echo  '<h1>'.__('Welcome to the Support Center').'</h1>';
    ?>
    <?php
    if ($cfg && $cfg->isKnowledgebaseEnabled()) { ?>
    <form class="form-row m-3" method="get" action="kb/faq.php">
        <input type="hidden" name="a" value="search"/>
        <div class="col">
            <input type="text" name="q" class="form-control" placeholder="<?php echo __('Search our knowledge base'); ?>"/>
        </div>
        <div class="col-2">
            <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> <?php echo __('Search'); ?></button>
        </div>
    </form>
    <?php
    } ?>
</div>
<?php
$BUTTONS = isset($BUTTONS) ? $BUTTONS : true;
?>
<?php if ($BUTTONS) { ?>
<div class="container">
    <div class="row justify-content-center">
<?php
    if ($cfg->getClientRegistrationMode() != 'disabled'
        || !$cfg->isClientLoginRequired()) { ?>
        <div class="col-md m-2">
            <div class="card text-center text-white bg-info">
                <div class="card-header">
                    <?php echo __('Open a New Ticket');?>
                </div>
                <div class="card-body">
                    <p class="card-text">Please provide as much detail as possible so we can best assist you. To update a previously submitted ticket, please login.</p>
                    <a href="open.php" class="btn btn-outline-light"><i class="fas fa-location-arrow"></i> <?php echo __('Open a New Ticket');?></a>
                </div>
            </div>
        </div>
<?php } ?>
        <div class="col-md m-2">
            <div class="card text-center text-white bg-success">
                <div class="card-header">
                    <?php echo __('Check Ticket Status');?>
                </div>
                <div class="card-body">
                    <p class="card-text">We provide archives and history of all your current and past support requests complete with responses.</p>
                    <a href="view.php" class="btn btn-outline-light"><i class="fas fa-clipboard-list"></i> <?php echo __('Check Ticket Status');?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div id="landing_page">
<?php include CLIENTINC_DIR.'templates/sidebar.tmpl.php'; ?>
<div>
<?php
if($cfg && $cfg->isKnowledgebaseEnabled()){
    //FIXME: provide ability to feature or select random FAQs ??
?>
<br/><br/>
<?php
$cats = Category::getFeatured();
if ($cats->all()) { ?>
<h1><?php echo __('Featured Knowledge Base Articles'); ?></h1>
<?php
}

    foreach ($cats as $C) { ?>
    <div class="featured-category front-page">
        <i class="icon-folder-open icon-2x"></i>
        <div class="category-name">
            <?php echo $C->getName(); ?>
        </div>
<?php foreach ($C->getTopArticles() as $F) { ?>
        <div class="article-headline">
            <div class="article-title"><a href="<?php echo ROOT_PATH;
                ?>kb/faq.php?id=<?php echo $F->getId(); ?>"><?php
                echo $F->getQuestion(); ?></a></div>
            <div class="article-teaser"><?php echo $F->getTeaser(); ?></div>
        </div>
<?php } ?>
    </div>
<?php
    }
}
?>
</div>
</div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
