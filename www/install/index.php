<?php
@session_start();

if (!defined('NN_INSTALLER')) {
	define('NN_INSTALLER', true);
}

require_once realpath(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'smarty.php');

use nntmux\Install;

$page_title = "Welcome";

$cfg = new Install();
if ($cfg->isLocked()) {
	$cfg->error = true;
}

$cfg->cacheCheck = is_writable(NN_RES . 'smarty' . DS . 'templates_c');
if ($cfg->cacheCheck === false) {
	$cfg->error = true;
}

if (!$cfg->error) {
	$cfg->setSession();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>
		<?php
		echo $page_title;
		?>
	</title>
	<link href="./templates/install.css" rel="stylesheet" type="text/css" media="screen" />
	<link rel="shortcut icon" type="image/ico" href="../themes/shared/images/favicon.ico" />
</head>
<body>
<h1 id="logo">
	<images alt="NNTmux" src="../themes/shared/images/logo.png" />
</h1>

<div class="content">
	<h2>Index Usenet. Now.</h2>

	<p>Welcome to NNTmux.</p>
	<p>Before getting started, you need to make sure that the server meets the minimum requirements. You will also need...</p>
	<ol>
		<li>Your database credentials.</li>
		<li>Your news server credentials.</li>
		<li>SSH & root ability on your server (in case you need to install missing packages).</li>
		<li>You should consider copying nntmux/nntmux/config/settings.example.php to
			nntmux/nntmux/config/settings.php (Default settngs should be fine for installing).</li>
	</ol>
	<br/><br/>
	<p>
		<strong>
			<div style="color: #ff0000">WARNING: </div>
			This software is not practical for use on shared hosting. You should only use this on a server where YOU have the required privileges and knowledge to solve any challenges that might appear.
		</strong>
	</p>
	<div align="center">
		<?php
		if (!$cfg->error) {
			?>
			<form action="step1.php">
				<input type="submit" value="Go to step one: Pre flight check" />
			</form>
		<?php
		} else {
			if (!$cfg->cacheCheck) {
				?>
				<div class="error">
					The template compile dir must be writable.<br />A quick solution is to run:	<br />
					<?php
					echo 'chmod 777 ' . NN_RES . 'smarty' . DS . 'templates_c';
					if (extension_loaded('posix') && strtolower(substr(PHP_OS, 0, 3)) !== 'win') {
						$group = posix_getgrgid(posix_getgid());
						echo
						'<br /><br />Another solution is to run:<br />chown -R YourUnixUserName:' . $group['name'] . ' ' . NN_ROOT .
						'<br />Then give your user access to the group:<br />usermod -a -G ' . $group['name'] . ' YourUnixUserName' .
						'<br />Finally give read/write access to your user/group:<br />chmod -R 774 ' . NN_ROOT;
					}
					?>
				</div>
			<?php
			} else {
				?>
				<div class="error">Installation Locked! If reinstalling, please remove www/install/install.lock.</div>
			<?php
			}
		}
		?>
	</div>

	<div class="footer">
		<p>
			<br />
			NN is released under GPL.
		</p>
	</div>
</div>
</body>
</html>
