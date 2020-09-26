<?php
if ( !isset($count) ) $count=0;

$postformat = get_post_format();
if($postformat == "") $postformat="standard";
$count++;
?>
<div class="<?php if ($count==1) { echo 'topseperator'; } ?> entry-wrapper post-<?php echo esc_attr($postformat); ?>-wrapper clearfix">
<div class="blog-content-section">
<?php
get_template_part( 'template-parts/postformats/default' );
?>
</div>
</div>