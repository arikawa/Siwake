<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php echo $this->element('google'); ?>
<head>
	<?php echo $this->Html->charset("UTF-8"); ?>
	<title><?php echo $title_for_layout; ?>@<?php echo SITE_TITLE; ?></title>
	<?php
		echo $this->Html->meta('icon', $html->webroot . '/img/biz.icon.jpg');
		echo $this->Html->css('siwake');
		echo $this->Html->meta('description', DESCRIPTION);
		echo $this->Html->meta('keywords', '弥生会計,変換,自動,作成,エクセル,Excel,CSV,インターネットバンキング,仕訳,データ,出納帳,元帳,現金');
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $html->link(SITE_TITLE, '/'); ?></h1>
			<span class="subtitle"><?php echo DESCRIPTION; ?></span>
			<!-- アフィリエイト -->
			<div>
				<!-- 黒田会計 -->
				<?php echo $this->Html->image("jimusyo.jpg", array('url' => 'http://kurodakaikei.com/', "height" => 100));?>
				<!-- BIZZIT -->
				<?php echo $this->Html->image("bizzit.jpg", array('url' => 'http://bizzit.jp/', "height" => 100));?>
			</div>
			<div>
				<!-- バージョンアップ -->
				<iframe frameborder="0" allowtransparency="true" height="60" width="468" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=3098142&pid=882323703" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=3098142&pid=882323703"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=3098142&pid=882323703" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=3098142&pid=882323703" height="60" width="468" border="0"></a></noscript></iframe>
				<!-- 新規 -->
				<iframe frameborder="0" allowtransparency="true" height="60" width="234" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=3098142&pid=882323706" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=3098142&pid=882323706"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=3098142&pid=882323706" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=3098142&pid=882323706" height="60" width="234" border="0"></a></noscript></iframe>
				<!-- 相談 -->
				<iframe frameborder="0" allowtransparency="true" height="60" width="120" marginheight="0" scrolling="no" src="http://ad.jp.ap.valuecommerce.com/servlet/htmlbanner?sid=3098142&pid=882324281" marginwidth="0"><script language="javascript" src="http://ad.jp.ap.valuecommerce.com/servlet/jsbanner?sid=3098142&pid=882324281"></script><noscript><a href="http://ck.jp.ap.valuecommerce.com/servlet/referral?sid=3098142&pid=882324281" target="_blank" ><img src="http://ad.jp.ap.valuecommerce.com/servlet/gifbanner?sid=3098142&pid=882324281" height="60" width="120" border="0"></a></noscript></iframe>
			</div>
		</div>
		<div id="content">
			<?php if($this->action != 'advatise') echo $this->element('menu'); ?>
			<?php echo $this->Session->flash(); ?>
			<h2>【<?php echo $title_for_layout; ?>】</h2>
			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			
			Copyright © 2012 copyrights. <?php echo $this->Html->link("BIZZIT", "http://bizzit.jp", array("target" => "_blank")); ?> All Rights Reserved.
		</div>
	</div>
</body>
</html>