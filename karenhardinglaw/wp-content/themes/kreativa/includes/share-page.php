<?php
$page_id = get_the_id();
$link = get_permalink( $page_id );
if ( kreativa_is_fullscreen_post() ) {
	$page_id=kreativa_get_active_fullscreen_post();
	$link = home_url('/');
}

$media = kreativa_featured_image_link( $page_id );
$title = get_the_title( $page_id );

$socialshare = array();

$disable_share_facebook = kreativa_get_option_data('disable_share_facebook');
if ( !$disable_share_facebook || $disable_share_facebook=="0" ) {
	$socialshare['facebook'] = array (
				'fa-facebook' => 'http://www.facebook.com/sharer.php?u='. esc_url( $link ) .'&t='. urlencode( $title )
			);
}
$disable_share_twitter = kreativa_get_option_data('disable_share_twitter');
if ( !$disable_share_twitter || $disable_share_twitter=="0" ) {
	$socialshare['twitter'] = array (
				'fa-twitter' => 'http://twitter.com/home?status='.urlencode( $title ).'+'. esc_url( $link )
			);
}
$disable_share_linkedin = kreativa_get_option_data('disable_share_linkedin');
if ( !$disable_share_linkedin || $disable_share_linkedin=="0" ) {
	$socialshare['linkedin'] = array (
				'fa-linkedin' => 'http://linkedin.com/shareArticle?mini=true&amp;url='.esc_url( $link ).'&amp;title='.urlencode( $title )
			);
}
$disable_share_googleplus = kreativa_get_option_data('disable_share_googleplus');
if ( !$disable_share_googleplus || $disable_share_googleplus=="0" ) {
	$socialshare['googleplus'] = array (
				'fa-google-plus' => 'https://plus.google.com/share?url='. esc_url( $link )
			);
}
$disable_share_reddit = kreativa_get_option_data('disable_share_reddit');
if ( !$disable_share_reddit || $disable_share_reddit=="0" ) {
	$socialshare['reddit'] = array (
				'fa-reddit' => 'http://reddit.com/submit?url='.esc_url( $link ).'&amp;title='.urlencode( $title )
			);
}
$disable_share_tumblr = kreativa_get_option_data('disable_share_tumblr');
if ( !$disable_share_tumblr || $disable_share_tumblr=="0" ) {
	$socialshare['tumblr'] = array (
				'fa-tumblr' => 'http://www.tumblr.com/share/link?url='.esc_url( $link ).'&amp;name='.urlencode( $title ).'&amp;description='.urlencode( $title )
			);
}
$disable_share_pinterest = kreativa_get_option_data('disable_share_pinterest');
if ( !$disable_share_pinterest || $disable_share_pinterest=="0" ) {
	$socialshare['pinterest'] = array (
				'fa-pinterest' => 'http://pinterest.com/pin/create/bookmarklet/?media=' .esc_url( $media ) .'&url='. esc_url( $link ) .'&is_video=false&description='.urlencode( $title )
			);
}
$disable_share_email = kreativa_get_option_data('disable_share_email');
if ( !$disable_share_email ) {
$socialshare['email'] = array (
			'fa-envelope' => 'mailto:email@address.com?subject=Interesting%20Link&body=' . $title . " " .  esc_url( $link )
		);
}
?>
<ul class="page-share">
<?php
foreach($socialshare as $key => $share){
  foreach( $share as $icon => $url){
    echo '<li class="share-page-'.$icon.'"><a target="_blank" href="'. esc_url( $url ).'"><i class="fa '.$icon.'"></i></a></li>';
  }
}
?>
</ul>