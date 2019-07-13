<?php
$title = ($cfg && is_object($cfg) && $cfg->getTitle())
? $cfg->getTitle() : 'osTicket :: ' . __('Support Ticket System');
$signin_url = ROOT_PATH . "login.php"
    . ($thisclient ? "?e=" . urlencode($thisclient->getEmail()) : "");
$signout_url = ROOT_PATH . "logout.php?auth=" . $ost->getLinkToken();

header("Content-Type: text/html; charset=UTF-8");
header("Content-Security-Policy: frame-ancestors '" . $cfg->getAllowIframes() . "';");

if (($lang = Internationalization::getCurrentLanguage())) {
    $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
    $langs = Internationalization::rfc1766($langs);
    header("Content-Language: " . implode(', ', $langs));
}
?>
<!DOCTYPE html>
<html <?php
$isrtl = False;
if ($lang
    && ($info = Internationalization::getLanguageInfo($lang))
    && (@$info['direction'] == 'rtl')) {
    $isrtl = true;
    echo ' dir="rtl" class="rtl"';
}

if ($lang) {
    echo ' lang="' . $lang . '"';
}
?>>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo Format::htmlchars($title); ?></title>
    <meta name="description" content="customer support platform">
    <meta name="keywords" content="osTicket, Customer support system, support ticket system">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Theme Assets -->
    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>css/bootstrap<?php echo $isrtl ? '-rtl' : ''; ?>.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo MATERIAL_PATH; ?>css/bootstrap-material-design.min.css" crossorigin="anonymous" />
    <!-- FontAwesome 5.9.0 icons -->
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/AwesomeFont/css/all.min.css" crossorigin="anonymous"/>
    <!-- Material Design for Bootstrap fonts and icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <!--Theme Custom asset -->
    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>theme-redesign.css" />

    <!-- End Theme Assets declaration -->
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/osticket.css?a076918" media="screen" />
    <!--<link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/theme.css?a076918" media="screen" /> disable theme default and add custom--> 
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/print.css?a076918" media="print" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>scp/css/typeahead.css?a076918" media="screen" />
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css?a076918"
        rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/thread.css?a076918" media="screen" />
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?a076918" media="screen" />
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?a076918" />
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/flags.css?a076918" />
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?a076918" />
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/select2.min.css?a076918" />
    <!-- Favicons -->
    <link rel="icon" type="image/png" href="<?php echo ROOT_PATH ?>images/oscar-favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?php echo ROOT_PATH ?>images/oscar-favicon-16x16.png" sizes="16x16" />
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-3.4.0.min.js?a076918"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.12.1.custom.min.js?a076918"></script>
    <script src="<?php echo ROOT_PATH; ?>js/osticket.js?a076918"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js?a076918"></script>
    <script src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js?a076918"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js?a076918"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js?a076918"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js?a076918"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js?a076918"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/fabric.min.js?a076918"></script>
    <?php
if ($ost && ($headers = $ost->getExtraHeaders())) {
    echo "\n\t" . implode("\n\t", $headers) . "\n";
}

// Offer alternate links for search engines
// @see https://support.google.com/webmasters/answer/189077?hl=en
if (($all_langs = Internationalization::getConfiguredSystemLanguages())
    && (count($all_langs) > 1)
) {
    $langs = Internationalization::rfc1766(array_keys($all_langs));
    $qs = array();
    parse_str($_SERVER['QUERY_STRING'], $qs);
    foreach ($langs as $L) {
        $qs['lang'] = $L;?>
    <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?<?php
echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>" />
    <?php
}?>
    <link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
        hreflang="x-default" />
    <?php
}
?>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
        <a class="navbar-brand" href="<?php echo ROOT_PATH; ?>index.php">
            <img src="<?php echo ROOT_PATH; ?>logo.php" alt="<?php
            echo $ost->getConfig()->getTitle(); ?>" width="150" height="30">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#subMenu" aria-controls="subMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="subMenu" class="collapse navbar-collapse">
            <?php
            if ($nav) {?>
            <ul class="navbar-nav mr-auto">
            <?php
                if ($nav && ($navs = $nav->getNavLinks()) && is_array($navs)) {
                    foreach ($navs as $name => $nav) {
                        echo sprintf('<li class="nav-item %s"><a class="nav-link" href="%s"><i class="fas %s"></i> %s</a></li>%s', $nav['active'] ? 'active' : '', (ROOT_PATH . $nav['href']), $nav['icon'] , $nav['desc'], "\n");
                    }
                }?>
            </ul>
            <?php
            } ?>
            <ul class="navbar-nav ml-auto">
            <?php
            if (($all_langs = Internationalization::getConfiguredSystemLanguages())
                && (count($all_langs) > 1)
            ) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="langsDrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-flag"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="langsDrop">
                    <?php
                        $qs = array();
                        parse_str($_SERVER['QUERY_STRING'], $qs);
                        foreach ($all_langs as $code => $info) {
                        list($lang, $locale) = explode('_', $code);
                        $qs['lang'] = $code;
                        ?>
                        <a class="dropdown-item flag flag-<?php echo strtolower($info['flag'] ?: $locale ?: $lang); ?>" href="?<?php echo http_build_query($qs);
                        ?>" title="<?php echo Internationalization::getLanguageDescription($code); ?>">&nbsp;</a>
                    <?php } ?>
                    </div>
                </li>
                <?php
            }?>
            <?php
            if ($thisclient && is_object($thisclient) && $thisclient->isValid()
                && !$thisclient->isGuest()) {
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-tie"></i><?php echo Format::htmlchars($thisclient->getName()); ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="userMenu">
                        <a class="dropdown-item" href="<?php echo ROOT_PATH; ?>profile.php"><?php echo __('Profile'); ?></a>
                        <a class="dropdown-item" href="<?php echo ROOT_PATH; ?>tickets.php"><?php echo sprintf(__('Tickets <b>(%d)</b>'), $thisclient->getNumTickets()); ?></a>
                        <a class="dropdown-item" href="<?php echo $signout_url; ?>"><?php echo __('Sign Out'); ?></a>
                    </div>
                </li>
            <?php
            } elseif ($nav) {
                if ($cfg->getClientRegistrationMode() == 'public') {?>
                    <span class="navbar-text">
                    <i class="fas fa-user-tie"></i> <?php echo __('Guest User'); ?>
                    </span> 
                <?php
                }
                if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) {?>
                   
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $signout_url; ?>"><i class="fas fa-sign-out-alt"></i> <?php echo __('Sign Out'); ?></a>
                        </li>
                    <?php
                } elseif ($cfg->getClientRegistrationMode() != 'disabled') {?>
                    
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $signin_url; ?>"><i class="fas fa-sign-in-alt"></i> <?php echo __('Sign In'); ?></a>
                        </li>
                    
                    <?php
                }
            }?>
            </ul>
        </div>
    </nav>
    <main class="main main-raised" role="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php if ($errors['err']) {?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errors['err']; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } elseif ($msg) {?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo $msg; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } elseif ($warn) {?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $warn; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php }?>
            </div>