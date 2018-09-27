<?php

class PokoButton implements PluggableButton {
	
	public function getJS() {
		return new JSObject(array('id' => get_class($this), 'location' => 'http://poko.lt/extras/button/button.js'));
	}
	
	public function printJS() {}
	
	public function getHTML() {
		return '<a class="poko-button" data-url="' . get_permalink() . '"></a>';
	}
}

class FacebookButton implements PluggableButton {
	
	public function getJS() {}
	
	public function printJS() {
	?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) {return;}
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=162591670505214";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	<?php
	}
	
	public function getHTML() {
		return 
			'<div	class="fb-like" data-href="' . get_permalink() . '" data-send="false"
					data-layout="button_count" data-width="77" data-show-faces="false"
					data-font="arial"></div>';
	}
}

class PlusOneButton implements PluggableButton {
	
	public function getJS() {}
	
	public function printJS() {
	?>
		<script type="text/javascript">
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/plusone.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
		</script>
	<?php
	}
	
	public function getHTML() {
		return 
			'<div class="poko-share-collection-plus">
				<g:plusone href="' . get_permalink() . '" size="medium" annotation="none"></g:plusone>
			</div>';
	}		
}

class LinkedInButton implements PluggableButton {
	
	public function getJS() {
		return new JSObject(array('id' => get_class($this), 'location' => PokoButtonPlugin::addScheme('//platform.linkedin.com/in.js')));		
	}
	
	public function printJS() {}
	
	public function getHTML() {
		return 
			'<div class="poko-share-collection-linkedin">
				<script type="IN/Share" data-url="' . get_permalink() . '"></script>
			</div>';
	}		
}

class TwitterButton implements PluggableButton {
	
	public function getJS() {
		return new JSObject(array('id' => get_class($this), 'location' => PokoButtonPlugin::addScheme('//platform.twitter.com/widgets.js')));				
	}
	
	public function printJS() {}
	
	public function getHTML() {
		return 
			'<div class="poko-share-collection-twitter">
				<a	href="https://twitter.com/share" class="twitter-share-button" 
					data-url="' . get_permalink() . '" data-text="' . get_the_title() . '"
					data-count="none" 
					data-via="' . PokoButtonPlugin::getSetting('twitterHandle')  . '">
					Tweet
				</a>
			</div>';
	}		
}
