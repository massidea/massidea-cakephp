<div id="login_box">
<?php 
	echo $this->Form->create('User', array('action' => 'login'));
	echo $this->Form->inputs(array(
		'legend' => __('', true),
		'username',
		'password' => array('type' => 'password', 'label' => 'Password', 'value' => '')
	));
	echo $this->Form->end('Login');
?>
<a href="#">Forgot your password?</a>
<div class="clear"></div>

<?php /*
	<form action="/en/account/login" method="post">
		<div>Username:</div>
		<div><input type="text" name="username"/></div>
		<div>Password</div>
		<div><input type="password" name="password"/></div>
	    <div><input type="hidden" name="returnurl" value="/en/view/2775"/></div>
	
	    <div style="margin-top: 10px;">
	        <input style="margin-right: 6px; width: 70px;" type="submit" value="Login"/>
	        <span class="top_right_box_links" style="font-size: 12px;">
	            <a href="/en/account/fetchpassword">Can't access your account?</a>
	        </span>
	    </div>
	</form>
	

	
	<div style="margin-top: 0px;">
	    <div class="top_right_box_links" style="float:left; font-size: 12px; margin-left: 4px; margin-top: 2px;">
			<span>Or use your<a id="login_link_openid" href="#">OpenID to login</a></span> 
			<img style="vertical-align: middle;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAMAAAAM7l6QAAAB4FBMVEWYoamcnJyenp6epaufn5+foKCgoKChoaGioqKio6Ojo6OkpKSkpaalpaWmpqWmpqanp6eoqKaoqKipqamqqqqrq6usrKyurq2urq6vr6+wsLCxsbGzusC0tLS2tra3t7e3vsO4uLi4u8C6urq7u7u7u7y8vLy9vb3En3/ExcfHzdPJycnKysrLysrLy8vMzMzM0NPNzc3Nz9DOzs7Q0NDQ09TR0dHR1dnStJvS0tHS0tLT09PU1NTV1dXWzcTW1tbX19fa2trbt5jb3d/c3Nzd3d3e3t7f1cvf39/g4ODh4eHi4uHi4uLj4+Pk5OTl5eXm2c7m5ubn5+fo6Ojo6erp6enp6uvq6urr6+vs7OztfR3tfiDt7e3t7u7ufBvufRzufR3ufR7ugCPugibuhCruhSvuvJLuzbHuzbLuzrPu0Lbu0Lfu0Lju0bfu0rru1sPu7Ovu7u3u7u7u8PLvexjvfh/vgSXvgybvgyfvgyjvhCnvhCrvlUfvxaLv0rrv49nv6ubv7+/whSnwhSrwhivwmE7wwJjwwprwz7Pw39Hw4dTw8PDxfx7xgSHxwZjxxJ7xx6PxyKXx5t3ygB/ygCDyiCzyt4bywZfy2MPzhCTzwJXzw5v0uIX0uYb1zqz13coRBTmLAAABS0lEQVQoz2MowgsYqCpdP7ELt3RB57SaXNzSHa1RSVm4pdvK4lKzcUu3V8Xjk56eEp9Sh1t6QmV88oxYrNKhPkbmtVPimwMMLP3C0aRj/AwVxTll0ibHT7VjFpRQdAiKcfODS4cainFxsPNoTe+Jb3FX4GPn4lI2ltSGSfuqc7MJyNo7h80rTajID3HUF+XnZWOzhkqHyrNxcOj4A1mzqxKq8ooiXKW5WdjYdCDSMXpsbMIOYEv6quNTM4qKPbVVJMTYlSHS/kLsbNrd8GDJBNKR4f4uOo4QaTMudn4vRKjBwjymESJtDHSXH0I6By3UXHnZua1wh3mEGjuHrAdO6RhPEXZuWY9IIG9WCrYYsxVjYpEy8Q4r7C9PxBahjupcjByimqZOM0ui07FEaLiNHD8HK4NGb9OcSdjiOyY4UFdVyWLu/AYaZgPSpAEwAGTJdYZU0wAAAABJRU5ErkJggg==" alt="OpenID"/>
	    </div>
	    <div style="clear: both;"></div>

	    <div><a href="/en/account/register">No account? Registering is free and fast!</a> </div>

	</div>
</div>

<div id="login_box_openid">
	<form action="/en/account/openid" method="post">
	    <div>Your OpenID</div>
	    <div>
	        <input style="margin-bottom: 12px; width: 212px; padding-left: 20px; background: #fff url('/images/openid-16x16.png') 2px no-repeat;" name="openid_identifier" type="text"/>
	    </div>
	    <div>
	        <input style="margin-right: 6px;" type="submit" name="openid_action" value="Login"/>
	        <span class="top_right_box_links" style="font-size: 12px;">
	
	            <a id="login_link_in_box" href="#">
	                Back to Massidea Login
	            </a>
	        </span>
	    </div>
	</form>
*/ ?>

</div>


