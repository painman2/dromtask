<?php defined('APPTODO') or die('Access denied'); ?>
<div class="main">
    <div class="CoverHeader">
        <div class="CoverHeader__logo"></div>
        <div class="CoverHeader__text">
            <div class="CoverHeader__header">Todo App</div>
            <div class="CoverHeader__sub-header"><?=$tempsess['login_user']?></div>
            <div class="CoverHeader__sub-header"><?=$tempsess['name_user']?></div>
            <div class="CoverHeader__sub-header"><a href="?logout=1" style="color: inherit;">Log Out</a></div>
        </div>
    </div>
    <div id="maincontent">
        <div id="reklama">
            <div class="myblock">
                <?php if($tempsess['success']):?>
                <div class="success"><?=$tempsess['success']?></div>
                <?php endif; ?>
                <?php if($tempsess['error']):?>
                <div class="error"><?=$tempsess['error']?></div>
                <?php endif; ?>
            </div>
            <div class="myblock">
                <section class="todoapp">
        			<header class="header">
        				<h1>todos</h1>
        				<input class="new-todo" placeholder="What needs to be done?" autofocus>
        			</header>
        			<!-- This section should be hidden by default and shown when there are todos -->
                    <section class="mainapp" <?php if(!$todolist) echo 'style="display: none;"';?>>
        				<input id="toggle-all" class="toggle-all" type="checkbox">
        				<label for="toggle-all">Mark all as complete</label>
                            <ul class="todo-list">
        					<!-- These are here just to show the structure of the list items -->
        					<!-- List items should get the class `editing` when editing and `completed` when marked as completed -->
        					<?php $cntactive = 0;?>
                            <?php foreach($todolist as $val): ?>
                            <?php
                                $strclass = '';
                                $strcheck = '';
                                if($val['state'] == 1){
                                    $strclass = 'class="completed"';
                                    $strcheck = 'checked';
                                }else if($tempsess['show'] == 'Completed'){
                                    $strclass += ' style="display: none;"';
                                    $cntactive += 1;
                                }else $cntactive += 1;
                            ?>
                            <li <?=$strclass?>>
        						<div class="view">
        							<input class="toggle" type="checkbox" <?=$strcheck?>>
        							<label><?=$val['name']?></label>
        							<button class="destroy"></button>
        						</div>
        						<input class="edit" value="<?=$val['name']?>">
                                <input type="hidden" value="<?=$val['id']?>">
        					</li>
                            <?php endforeach; ?>
        				</ul>
        			</section>
        			<!-- This footer should hidden by default and shown when there are todos -->
        			<footer class="footer" <?php if(!$todolist) echo 'style="display: none;"';?>>
        				<!-- This should be `0 items left` by default -->
        				<span class="todo-count"><strong><?=$cntactive?></strong> item left</span>
        				<!-- Remove this if you don't implement routing -->
        				<ul class="filters">
        					<li>
        						<a <?php if($tempsess['show'] == 'All') echo 'class="selected"';?> href="#/">All</a>
        					</li>
        					<li>
        						<a <?php if($tempsess['show'] == 'Active') echo 'class="selected"';?> href="#/active">Active</a>
        					</li>
        					<li>
        						<a <?php if($tempsess['show'] == 'Completed') echo 'class="selected"';?> href="#/completed">Completed</a>
        					</li>
        				</ul>
        				<!-- Hidden if no completed items are left ↓ -->
        				<button class="clear-completed">Clear completed</button>
        			</footer>
        		</section>
        		<footer class="info">
        			<p>Double-click to edit a todo</p>
        			<!-- Change this out with your name and url ↓ -->
        			<p>Created by <a href="https://mychoicefb.com/?service=that">Artem Melnik</a></p>
        			<p>Part of <a href="http://todomvc.com">TodoMVC</a></p>
        		</footer>
            </div> 
        </div>
    </div>    
</div>
<?php
    $tempsess['error'] = 0;
    $tempsess['success'] = 0;
    $_SESSION["tempsess"] = $tempsess;
?>
<script type="text/javascript" src="<?=TEMPLATE?>js/app.js"></script>