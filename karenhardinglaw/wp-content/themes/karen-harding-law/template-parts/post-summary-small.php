<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
<?php
$postformat = get_post_format();
if($postformat == "") {
	$postformat="standard";
}
echo '<div class="blog-small-left">';
get_template_part( 'template-parts/postformats/postformat-media' );
echo '</div>';
echo '<div class="blog-small-right">';
?>

<?php
if ( !isset($count) ) $count=0;

$postformat = get_post_format();
if($postformat == "") $postformat="standard";
$count++;
?>
<div class="<?php if ($count==1) { echo 'topseperator'; } ?> entry-wrapper post-<?php echo esc_attr($postformat); ?>-wrapper clearfix">
	<div class="blog-content-section">
		
<?php
$the_content_class = "post-display-excerpt";
if ( kreativa_get_option_data('postformat_fullcontent') ) {
	$the_content_class = "post-display-content";
}
if (is_singular()) {
	$the_content_class = "post-display-content";
}
?>
<div class="entry-content postformat_contents <?php echo esc_attr($the_content_class); ?> clearfix">
<?php
$show_readmore=false;
$blogpost_style= get_post_meta($post->ID, 'pagemeta_pagestyle', true);

	switch ($postformat) {
		case 'video':
			$postformat_icon = "feather-icon-play";
			break;
		case 'audio':
			$postformat_icon = "feather-icon-volume";
			break;
		case 'gallery':
			$postformat_icon = "feather-icon-layers";
			break;
		case 'quote':
			$postformat_icon = "feather-icon-speech-bubble";
			break;
		case 'link':
			$postformat_icon = "feather-icon-link";
			break;
		case 'aside':
			$postformat_icon = "feather-icon-align-justify";
			break;
		case 'image':
			$postformat_icon = "feather-icon-image";
			break;
		default:
			$postformat_icon ="feather-icon-paper";
			break;
	}

if (!is_single()) {
	switch ($postformat) {
		
		case 'aside':
		break;
		
		case 'link':
		$linked_to= get_post_meta($post->ID, 'pagemeta_meta_link', true);
		$fullcontent=true;		
		?>
		<div class="entry-post-title entry-post-title-only">
		<h2>
		<a class="postformat_<?php echo esc_attr($postformat); ?>" href="<?php echo esc_url($linked_to); ?>" title="<?php echo esc_attr($linked_to); ?>"><?php the_title(); ?></a>
		</h2>
		</div>
		<?php
		break;

		case 'quote':
		break;
		
		default:
		?>
		<div class="entry-post-title">
		<h2>
		<a class="postformat_<?php echo esc_attr($postformat); ?>" href="<?php the_permalink() ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'kreativa' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		</div>
		<?php
	}
}
?>
<?php
if ( !is_search() ) {
	get_template_part( 'template-parts/postformats/post','data' );
}
if ($postformat=="quote") {
		$quote=get_post_meta($post->ID, 'pagemeta_meta_quote', true);
		$quote_author=get_post_meta($post->ID, 'pagemeta_meta_quote_author', true);
		$fullcontent=true;
		if ($quote<>"") {
		?>
			<span class="quote_say"><div class="quote-symbol"><i class="fa fa-quote-left"></i></div><?php echo esc_html($quote); ?></span>
		<?php
			if ($quote_author != "") { ?>
				<span class="quote_author"><?php echo "&#8212;&nbsp;" . $quote_author; ?></span>
		<?php
			}
		}
}
?>
<?php
if ($postformat!="link" && $postformat!="aside" && $postformat!="quote"  ) {
	echo '<div class="postsummary-spacing">';
	the_excerpt();
	echo '</div>';
	$show_readmore=true;		
} else {
	echo '<div class="postsummary-spacing">';
	global $more;
	$more = 0;
	the_content();
	echo '</div>';
	$show_readmore=false;		
}
?>
<?php
if ( $show_readmore==true ) {
echo '<div class="button-blog-continue">
	<a href="'.esc_url( get_the_permalink() ).'">' . esc_html( kreativa_get_option_data ( 'read_more' ) ) . '</a>
</div>';
}
?>
</div>
</div>
	</div>
</div>
</div>