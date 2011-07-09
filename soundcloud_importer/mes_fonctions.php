<?php

function soundcloud_player($url, $show_comments=false, $auto_play=false,
    $color='0066cc', $width='100%', $height='81') {
    
    $show_comments = $show_comments ? 'true' : 'false';
    $auto_play = $auto_play ? 'true' : 'false';

    $url = urlencode($url);

    $out = <<<BASE
<object width="$width" height="$height">
<param value="http://player.soundcloud.com/player.swf?url=$url&show_comments=$show_comments&auto_play=$auto_play&color=$color" name="movie">
<param value="always" name="allowscriptaccess">
<param name="wmode" value="opaque" />
<embed width="$width" height="$height" type="application/x-shockwave-flash" src="http://player.soundcloud.com/player.swf?url=$url&show_comments=$show_comments&auto_play=$auto_play&color=$color" allowscriptaccess="always">
</object>
BASE;

    return $out;
}

?>