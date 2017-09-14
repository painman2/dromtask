<?php defined('APPTODO') or die('Access denied'); ?>
<div class="main">
    <div class="CoverHeader">
        <div class="CoverHeader__logo"></div>
        <div class="CoverHeader__text">
            <div class="CoverHeader__header">Todo App</div>
            <div class="CoverHeader__sub-header">Authorization</div>
        </div>
    </div>
    <div id="maincontent">
        <div id="reklama">
            <form method="POST" action="">
            <div class="myblock">
                <?php if($tempsess['error']):?>
                <div class="error"><?=$tempsess['error']?></div>
                <?php endif; ?>
            </div>
            <div class="myblock">
                <div class="insetting">
                    <input id="login" type="text" maxlength="32" name="login" required placeholder="Your login">
                </div>
            </div>
            <div class="myblock">
                <div class="insetting">
                    <input type="password" maxlength="32" name="password" required placeholder="Your password">
                </div>
            </div>
            <div class="myblock">
                <div class="insetting">
                    <input type="submit" value="Log In">
                </div>
            </div>
            </form>
            <div class="myblock">
                <div class="insetting">
                    <a href="?view=reg">Sign Up</a>   
                </div>
            </div>
        </div>
    </div>    
</div>
<?php
    $tempsess['error'] = 0;
    $_SESSION["tempsess"] = $tempsess;
?>