<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['lemail']?$_POST['lemail']:$_GET['e']);
$ticketid=Format::input($_POST['lticket']?$_POST['lticket']:$_GET['t']);

if ($cfg->isClientEmailVerificationRequired())
    $button = __("Email Access Link");
else
    $button = __("View Ticket");
?>
<div class="col-md-12 my-4">
<h2><?php echo __('Check Ticket Status'); ?></h2>
<p class="text-muted"><?php
echo __('Please provide your email address and a ticket number.');
if ($cfg->isClientEmailVerificationRequired())
    echo ' '.__('An access link will be emailed to you.');
else
    echo ' '.__('This will sign you in to view your ticket.');
?></p>
<div class="container">
    <div class="row">
        <div class="card col-md-12 rounded shadow">
            <div class="card-body">
                <div class="row my-2">
                    <?php if (isset($errors['login'])) { ?>
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><?php echo Format::htmlchars($errors['login']); ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-5">
                        <form action="login.php" method="post" id="clientLogin">
                            <?php csrf_token(); ?>
                            <div class="form-group">
                                <label for="email"><?php echo __('Email Address'); ?>:</label>
                                <input type="text" name="lemail" class="form-control nowarn" id="email" value="<?php echo $email; ?>" placeholder="<?php echo __('e.g. john.doe@osticket.com'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="ticketno"><?php echo __('Ticket Number'); ?>:</label>
                                <input id="ticketno" type="text" name="lticket" placeholder="<?php echo __('e.g. 051243'); ?>"
                                value="<?php echo $ticketid; ?>" class="form-control nowarn">
                            </div>
                            <input class="btn btn-primary" type="submit" value="<?php echo $button; ?>">
                        </form>
                    </div>
                    <div class="col-md-7 border-left">
                        <?php if ($cfg && $cfg->getClientRegistrationMode() !== 'disabled') { ?>
                            <?php echo __('Have an account with us?'); ?>
                            <a href="login.php"><?php echo __('Sign In'); ?></a> <?php
                            if ($cfg->isClientRegistrationEnabled()) { ?>
                                <?php echo sprintf(__('or %s register for an account %s to access all your tickets.'),
                                '<a href="account.php?do=create">','</a>');
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<p>
<?php
if ($cfg->getClientRegistrationMode() != 'disabled'
    || !$cfg->isClientLoginRequired()) {
    echo sprintf(
    __("If this is your first time contacting us or you've lost the ticket number, please %s open a new ticket %s"),
        '<a href="open.php">','</a>');
} ?>
</p>
</div>
