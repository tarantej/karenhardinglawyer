<?php
// Pull all the Portfolio Categories into an array
$the_list = get_categories('taxonomy=types&title_li=');
if ($the_list) {
	$portfolio_categories=array();
	$portfolio_categories['-1']="All the items";
	foreach($the_list as $key => $list) {
		if (isSet($list->slug)) {
			$portfolio_categories[$list->slug] = $list->name;
		}
	}
} else {
	$portfolio_categories['none']="Portfolio Categories not found.";
}

// Pull all the categories into an array
$options_categories = array(); 
$options_categories['']="All Categories";
$options_categories_obj = get_categories();
foreach ($options_categories_obj as $category) {
	$options_categories[$category->slug] = $category->cat_name;
}

// Pull all the blog category slugs into an array
$blog_cat_slugs = array();
$blog_cat_slugs_obj = get_categories();
if ($blog_cat_slugs_obj) {
	foreach ($blog_cat_slugs_obj as $category) {
		$blog_cat_slugs[$category->slug] = $category->slug;
	}
} else {
	$blog_cat_slugs[0]="Blog Categories not found.";
}

// Pull all the Portfolio Categories into an array
$the_list = get_categories('taxonomy=types&title_li=');
if ($the_list) {
	$portfolio_categories=array();
	//$portfolio_categories[0]="All the items";
	foreach($the_list as $key => $list) {
		if (isSet($list->slug)) {
			$portfolio_categories[$list->slug] = $list->name;
		}
	}
} else {
	$portfolio_categories[0]="Portfolio Categories not found.";
}

// // Fontawesome icons list
// $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
// $fontawesome_file = mtheme_TINYMCE_DIR . '/css/font-awesome/css/font-awesome.css';

// @$fontawesome_contents = file_get_contents($fontawesome_file);

// preg_match_all($pattern, $fontawesome_contents, $matches, PREG_SET_ORDER);
// $fontawesome_icons = array();
// foreach($matches as $match){
// 	$fontawesome_icons[$match[1]] = $match[2];
// }
// var_export($fontawesome_icons);

	$ion_icons = array ('ion-alert' => '\f101','ion-alert-circled' => '\f100','ion-android-add' => '\f2c7','ion-android-add-circle' => '\f359','ion-android-alarm-clock' => '\f35a','ion-android-alert' => '\f35b','ion-android-apps' => '\f35c','ion-android-archive' => '\f2c9','ion-android-arrow-back' => '\f2ca','ion-android-arrow-down' => '\f35d','ion-android-arrow-dropdown' => '\f35f','ion-android-arrow-dropdown-circle' => '\f35e','ion-android-arrow-dropleft' => '\f361','ion-android-arrow-dropleft-circle' => '\f360','ion-android-arrow-dropright' => '\f363','ion-android-arrow-dropright-circle' => '\f362','ion-android-arrow-dropup' => '\f365','ion-android-arrow-dropup-circle' => '\f364','ion-android-arrow-forward' => '\f30f','ion-android-arrow-up' => '\f366','ion-android-attach' => '\f367','ion-android-bar' => '\f368','ion-android-bicycle' => '\f369','ion-android-boat' => '\f36a','ion-android-bookmark' => '\f36b','ion-android-bulb' => '\f36c','ion-android-bus' => '\f36d','ion-android-calendar' => '\f2d1','ion-android-call' => '\f2d2','ion-android-camera' => '\f2d3','ion-android-cancel' => '\f36e','ion-android-car' => '\f36f','ion-android-cart' => '\f370','ion-android-chat' => '\f2d4','ion-android-checkbox' => '\f374','ion-android-checkbox-blank' => '\f371','ion-android-checkbox-outline' => '\f373','ion-android-checkbox-outline-blank' => '\f372','ion-android-checkmark-circle' => '\f375','ion-android-clipboard' => '\f376','ion-android-close' => '\f2d7','ion-android-cloud' => '\f37a','ion-android-cloud-circle' => '\f377','ion-android-cloud-done' => '\f378','ion-android-cloud-outline' => '\f379','ion-android-color-palette' => '\f37b','ion-android-compass' => '\f37c','ion-android-contact' => '\f2d8','ion-android-contacts' => '\f2d9','ion-android-contract' => '\f37d','ion-android-create' => '\f37e','ion-android-delete' => '\f37f','ion-android-desktop' => '\f380','ion-android-document' => '\f381','ion-android-done' => '\f383','ion-android-done-all' => '\f382','ion-android-download' => '\f2dd','ion-android-drafts' => '\f384','ion-android-exit' => '\f385','ion-android-expand' => '\f386','ion-android-favorite' => '\f388','ion-android-favorite-outline' => '\f387','ion-android-film' => '\f389','ion-android-folder' => '\f2e0','ion-android-folder-open' => '\f38a','ion-android-funnel' => '\f38b','ion-android-globe' => '\f38c','ion-android-hand' => '\f2e3','ion-android-hangout' => '\f38d','ion-android-happy' => '\f38e','ion-android-home' => '\f38f','ion-android-image' => '\f2e4','ion-android-laptop' => '\f390','ion-android-list' => '\f391','ion-android-locate' => '\f2e9','ion-android-lock' => '\f392','ion-android-mail' => '\f2eb','ion-android-map' => '\f393','ion-android-menu' => '\f394','ion-android-microphone' => '\f2ec','ion-android-microphone-off' => '\f395','ion-android-more-horizontal' => '\f396','ion-android-more-vertical' => '\f397','ion-android-navigate' => '\f398','ion-android-notifications' => '\f39b','ion-android-notifications-none' => '\f399','ion-android-notifications-off' => '\f39a','ion-android-open' => '\f39c','ion-android-options' => '\f39d','ion-android-people' => '\f39e','ion-android-person' => '\f3a0','ion-android-person-add' => '\f39f','ion-android-phone-landscape' => '\f3a1','ion-android-phone-portrait' => '\f3a2','ion-android-pin' => '\f3a3','ion-android-plane' => '\f3a4','ion-android-playstore' => '\f2f0','ion-android-print' => '\f3a5','ion-android-radio-button-off' => '\f3a6','ion-android-radio-button-on' => '\f3a7','ion-android-refresh' => '\f3a8','ion-android-remove' => '\f2f4','ion-android-remove-circle' => '\f3a9','ion-android-restaurant' => '\f3aa','ion-android-sad' => '\f3ab','ion-android-search' => '\f2f5','ion-android-send' => '\f2f6','ion-android-settings' => '\f2f7','ion-android-share' => '\f2f8','ion-android-share-alt' => '\f3ac','ion-android-star' => '\f2fc','ion-android-star-half' => '\f3ad','ion-android-star-outline' => '\f3ae','ion-android-stopwatch' => '\f2fd','ion-android-subway' => '\f3af','ion-android-sunny' => '\f3b0','ion-android-sync' => '\f3b1','ion-android-textsms' => '\f3b2','ion-android-time' => '\f3b3','ion-android-train' => '\f3b4','ion-android-unlock' => '\f3b5','ion-android-upload' => '\f3b6','ion-android-volume-down' => '\f3b7','ion-android-volume-mute' => '\f3b8','ion-android-volume-off' => '\f3b9','ion-android-volume-up' => '\f3ba','ion-android-walk' => '\f3bb','ion-android-warning' => '\f3bc','ion-android-watch' => '\f3bd','ion-android-wifi' => '\f305','ion-aperture' => '\f313','ion-archive' => '\f102','ion-arrow-down-a' => '\f103','ion-arrow-down-b' => '\f104','ion-arrow-down-c' => '\f105','ion-arrow-expand' => '\f25e','ion-arrow-graph-down-left' => '\f25f','ion-arrow-graph-down-right' => '\f260','ion-arrow-graph-up-left' => '\f261','ion-arrow-graph-up-right' => '\f262','ion-arrow-left-a' => '\f106','ion-arrow-left-b' => '\f107','ion-arrow-left-c' => '\f108','ion-arrow-move' => '\f263','ion-arrow-resize' => '\f264','ion-arrow-return-left' => '\f265','ion-arrow-return-right' => '\f266','ion-arrow-right-a' => '\f109','ion-arrow-right-b' => '\f10a','ion-arrow-right-c' => '\f10b','ion-arrow-shrink' => '\f267','ion-arrow-swap' => '\f268','ion-arrow-up-a' => '\f10c','ion-arrow-up-b' => '\f10d','ion-arrow-up-c' => '\f10e','ion-asterisk' => '\f314','ion-at' => '\f10f','ion-backspace' => '\f3bf','ion-backspace-outline' => '\f3be','ion-bag' => '\f110','ion-battery-charging' => '\f111','ion-battery-empty' => '\f112','ion-battery-full' => '\f113','ion-battery-half' => '\f114','ion-battery-low' => '\f115','ion-beaker' => '\f269','ion-beer' => '\f26a','ion-bluetooth' => '\f116','ion-bonfire' => '\f315','ion-bookmark' => '\f26b','ion-bowtie' => '\f3c0','ion-briefcase' => '\f26c','ion-bug' => '\f2be','ion-calculator' => '\f26d','ion-calendar' => '\f117','ion-camera' => '\f118','ion-card' => '\f119','ion-cash' => '\f316','ion-chatbox' => '\f11b','ion-chatbox-working' => '\f11a','ion-chatboxes' => '\f11c','ion-chatbubble' => '\f11e','ion-chatbubble-working' => '\f11d','ion-chatbubbles' => '\f11f','ion-checkmark' => '\f122','ion-checkmark-circled' => '\f120','ion-checkmark-round' => '\f121','ion-chevron-down' => '\f123','ion-chevron-left' => '\f124','ion-chevron-right' => '\f125','ion-chevron-up' => '\f126','ion-clipboard' => '\f127','ion-clock' => '\f26e','ion-close' => '\f12a','ion-close-circled' => '\f128','ion-close-round' => '\f129','ion-closed-captioning' => '\f317','ion-cloud' => '\f12b','ion-code' => '\f271','ion-code-download' => '\f26f','ion-code-working' => '\f270','ion-coffee' => '\f272','ion-compass' => '\f273','ion-compose' => '\f12c','ion-connection-bars' => '\f274','ion-contrast' => '\f275','ion-crop' => '\f3c1','ion-cube' => '\f318','ion-disc' => '\f12d','ion-document' => '\f12f','ion-document-text' => '\f12e','ion-drag' => '\f130','ion-earth' => '\f276','ion-easel' => '\f3c2','ion-edit' => '\f2bf','ion-egg' => '\f277','ion-eject' => '\f131','ion-email' => '\f132','ion-email-unread' => '\f3c3','ion-erlenmeyer-flask' => '\f3c5','ion-erlenmeyer-flask-bubbles' => '\f3c4','ion-eye' => '\f133','ion-eye-disabled' => '\f306','ion-female' => '\f278','ion-filing' => '\f134','ion-film-marker' => '\f135','ion-fireball' => '\f319','ion-flag' => '\f279','ion-flame' => '\f31a','ion-flash' => '\f137','ion-flash-off' => '\f136','ion-folder' => '\f139','ion-fork' => '\f27a','ion-fork-repo' => '\f2c0','ion-forward' => '\f13a','ion-funnel' => '\f31b','ion-gear-a' => '\f13d','ion-gear-b' => '\f13e','ion-grid' => '\f13f','ion-hammer' => '\f27b','ion-happy' => '\f31c','ion-happy-outline' => '\f3c6','ion-headphone' => '\f140','ion-heart' => '\f141','ion-heart-broken' => '\f31d','ion-help' => '\f143','ion-help-buoy' => '\f27c','ion-help-circled' => '\f142','ion-home' => '\f144','ion-icecream' => '\f27d','ion-image' => '\f147','ion-images' => '\f148','ion-information' => '\f14a','ion-information-circled' => '\f149','ion-ionic' => '\f14b','ion-ios-alarm' => '\f3c8','ion-ios-alarm-outline' => '\f3c7','ion-ios-albums' => '\f3ca','ion-ios-albums-outline' => '\f3c9','ion-ios-americanfootball' => '\f3cc','ion-ios-americanfootball-outline' => '\f3cb','ion-ios-analytics' => '\f3ce','ion-ios-analytics-outline' => '\f3cd','ion-ios-arrow-back' => '\f3cf','ion-ios-arrow-down' => '\f3d0','ion-ios-arrow-forward' => '\f3d1','ion-ios-arrow-left' => '\f3d2','ion-ios-arrow-right' => '\f3d3','ion-ios-arrow-thin-down' => '\f3d4','ion-ios-arrow-thin-left' => '\f3d5','ion-ios-arrow-thin-right' => '\f3d6','ion-ios-arrow-thin-up' => '\f3d7','ion-ios-arrow-up' => '\f3d8','ion-ios-at' => '\f3da','ion-ios-at-outline' => '\f3d9','ion-ios-barcode' => '\f3dc','ion-ios-barcode-outline' => '\f3db','ion-ios-baseball' => '\f3de','ion-ios-baseball-outline' => '\f3dd','ion-ios-basketball' => '\f3e0','ion-ios-basketball-outline' => '\f3df','ion-ios-bell' => '\f3e2','ion-ios-bell-outline' => '\f3e1','ion-ios-body' => '\f3e4','ion-ios-body-outline' => '\f3e3','ion-ios-bolt' => '\f3e6','ion-ios-bolt-outline' => '\f3e5','ion-ios-book' => '\f3e8','ion-ios-book-outline' => '\f3e7','ion-ios-bookmarks' => '\f3ea','ion-ios-bookmarks-outline' => '\f3e9','ion-ios-box' => '\f3ec','ion-ios-box-outline' => '\f3eb','ion-ios-briefcase' => '\f3ee','ion-ios-briefcase-outline' => '\f3ed','ion-ios-browsers' => '\f3f0','ion-ios-browsers-outline' => '\f3ef','ion-ios-calculator' => '\f3f2','ion-ios-calculator-outline' => '\f3f1','ion-ios-calendar' => '\f3f4','ion-ios-calendar-outline' => '\f3f3','ion-ios-camera' => '\f3f6','ion-ios-camera-outline' => '\f3f5','ion-ios-cart' => '\f3f8','ion-ios-cart-outline' => '\f3f7','ion-ios-chatboxes' => '\f3fa','ion-ios-chatboxes-outline' => '\f3f9','ion-ios-chatbubble' => '\f3fc','ion-ios-chatbubble-outline' => '\f3fb','ion-ios-checkmark' => '\f3ff','ion-ios-checkmark-empty' => '\f3fd','ion-ios-checkmark-outline' => '\f3fe','ion-ios-circle-filled' => '\f400','ion-ios-circle-outline' => '\f401','ion-ios-clock' => '\f403','ion-ios-clock-outline' => '\f402','ion-ios-close' => '\f406','ion-ios-close-empty' => '\f404','ion-ios-close-outline' => '\f405','ion-ios-cloud' => '\f40c','ion-ios-cloud-download' => '\f408','ion-ios-cloud-download-outline' => '\f407','ion-ios-cloud-outline' => '\f409','ion-ios-cloud-upload' => '\f40b','ion-ios-cloud-upload-outline' => '\f40a','ion-ios-cloudy' => '\f410','ion-ios-cloudy-night' => '\f40e','ion-ios-cloudy-night-outline' => '\f40d','ion-ios-cloudy-outline' => '\f40f','ion-ios-cog' => '\f412','ion-ios-cog-outline' => '\f411','ion-ios-color-filter' => '\f414','ion-ios-color-filter-outline' => '\f413','ion-ios-color-wand' => '\f416','ion-ios-color-wand-outline' => '\f415','ion-ios-compose' => '\f418','ion-ios-compose-outline' => '\f417','ion-ios-contact' => '\f41a','ion-ios-contact-outline' => '\f419','ion-ios-copy' => '\f41c','ion-ios-copy-outline' => '\f41b','ion-ios-crop' => '\f41e','ion-ios-crop-strong' => '\f41d','ion-ios-download' => '\f420','ion-ios-download-outline' => '\f41f','ion-ios-drag' => '\f421','ion-ios-email' => '\f423','ion-ios-email-outline' => '\f422','ion-ios-eye' => '\f425','ion-ios-eye-outline' => '\f424','ion-ios-fastforward' => '\f427','ion-ios-fastforward-outline' => '\f426','ion-ios-filing' => '\f429','ion-ios-filing-outline' => '\f428','ion-ios-film' => '\f42b','ion-ios-film-outline' => '\f42a','ion-ios-flag' => '\f42d','ion-ios-flag-outline' => '\f42c','ion-ios-flame' => '\f42f','ion-ios-flame-outline' => '\f42e','ion-ios-flask' => '\f431','ion-ios-flask-outline' => '\f430','ion-ios-flower' => '\f433','ion-ios-flower-outline' => '\f432','ion-ios-folder' => '\f435','ion-ios-folder-outline' => '\f434','ion-ios-football' => '\f437','ion-ios-football-outline' => '\f436','ion-ios-game-controller-a' => '\f439','ion-ios-game-controller-a-outline' => '\f438','ion-ios-game-controller-b' => '\f43b','ion-ios-game-controller-b-outline' => '\f43a','ion-ios-gear' => '\f43d','ion-ios-gear-outline' => '\f43c','ion-ios-glasses' => '\f43f','ion-ios-glasses-outline' => '\f43e','ion-ios-grid-view' => '\f441','ion-ios-grid-view-outline' => '\f440','ion-ios-heart' => '\f443','ion-ios-heart-outline' => '\f442','ion-ios-help' => '\f446','ion-ios-help-empty' => '\f444','ion-ios-help-outline' => '\f445','ion-ios-home' => '\f448','ion-ios-home-outline' => '\f447','ion-ios-infinite' => '\f44a','ion-ios-infinite-outline' => '\f449','ion-ios-information' => '\f44d','ion-ios-information-empty' => '\f44b','ion-ios-information-outline' => '\f44c','ion-ios-ionic-outline' => '\f44e','ion-ios-keypad' => '\f450','ion-ios-keypad-outline' => '\f44f','ion-ios-lightbulb' => '\f452','ion-ios-lightbulb-outline' => '\f451','ion-ios-list' => '\f454','ion-ios-list-outline' => '\f453','ion-ios-location' => '\f456','ion-ios-location-outline' => '\f455','ion-ios-locked' => '\f458','ion-ios-locked-outline' => '\f457','ion-ios-loop' => '\f45a','ion-ios-loop-strong' => '\f459','ion-ios-medical' => '\f45c','ion-ios-medical-outline' => '\f45b','ion-ios-medkit' => '\f45e','ion-ios-medkit-outline' => '\f45d','ion-ios-mic' => '\f461','ion-ios-mic-off' => '\f45f','ion-ios-mic-outline' => '\f460','ion-ios-minus' => '\f464','ion-ios-minus-empty' => '\f462','ion-ios-minus-outline' => '\f463','ion-ios-monitor' => '\f466','ion-ios-monitor-outline' => '\f465','ion-ios-moon' => '\f468','ion-ios-moon-outline' => '\f467','ion-ios-more' => '\f46a','ion-ios-more-outline' => '\f469','ion-ios-musical-note' => '\f46b','ion-ios-musical-notes' => '\f46c','ion-ios-navigate' => '\f46e','ion-ios-navigate-outline' => '\f46d','ion-ios-nutrition' => '\f470','ion-ios-nutrition-outline' => '\f46f','ion-ios-paper' => '\f472','ion-ios-paper-outline' => '\f471','ion-ios-paperplane' => '\f474','ion-ios-paperplane-outline' => '\f473','ion-ios-partlysunny' => '\f476','ion-ios-partlysunny-outline' => '\f475','ion-ios-pause' => '\f478','ion-ios-pause-outline' => '\f477','ion-ios-paw' => '\f47a','ion-ios-paw-outline' => '\f479','ion-ios-people' => '\f47c','ion-ios-people-outline' => '\f47b','ion-ios-person' => '\f47e','ion-ios-person-outline' => '\f47d','ion-ios-personadd' => '\f480','ion-ios-personadd-outline' => '\f47f','ion-ios-photos' => '\f482','ion-ios-photos-outline' => '\f481','ion-ios-pie' => '\f484','ion-ios-pie-outline' => '\f483','ion-ios-pint' => '\f486','ion-ios-pint-outline' => '\f485','ion-ios-play' => '\f488','ion-ios-play-outline' => '\f487','ion-ios-plus' => '\f48b','ion-ios-plus-empty' => '\f489','ion-ios-plus-outline' => '\f48a','ion-ios-pricetag' => '\f48d','ion-ios-pricetag-outline' => '\f48c','ion-ios-pricetags' => '\f48f','ion-ios-pricetags-outline' => '\f48e','ion-ios-printer' => '\f491','ion-ios-printer-outline' => '\f490','ion-ios-pulse' => '\f493','ion-ios-pulse-strong' => '\f492','ion-ios-rainy' => '\f495','ion-ios-rainy-outline' => '\f494','ion-ios-recording' => '\f497','ion-ios-recording-outline' => '\f496','ion-ios-redo' => '\f499','ion-ios-redo-outline' => '\f498','ion-ios-refresh' => '\f49c','ion-ios-refresh-empty' => '\f49a','ion-ios-refresh-outline' => '\f49b','ion-ios-reload' => '\f49d','ion-ios-reverse-camera' => '\f49f','ion-ios-reverse-camera-outline' => '\f49e','ion-ios-rewind' => '\f4a1','ion-ios-rewind-outline' => '\f4a0','ion-ios-rose' => '\f4a3','ion-ios-rose-outline' => '\f4a2','ion-ios-search' => '\f4a5','ion-ios-search-strong' => '\f4a4','ion-ios-settings' => '\f4a7','ion-ios-settings-strong' => '\f4a6','ion-ios-shuffle' => '\f4a9','ion-ios-shuffle-strong' => '\f4a8','ion-ios-skipbackward' => '\f4ab','ion-ios-skipbackward-outline' => '\f4aa','ion-ios-skipforward' => '\f4ad','ion-ios-skipforward-outline' => '\f4ac','ion-ios-snowy' => '\f4ae','ion-ios-speedometer' => '\f4b0','ion-ios-speedometer-outline' => '\f4af','ion-ios-star' => '\f4b3','ion-ios-star-half' => '\f4b1','ion-ios-star-outline' => '\f4b2','ion-ios-stopwatch' => '\f4b5','ion-ios-stopwatch-outline' => '\f4b4','ion-ios-sunny' => '\f4b7','ion-ios-sunny-outline' => '\f4b6','ion-ios-telephone' => '\f4b9','ion-ios-telephone-outline' => '\f4b8','ion-ios-tennisball' => '\f4bb','ion-ios-tennisball-outline' => '\f4ba','ion-ios-thunderstorm' => '\f4bd','ion-ios-thunderstorm-outline' => '\f4bc','ion-ios-time' => '\f4bf','ion-ios-time-outline' => '\f4be','ion-ios-timer' => '\f4c1','ion-ios-timer-outline' => '\f4c0','ion-ios-toggle' => '\f4c3','ion-ios-toggle-outline' => '\f4c2','ion-ios-trash' => '\f4c5','ion-ios-trash-outline' => '\f4c4','ion-ios-undo' => '\f4c7','ion-ios-undo-outline' => '\f4c6','ion-ios-unlocked' => '\f4c9','ion-ios-unlocked-outline' => '\f4c8','ion-ios-upload' => '\f4cb','ion-ios-upload-outline' => '\f4ca','ion-ios-videocam' => '\f4cd','ion-ios-videocam-outline' => '\f4cc','ion-ios-volume-high' => '\f4ce','ion-ios-volume-low' => '\f4cf','ion-ios-wineglass' => '\f4d1','ion-ios-wineglass-outline' => '\f4d0','ion-ios-world' => '\f4d3','ion-ios-world-outline' => '\f4d2','ion-ipad' => '\f1f9','ion-iphone' => '\f1fa','ion-ipod' => '\f1fb','ion-jet' => '\f295','ion-key' => '\f296','ion-knife' => '\f297','ion-laptop' => '\f1fc','ion-leaf' => '\f1fd','ion-levels' => '\f298','ion-lightbulb' => '\f299','ion-link' => '\f1fe','ion-load-a' => '\f29a','ion-load-b' => '\f29b','ion-load-c' => '\f29c','ion-load-d' => '\f29d','ion-location' => '\f1ff','ion-lock-combination' => '\f4d4','ion-locked' => '\f200','ion-log-in' => '\f29e','ion-log-out' => '\f29f','ion-loop' => '\f201','ion-magnet' => '\f2a0','ion-male' => '\f2a1','ion-man' => '\f202','ion-map' => '\f203','ion-medkit' => '\f2a2','ion-merge' => '\f33f','ion-mic-a' => '\f204','ion-mic-b' => '\f205','ion-mic-c' => '\f206','ion-minus' => '\f209','ion-minus-circled' => '\f207','ion-minus-round' => '\f208','ion-model-s' => '\f2c1','ion-monitor' => '\f20a','ion-more' => '\f20b','ion-mouse' => '\f340','ion-music-note' => '\f20c','ion-navicon' => '\f20e','ion-navicon-round' => '\f20d','ion-navigate' => '\f2a3','ion-network' => '\f341','ion-no-smoking' => '\f2c2','ion-nuclear' => '\f2a4','ion-outlet' => '\f342','ion-paintbrush' => '\f4d5','ion-paintbucket' => '\f4d6','ion-paper-airplane' => '\f2c3','ion-paperclip' => '\f20f','ion-pause' => '\f210','ion-person' => '\f213','ion-person-add' => '\f211','ion-person-stalker' => '\f212','ion-pie-graph' => '\f2a5','ion-pin' => '\f2a6','ion-pinpoint' => '\f2a7','ion-pizza' => '\f2a8','ion-plane' => '\f214','ion-planet' => '\f343','ion-play' => '\f215','ion-playstation' => '\f30a','ion-plus' => '\f218','ion-plus-circled' => '\f216','ion-plus-round' => '\f217','ion-podium' => '\f344','ion-pound' => '\f219','ion-power' => '\f2a9','ion-pricetag' => '\f2aa','ion-pricetags' => '\f2ab','ion-printer' => '\f21a','ion-pull-request' => '\f345','ion-qr-scanner' => '\f346','ion-quote' => '\f347','ion-radio-waves' => '\f2ac','ion-record' => '\f21b','ion-refresh' => '\f21c','ion-reply' => '\f21e','ion-reply-all' => '\f21d','ion-ribbon-a' => '\f348','ion-ribbon-b' => '\f349','ion-sad' => '\f34a','ion-sad-outline' => '\f4d7','ion-scissors' => '\f34b','ion-search' => '\f21f','ion-settings' => '\f2ad','ion-share' => '\f220','ion-shuffle' => '\f221','ion-skip-backward' => '\f222','ion-skip-forward' => '\f223','ion-social-android' => '\f225','ion-social-android-outline' => '\f224','ion-social-angular' => '\f4d9','ion-social-angular-outline' => '\f4d8','ion-social-apple' => '\f227','ion-social-apple-outline' => '\f226','ion-social-bitcoin' => '\f2af','ion-social-bitcoin-outline' => '\f2ae','ion-social-buffer' => '\f229','ion-social-buffer-outline' => '\f228','ion-social-chrome' => '\f4db','ion-social-chrome-outline' => '\f4da','ion-social-codepen' => '\f4dd','ion-social-codepen-outline' => '\f4dc','ion-social-css3' => '\f4df','ion-social-css3-outline' => '\f4de','ion-social-designernews' => '\f22b','ion-social-designernews-outline' => '\f22a','ion-social-dribbble' => '\f22d','ion-social-dribbble-outline' => '\f22c','ion-social-dropbox' => '\f22f','ion-social-dropbox-outline' => '\f22e','ion-social-euro' => '\f4e1','ion-social-euro-outline' => '\f4e0','ion-social-facebook' => '\f231','ion-social-facebook-outline' => '\f230','ion-social-foursquare' => '\f34d','ion-social-foursquare-outline' => '\f34c','ion-social-freebsd-devil' => '\f2c4','ion-social-github' => '\f233','ion-social-github-outline' => '\f232','ion-social-google' => '\f34f','ion-social-google-outline' => '\f34e','ion-social-googleplus' => '\f235','ion-social-googleplus-outline' => '\f234','ion-social-hackernews' => '\f237','ion-social-hackernews-outline' => '\f236','ion-social-html5' => '\f4e3','ion-social-html5-outline' => '\f4e2','ion-social-instagram' => '\f351','ion-social-instagram-outline' => '\f350','ion-social-javascript' => '\f4e5','ion-social-javascript-outline' => '\f4e4','ion-social-linkedin' => '\f239','ion-social-linkedin-outline' => '\f238','ion-social-markdown' => '\f4e6','ion-social-nodejs' => '\f4e7','ion-social-octocat' => '\f4e8','ion-social-pinterest' => '\f2b1','ion-social-pinterest-outline' => '\f2b0','ion-social-python' => '\f4e9','ion-social-reddit' => '\f23b','ion-social-reddit-outline' => '\f23a','ion-social-rss' => '\f23d','ion-social-rss-outline' => '\f23c','ion-social-sass' => '\f4ea','ion-social-skype' => '\f23f','ion-social-skype-outline' => '\f23e','ion-social-snapchat' => '\f4ec','ion-social-snapchat-outline' => '\f4eb','ion-social-tumblr' => '\f241','ion-social-tumblr-outline' => '\f240','ion-social-tux' => '\f2c5','ion-social-twitch' => '\f4ee','ion-social-twitch-outline' => '\f4ed','ion-social-twitter' => '\f243','ion-social-twitter-outline' => '\f242','ion-social-usd' => '\f353','ion-social-usd-outline' => '\f352','ion-social-vimeo' => '\f245','ion-social-vimeo-outline' => '\f244','ion-social-whatsapp' => '\f4f0','ion-social-whatsapp-outline' => '\f4ef','ion-social-windows' => '\f247','ion-social-windows-outline' => '\f246','ion-social-wordpress' => '\f249','ion-social-wordpress-outline' => '\f248','ion-social-yahoo' => '\f24b','ion-social-yahoo-outline' => '\f24a','ion-social-yen' => '\f4f2','ion-social-yen-outline' => '\f4f1','ion-social-youtube' => '\f24d','ion-social-youtube-outline' => '\f24c','ion-soup-can' => '\f4f4','ion-soup-can-outline' => '\f4f3','ion-speakerphone' => '\f2b2','ion-speedometer' => '\f2b3','ion-spoon' => '\f2b4','ion-star' => '\f24e','ion-stats-bars' => '\f2b5','ion-steam' => '\f30b','ion-stop' => '\f24f','ion-thermometer' => '\f2b6','ion-thumbsdown' => '\f250','ion-thumbsup' => '\f251','ion-toggle' => '\f355','ion-toggle-filled' => '\f354','ion-transgender' => '\f4f5','ion-trash-a' => '\f252','ion-trash-b' => '\f253','ion-trophy' => '\f356','ion-tshirt' => '\f4f7','ion-tshirt-outline' => '\f4f6','ion-umbrella' => '\f2b7','ion-university' => '\f357','ion-unlocked' => '\f254','ion-upload' => '\f255','ion-usb' => '\f2b8','ion-videocamera' => '\f256','ion-volume-high' => '\f257','ion-volume-low' => '\f258','ion-volume-medium' => '\f259','ion-volume-mute' => '\f25a','ion-wand' => '\f358','ion-waterdrop' => '\f25b','ion-wifi' => '\f25c','ion-wineglass' => '\f2b9','ion-woman' => '\f25d','ion-wrench' => '\f2ba','ion-xbox' => '\f30c');

$fontello_icons = array ('fontello-icon-music' => '\e800','fontello-icon-search' => '\e801','fontello-icon-mail' => '\e802','fontello-icon-heart' => '\e803','fontello-icon-star' => '\e804','fontello-icon-user' => '\e805','fontello-icon-videocam' => '\e806','fontello-icon-camera' => '\e807','fontello-icon-photo' => '\e808','fontello-icon-attach' => '\e809','fontello-icon-lock' => '\e80a','fontello-icon-eye' => '\e80b','fontello-icon-tag' => '\e80c','fontello-icon-thumbs-up' => '\e80d','fontello-icon-pencil' => '\e80e','fontello-icon-comment' => '\e80f','fontello-icon-location' => '\e810','fontello-icon-cup' => '\e811','fontello-icon-trash' => '\e812','fontello-icon-doc' => '\e813','fontello-icon-note' => '\e814','fontello-icon-cog' => '\e815','fontello-icon-params' => '\e816','fontello-icon-calendar' => '\e817','fontello-icon-sound' => '\e818','fontello-icon-clock' => '\e819','fontello-icon-lightbulb' => '\e81a','fontello-icon-tv' => '\e81b','fontello-icon-desktop' => '\e81c','fontello-icon-mobile' => '\e81d','fontello-icon-cd' => '\e81e','fontello-icon-inbox' => '\e81f','fontello-icon-globe' => '\e820','fontello-icon-cloud' => '\e821','fontello-icon-paper-plane' => '\e822','fontello-icon-fire' => '\e823','fontello-icon-graduation-cap' => '\e824','fontello-icon-megaphone' => '\e825','fontello-icon-database' => '\e826','fontello-icon-key' => '\e827','fontello-icon-beaker' => '\e828','fontello-icon-truck' => '\e829','fontello-icon-money' => '\e82a','fontello-icon-food' => '\e82b','fontello-icon-shop' => '\e82c','fontello-icon-diamond' => '\e82d','fontello-icon-t-shirt' => '\e82e','fontello-icon-wallet' => '\e82f');
$feather_icons = array ('feather-icon-eye'=> '\e000' , 'feather-icon-paper-clip'=> '\e001' , 'feather-icon-mail'=> '\e002' , 'feather-icon-mail'=> '\e002' , 'feather-icon-toggle'=> '\e003' , 'feather-icon-layout'=> '\e004' , 'feather-icon-link'=> '\e005' , 'feather-icon-bell'=> '\e006' , 'feather-icon-lock'=> '\e007' , 'feather-icon-unlock'=> '\e008' , 'feather-icon-ribbon'=> '\e009' , 'feather-icon-image'=> '\e010' , 'feather-icon-signal'=> '\e011' , 'feather-icon-target'=> '\e012' , 'feather-icon-clipboard'=> '\e013' , 'feather-icon-clock'=> '\e014' , 'feather-icon-clock'=> '\e014' , 'feather-icon-watch'=> '\e015' , 'feather-icon-air-play'=> '\e016' , 'feather-icon-camera'=> '\e017' , 'feather-icon-video'=> '\e018' , 'feather-icon-disc'=> '\e019' , 'feather-icon-printer'=> '\e020' , 'feather-icon-monitor'=> '\e021' , 'feather-icon-server'=> '\e022' , 'feather-icon-cog'=> '\e023' , 'feather-icon-heart'=> '\e024' , 'feather-icon-paragraph'=> '\e025' , 'feather-icon-align-justify'=> '\e026' , 'feather-icon-align-left'=> '\e027' , 'feather-icon-align-center'=> '\e028' , 'feather-icon-align-right'=> '\e029' , 'feather-icon-book'=> '\e030' , 'feather-icon-layers'=> '\e031' , 'feather-icon-stack'=> '\e032' , 'feather-icon-stack-2'=> '\e033' , 'feather-icon-paper'=> '\e034' , 'feather-icon-paper-stack'=> '\e035' , 'feather-icon-search'=> '\e036' , 'feather-icon-zoom-in'=> '\e037' , 'feather-icon-zoom-out'=> '\e038' , 'feather-icon-reply'=> '\e039' , 'feather-icon-circle-plus'=> '\e040' , 'feather-icon-circle-minus'=> '\e041' , 'feather-icon-circle-check'=> '\e042' , 'feather-icon-circle-cross'=> '\e043' , 'feather-icon-square-plus'=> '\e044' , 'feather-icon-square-minus'=> '\e045' , 'feather-icon-square-check'=> '\e046' , 'feather-icon-square-cross'=> '\e047' , 'feather-icon-microphone'=> '\e048' , 'feather-icon-record'=> '\e049' , 'feather-icon-skip-back'=> '\e050' , 'feather-icon-rewind'=> '\e051' , 'feather-icon-play'=> '\e052' , 'feather-icon-pause'=> '\e053' , 'feather-icon-stop'=> '\e054' , 'feather-icon-fast-forward'=> '\e055' , 'feather-icon-skip-forward'=> '\e056' , 'feather-icon-shuffle'=> '\e057' , 'feather-icon-repeat'=> '\e058' , 'feather-icon-folder'=> '\e059' , 'feather-icon-umbrella'=> '\e060' , 'feather-icon-moon'=> '\e061' , 'feather-icon-thermometer'=> '\e062' , 'feather-icon-drop'=> '\e063' , 'feather-icon-sun'=> '\e064' , 'feather-icon-cloud'=> '\e065' , 'feather-icon-cloud-upload'=> '\e066' , 'feather-icon-cloud-download'=> '\e067' , 'feather-icon-upload'=> '\e068' , 'feather-icon-download'=> '\e069' , 'feather-icon-location'=> '\e070' , 'feather-icon-location-2'=> '\e071' , 'feather-icon-map'=> '\e072' , 'feather-icon-battery'=> '\e073' , 'feather-icon-head'=> '\e074' , 'feather-icon-briefcase'=> '\e075' , 'feather-icon-speech-bubble'=> '\e076' , 'feather-icon-anchor'=> '\e077' , 'feather-icon-globe'=> '\e078' , 'feather-icon-box'=> '\e079' , 'feather-icon-reload'=> '\e080' , 'feather-icon-share'=> '\e081' , 'feather-icon-marquee'=> '\e082' , 'feather-icon-marquee-plus'=> '\e083' , 'feather-icon-marquee-minus'=> '\e084' , 'feather-icon-tag'=> '\e085' , 'feather-icon-power'=> '\e086' , 'feather-icon-command'=> '\e087' , 'feather-icon-alt'=> '\e088' , 'feather-icon-esc'=> '\e089' , 'feather-icon-bar-graph'=> '\e090' , 'feather-icon-bar-graph-2'=> '\e091' , 'feather-icon-pie-graph'=> '\e092' , 'feather-icon-star'=> '\e093' , 'feather-icon-arrow-left'=> '\e094' , 'feather-icon-arrow-right'=> '\e095' , 'feather-icon-arrow-up'=> '\e096' , 'feather-icon-arrow-down'=> '\e097' , 'feather-icon-volume'=> '\e098' , 'feather-icon-mute'=> '\e099' , 'feather-icon-content-right'=> '\e100' , 'feather-icon-content-left'=> '\e101' , 'feather-icon-grid'=> '\e102' , 'feather-icon-grid-2'=> '\e103' , 'feather-icon-columns'=> '\e104' , 'feather-icon-loader'=> '\e105' , 'feather-icon-bag'=> '\e106' , 'feather-icon-ban'=> '\e107' , 'feather-icon-flag'=> '\e108' , 'feather-icon-trash'=> '\e109' , 'feather-icon-expand'=> '\e110' , 'feather-icon-contract'=> '\e111' , 'feather-icon-maximize'=> '\e112' , 'feather-icon-minimize'=> '\e113' , 'feather-icon-plus'=> '\e114' , 'feather-icon-minus'=> '\e115' , 'feather-icon-check'=> '\e116' , 'feather-icon-cross'=> '\e117' , 'feather-icon-move'=> '\e118' , 'feather-icon-delete'=> '\e119' , 'feather-icon-menu'=> '\e120' , 'feather-icon-archive'=> '\e121' , 'feather-icon-inbox'=> '\e122' , 'feather-icon-outbox'=> '\e123' , 'feather-icon-file'=> '\e124' , 'feather-icon-file-add'=> '\e125' , 'feather-icon-file-subtract'=> '\e126' , 'feather-icon-help'=> '\e127' , 'feather-icon-open'=> '\e128' , 'feather-icon-ellipsis'=> '\e129');
$et_icons = array ('et-icon-mobile' => '\e000','et-icon-laptop' => '\e001','et-icon-desktop' => '\e002','et-icon-tablet' => '\e003','et-icon-phone' => '\e004','et-icon-document' => '\e005','et-icon-documents' => '\e006','et-icon-search' => '\e007','et-icon-clipboard' => '\e008','et-icon-newspaper' => '\e009','et-icon-notebook' => '\e00a','et-icon-book-open' => '\e00b','et-icon-browser' => '\e00c','et-icon-calendar' => '\e00d','et-icon-presentation' => '\e00e','et-icon-picture' => '\e00f','et-icon-pictures' => '\e010','et-icon-video' => '\e011','et-icon-camera' => '\e012','et-icon-printer' => '\e013','et-icon-toolbox' => '\e014','et-icon-briefcase' => '\e015','et-icon-wallet' => '\e016','et-icon-gift' => '\e017','et-icon-bargraph' => '\e018','et-icon-grid' => '\e019','et-icon-expand' => '\e01a','et-icon-focus' => '\e01b','et-icon-edit' => '\e01c','et-icon-adjustments' => '\e01d','et-icon-ribbon' => '\e01e','et-icon-hourglass' => '\e01f','et-icon-lock' => '\e020','et-icon-megaphone' => '\e021','et-icon-shield' => '\e022','et-icon-trophy' => '\e023','et-icon-flag' => '\e024','et-icon-map' => '\e025','et-icon-puzzle' => '\e026','et-icon-basket' => '\e027','et-icon-envelope' => '\e028','et-icon-streetsign' => '\e029','et-icon-telescope' => '\e02a','et-icon-gears' => '\e02b','et-icon-key' => '\e02c','et-icon-paperclip' => '\e02d','et-icon-attachment' => '\e02e','et-icon-pricetags' => '\e02f','et-icon-lightbulb' => '\e030','et-icon-layers' => '\e031','et-icon-pencil' => '\e032','et-icon-tools' => '\e033','et-icon-tools-2' => '\e034','et-icon-scissors' => '\e035','et-icon-paintbrush' => '\e036','et-icon-magnifying-glass' => '\e037','et-icon-circle-compass' => '\e038','et-icon-linegraph' => '\e039','et-icon-mic' => '\e03a','et-icon-strategy' => '\e03b','et-icon-beaker' => '\e03c','et-icon-caution' => '\e03d','et-icon-recycle' => '\e03e','et-icon-anchor' => '\e03f','et-icon-profile-male' => '\e040','et-icon-profile-female' => '\e041','et-icon-bike' => '\e042','et-icon-wine' => '\e043','et-icon-hotairballoon' => '\e044','et-icon-globe' => '\e045','et-icon-genius' => '\e046','et-icon-map-pin' => '\e047','et-icon-dial' => '\e048','et-icon-chat' => '\e049','et-icon-heart' => '\e04a','et-icon-cloud' => '\e04b','et-icon-upload' => '\e04c','et-icon-download' => '\e04d','et-icon-target' => '\e04e','et-icon-hazardous' => '\e04f','et-icon-piechart' => '\e050','et-icon-speedometer' => '\e051','et-icon-global' => '\e052','et-icon-compass' => '\e053','et-icon-lifesaver' => '\e054','et-icon-clock' => '\e055','et-icon-aperture' => '\e056','et-icon-quote' => '\e057','et-icon-scope' => '\e058','et-icon-alarmclock' => '\e059','et-icon-refresh' => '\e05a','et-icon-happy' => '\e05b','et-icon-sad' => '\e05c','et-icon-facebook' => '\e05d','et-icon-twitter' => '\e05e','et-icon-googleplus' => '\e05f','et-icon-rss' => '\e060','et-icon-tumblr' => '\e061','et-icon-linkedin' => '\e062','et-icon-dribbble' => '\e063');
$fontawesome_icons = array ('fa fa-500px' => '\f26e','fa fa-address-book' => '\f2b9','fa fa-address-book-o' => '\f2ba','fa fa-address-card' => '\f2bb','fa fa-address-card-o' => '\f2bc','fa fa-adjust' => '\f042','fa fa-adn' => '\f170','fa fa-align-center' => '\f037','fa fa-align-justify' => '\f039','fa fa-align-left' => '\f036','fa fa-align-right' => '\f038','fa fa-amazon' => '\f270','fa fa-ambulance' => '\f0f9','fa fa-american-sign-language-interpreting' => '\f2a3','fa fa-anchor' => '\f13d','fa fa-android' => '\f17b','fa fa-angellist' => '\f209','fa fa-angle-double-down' => '\f103','fa fa-angle-double-left' => '\f100','fa fa-angle-double-right' => '\f101','fa fa-angle-double-up' => '\f102','fa fa-angle-down' => '\f107','fa fa-angle-left' => '\f104','fa fa-angle-right' => '\f105','fa fa-angle-up' => '\f106','fa fa-apple' => '\f179','fa fa-archive' => '\f187','fa fa-area-chart' => '\f1fe','fa fa-arrow-circle-down' => '\f0ab','fa fa-arrow-circle-left' => '\f0a8','fa fa-arrow-circle-o-down' => '\f01a','fa fa-arrow-circle-o-left' => '\f190','fa fa-arrow-circle-o-right' => '\f18e','fa fa-arrow-circle-o-up' => '\f01b','fa fa-arrow-circle-right' => '\f0a9','fa fa-arrow-circle-up' => '\f0aa','fa fa-arrow-down' => '\f063','fa fa-arrow-left' => '\f060','fa fa-arrow-right' => '\f061','fa fa-arrow-up' => '\f062','fa fa-arrows' => '\f047','fa fa-arrows-alt' => '\f0b2','fa fa-arrows-h' => '\f07e','fa fa-arrows-v' => '\f07d','fa fa-assistive-listening-systems' => '\f2a2','fa fa-asterisk' => '\f069','fa fa-at' => '\f1fa','fa fa-audio-description' => '\f29e','fa fa-backward' => '\f04a','fa fa-balance-scale' => '\f24e','fa fa-ban' => '\f05e','fa fa-bandcamp' => '\f2d5','fa fa-bar-chart' => '\f080','fa fa-barcode' => '\f02a','fa fa-bars' => '\f0c9','fa fa-bath' => '\f2cd','fa fa-battery-empty' => '\f244','fa fa-battery-full' => '\f240','fa fa-battery-half' => '\f242','fa fa-battery-quarter' => '\f243','fa fa-battery-three-quarters' => '\f241','fa fa-bed' => '\f236','fa fa-beer' => '\f0fc','fa fa-behance' => '\f1b4','fa fa-behance-square' => '\f1b5','fa fa-bell' => '\f0f3','fa fa-bell-o' => '\f0a2','fa fa-bell-slash' => '\f1f6','fa fa-bell-slash-o' => '\f1f7','fa fa-bicycle' => '\f206','fa fa-binoculars' => '\f1e5','fa fa-birthday-cake' => '\f1fd','fa fa-bitbucket' => '\f171','fa fa-bitbucket-square' => '\f172','fa fa-black-tie' => '\f27e','fa fa-blind' => '\f29d','fa fa-bluetooth' => '\f293','fa fa-bluetooth-b' => '\f294','fa fa-bold' => '\f032','fa fa-bolt' => '\f0e7','fa fa-bomb' => '\f1e2','fa fa-book' => '\f02d','fa fa-bookmark' => '\f02e','fa fa-bookmark-o' => '\f097','fa fa-braille' => '\f2a1','fa fa-briefcase' => '\f0b1','fa fa-btc' => '\f15a','fa fa-bug' => '\f188','fa fa-building' => '\f1ad','fa fa-building-o' => '\f0f7','fa fa-bullhorn' => '\f0a1','fa fa-bullseye' => '\f140','fa fa-bus' => '\f207','fa fa-buysellads' => '\f20d','fa fa-calculator' => '\f1ec','fa fa-calendar' => '\f073','fa fa-calendar-check-o' => '\f274','fa fa-calendar-minus-o' => '\f272','fa fa-calendar-o' => '\f133','fa fa-calendar-plus-o' => '\f271','fa fa-calendar-times-o' => '\f273','fa fa-camera' => '\f030','fa fa-camera-retro' => '\f083','fa fa-car' => '\f1b9','fa fa-caret-down' => '\f0d7','fa fa-caret-left' => '\f0d9','fa fa-caret-right' => '\f0da','fa fa-caret-square-o-down' => '\f150','fa fa-caret-square-o-left' => '\f191','fa fa-caret-square-o-right' => '\f152','fa fa-caret-square-o-up' => '\f151','fa fa-caret-up' => '\f0d8','fa fa-cart-arrow-down' => '\f218','fa fa-cart-plus' => '\f217','fa fa-cc' => '\f20a','fa fa-cc-amex' => '\f1f3','fa fa-cc-diners-club' => '\f24c','fa fa-cc-discover' => '\f1f2','fa fa-cc-jcb' => '\f24b','fa fa-cc-mastercard' => '\f1f1','fa fa-cc-paypal' => '\f1f4','fa fa-cc-stripe' => '\f1f5','fa fa-cc-visa' => '\f1f0','fa fa-certificate' => '\f0a3','fa fa-chain-broken' => '\f127','fa fa-check' => '\f00c','fa fa-check-circle' => '\f058','fa fa-check-circle-o' => '\f05d','fa fa-check-square' => '\f14a','fa fa-check-square-o' => '\f046','fa fa-chevron-circle-down' => '\f13a','fa fa-chevron-circle-left' => '\f137','fa fa-chevron-circle-right' => '\f138','fa fa-chevron-circle-up' => '\f139','fa fa-chevron-down' => '\f078','fa fa-chevron-left' => '\f053','fa fa-chevron-right' => '\f054','fa fa-chevron-up' => '\f077','fa fa-child' => '\f1ae','fa fa-chrome' => '\f268','fa fa-circle' => '\f111','fa fa-circle-o' => '\f10c','fa fa-circle-o-notch' => '\f1ce','fa fa-circle-thin' => '\f1db','fa fa-clipboard' => '\f0ea','fa fa-clock-o' => '\f017','fa fa-clone' => '\f24d','fa fa-cloud' => '\f0c2','fa fa-cloud-download' => '\f0ed','fa fa-cloud-upload' => '\f0ee','fa fa-code' => '\f121','fa fa-code-fork' => '\f126','fa fa-codepen' => '\f1cb','fa fa-codiepie' => '\f284','fa fa-coffee' => '\f0f4','fa fa-cog' => '\f013','fa fa-cogs' => '\f085','fa fa-columns' => '\f0db','fa fa-comment' => '\f075','fa fa-comment-o' => '\f0e5','fa fa-commenting' => '\f27a','fa fa-commenting-o' => '\f27b','fa fa-comments' => '\f086','fa fa-comments-o' => '\f0e6','fa fa-compass' => '\f14e','fa fa-compress' => '\f066','fa fa-connectdevelop' => '\f20e','fa fa-contao' => '\f26d','fa fa-copyright' => '\f1f9','fa fa-creative-commons' => '\f25e','fa fa-credit-card' => '\f09d','fa fa-credit-card-alt' => '\f283','fa fa-crop' => '\f125','fa fa-crosshairs' => '\f05b','fa fa-css3' => '\f13c','fa fa-cube' => '\f1b2','fa fa-cubes' => '\f1b3','fa fa-cutlery' => '\f0f5','fa fa-dashcube' => '\f210','fa fa-database' => '\f1c0','fa fa-deaf' => '\f2a4','fa fa-delicious' => '\f1a5','fa fa-desktop' => '\f108','fa fa-deviantart' => '\f1bd','fa fa-diamond' => '\f219','fa fa-digg' => '\f1a6','fa fa-dot-circle-o' => '\f192','fa fa-download' => '\f019','fa fa-dribbble' => '\f17d','fa fa-dropbox' => '\f16b','fa fa-drupal' => '\f1a9','fa fa-edge' => '\f282','fa fa-eercast' => '\f2da','fa fa-eject' => '\f052','fa fa-ellipsis-h' => '\f141','fa fa-ellipsis-v' => '\f142','fa fa-empire' => '\f1d1','fa fa-envelope' => '\f0e0','fa fa-envelope-o' => '\f003','fa fa-envelope-open' => '\f2b6','fa fa-envelope-open-o' => '\f2b7','fa fa-envelope-square' => '\f199','fa fa-envira' => '\f299','fa fa-eraser' => '\f12d','fa fa-etsy' => '\f2d7','fa fa-eur' => '\f153','fa fa-exchange' => '\f0ec','fa fa-exclamation' => '\f12a','fa fa-exclamation-circle' => '\f06a','fa fa-exclamation-triangle' => '\f071','fa fa-expand' => '\f065','fa fa-expeditedssl' => '\f23e','fa fa-external-link' => '\f08e','fa fa-external-link-square' => '\f14c','fa fa-eye' => '\f06e','fa fa-eye-slash' => '\f070','fa fa-eyedropper' => '\f1fb','fa fa-facebook' => '\f09a','fa fa-facebook-official' => '\f230','fa fa-facebook-square' => '\f082','fa fa-fast-backward' => '\f049','fa fa-fast-forward' => '\f050','fa fa-fax' => '\f1ac','fa fa-female' => '\f182','fa fa-fighter-jet' => '\f0fb','fa fa-file' => '\f15b','fa fa-file-archive-o' => '\f1c6','fa fa-file-audio-o' => '\f1c7','fa fa-file-code-o' => '\f1c9','fa fa-file-excel-o' => '\f1c3','fa fa-file-image-o' => '\f1c5','fa fa-file-o' => '\f016','fa fa-file-pdf-o' => '\f1c1','fa fa-file-powerpoint-o' => '\f1c4','fa fa-file-text' => '\f15c','fa fa-file-text-o' => '\f0f6','fa fa-file-video-o' => '\f1c8','fa fa-file-word-o' => '\f1c2','fa fa-files-o' => '\f0c5','fa fa-film' => '\f008','fa fa-filter' => '\f0b0','fa fa-fire' => '\f06d','fa fa-fire-extinguisher' => '\f134','fa fa-firefox' => '\f269','fa fa-first-order' => '\f2b0','fa fa-flag' => '\f024','fa fa-flag-checkered' => '\f11e','fa fa-flag-o' => '\f11d','fa fa-flask' => '\f0c3','fa fa-flickr' => '\f16e','fa fa-floppy-o' => '\f0c7','fa fa-folder' => '\f07b','fa fa-folder-o' => '\f114','fa fa-folder-open' => '\f07c','fa fa-folder-open-o' => '\f115','fa fa-font' => '\f031','fa fa-font-awesome' => '\f2b4','fa fa-fonticons' => '\f280','fa fa-fort-awesome' => '\f286','fa fa-forumbee' => '\f211','fa fa-forward' => '\f04e','fa fa-foursquare' => '\f180','fa fa-free-code-camp' => '\f2c5','fa fa-frown-o' => '\f119','fa fa-futbol-o' => '\f1e3','fa fa-gamepad' => '\f11b','fa fa-gavel' => '\f0e3','fa fa-gbp' => '\f154','fa fa-genderless' => '\f22d','fa fa-get-pocket' => '\f265','fa fa-gg' => '\f260','fa fa-gg-circle' => '\f261','fa fa-gift' => '\f06b','fa fa-git' => '\f1d3','fa fa-git-square' => '\f1d2','fa fa-github' => '\f09b','fa fa-github-alt' => '\f113','fa fa-github-square' => '\f092','fa fa-gitlab' => '\f296','fa fa-glass' => '\f000','fa fa-glide' => '\f2a5','fa fa-glide-g' => '\f2a6','fa fa-globe' => '\f0ac','fa fa-google' => '\f1a0','fa fa-google-plus' => '\f0d5','fa fa-google-plus-official' => '\f2b3','fa fa-google-plus-square' => '\f0d4','fa fa-google-wallet' => '\f1ee','fa fa-graduation-cap' => '\f19d','fa fa-gratipay' => '\f184','fa fa-grav' => '\f2d6','fa fa-h-square' => '\f0fd','fa fa-hacker-news' => '\f1d4','fa fa-hand-lizard-o' => '\f258','fa fa-hand-o-down' => '\f0a7','fa fa-hand-o-left' => '\f0a5','fa fa-hand-o-right' => '\f0a4','fa fa-hand-o-up' => '\f0a6','fa fa-hand-paper-o' => '\f256','fa fa-hand-peace-o' => '\f25b','fa fa-hand-pointer-o' => '\f25a','fa fa-hand-rock-o' => '\f255','fa fa-hand-scissors-o' => '\f257','fa fa-hand-spock-o' => '\f259','fa fa-handshake-o' => '\f2b5','fa fa-hashtag' => '\f292','fa fa-hdd-o' => '\f0a0','fa fa-header' => '\f1dc','fa fa-headphones' => '\f025','fa fa-heart' => '\f004','fa fa-heart-o' => '\f08a','fa fa-heartbeat' => '\f21e','fa fa-history' => '\f1da','fa fa-home' => '\f015','fa fa-hospital-o' => '\f0f8','fa fa-hourglass' => '\f254','fa fa-hourglass-end' => '\f253','fa fa-hourglass-half' => '\f252','fa fa-hourglass-o' => '\f250','fa fa-hourglass-start' => '\f251','fa fa-houzz' => '\f27c','fa fa-html5' => '\f13b','fa fa-i-cursor' => '\f246','fa fa-id-badge' => '\f2c1','fa fa-id-card' => '\f2c2','fa fa-id-card-o' => '\f2c3','fa fa-ils' => '\f20b','fa fa-imdb' => '\f2d8','fa fa-inbox' => '\f01c','fa fa-indent' => '\f03c','fa fa-industry' => '\f275','fa fa-info' => '\f129','fa fa-info-circle' => '\f05a','fa fa-inr' => '\f156','fa fa-instagram' => '\f16d','fa fa-internet-explorer' => '\f26b','fa fa-ioxhost' => '\f208','fa fa-italic' => '\f033','fa fa-joomla' => '\f1aa','fa fa-jpy' => '\f157','fa fa-jsfiddle' => '\f1cc','fa fa-key' => '\f084','fa fa-keyboard-o' => '\f11c','fa fa-krw' => '\f159','fa fa-language' => '\f1ab','fa fa-laptop' => '\f109','fa fa-lastfm' => '\f202','fa fa-lastfm-square' => '\f203','fa fa-leaf' => '\f06c','fa fa-leanpub' => '\f212','fa fa-lemon-o' => '\f094','fa fa-level-down' => '\f149','fa fa-level-up' => '\f148','fa fa-life-ring' => '\f1cd','fa fa-lightbulb-o' => '\f0eb','fa fa-line-chart' => '\f201','fa fa-link' => '\f0c1','fa fa-linkedin' => '\f0e1','fa fa-linkedin-square' => '\f08c','fa fa-linode' => '\f2b8','fa fa-linux' => '\f17c','fa fa-list' => '\f03a','fa fa-list-alt' => '\f022','fa fa-list-ol' => '\f0cb','fa fa-list-ul' => '\f0ca','fa fa-location-arrow' => '\f124','fa fa-lock' => '\f023','fa fa-long-arrow-down' => '\f175','fa fa-long-arrow-left' => '\f177','fa fa-long-arrow-right' => '\f178','fa fa-long-arrow-up' => '\f176','fa fa-low-vision' => '\f2a8','fa fa-magic' => '\f0d0','fa fa-magnet' => '\f076','fa fa-male' => '\f183','fa fa-map' => '\f279','fa fa-map-marker' => '\f041','fa fa-map-o' => '\f278','fa fa-map-pin' => '\f276','fa fa-map-signs' => '\f277','fa fa-mars' => '\f222','fa fa-mars-double' => '\f227','fa fa-mars-stroke' => '\f229','fa fa-mars-stroke-h' => '\f22b','fa fa-mars-stroke-v' => '\f22a','fa fa-maxcdn' => '\f136','fa fa-meanpath' => '\f20c','fa fa-medium' => '\f23a','fa fa-medkit' => '\f0fa','fa fa-meetup' => '\f2e0','fa fa-meh-o' => '\f11a','fa fa-mercury' => '\f223','fa fa-microchip' => '\f2db','fa fa-microphone' => '\f130','fa fa-microphone-slash' => '\f131','fa fa-minus' => '\f068','fa fa-minus-circle' => '\f056','fa fa-minus-square' => '\f146','fa fa-minus-square-o' => '\f147','fa fa-mixcloud' => '\f289','fa fa-mobile' => '\f10b','fa fa-modx' => '\f285','fa fa-money' => '\f0d6','fa fa-moon-o' => '\f186','fa fa-motorcycle' => '\f21c','fa fa-mouse-pointer' => '\f245','fa fa-music' => '\f001','fa fa-neuter' => '\f22c','fa fa-newspaper-o' => '\f1ea','fa fa-object-group' => '\f247','fa fa-object-ungroup' => '\f248','fa fa-odnoklassniki' => '\f263','fa fa-odnoklassniki-square' => '\f264','fa fa-opencart' => '\f23d','fa fa-openid' => '\f19b','fa fa-opera' => '\f26a','fa fa-optin-monster' => '\f23c','fa fa-outdent' => '\f03b','fa fa-pagelines' => '\f18c','fa fa-paint-brush' => '\f1fc','fa fa-paper-plane' => '\f1d8','fa fa-paper-plane-o' => '\f1d9','fa fa-paperclip' => '\f0c6','fa fa-paragraph' => '\f1dd','fa fa-pause' => '\f04c','fa fa-pause-circle' => '\f28b','fa fa-pause-circle-o' => '\f28c','fa fa-paw' => '\f1b0','fa fa-paypal' => '\f1ed','fa fa-pencil' => '\f040','fa fa-pencil-square' => '\f14b','fa fa-pencil-square-o' => '\f044','fa fa-percent' => '\f295','fa fa-phone' => '\f095','fa fa-phone-square' => '\f098','fa fa-picture-o' => '\f03e','fa fa-pie-chart' => '\f200','fa fa-pied-piper' => '\f2ae','fa fa-pied-piper-alt' => '\f1a8','fa fa-pied-piper-pp' => '\f1a7','fa fa-pinterest' => '\f0d2','fa fa-pinterest-p' => '\f231','fa fa-pinterest-square' => '\f0d3','fa fa-plane' => '\f072','fa fa-play' => '\f04b','fa fa-play-circle' => '\f144','fa fa-play-circle-o' => '\f01d','fa fa-plug' => '\f1e6','fa fa-plus' => '\f067','fa fa-plus-circle' => '\f055','fa fa-plus-square' => '\f0fe','fa fa-plus-square-o' => '\f196','fa fa-podcast' => '\f2ce','fa fa-power-off' => '\f011','fa fa-print' => '\f02f','fa fa-product-hunt' => '\f288','fa fa-puzzle-piece' => '\f12e','fa fa-qq' => '\f1d6','fa fa-qrcode' => '\f029','fa fa-question' => '\f128','fa fa-question-circle' => '\f059','fa fa-question-circle-o' => '\f29c','fa fa-quora' => '\f2c4','fa fa-quote-left' => '\f10d','fa fa-quote-right' => '\f10e','fa fa-random' => '\f074','fa fa-ravelry' => '\f2d9','fa fa-rebel' => '\f1d0','fa fa-recycle' => '\f1b8','fa fa-reddit' => '\f1a1','fa fa-reddit-alien' => '\f281','fa fa-reddit-square' => '\f1a2','fa fa-refresh' => '\f021','fa fa-registered' => '\f25d','fa fa-renren' => '\f18b','fa fa-repeat' => '\f01e','fa fa-reply' => '\f112','fa fa-reply-all' => '\f122','fa fa-retweet' => '\f079','fa fa-road' => '\f018','fa fa-rocket' => '\f135','fa fa-rss' => '\f09e','fa fa-rss-square' => '\f143','fa fa-rub' => '\f158','fa fa-safari' => '\f267','fa fa-scissors' => '\f0c4','fa fa-scribd' => '\f28a','fa fa-search' => '\f002','fa fa-search-minus' => '\f010','fa fa-search-plus' => '\f00e','fa fa-sellsy' => '\f213','fa fa-server' => '\f233','fa fa-share' => '\f064','fa fa-share-alt' => '\f1e0','fa fa-share-alt-square' => '\f1e1','fa fa-share-square' => '\f14d','fa fa-share-square-o' => '\f045','fa fa-shield' => '\f132','fa fa-ship' => '\f21a','fa fa-shirtsinbulk' => '\f214','fa fa-shopping-bag' => '\f290','fa fa-shopping-basket' => '\f291','fa fa-shopping-cart' => '\f07a','fa fa-shower' => '\f2cc','fa fa-sign-in' => '\f090','fa fa-sign-language' => '\f2a7','fa fa-sign-out' => '\f08b','fa fa-signal' => '\f012','fa fa-simplybuilt' => '\f215','fa fa-sitemap' => '\f0e8','fa fa-skyatlas' => '\f216','fa fa-skype' => '\f17e','fa fa-slack' => '\f198','fa fa-sliders' => '\f1de','fa fa-slideshare' => '\f1e7','fa fa-smile-o' => '\f118','fa fa-snapchat' => '\f2ab','fa fa-snapchat-ghost' => '\f2ac','fa fa-snapchat-square' => '\f2ad','fa fa-snowflake-o' => '\f2dc','fa fa-sort' => '\f0dc','fa fa-sort-alpha-asc' => '\f15d','fa fa-sort-alpha-desc' => '\f15e','fa fa-sort-amount-asc' => '\f160','fa fa-sort-amount-desc' => '\f161','fa fa-sort-asc' => '\f0de','fa fa-sort-desc' => '\f0dd','fa fa-sort-numeric-asc' => '\f162','fa fa-sort-numeric-desc' => '\f163','fa fa-soundcloud' => '\f1be','fa fa-space-shuttle' => '\f197','fa fa-spinner' => '\f110','fa fa-spoon' => '\f1b1','fa fa-spotify' => '\f1bc','fa fa-square' => '\f0c8','fa fa-square-o' => '\f096','fa fa-stack-exchange' => '\f18d','fa fa-stack-overflow' => '\f16c','fa fa-star' => '\f005','fa fa-star-half' => '\f089','fa fa-star-half-o' => '\f123','fa fa-star-o' => '\f006','fa fa-steam' => '\f1b6','fa fa-steam-square' => '\f1b7','fa fa-step-backward' => '\f048','fa fa-step-forward' => '\f051','fa fa-stethoscope' => '\f0f1','fa fa-sticky-note' => '\f249','fa fa-sticky-note-o' => '\f24a','fa fa-stop' => '\f04d','fa fa-stop-circle' => '\f28d','fa fa-stop-circle-o' => '\f28e','fa fa-street-view' => '\f21d','fa fa-strikethrough' => '\f0cc','fa fa-stumbleupon' => '\f1a4','fa fa-stumbleupon-circle' => '\f1a3','fa fa-subscript' => '\f12c','fa fa-subway' => '\f239','fa fa-suitcase' => '\f0f2','fa fa-sun-o' => '\f185','fa fa-superpowers' => '\f2dd','fa fa-superscript' => '\f12b','fa fa-table' => '\f0ce','fa fa-tablet' => '\f10a','fa fa-tachometer' => '\f0e4','fa fa-tag' => '\f02b','fa fa-tags' => '\f02c','fa fa-tasks' => '\f0ae','fa fa-taxi' => '\f1ba','fa fa-telegram' => '\f2c6','fa fa-television' => '\f26c','fa fa-tencent-weibo' => '\f1d5','fa fa-terminal' => '\f120','fa fa-text-height' => '\f034','fa fa-text-width' => '\f035','fa fa-th' => '\f00a','fa fa-th-large' => '\f009','fa fa-th-list' => '\f00b','fa fa-themeisle' => '\f2b2','fa fa-thermometer-empty' => '\f2cb','fa fa-thermometer-full' => '\f2c7','fa fa-thermometer-half' => '\f2c9','fa fa-thermometer-quarter' => '\f2ca','fa fa-thermometer-three-quarters' => '\f2c8','fa fa-thumb-tack' => '\f08d','fa fa-thumbs-down' => '\f165','fa fa-thumbs-o-down' => '\f088','fa fa-thumbs-o-up' => '\f087','fa fa-thumbs-up' => '\f164','fa fa-ticket' => '\f145','fa fa-times' => '\f00d','fa fa-times-circle' => '\f057','fa fa-times-circle-o' => '\f05c','fa fa-tint' => '\f043','fa fa-toggle-off' => '\f204','fa fa-toggle-on' => '\f205','fa fa-trademark' => '\f25c','fa fa-train' => '\f238','fa fa-transgender' => '\f224','fa fa-transgender-alt' => '\f225','fa fa-trash' => '\f1f8','fa fa-trash-o' => '\f014','fa fa-tree' => '\f1bb','fa fa-trello' => '\f181','fa fa-tripadvisor' => '\f262','fa fa-trophy' => '\f091','fa fa-truck' => '\f0d1','fa fa-try' => '\f195','fa fa-tty' => '\f1e4','fa fa-tumblr' => '\f173','fa fa-tumblr-square' => '\f174','fa fa-twitch' => '\f1e8','fa fa-twitter' => '\f099','fa fa-twitter-square' => '\f081','fa fa-umbrella' => '\f0e9','fa fa-underline' => '\f0cd','fa fa-undo' => '\f0e2','fa fa-universal-access' => '\f29a','fa fa-university' => '\f19c','fa fa-unlock' => '\f09c','fa fa-unlock-alt' => '\f13e','fa fa-upload' => '\f093','fa fa-usb' => '\f287','fa fa-usd' => '\f155','fa fa-user' => '\f007','fa fa-user-circle' => '\f2bd','fa fa-user-circle-o' => '\f2be','fa fa-user-md' => '\f0f0','fa fa-user-o' => '\f2c0','fa fa-user-plus' => '\f234','fa fa-user-secret' => '\f21b','fa fa-user-times' => '\f235','fa fa-users' => '\f0c0','fa fa-venus' => '\f221','fa fa-venus-double' => '\f226','fa fa-venus-mars' => '\f228','fa fa-viacoin' => '\f237','fa fa-viadeo' => '\f2a9','fa fa-viadeo-square' => '\f2aa','fa fa-video-camera' => '\f03d','fa fa-vimeo' => '\f27d','fa fa-vimeo-square' => '\f194','fa fa-vine' => '\f1ca','fa fa-vk' => '\f189','fa fa-volume-control-phone' => '\f2a0','fa fa-volume-down' => '\f027','fa fa-volume-off' => '\f026','fa fa-volume-up' => '\f028','fa fa-weibo' => '\f18a','fa fa-weixin' => '\f1d7','fa fa-whatsapp' => '\f232','fa fa-wheelchair' => '\f193','fa fa-wheelchair-alt' => '\f29b','fa fa-wifi' => '\f1eb','fa fa-wikipedia-w' => '\f266','fa fa-window-close' => '\f2d3','fa fa-window-close-o' => '\f2d4','fa fa-window-maximize' => '\f2d0','fa fa-window-minimize' => '\f2d1','fa fa-window-restore' => '\f2d2','fa fa-windows' => '\f17a','fa fa-wordpress' => '\f19a','fa fa-wpbeginner' => '\f297','fa fa-wpexplorer' => '\f2de','fa fa-wpforms' => '\f298','fa fa-wrench' => '\f0ad','fa fa-xing' => '\f168','fa fa-xing-square' => '\f169','fa fa-y-combinator' => '\f23b','fa fa-yahoo' => '\f19e','fa fa-yelp' => '\f1e9','fa fa-yoast' => '\f2b1','fa fa-youtube' => '\f167','fa fa-youtube-play' => '\f16a','fa fa-youtube-square' => '\f166');

$fontawesome_icons = array_merge($ion_icons,$et_icons, $feather_icons, $fontello_icons , $fontawesome_icons );
//$fontawesome_icons = array ( 'fa-glass' => '\\f000', 'fa-music' => '\\f001', 'fa-search' => '\\f002', 'fa-envelope-o' => '\\f003', 'fa-heart' => '\\f004', 'fa-star' => '\\f005', 'fa-star-o' => '\\f006', 'fa-user' => '\\f007', 'fa-film' => '\\f008', 'fa-th-large' => '\\f009', 'fa-th' => '\\f00a', 'fa-th-list' => '\\f00b', 'fa-check' => '\\f00c', 'fa-times' => '\\f00d', 'fa-search-plus' => '\\f00e', 'fa-search-minus' => '\\f010', 'fa-power-off' => '\\f011', 'fa-signal' => '\\f012', 'fa-cog' => '\\f013', 'fa-trash-o' => '\\f014', 'fa-home' => '\\f015', 'fa-file-o' => '\\f016', 'fa-clock-o' => '\\f017', 'fa-road' => '\\f018', 'fa-download' => '\\f019', 'fa-arrow-circle-o-down' => '\\f01a', 'fa-arrow-circle-o-up' => '\\f01b', 'fa-inbox' => '\\f01c', 'fa-play-circle-o' => '\\f01d', 'fa-repeat' => '\\f01e', 'fa-refresh' => '\\f021', 'fa-list-alt' => '\\f022', 'fa-lock' => '\\f023', 'fa-flag' => '\\f024', 'fa-headphones' => '\\f025', 'fa-volume-off' => '\\f026', 'fa-volume-down' => '\\f027', 'fa-volume-up' => '\\f028', 'fa-qrcode' => '\\f029', 'fa-barcode' => '\\f02a', 'fa-tag' => '\\f02b', 'fa-tags' => '\\f02c', 'fa-book' => '\\f02d', 'fa-bookmark' => '\\f02e', 'fa-print' => '\\f02f', 'fa-camera' => '\\f030', 'fa-font' => '\\f031', 'fa-bold' => '\\f032', 'fa-italic' => '\\f033', 'fa-text-height' => '\\f034', 'fa-text-width' => '\\f035', 'fa-align-left' => '\\f036', 'fa-align-center' => '\\f037', 'fa-align-right' => '\\f038', 'fa-align-justify' => '\\f039', 'fa-list' => '\\f03a', 'fa-outdent' => '\\f03b', 'fa-indent' => '\\f03c', 'fa-video-camera' => '\\f03d', 'fa-picture-o' => '\\f03e', 'fa-pencil' => '\\f040', 'fa-map-marker' => '\\f041', 'fa-adjust' => '\\f042', 'fa-tint' => '\\f043', 'fa-pencil-square-o' => '\\f044', 'fa-share-square-o' => '\\f045', 'fa-check-square-o' => '\\f046', 'fa-arrows' => '\\f047', 'fa-step-backward' => '\\f048', 'fa-fast-backward' => '\\f049', 'fa-backward' => '\\f04a', 'fa-play' => '\\f04b', 'fa-pause' => '\\f04c', 'fa-stop' => '\\f04d', 'fa-forward' => '\\f04e', 'fa-fast-forward' => '\\f050', 'fa-step-forward' => '\\f051', 'fa-eject' => '\\f052', 'fa-chevron-left' => '\\f053', 'fa-chevron-right' => '\\f054', 'fa-plus-circle' => '\\f055', 'fa-minus-circle' => '\\f056', 'fa-times-circle' => '\\f057', 'fa-check-circle' => '\\f058', 'fa-question-circle' => '\\f059', 'fa-info-circle' => '\\f05a', 'fa-crosshairs' => '\\f05b', 'fa-times-circle-o' => '\\f05c', 'fa-check-circle-o' => '\\f05d', 'fa-ban' => '\\f05e', 'fa-arrow-left' => '\\f060', 'fa-arrow-right' => '\\f061', 'fa-arrow-up' => '\\f062', 'fa-arrow-down' => '\\f063', 'fa-share' => '\\f064', 'fa-expand' => '\\f065', 'fa-compress' => '\\f066', 'fa-plus' => '\\f067', 'fa-minus' => '\\f068', 'fa-asterisk' => '\\f069', 'fa-exclamation-circle' => '\\f06a', 'fa-gift' => '\\f06b', 'fa-leaf' => '\\f06c', 'fa-fire' => '\\f06d', 'fa-eye' => '\\f06e', 'fa-eye-slash' => '\\f070', 'fa-exclamation-triangle' => '\\f071', 'fa-plane' => '\\f072', 'fa-calendar' => '\\f073', 'fa-random' => '\\f074', 'fa-comment' => '\\f075', 'fa-magnet' => '\\f076', 'fa-chevron-up' => '\\f077', 'fa-chevron-down' => '\\f078', 'fa-retweet' => '\\f079', 'fa-shopping-cart' => '\\f07a', 'fa-folder' => '\\f07b', 'fa-folder-open' => '\\f07c', 'fa-arrows-v' => '\\f07d', 'fa-arrows-h' => '\\f07e', 'fa-bar-chart-o' => '\\f080', 'fa-twitter-square' => '\\f081', 'fa-facebook-square' => '\\f082', 'fa-camera-retro' => '\\f083', 'fa-key' => '\\f084', 'fa-cogs' => '\\f085', 'fa-comments' => '\\f086', 'fa-thumbs-o-up' => '\\f087', 'fa-thumbs-o-down' => '\\f088', 'fa-star-half' => '\\f089', 'fa-heart-o' => '\\f08a', 'fa-sign-out' => '\\f08b', 'fa-linkedin-square' => '\\f08c', 'fa-thumb-tack' => '\\f08d', 'fa-external-link' => '\\f08e', 'fa-sign-in' => '\\f090', 'fa-trophy' => '\\f091', 'fa-github-square' => '\\f092', 'fa-upload' => '\\f093', 'fa-lemon-o' => '\\f094', 'fa-phone' => '\\f095', 'fa-square-o' => '\\f096', 'fa-bookmark-o' => '\\f097', 'fa-phone-square' => '\\f098', 'fa-twitter' => '\\f099', 'fa-facebook' => '\\f09a', 'fa-github' => '\\f09b', 'fa-unlock' => '\\f09c', 'fa-credit-card' => '\\f09d', 'fa-rss' => '\\f09e', 'fa-hdd-o' => '\\f0a0', 'fa-bullhorn' => '\\f0a1', 'fa-bell' => '\\f0f3', 'fa-certificate' => '\\f0a3', 'fa-hand-o-right' => '\\f0a4', 'fa-hand-o-left' => '\\f0a5', 'fa-hand-o-up' => '\\f0a6', 'fa-hand-o-down' => '\\f0a7', 'fa-arrow-circle-left' => '\\f0a8', 'fa-arrow-circle-right' => '\\f0a9', 'fa-arrow-circle-up' => '\\f0aa', 'fa-arrow-circle-down' => '\\f0ab', 'fa-globe' => '\\f0ac', 'fa-wrench' => '\\f0ad', 'fa-tasks' => '\\f0ae', 'fa-filter' => '\\f0b0', 'fa-briefcase' => '\\f0b1', 'fa-arrows-alt' => '\\f0b2', 'fa-users' => '\\f0c0', 'fa-link' => '\\f0c1', 'fa-cloud' => '\\f0c2', 'fa-flask' => '\\f0c3', 'fa-scissors' => '\\f0c4', 'fa-files-o' => '\\f0c5', 'fa-paperclip' => '\\f0c6', 'fa-floppy-o' => '\\f0c7', 'fa-square' => '\\f0c8', 'fa-bars' => '\\f0c9', 'fa-list-ul' => '\\f0ca', 'fa-list-ol' => '\\f0cb', 'fa-strikethrough' => '\\f0cc', 'fa-underline' => '\\f0cd', 'fa-table' => '\\f0ce', 'fa-magic' => '\\f0d0', 'fa-truck' => '\\f0d1', 'fa-pinterest' => '\\f0d2', 'fa-pinterest-square' => '\\f0d3', 'fa-google-plus-square' => '\\f0d4', 'fa-google-plus' => '\\f0d5', 'fa-money' => '\\f0d6', 'fa-caret-down' => '\\f0d7', 'fa-caret-up' => '\\f0d8', 'fa-caret-left' => '\\f0d9', 'fa-caret-right' => '\\f0da', 'fa-columns' => '\\f0db', 'fa-sort' => '\\f0dc', 'fa-sort-desc' => '\\f0dd', 'fa-sort-asc' => '\\f0de', 'fa-envelope' => '\\f0e0', 'fa-linkedin' => '\\f0e1', 'fa-undo' => '\\f0e2', 'fa-gavel' => '\\f0e3', 'fa-tachometer' => '\\f0e4', 'fa-comment-o' => '\\f0e5', 'fa-comments-o' => '\\f0e6', 'fa-bolt' => '\\f0e7', 'fa-sitemap' => '\\f0e8', 'fa-umbrella' => '\\f0e9', 'fa-clipboard' => '\\f0ea', 'fa-lightbulb-o' => '\\f0eb', 'fa-exchange' => '\\f0ec', 'fa-cloud-download' => '\\f0ed', 'fa-cloud-upload' => '\\f0ee', 'fa-user-md' => '\\f0f0', 'fa-stethoscope' => '\\f0f1', 'fa-suitcase' => '\\f0f2', 'fa-bell-o' => '\\f0a2', 'fa-coffee' => '\\f0f4', 'fa-cutlery' => '\\f0f5', 'fa-file-text-o' => '\\f0f6', 'fa-building-o' => '\\f0f7', 'fa-hospital-o' => '\\f0f8', 'fa-ambulance' => '\\f0f9', 'fa-medkit' => '\\f0fa', 'fa-fighter-jet' => '\\f0fb', 'fa-beer' => '\\f0fc', 'fa-h-square' => '\\f0fd', 'fa-plus-square' => '\\f0fe', 'fa-angle-double-left' => '\\f100', 'fa-angle-double-right' => '\\f101', 'fa-angle-double-up' => '\\f102', 'fa-angle-double-down' => '\\f103', 'fa-angle-left' => '\\f104', 'fa-angle-right' => '\\f105', 'fa-angle-up' => '\\f106', 'fa-angle-down' => '\\f107', 'fa-desktop' => '\\f108', 'fa-laptop' => '\\f109', 'fa-tablet' => '\\f10a', 'fa-mobile' => '\\f10b', 'fa-circle-o' => '\\f10c', 'fa-quote-left' => '\\f10d', 'fa-quote-right' => '\\f10e', 'fa-spinner' => '\\f110', 'fa-circle' => '\\f111', 'fa-reply' => '\\f112', 'fa-github-alt' => '\\f113', 'fa-folder-o' => '\\f114', 'fa-folder-open-o' => '\\f115', 'fa-smile-o' => '\\f118', 'fa-frown-o' => '\\f119', 'fa-meh-o' => '\\f11a', 'fa-gamepad' => '\\f11b', 'fa-keyboard-o' => '\\f11c', 'fa-flag-o' => '\\f11d', 'fa-flag-checkered' => '\\f11e', 'fa-terminal' => '\\f120', 'fa-code' => '\\f121', 'fa-reply-all' => '\\f122', 'fa-star-half-o' => '\\f123', 'fa-location-arrow' => '\\f124', 'fa-crop' => '\\f125', 'fa-code-fork' => '\\f126', 'fa-chain-broken' => '\\f127', 'fa-question' => '\\f128', 'fa-info' => '\\f129', 'fa-exclamation' => '\\f12a', 'fa-superscript' => '\\f12b', 'fa-subscript' => '\\f12c', 'fa-eraser' => '\\f12d', 'fa-puzzle-piece' => '\\f12e', 'fa-microphone' => '\\f130', 'fa-microphone-slash' => '\\f131', 'fa-shield' => '\\f132', 'fa-calendar-o' => '\\f133', 'fa-fire-extinguisher' => '\\f134', 'fa-rocket' => '\\f135', 'fa-maxcdn' => '\\f136', 'fa-chevron-circle-left' => '\\f137', 'fa-chevron-circle-right' => '\\f138', 'fa-chevron-circle-up' => '\\f139', 'fa-chevron-circle-down' => '\\f13a', 'fa-html5' => '\\f13b', 'fa-css3' => '\\f13c', 'fa-anchor' => '\\f13d', 'fa-unlock-alt' => '\\f13e', 'fa-bullseye' => '\\f140', 'fa-ellipsis-h' => '\\f141', 'fa-ellipsis-v' => '\\f142', 'fa-rss-square' => '\\f143', 'fa-play-circle' => '\\f144', 'fa-ticket' => '\\f145', 'fa-minus-square' => '\\f146', 'fa-minus-square-o' => '\\f147', 'fa-level-up' => '\\f148', 'fa-level-down' => '\\f149', 'fa-check-square' => '\\f14a', 'fa-pencil-square' => '\\f14b', 'fa-external-link-square' => '\\f14c', 'fa-share-square' => '\\f14d', 'fa-compass' => '\\f14e', 'fa-caret-square-o-down' => '\\f150', 'fa-caret-square-o-up' => '\\f151', 'fa-caret-square-o-right' => '\\f152', 'fa-eur' => '\\f153', 'fa-gbp' => '\\f154', 'fa-usd' => '\\f155', 'fa-inr' => '\\f156', 'fa-jpy' => '\\f157', 'fa-rub' => '\\f158', 'fa-krw' => '\\f159', 'fa-btc' => '\\f15a', 'fa-file' => '\\f15b', 'fa-file-text' => '\\f15c', 'fa-sort-alpha-asc' => '\\f15d', 'fa-sort-alpha-desc' => '\\f15e', 'fa-sort-amount-asc' => '\\f160', 'fa-sort-amount-desc' => '\\f161', 'fa-sort-numeric-asc' => '\\f162', 'fa-sort-numeric-desc' => '\\f163', 'fa-thumbs-up' => '\\f164', 'fa-thumbs-down' => '\\f165', 'fa-youtube-square' => '\\f166', 'fa-youtube' => '\\f167', 'fa-xing' => '\\f168', 'fa-xing-square' => '\\f169', 'fa-youtube-play' => '\\f16a', 'fa-dropbox' => '\\f16b', 'fa-stack-overflow' => '\\f16c', 'fa-instagram' => '\\f16d', 'fa-flickr' => '\\f16e', 'fa-adn' => '\\f170', 'fa-bitbucket' => '\\f171', 'fa-bitbucket-square' => '\\f172', 'fa-tumblr' => '\\f173', 'fa-tumblr-square' => '\\f174', 'fa-long-arrow-down' => '\\f175', 'fa-long-arrow-up' => '\\f176', 'fa-long-arrow-left' => '\\f177', 'fa-long-arrow-right' => '\\f178', 'fa-apple' => '\\f179', 'fa-windows' => '\\f17a', 'fa-android' => '\\f17b', 'fa-linux' => '\\f17c', 'fa-dribbble' => '\\f17d', 'fa-skype' => '\\f17e', 'fa-foursquare' => '\\f180', 'fa-trello' => '\\f181', 'fa-female' => '\\f182', 'fa-male' => '\\f183', 'fa-gittip' => '\\f184', 'fa-sun-o' => '\\f185', 'fa-moon-o' => '\\f186', 'fa-archive' => '\\f187', 'fa-bug' => '\\f188', 'fa-vk' => '\\f189', 'fa-weibo' => '\\f18a', 'fa-renren' => '\\f18b', 'fa-pagelines' => '\\f18c', 'fa-stack-exchange' => '\\f18d', 'fa-arrow-circle-o-right' => '\\f18e', 'fa-arrow-circle-o-left' => '\\f190', 'fa-caret-square-o-left' => '\\f191', 'fa-dot-circle-o' => '\\f192', 'fa-wheelchair' => '\\f193', 'fa-vimeo-square' => '\\f194', 'fa-try' => '\\f195', 'fa-plus-square-o' => '\\f196', 'fa-space-shuttle' => '\\f197', 'fa-slack' => '\\f198', 'fa-envelope-square' => '\\f199', 'fa-wordpress' => '\\f19a', 'fa-openid' => '\\f19b', 'fa-university' => '\\f19c', 'fa-graduation-cap' => '\\f19d', 'fa-yahoo' => '\\f19e', 'fa-google' => '\\f1a0', 'fa-reddit' => '\\f1a1', 'fa-reddit-square' => '\\f1a2', 'fa-stumbleupon-circle' => '\\f1a3', 'fa-stumbleupon' => '\\f1a4', 'fa-delicious' => '\\f1a5', 'fa-digg' => '\\f1a6', 'fa-pied-piper' => '\\f1a7', 'fa-pied-piper-alt' => '\\f1a8', 'fa-drupal' => '\\f1a9', 'fa-joomla' => '\\f1aa', 'fa-language' => '\\f1ab', 'fa-fax' => '\\f1ac', 'fa-building' => '\\f1ad', 'fa-child' => '\\f1ae', 'fa-paw' => '\\f1b0', 'fa-spoon' => '\\f1b1', 'fa-cube' => '\\f1b2', 'fa-cubes' => '\\f1b3', 'fa-behance' => '\\f1b4', 'fa-behance-square' => '\\f1b5', 'fa-steam' => '\\f1b6', 'fa-steam-square' => '\\f1b7', 'fa-recycle' => '\\f1b8', 'fa-car' => '\\f1b9', 'fa-taxi' => '\\f1ba', 'fa-tree' => '\\f1bb', 'fa-spotify' => '\\f1bc', 'fa-deviantart' => '\\f1bd', 'fa-soundcloud' => '\\f1be', 'fa-database' => '\\f1c0', 'fa-file-pdf-o' => '\\f1c1', 'fa-file-word-o' => '\\f1c2', 'fa-file-excel-o' => '\\f1c3', 'fa-file-powerpoint-o' => '\\f1c4', 'fa-file-image-o' => '\\f1c5', 'fa-file-archive-o' => '\\f1c6', 'fa-file-audio-o' => '\\f1c7', 'fa-file-video-o' => '\\f1c8', 'fa-file-code-o' => '\\f1c9', 'fa-vine' => '\\f1ca', 'fa-codepen' => '\\f1cb', 'fa-jsfiddle' => '\\f1cc', 'fa-life-ring' => '\\f1cd', 'fa-circle-o-notch' => '\\f1ce', 'fa-rebel' => '\\f1d0', 'fa-empire' => '\\f1d1', 'fa-git-square' => '\\f1d2', 'fa-git' => '\\f1d3', 'fa-hacker-news' => '\\f1d4', 'fa-tencent-weibo' => '\\f1d5', 'fa-qq' => '\\f1d6', 'fa-weixin' => '\\f1d7', 'fa-paper-plane' => '\\f1d8', 'fa-paper-plane-o' => '\\f1d9', 'fa-history' => '\\f1da', 'fa-circle-thin' => '\\f1db', 'fa-header' => '\\f1dc', 'fa-paragraph' => '\\f1dd', 'fa-sliders' => '\\f1de', 'fa-share-alt' => '\\f1e0', 'fa-share-alt-square' => '\\f1e1', 'fa-bomb' => '\\f1e2', );

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Gen
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => '',
	'shortcode_desc' => ''
);

/*-----------------------------------------------------------------------------------*/
/*	Social Links
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['socials'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add a Social link', 'mthemelocal'),
	'params' => array(
        'social_icon' => array(
            'std' => '',
            'type' => 'fontawesome-iconpicker',
            'label' => __('Icon', 'mthemelocal'),
            'desc' => __('Select an icon', 'mthemelocal'),
            'options' => $fontawesome_icons
        ),
		'align' => array(
			'type' => 'select',
			'label' => __('Align', 'mthemelocal'),
			'desc' => __('Align', 'mthemelocal'),
			'options' => array(
				'left' => 'left',
				'right' => 'right'
			)
		),
		'social_color' => array(
			'std' => '#EC3939',
			'type' => 'color',
			'label' => __('Social icon color', 'mthemelocal'),
			'desc' => __('Social icon color', 'mthemelocal'),
		),
        'social_link' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Social link', 'mthemelocal'),
            'desc' => __('Social link', 'mthemelocal'),
        ),
        'social_text' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Social hover text', 'mthemelocal'),
            'desc' => __('Social hover text', 'mthemelocal'),
        )
	),
	'shortcode' => '[socials align="{{align}}" social_color="{{social_color}}" social_icon="{{social_icon}}" social_link="{{social_link}}" social_text="{{social_text}}"]',
	'popup_title' => __('Add a Social link', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Clients
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['clients'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Add client logos', 'mthemelocal'),
    'shortcode' => '[clients column="{{column}}" ] {{child_shortcode}} <br/>[/clients]',
    'popup_title' => __('Generate Clients Shortcode', 'mthemelocal'),
 	'params' => array(
		'column' => array(
			'type' => 'select',
			'label' => __('Clients Columns', 'mthemelocal'),
			'desc' => __('Select number of columns for client boxes. Add matching number of Client Items. You can add as many as you need.', 'mthemelocal'),
			'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6'
			)
		)
		
	),
    'child_shortcode' => array(
        'params' => array(
            'logo' => array(
                'std' => '',
                'type' => 'uploader',
                'label' => __('Add image', 'mthemelocal'),
                'desc' => __('Upload a logo', 'mthemelocal'),
            ),
            'hovertitle' => array(
                'std' => 'Client Name',
                'type' => 'text',
                'label' => __('Client Name', 'mthemelocal'),
                'desc' => __('Client Name', 'mthemelocal'),
            ),
            'link' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Link', 'mthemelocal'),
                'desc' => __('Link to title', 'mthemelocal'),
            )
        ),
        'shortcode' => '<br/> [client logo="{{logo}}" hovertitle="{{hovertitle}}" link="{{link}}"]',
        'clone_button' => __('+ Add another Client', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Google Maps
/*-----------------------------------------------------------------------------------*/
$mtheme_shortcodes['map'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add Google Maps', 'mthemelocal'),
	'params' => array(
		'map_type' => array(
			'type' => 'select',
			'label' => __('Map Type', 'mthemelocal'),
			'desc' => __('Map Type', 'mthemelocal'),
			'options' => array(
				'ROADMAP' => 'roadmap',
				'SATELLITE' => 'satellite',
				'HYBRID' => 'hybrid',
				'TERRAIN' => 'terrain',
			)
		),
        'map_address' => array(
            'std' => 'Tokyo, Japan',
            'type' => 'text',
            'label' => __('Map Address', 'mthemelocal'),
            'desc' => __('Map Address', 'mthemelocal'),
        ),
        'map_height' => array(
            'std' => '400',
            'type' => 'text',
            'label' => __('Map Height', 'mthemelocal'),
            'desc' => __('Map Height', 'mthemelocal'),
        ),
        'map_latitude' => array(
            'std' => '0',
            'type' => 'text',
            'label' => __('Map Latitude', 'mthemelocal'),
            'desc' => __('Set 0 if you want to don\'t want to use the field. Map Latitude', 'mthemelocal'),
        ),
        'map_longitude' => array(
            'std' => '0',
            'type' => 'text',
            'label' => __('Map Longitude', 'mthemelocal'),
            'desc' => __('Set 0 if you want to don\'t want to use the field. Map Longitude', 'mthemelocal'),
        ),
		'map_marker' => array(
			'type' => 'select',
			'label' => __('Map Marker', 'mthemelocal'),
			'desc' => __('Map Marker', 'mthemelocal'),
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No'
			)
		),
        'map_zoom' => array(
            'std' => '18',
            'type' => 'text',
            'label' => __('Map Zoom (1 to 20)', 'mthemelocal'),
            'desc' => __('Map Height', 'mthemelocal'),
        ),
		'map_scroll' => array(
			'type' => 'select',
			'label' => __('Mouse Scroll', 'mthemelocal'),
			'desc' => __('Mouse Scroll', 'mthemelocal'),
			'options' => array(
				'true' => 'True',
				'false' => 'False'
			)
		),
		'map_control' => array(
			'type' => 'select',
			'label' => __('Map Controls', 'mthemelocal'),
			'desc' => __('Map Controls', 'mthemelocal'),
			'options' => array(
				'true' => 'True',
				'false' => 'False'
			)
		),
        'map_marker_image' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Image as marker', 'mthemelocal'),
            'desc' => __('Image as marker', 'mthemelocal'),
        ),
        'map_marker_text' => array(
            'std' => 'Marker Text',
            'type' => 'text',
            'label' => __('Marker text', 'mthemelocal'),
            'desc' => __('Marker text', 'mthemelocal'),
        )
	),
	'shortcode' => '[map maptype="{{map_type}}" scrollwheel="{{map_scroll}}" markerimage="{{map_marker_image}}" infowindow="{{map_marker_text}}" lat="{{map_latitude}}" lon="{{map_longitude}}" hidecontrols="{{map_control}}" marker="{{map_marker}}" z="{{map_zoom}}" h="{{map_height}}" w="{{map_width}}" address="{{map_address}}"]',
	'popup_title' => __('Add Google Maps', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Portfolio Slideshow
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['recent_portfolio_slideshow'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add a slideshow of portfolio items', 'mthemelocal'),
	'params' => array(
        'limit' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Limit posts', 'mthemelocal'),
            'desc' => __('Limit the number of posts', 'mthemelocal'),
        ),
		'worktype_slugs' => array(
			'type' => 'multilist',
			'std' => '',
			'label' => __('Enter Work type slugs to list', 'mthemelocal'),
			'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
			'options' => $portfolio_categories
		),
		'transition' => array(
			'type' => 'select',
			'label' => __('Slideshow transition', 'mthemelocal'),
			'desc' => __('Slideshow transition', 'mthemelocal'),
			'options' => array(
				'fade' => 'fade',
				'slide' => 'slide'
			)
		)
	),
	'shortcode' => '[recent_portfolio_slideshow limit="{{limit}}" worktype_slugs="{{worktype_slugs}}" transition="{{transition}}"]',
	'popup_title' => __('Add a slideshow of portfolio items', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Blog Slideshow
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['recent_blog_slideshow'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add a slideshow of blog posts', 'mthemelocal'),
	'params' => array(
        'limit' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Limit posts', 'mthemelocal'),
            'desc' => __('Limit the number of posts', 'mthemelocal'),
        ),
		'cat_slugs' => array(
			'type' => 'multilist',
			'std' => '',
			'label' => __('Enter category slugs to list', 'mthemelocal'),
			'desc' => __('Leave blank to list all. Enter comma seperated blog categories. eg. artwork,photography,prints ', 'mthemelocal'),
			'options' => $blog_cat_slugs
		),
		'transition' => array(
			'type' => 'select',
			'label' => __('Slideshow transition', 'mthemelocal'),
			'desc' => __('Slideshow transition', 'mthemelocal'),
			'options' => array(
				'fade' => 'fade',
				'slide' => 'slide'
			)
		)
	),
	'shortcode' => '[recent_blog_slideshow limit="{{limit}}" cat_slugs="{{cat_slugs}}" transition="{{transition}}"]',
	'popup_title' => __('Add a slideshow of blog posts', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Slideshow Shortcode
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['slideshowcarousel'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add flexiSlideshow', 'mthemelocal'),
	'params' => array(
		'thumbnails' => array(
			'type' => 'select',
			'label' => __('Dispay thumbnails', 'mthemelocal'),
			'desc' => __('Display thumbnails', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'displaytitle' => array(
			'type' => 'select',
			'std' => 'false',
			'label' => __('Dispay title', 'mthemelocal'),
			'desc' => __('Display thumbnails', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		)
	),
	'shortcode' => '[slideshowcarousel displaytitle="{{displaytitle}}" thumbnails="{{thumbnails}}"]',
	'popup_title' => __('Add FlexSlideshow', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Audio Shortcode
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['audioplayer'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add HTML5 Audio Player', 'mthemelocal'),
	'params' => array(
        'title' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Title of Audio', 'mthemelocal'),
            'desc' => __('Title of Audio', 'mthemelocal'),
        ),
        'mp3' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('MP3 url. File path', 'mthemelocal'),
            'desc' => __('MP3 url. File path', 'mthemelocal'),
        ),
        'm4a' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('M4A url. File path', 'mthemelocal'),
            'desc' => __('M4A url. File path', 'mthemelocal'),
        ),
        'oga' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('OGA url. File path', 'mthemelocal'),
            'desc' => __('OGA url. File path', 'mthemelocal'),
        )
	),
	'shortcode' => '[audioplayer mp3="{{mp3}}" m4a="{{m4a}}" oga="{{oga}}" title="{{title}}"]',
	'popup_title' => __('Insert Audio Player', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Call Out
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['callout'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Callout box.', 'mthemelocal'),
	'params' => array(
        'title' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Title', 'mthemelocal'),
            'desc' => __('Title for Callout box', 'mthemelocal'),
        ),
        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => __('Text for Callout', 'mthemelocal'),
            'desc' => __('Text for Callout', 'mthemelocal'),
        ),
        'button_icon' => array(
                'std' => 'fa fa-anchor',
	            'type' => 'fontawesome-iconpicker',
	            'label' => __('Choose an icon', 'mthemelocal'),
	            'desc' => __('Pick a icon', 'mthemelocal'),
	            'options' => $fontawesome_icons
        ),
        'button_color' => array(
            'std' => '',
            'type' => 'color',
            'label' => __('Button Color', 'mthemelocal'),
            'desc' => __('Button Color', 'mthemelocal'),
        ),
        'button_text' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Button Text', 'mthemelocal'),
            'desc' => __('Button Text', 'mthemelocal'),
        ),
        'button_link' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Button Link', 'mthemelocal'),
            'desc' => __('Button Link', 'mthemelocal'),
        ),
	),
	'shortcode' => '[callout type="{{style}}" title="{{title}}" description="{{content}}" button_color="{{button_color}}" button="true" button_icon="{{button_icon}}" button_text="{{button_text}}" button_link="{{button_link}}"]',
	'popup_title' => __('Insert Callout Box', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Dividers
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['divider'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Display Dividers. Blanks and minimal decorations.', 'mthemelocal'),
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('Choose Divider', 'mthemelocal'),
			'desc' => __('Choose Divider', 'mthemelocal'),
			'options' => array(
				'blank' => 'blank',
				'line' => 'line',
				'double' => 'double',
				'stripes' => 'stripes',
				'thinfade' => 'thinfade',
				'threelines' => 'threelines',
				'circleline' => 'circleline',
				'stripedcenter' => 'stripedcenter',
				'linedcenter' => 'linedcenter'
			)
		),
        'top' => array(
            'std' => '10',
            'type' => 'text',
            'label' => __('Top Space in pixels', 'mthemelocal'),
            'desc' => __('Top Spacing', 'mthemelocal'),
        ),
        'bottom' => array(
            'std' => '10',
            'type' => 'text',
            'label' => __('Bottom Space pixels', 'mthemelocal'),
            'desc' => __('Bottom Spacing', 'mthemelocal'),
        )
	),
	'shortcode' => '[divider top="{{top}}" bottom="{{bottom}}" style="{{style}}"]',
	'popup_title' => __('Insert Divider', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Heading
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['heading'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Display Section Headings', 'mthemelocal'),
				'params' => array(
					'title' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Section Heading text', 'mthemelocal'),
						'desc' => __('Section Heading text', 'mthemelocal'),
					),
					'subtitle' => array(
						'std' => '',
						'type' => 'text',
						'label' => __('Section subtitle (optional)', 'mthemelocal'),
						'desc' => __('Section Heading text', 'mthemelocal'),
					),
					'align' => array(
						'type' => 'select',
						'label' => __('Align text', 'mthemelocal'),
						'desc' => __('Align text', 'mthemelocal'),
						'options' => array(
							'left' => 'Left',
							'center' => 'Center',
							'right' => 'Right'
						)
					),
					'size' => array(
						'type' => 'select',
						'label' => __('Heading size', 'mthemelocal'),
						'desc' => __('Heading size', 'mthemelocal'),
						'options' => array(
							'1' => 'h1',
							'2' => 'h2',
							'3' => 'h3',
							'4' => 'h4',
							'5' => 'h5',
							'6' => 'h6'
						)
					),
					'content_richtext' => array(
						'std' => '',
						'textformat' => 'richtext',
						'type' => 'textarea',
						'label' => __('Toggle Content', 'mthemelocal'),
						'desc' => __('Add the toggle content. Will accept HTML', 'mthemelocal'),
					),
			        'button' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Button Text', 'mthemelocal'),
			            'desc' => __('Button Text', 'mthemelocal'),
			        ),
			        'button_link' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Button link', 'mthemelocal'),
			            'desc' => __('Button link', 'mthemelocal'),
			        ),
			        'width' => array(
			            'std' => '',
			            'type' => 'text',
			            'label' => __('Width in percent', 'mthemelocal'),
			            'desc' => __('Width in percent', 'mthemelocal'),
			        ),
			        'top' => array(
			            'std' => '10',
			            'type' => 'text',
			            'label' => __('Padding Top in pixels', 'mthemelocal'),
			            'desc' => __('Top Spacing', 'mthemelocal'),
			        ),
			        'bottom' => array(
			            'std' => '10',
			            'type' => 'text',
			            'label' => __('Padding bottom pixels', 'mthemelocal'),
			            'desc' => __('Bottom Spacing', 'mthemelocal'),
			        ),
			        'marginbottom' => array(
			            'std' => '60',
			            'type' => 'text',
			            'label' => __('Margin bottom pixels', 'mthemelocal'),
			            'desc' => __('Margin Bottom Spacing', 'mthemelocal'),
			        )
				),
				'shortcode' => '[heading marginbottom="{{marginbottom}}" width="{{width}}" content_richtext="{{content_richtext}}" button="{{button}}" button_link="{{button_link}}" top="{{top}}" bottom="{{bottom}}" size="{{size}}" title="{{title}}" subtitle="{{subtitle}}" align="{{align}}"]',
	'popup_title' => __('Insert Section Heading', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Pullquote
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['pullquote'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Display Pullquotes', 'mthemelocal'),
	'params' => array(
		'content' => array(
			'std' => 'Nunc ligula risus, dignissim eget dolor sed, condimentum scelerisque quam. Nulla id lectus posuere, fermentum elit at, fringilla eros. Vivamus at facilisis leo, id convallis sem. Sed mauris urna, finibus ac lectus vel, condimentum aliquet velit. Donec laoreet rutrum ipsum a commodo. Aenean non venenatis dolor. Mauris in justo fringilla, suscipit lectus in, vehicula ex. Duis molestie quis quam ut sollicitudin. Cras placerat faucibus sapien, sed convallis turpis dapibus ultrices. Praesent porta metus odio, sed venenatis augue tincidunt at.',
			'type' => 'textarea',
			'label' => __('Pullquote text', 'mthemelocal'),
			'desc' => __('Pullquote text', 'mthemelocal'),
		),
		'align' => array(
			'type' => 'select',
			'label' => __('Alignment', 'mthemelocal'),
			'desc' => __('Alignment', 'mthemelocal'),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center'
			)
		)
		
	),
	'shortcode' => '[pullquote align="{{align}}"]{{content}}[/pullquote]',
	'popup_title' => __('Insert Pullquote', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Highlight Text
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['highlight'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Highlight texts', 'mthemelocal'),
	'params' => array(
		'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Text to hightlight', 'mthemelocal'),
			'desc' => __('Text to hightlight', 'mthemelocal'),
		)
		
	),
	'shortcode' => '[highlight]{{content}}[/highlight]',
	'popup_title' => __('Insert Highlighted text', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Drop Caps
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Display Drop Cap letters', 'mthemelocal'),
	'params' => array(
		'letter' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Drop cap letter', 'mthemelocal'),
			'desc' => __('Drop cap letter', 'mthemelocal'),
		),
		'type' => array(
			'type' => 'select',
			'label' => __('Display style', 'mthemelocal'),
			'desc' => __('Display style', 'mthemelocal'),
			'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3'
			)
		)
		
	),
	'shortcode' => '[dropcap type="{{type}}"]{{letter}}[/dropcap]',
	'popup_title' => __('Insert Drop Cap Letter', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Lightbox Image/Video
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['lightbox'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Display lightboxes', 'mthemelocal'),
	'params' => array(
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Lightbox image title', 'mthemelocal'),
			'desc' => __('Lightbox image title', 'mthemelocal'),
		),
		'lightbox_url' => array(
			'std' => '',
			'type' => 'uploader',
			'label' => __('Lightbox image', 'mthemelocal'),
			'desc' => __('Lightbox image.', 'mthemelocal')
		),
		'lightbox_video_url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Lightbox video', 'mthemelocal'),
			'desc' => __('Enter a youtube or vimeo video url here for videos.', 'mthemelocal')
		),
		'thumbnail_url' => array(
			'std' => '',
			'type' => 'uploader',
			'label' => __('Thumbnail image', 'mthemelocal'),
			'desc' => __('Thumbnail image', 'mthemelocal')
		),
		'align' => array(
			'type' => 'select',
			'label' => __('Image Alignment', 'mthemelocal'),
			'desc' => __('Alignment of image', 'mthemelocal'),
			'options' => array(
				'left' => 'left',
				'right' => 'right',
				'center' => 'center'
			)
		)
		
	),
	'shortcode' => '[lightbox title="{{title}}" lightbox_video_url="{{lightbox_video_url}}" lightbox_url="{{lightbox_url}}" thumbnail_url="{{thumbnail_url}}" align="{{align}}"]',
	'popup_title' => __('Insert Lightbox Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Pricing Shortcode
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['pricing_table'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Add Pricing shortcode. You can configure the shortcode after adding them.', 'mthemelocal'),
    'shortcode' => '[pricing_table columns="{{columns}}"]<br/> {{child_shortcode}}  [/pricing_table]',
    'popup_title' => __('Add Pricing Shortcode', 'mthemelocal'),
 	'params' => array(
		'columns' => array(
			'type' => 'select',
			'label' => __('Columns', 'mthemelocal'),
			'desc' => __('No. of Pricing Columns', 'mthemelocal'),
			'options' => array(
				'6' => '6',
				'5' => '5',
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1'
			)
		)
	),
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Column Title', 'mthemelocal'),
                'desc' => __('After generating shortcode you can duplicate the [pricing_row] section to make as many rows as you prefer.', 'mthemelocal'),
            )
        ),
        'shortcode' => '[pricing_column title="{{title}}" featured="false"]<br/>[pricing_price currency="$" price="29.99" duration="monthly"]<br/>[pricing_row type="tick"] Apple [/pricing_row]<br/>[pricing_row type="cross"] Orange [/pricing_row]<br/>[pricing_footer][button link="#" align="center"]Signup[/button][/pricing_footer]<br/>[/pricing_column]<br/>',
        'clone_button' => __('+ Add Another Column', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Portfolio Grid
/*-----------------------------------------------------------------------------------*/
//[portfoliogrid worktype_slugs="" limit="8" pagination="true" columns="4" title="false" desc="true" type="filter"]
$mtheme_shortcodes['portfoliogrid'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('A Grid based list of portfolio items.', 'mthemelocal'),
	'params' => array(
		'worktype_slugs' => array(
			'type' => 'multilist',
			'std' => '',
			'label' => __('Choose Work types to list', 'mthemelocal'),
			'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
			'options' => $portfolio_categories
		),
		'type' => array(
			'type' => 'select',
			'label' => __('Type of Portfolio list', 'mthemelocal'),
			'desc' => __('Type of Portfolio list', 'mthemelocal'),
			'options' => array(
				'no-filter' => 'No Filter',
				'filter' => 'Filterable',
				'ajax' => 'Ajax Filterable',
			)
		),
		'columns' => array(
			'type' => 'select',
			'label' => __('Grid Columns', 'mthemelocal'),
			'desc' => __('No. of Grid Columns', 'mthemelocal'),
			'options' => array(
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1'
			)
		),
		'title' => array(
			'type' => 'select',
			'label' => __('Display post title', 'mthemelocal'),
			'desc' => __('Display post title', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'desc' => array(
			'type' => 'select',
			'label' => __('Display Post description', 'mthemelocal'),
			'desc' => __('Display Post description', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'limit' => array(
			'std' => '-1',
			'type' => 'text',
			'label' => __('Limit. -1 for unlimited', 'mthemelocal'),
			'desc' => __('Limit items. -1 for unlimited', 'mthemelocal'),
		),
		'pagination' => array(
			'type' => 'select',
			'label' => __('Generate Pagination', 'mthemelocal'),
			'desc' => __('Generate Pagination', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		)
	),
	'shortcode' => '[portfoliogrid type="{{type}}" columns="{{columns}}" worktype_slugs="{{worktype_slugs}}" title="{{title}}" desc="{{desc}}" pagination="{{pagination}}" limit="{{limit}}"]',
	'popup_title' => __('Insert Portfolio Grid Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Counter Shortcode
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['counter'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Generate Counters based on percentage', 'mthemelocal'),
	'params' => array(
		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Title', 'mthemelocal'),
			'desc' => __('Add the alert\'s text', 'mthemelocal'),
		),
		'percentage' => array(
			'std' => '70',
			'type' => 'text',
			'label' => __('Percentage', 'mthemelocal'),
			'desc' => __('Percentage', 'mthemelocal'),
		),
		'size' => array(
			'std' => '150',
			'type' => 'text',
			'label' => __('Counter Size', 'mthemelocal'),
			'desc' => __('Counter size', 'mthemelocal'),
		),
		'donutwidth' => array(
			'std' => '10',
			'type' => 'text',
			'label' => __('Border Size', 'mthemelocal'),
			'desc' => __('Border size', 'mthemelocal'),
		),
		'textsize' => array(
			'std' => '32',
			'type' => 'text',
			'label' => __('Counter percent text size', 'mthemelocal'),
			'desc' => __('Counter percent text size', 'mthemelocal'),
		),
		'fgcolor' => array(
			'std' => '#EC3939',
			'type' => 'color',
			'label' => __('Foreground Color', 'mthemelocal'),
			'desc' => __('Foreground Color', 'mthemelocal'),
		),
		'bgcolor' => array(
			'std' => '#f0f0f0',
			'type' => 'color',
			'label' => __('Background Color', 'mthemelocal'),
			'desc' => __('Background color', 'mthemelocal'),
		),
		'content' => array(
			'std' => 'Counter Description',
			'type' => 'textarea',
			'label' => __('Counter description', 'mthemelocal'),
			'desc' => __('Counter Description', 'mthemelocal'),
		)
		
	),
	'shortcode' => '[counter size="{{size}}" percentage="{{percentage}}" textsize="{{textsize}}" bgcolor="{{bgcolor}}" fgcolor="{{fgcolor}}" donutwidth="{{donutwidth}}" title="{{title}}"]{{content}}[/counter]',
	'popup_title' => __('Insert Counter Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Staff Shortcode
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['staff'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Add a Staff with multiple social links.', 'mthemelocal'),
    'shortcode' => '[staff title="{{title}}" name="{{name}}" image="{{image}}" desc="{{description}}"]<br/> {{child_shortcode}} [/staff]',
    'popup_title' => __('Insert Staff Shortcode', 'mthemelocal'),
 	'params' => array(
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Staff title', 'mthemelocal'),
			'desc' => __('Staff title', 'mthemelocal')
		),
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Staff name', 'mthemelocal'),
			'desc' => __('Staff name', 'mthemelocal')
		),
		'image' => array(
			'std' => '',
			'type' => 'uploader',
			'label' => __('Staff image', 'mthemelocal'),
			'desc' => __('Staff image', 'mthemelocal')
		),
		'description' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Staff Description', 'mthemelocal'),
			'desc' => __('Staff Description', 'mthemelocal')
		)
	),
    'child_shortcode' => array(
        'params' => array(
            'social_icon' => array(
                'std' => 'fa fa-facebook',
	            'type' => 'fontawesome-iconpicker',
	            'label' => __('Choose an icon', 'mthemelocal'),
	            'desc' => __('Pick an icon', 'mthemelocal'),
	            'options' => $fontawesome_icons
            ),
            'social_text' => array(
                'std' => 'Facebook',
                'type' => 'text',
                'label' => __('Social Text', 'mthemelocal'),
                'desc' => __('Social Text', 'mthemelocal'),
            ),
            'social_link' => array(
                'std' => 'http://www.facebook.com/',
                'type' => 'text',
                'label' => __('Link', 'mthemelocal'),
                'desc' => __('Social Link', 'mthemelocal'),
            )
        ),
		'shortcode' => '[socials social_icon="{{social_icon}}" social_link="{{social_link}}" social_text="{{social_text}}"]<br/>',
        'clone_button' => __('+ Add Another Social Link', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Thumbnails
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['thumbnails'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Generate a Thumbnail grid using image attachments', 'mthemelocal'),
	'params' => array(
		'pageid' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Page ID', 'mthemelocal'),
			'desc' => __('Default(blank) Add page ID if you require images from another page.', 'mthemelocal')
		),
		'columns' => array(
			'type' => 'select',
			'label' => __('Grid Columns', 'mthemelocal'),
			'desc' => __('No. of Grid Columns', 'mthemelocal'),
			'options' => array(
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1'
			)
		),
		'start' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Start from image count', 'mthemelocal'),
			'desc' => __('Start from the defined image count', 'mthemelocal')
		),
		'end' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('End to image count', 'mthemelocal'),
			'desc' => __('End to the defined image count', 'mthemelocal')
		),
		'title' => array(
			'type' => 'select',
			'label' => __('Dispay image title', 'mthemelocal'),
			'desc' => __('Display image title', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'description' => array(
			'type' => 'select',
			'label' => __('Display image description', 'mthemelocal'),
			'desc' => __('Display image description', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'exclude_featured' => array(
			'type' => 'select',
			'label' => __('Exclude featured image', 'mthemelocal'),
			'desc' => __('Exclude featured image in posts or portfolio', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
	),
	'shortcode' => '[thumbnails columns="{{columns}}" pageid="{{pageid}}" start="{{start}}" end="{{end}}" title="{{title}}" exclude_featured="{{exclude_featured}}" description="{{description}}"]',
	'popup_title' => __('Insert Thumbnails Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['button'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add button.', 'mthemelocal'),
	'params' => array(
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'mthemelocal'),
			'desc' => __('Add the button\'s url eg http://example.com', 'mthemelocal')
		),
		'button_color' => array(
			'std' => '#000000',
			'type' => 'color',
			'label' => __('Button Style', 'mthemelocal'),
			'desc' => __('Select the button\'s style, ie the button\'s colour', 'mthemelocal')
		),
		'button_icon' => array(
			'std' => 'fa fa-arrow-right',
            'type' => 'fontawesome-iconpicker',
            'label' => __('Icon', 'mthemelocal'),
            'desc' => __('Select an icon', 'mthemelocal'),
            'options' => $fontawesome_icons
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Button Target', 'mthemelocal'),
			'desc' => __('_self = open in same window. _blank = open in new window', 'mthemelocal'),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
		'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __('Button\'s Text', 'mthemelocal'),
			'desc' => __('Add the button\'s text', 'mthemelocal'),
		)
	),
	'shortcode' => '[button link="{{link}}" button_color="{{button_color}}" button_icon="{{button_icon}}" target="{{target}}"] {{content}} [/button]',
	'popup_title' => __('Insert Button Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Alert Shortcode
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['alert'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Generate alert messages using presets icons or custom icon.', 'mthemelocal'),
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('Alert Type', 'mthemelocal'),
			'desc' => __('Select alert type', 'mthemelocal'),
			'options' => array(
				'yellow' => 'Yellow',
				'red' => 'Red',
				'blue' => 'Blue',
				'green' => 'Green'
			)
		),
		'content' => array(
			'std' => 'Alert Message',
			'type' => 'textarea',
			'label' => __('Alert Text', 'mthemelocal'),
			'desc' => __('Add the alert\'s text', 'mthemelocal'),
		),
        'icon' => array(
            'std' => '',
            'type' => 'fontawesome-iconpicker',
            'label' => __('Choose an icon', 'mthemelocal'),
            'desc' => __('Pick an icon', 'mthemelocal'),
            'options' => $fontawesome_icons
        )
		
	),
	'shortcode' => '[alert type="{{style}}" icon="{{icon}}"] {{content}} [/alert]',
	'popup_title' => __('Insert Alert Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Checklist Shortcode
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['checklist'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Add Checklist shortcode.', 'mthemelocal'),
    'shortcode' => '[checklist icon="{{icon}}" color="{{iconcolor}}"]<ul>{{child_shortcode}}</ul>[/checklist]',
    'popup_title' => __('Insert Checklist Shortcode', 'mthemelocal'),
 	'params' => array(
        'icon' => array(
            'std' => 'fa fa-ok',
            'type' => 'fontawesome-iconpicker',
            'label' => __('Choose an icon', 'mthemelocal'),
            'desc' => __('Pick an icon', 'mthemelocal'),
            'options' => $fontawesome_icons
        ),
		'iconcolor' => array(
			'std' => '#EC3939',
			'type' => 'color',
			'label' => __('Icon color', 'mthemelocal'),
			'desc' => __('Icon color in hex', 'mthemelocal'),
		),
	),
    'child_shortcode' => array(
        'params' => array(
            'content' => array(
                'std' => 'Aenean eu leo quam. Pellentesque ornare sem lacinia.',
                'type' => 'text',
                'label' => __('List a line', 'mthemelocal'),
                'desc' => __('You can add as many as you like.', 'mthemelocal')
            )
        ),
        'shortcode' => '<li>{{content}}</li>',
        'clone_button' => __('+ Add Another Checklist Line', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Toggle Config
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['toggle'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add toggle shortcode.', 'mthemelocal'),
	'params' => array(
		'title' => array(
			'type' => 'text',
			'label' => __('Toggle Content Title', 'mthemelocal'),
			'desc' => __('Add the title that will go above the toggle content', 'mthemelocal'),
			'std' => 'Title'
		),
		'content' => array(
			'std' => 'Content',
			'type' => 'textarea',
			'label' => __('Toggle Content', 'mthemelocal'),
			'desc' => __('Add the toggle content. Will accept HTML', 'mthemelocal'),
		),
		'state' => array(
			'type' => 'select',
			'label' => __('Toggle State', 'mthemelocal'),
			'desc' => __('Select the state of the toggle on page load', 'mthemelocal'),
			'options' => array(
				'open' => 'Open',
				'closed' => 'Closed'
			)
		),
		
	),
	'shortcode' => '[toggle title="{{title}}" state="{{state}}"] {{content}} [/toggle]',
	'popup_title' => __('Insert Toggle Content Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Accordions Shortcode
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['accordions'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Add accordions shortcode. You can add multiple accordion tab sections within this generator.', 'mthemelocal'),
    'shortcode' => '[accordions active="{{active}}"]<br/> {{child_shortcode}}  [/accordions]',
    'popup_title' => __('Insert Accordions Shortcode', 'mthemelocal'),
 	'params' => array(
        'active' => array(
            'std' => '-1',
            'type' => 'text',
            'label' => __('Accordion Tab to activate', 'mthemelocal'),
            'desc' => __('Set -1 to close all. 0 is the first, 1 for second and so on...', 'mthemelocal'),
        ),
	),
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Title', 'mthemelocal'),
                'desc' => __('Title', 'mthemelocal'),
            ),
            'content' => array(
                'std' => 'Accordion Content',
                'type' => 'textarea',
                'label' => __('Content', 'mthemelocal'),
                'desc' => __('Accordion Tab content', 'mthemelocal')
            )
        ),
        'shortcode' => '[accordion title="{{title}}"] {{content}} [/accordion]<br/>',
        'clone_button' => __('+ Add Another Accordion Tab', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcode
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['tabs'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Add tabs shortcode. You can add multiple tab sections within this generator.', 'mthemelocal'),
    'shortcode' => '[tabs type="{{type}}"]<br/> {{child_shortcode}}  [/tabs]',
    'popup_title' => __('Insert Tab Shortcode', 'mthemelocal'),
 	'params' => array(
		'type' => array(
			'type' => 'select',
			'label' => __('Tab function type', 'mthemelocal'),
			'desc' => __('Tab function type', 'mthemelocal'),
			'options' => array(
				'horizontal' => 'horizontal',
				'vertical' => 'vertical'
			)
		)
		
	),
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Tab Title', 'mthemelocal'),
                'desc' => __('Title of the tab', 'mthemelocal'),
            ),
            'content' => array(
                'std' => 'Tab Content',
                'type' => 'textarea',
                'label' => __('Tab Content', 'mthemelocal'),
                'desc' => __('Tab content', 'mthemelocal')
            )
        ),
        'shortcode' => '[tab title="{{title}}"] {{content}} [/tab]<br/>',
        'clone_button' => __('+ Add Another Tab', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Blog List boxes
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['recent_blog_listbox'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('A Grid based list of most recent blog posts.', 'mthemelocal'),
	'params' => array(
		'cat_slug' => array(
			'type' => 'select',
			'label' => __('Choose Category to list', 'mthemelocal'),
			'desc' => __('Choose Category to list', 'mthemelocal'),
			'options' => $options_categories
		),
		'post_type' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Comma seperated post types or a single post type.', 'mthemelocal'),
			'desc' => __('audio,gallery,aside,quote,video,image,standard', 'mthemelocal'),
		),
		'title' => array(
			'type' => 'select',
			'label' => __('Display post title', 'mthemelocal'),
			'desc' => __('Display post title', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'description' => array(
			'type' => 'select',
			'label' => __('Display Post description', 'mthemelocal'),
			'desc' => __('Display Post description', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'excerpt_length' => array(
			'std' => '15',
			'type' => 'text',
			'label' => __('Excerpt length', 'mthemelocal'),
			'desc' => __('Excerpt length', 'mthemelocal'),
		),
		'readmore_text' => array(
			'std' => 'Continue reading',
			'type' => 'text',
			'label' => __('Read more text', 'mthemelocal'),
			'desc' => __('Read more text', 'mthemelocal'),
		),
		'comments' => array(
			'type' => 'select',
			'label' => __('Display number of Comments', 'mthemelocal'),
			'desc' => __('Display number of Comments', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'date' => array(
			'type' => 'select',
			'label' => __('Display age of post', 'mthemelocal'),
			'desc' => __('Display age of post', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'limit' => array(
			'std' => '-1',
			'type' => 'text',
			'label' => __('Limit. -1 for unlimited', 'mthemelocal'),
			'desc' => __('Limit items. -1 for unlimited', 'mthemelocal'),
		)
	),
	'shortcode' => '[recent_blog_listbox cat_slug="{{cat_slug}}" readmore_text="{{readmore_text}}" excerpt_length="{{excerpt_length}}" date="{{date}}" comments="{{comments}}" title="{{title}}" description="{{description}}" post_type="{{post_type}}" limit="{{limit}}"]',
	'popup_title' => __('Insert Recent Blog List box Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Blog Posts
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['recentblog'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('A Grid based list of most recent blog posts.', 'mthemelocal'),
	'params' => array(
		'cat_slug' => array(
			'type' => 'select',
			'label' => __('Choose Category to list', 'mthemelocal'),
			'desc' => __('Choose Category to list', 'mthemelocal'),
			'options' => $options_categories
		),
		'columns' => array(
			'type' => 'select',
			'label' => __('Grid Columns', 'mthemelocal'),
			'desc' => __('No. of Grid Columns', 'mthemelocal'),
			'options' => array(
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1'
			)
		),
		'post_type' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Comma seperated post types or a single post type.', 'mthemelocal'),
			'desc' => __('audio,gallery,aside,quote,video,image,standard', 'mthemelocal'),
		),
		'title' => array(
			'type' => 'select',
			'label' => __('Display post title', 'mthemelocal'),
			'desc' => __('Display post title', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'description' => array(
			'type' => 'select',
			'label' => __('Display Post description', 'mthemelocal'),
			'desc' => __('Display Post description', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'excerpt_length' => array(
			'std' => '15',
			'type' => 'text',
			'label' => __('Excerpt length', 'mthemelocal'),
			'desc' => __('Excerpt length', 'mthemelocal'),
		),
		'readmore_text' => array(
			'std' => 'Continue reading',
			'type' => 'text',
			'label' => __('Read more text', 'mthemelocal'),
			'desc' => __('Read more text', 'mthemelocal'),
		),
		'comments' => array(
			'type' => 'select',
			'label' => __('Display number of Comments', 'mthemelocal'),
			'desc' => __('Display number of Comments', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'date' => array(
			'type' => 'select',
			'label' => __('Display age of post', 'mthemelocal'),
			'desc' => __('Display age of post', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'limit' => array(
			'std' => '-1',
			'type' => 'text',
			'label' => __('Limit. -1 for unlimited', 'mthemelocal'),
			'desc' => __('Limit items. -1 for unlimited', 'mthemelocal'),
		),
		'pagination' => array(
			'type' => 'select',
			'label' => __('Generate Pagination', 'mthemelocal'),
			'desc' => __('Generate Pagination', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		)
	),
	'shortcode' => '[recentblog columns="{{columns}}" cat_slug="{{cat_slug}}" readmore_text="{{readmore_text}}" excerpt_length="{{excerpt_length}}" date="{{date}}" comments="{{comments}}" title="{{title}}" description="{{description}}" post_type="{{post_type}}" pagination="{{pagination}}" limit="{{limit}}"]',
	'popup_title' => __('Insert Recent Blog Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Recent Works Carousel
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['workscarousel'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Generate a slideshow thumbnails carousel using your work type categories.', 'mthemelocal'),
	'params' => array(
		'work_categories' => array(
			'type' => 'multilist',
			'std' => '',
			'label' => __('Enter Work type slugs to list', 'mthemelocal'),
			'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
			'options' => $portfolio_categories
		),
		'boxtitle' => array(
			'type' => 'select',
			'label' => __('Box Title', 'mthemelocal'),
			'desc' => __('Display title inside box on hover', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'limit' => array(
			'std' => '-1',
			'type' => 'text',
			'label' => __('Limit. -1 for unlimited', 'mthemelocal'),
			'desc' => __('Limit items. -1 for unlimited', 'mthemelocal'),
		)
	),
	'shortcode' => '[workscarousel worktype_slug="{{work_categories}}" limit="{{limit}}" boxtitle="{{boxtitle}}"]',
	'popup_title' => __('Insert Works Carousel Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Lightbox
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['lightboxcarousel'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Generate a lightbox carousel', 'mthemelocal'),
	'params' => array(
		'work_categories' => array(
			'type' => 'multilist',
			'std' => '',
			'label' => __('Enter Work type slugs to list', 'mthemelocal'),
			'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
			'options' => $portfolio_categories
		),
		'boxtitle' => array(
			'type' => 'select',
			'label' => __('Box Title', 'mthemelocal'),
			'desc' => __('Display title inside box on hover', 'mthemelocal'),
			'options' => array(
				'true' => 'Yes',
				'false' => 'No'
			)
		),
		'limit' => array(
			'std' => '-1',
			'type' => 'text',
			'label' => __('Limit. -1 for unlimited', 'mthemelocal'),
			'desc' => __('Limit items. -1 for unlimited', 'mthemelocal'),
		)
	),
	'shortcode' => '[lightboxcarousel worktype_slug="{{work_categories}}" limit="{{limit}}" boxtitle="{{boxtitle}}"]',
	'popup_title' => __('Insert Works Carousel Shortcode', 'mthemelocal')
);


/*-----------------------------------------------------------------------------------*/
/*	Testimonials
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['testimonials'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Generates testimonials slideshow using multiple testimonial items. You can add as many testimonial items as you prefer and multiple testimonial blocks on the same page.', 'mthemelocal'),
    'shortcode' => '[testimonials] {{child_shortcode}} <br/>[/testimonials]',
    'popup_title' => __('Insert Testimonial Shortcode', 'mthemelocal'),
    
    'child_shortcode' => array(
        'params' => array(
            'name' => array(
                'std' => 'John Doe',
                'type' => 'text',
                'label' => __('Client Name', 'mthemelocal'),
                'desc' => __('Client Name', 'mthemelocal'),
            ),
            'company' => array(
                'std' => 'Company Name',
                'type' => 'text',
                'label' => __('Company', 'mthemelocal'),
                'desc' => __('Company', 'mthemelocal'),
            ),
            'position' => array(
                'std' => 'Client Position',
                'type' => 'text',
                'label' => __('Client Position', 'mthemelocal'),
                'desc' => __('Client Position', 'mthemelocal'),
            ),
            'link' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Company link', 'mthemelocal'),
                'desc' => __('Client link', 'mthemelocal'),
            ),
            'image' => array(
                'std' => '',
                'type' => 'uploader',
                'label' => __('Image', 'mthemelocal'),
                'desc' => __('Image', 'mthemelocal'),
            ),
            'quote' => array(
                'std' => 'Nullam id dolor id nibh ultricies vehicula ut id elit. Nulla vitae elit libero a pharetra augue. Nulla vitae elit libero, a pharetra augue.',
                'type' => 'textarea',
                'label' => __('Quote', 'mthemelocal'),
                'desc' => __('Quote', 'mthemelocal'),
            ),
        ),
        'shortcode' => '<br/>[testimonial image="{{image}}" link="{{link}}" position={{position}} name="{{name}}" company="{{company}}" quote="{{quote}}"]',
        'clone_button' => __('+ Add Testimonial', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Progress Bar
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['progressbar'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Generates a percentage based progress bar.', 'mthemelocal'),
	'params' => array(
		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __('Progress Bar title', 'mthemelocal'),
			'desc' => __('Progress bar title', 'mthemelocal'),
		),
		'iconcolor' => array(
			'std' => '#EC3939',
			'type' => 'color',
			'label' => __('Progress color', 'mthemelocal'),
			'desc' => __('Progress color in hex', 'mthemelocal'),
		),
		'percentage' => array(
			'std' => '55',
			'type' => 'text',
			'label' => __('Percent Value', 'mthemelocal'),
			'desc' => __('Percent Value', 'mthemelocal'),
		),
		'unit' => array(
			'std' => '%',
			'type' => 'text',
			'label' => __('Display unit', 'mthemelocal'),
			'desc' => __('Display unit', 'mthemelocal'),
		)
		
	),
	'shortcode' => '[progressbar unit="{{unit}}" color="{{iconcolor}}" percentage="{{percentage}}" title="{{title}}"]',
	'popup_title' => __('Insert Progressbar Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Fullpage Center
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['fullpageblock'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Creates a fullpage cell where you can display an edge to edge row with any shortcode or contents within it. This shortcode is design for Fullpage Template. Ideal to build homepages and landing pages.', 'mthemelocal'),
	'params' => array(
        'top' => array(
            'std' => '80',
            'type' => 'text',
            'label' => __('Top Space', 'mthemelocal'),
            'desc' => __('Top Spacing', 'mthemelocal'),
        ),
        'bottom' => array(
            'std' => '80',
            'type' => 'text',
            'label' => __('Bottom Space', 'mthemelocal'),
            'desc' => __('Bottom Spacing', 'mthemelocal'),
        ),
		'textcolor' => array(
			'type' => 'select',
			'label' => __('Text Color Style', 'mthemelocal'),
			'desc' => __('Text Color Style', 'mthemelocal'),
			'options' => array(
				'default' => 'default',
				'bright' => 'bright'
			)
		),
		'border_style' => array(
			'type' => 'select',
			'label' => __('Border Style', 'mthemelocal'),
			'desc' => __('Border Style. Double style required more than 3px in width.', 'mthemelocal'),
			'options' => array(
				'solid' => 'solid',
				'dotted' => 'dotted',
				'double' => 'double',
			)
		),
        'border_width' => array(
            'std' => '1',
            'type' => 'text',
            'label' => __('Border width', 'mthemelocal'),
            'desc' => __('Border width in pixels', 'mthemelocal'),
        ),
		'border_color' => array(
			'std' => '',
			'type' => 'color',
			'label' => __('Border color', 'mthemelocal'),
			'desc' => __('Border color', 'mthemelocal'),
		),
        'background_image' => array(
            'std' => '',
            'type' => 'uploader',
            'label' => __('Background image', 'mthemelocal'),
            'desc' => __('Background image', 'mthemelocal'),
        ),
		'scroll' => array(
			'type' => 'select',
			'label' => __('Background Scroll Type', 'mthemelocal'),
			'desc' => __('Background Scroll Type', 'mthemelocal'),
			'options' => array(
				'static' => 'static',
				'parallax' => 'parallax'
			)
		),
		'background_color' => array(
			'std' => '',
			'type' => 'color',
			'label' => __('Background color', 'mthemelocal'),
			'desc' => __('Background color', 'mthemelocal'),
		),
		'content' => array(
			'std' => 'Contents',
			'type' => 'textarea',
			'label' => __('Contents', 'mthemelocal'),
			'desc' => __('Contents', 'mthemelocal'),
		)
		
	),
	'shortcode' => '[fullpageblock top="{{top}}" bottom="{{bottom}}" textcolor="{{textcolor}}" border_color="{{border_color}}" border_style="{{border_style}}" border_width="{{border_width}}" background_image="{{background_image}}" background_color="{{background_color}}" scroll="{{scroll}}"] {{content}} [/fullpageblock]',
	'popup_title' => __('Insert Fullpage Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Information Boxes
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['infoboxes'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Add Information columns. You can add multiple information items from this generator as well as sort them before adding to contents editor.', 'mthemelocal'),
    'shortcode' => '[infobox column="{{column}}"] {{child_shortcode}} <br/>[/infobox]',
    'popup_title' => __('Generate Info boxes Shortcode', 'mthemelocal'),
 	'params' => array(
		'column' => array(
			'type' => 'select',
			'label' => __('Info Box Columns', 'mthemelocal'),
			'desc' => __('Select number of columns for info boxes. Add matching number of Service Items to the Service Box', 'mthemelocal'),
			'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6'
			)
		)
		
	),
    'child_shortcode' => array(
        'params' => array(
			'lastitem' => array(
				'type' => 'select',
				'std' => 'no',
				'label' => __('Last Item', 'mthemelocal'),
				'desc' => __('Is it the last item', 'mthemelocal'),
				'options' => array(
					'no' => 'no',
					'yes' => 'yes'
				)
			),
            'image' => array(
                'std' => '',
                'type' => 'uploader',
                'label' => __('Image URL', 'mthemelocal'),
                'desc' => __('Image URL', 'mthemelocal'),
            ),
            'title' => array(
                'std' => 'Title of the info box',
                'type' => 'text',
                'label' => __('Service Title', 'mthemelocal'),
                'desc' => __('Title of the info box', 'mthemelocal'),
            ),
            'link' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Link', 'mthemelocal'),
                'desc' => __('Link to title', 'mthemelocal'),
            ),
            'content' => array(
                'std' => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.',
                'type' => 'textarea',
                'label' => __('Service Content', 'mthemelocal'),
                'desc' => __('Add the service content', 'mthemelocal')
            )
        ),
        'shortcode' => '<br/> [infobox_item image="{{image}}" title="{{title}}" link="{{link}}" last_item="{{lastitem}}"] {{content}} [/infobox_item]',
        'clone_button' => __('+ Add another Information Box', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Service Boxes
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['serviceboxes'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Add Service columns. You can add multiple service items from this generator as well as sort them before adding to contents editor.', 'mthemelocal'),
    'shortcode' => '[servicebox column="{{column}}" iconplace="{{iconplace}}" boxplace="{{boxplace}}" iconcolor="{{iconcolor}}"] {{child_shortcode}} <br/>[/servicebox]',
    'popup_title' => __('Generate Services Shortcode', 'mthemelocal'),
 	'params' => array(
		'column' => array(
			'type' => 'select',
			'label' => __('Service Box Columns', 'mthemelocal'),
			'desc' => __('Select number of columns for service boxes. Add matching number of Service Items to the Service Box', 'mthemelocal'),
			'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6'
			)
		),
		'iconplace' => array(
			'type' => 'select',
			'label' => __('Icon Placement', 'mthemelocal'),
			'desc' => __('Placement of icon', 'mthemelocal'),
			'options' => array(
				'top' => 'top',
				'left' => 'left'
			)
		),
		'boxplace' => array(
			'type' => 'select',
			'label' => __('Box Placement', 'mthemelocal'),
			'desc' => __('Placement of service boxes', 'mthemelocal'),
			'options' => array(
				'horizontal' => 'horizontal',
				'vertical' => 'vertical'
			)
		),
		'iconcolor' => array(
			'std' => '',
			'type' => 'color',
			'label' => __('Icon color', 'mthemelocal'),
			'desc' => __('Color of icon in hex', 'mthemelocal'),
		)
		
	),
    'child_shortcode' => array(
        'params' => array(
			'lastitem' => array(
				'type' => 'select',
				'std' => 'no',
				'label' => __('Last Item', 'mthemelocal'),
				'desc' => __('Is it the last item', 'mthemelocal'),
				'options' => array(
					'no' => 'no',
					'yes' => 'yes'
				)
			),
            'icon' => array(
                'std' => 'fa fa-anchor',
	            'type' => 'fontawesome-iconpicker',
	            'label' => __('Choose an icon', 'mthemelocal'),
	            'desc' => __('Pick a icon', 'mthemelocal'),
	            'options' => $fontawesome_icons
            ),
            'title' => array(
                'std' => 'Fusce Magna Elit',
                'type' => 'text',
                'label' => __('Service Title', 'mthemelocal'),
                'desc' => __('Title of the service', 'mthemelocal'),
            ),
            'link' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Link', 'mthemelocal'),
                'desc' => __('Link to title', 'mthemelocal'),
            ),
            'content' => array(
                'std' => 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.',
                'type' => 'textarea',
                'label' => __('Service Content', 'mthemelocal'),
                'desc' => __('Add the service content', 'mthemelocal')
            )
        ),
        'shortcode' => '<br/> [servicebox_item icon="{{icon}}" title="{{title}}" link="{{link}}" last_item="{{lastitem}}"] {{content}} [/servicebox_item]',
        'clone_button' => __('+ Add another Service Column', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Columns Config
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['columns'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add Columns Shortcode and Combinations', 'mthemelocal'),
	'params' => array(
		'columns' => array(
			'type' => 'select',
			'label' => __('Column Type', 'mthemelocal'),
			'desc' => __('Select the type, ie width of the column.', 'mthemelocal'),
			'options' => array(
				'[column span=12]text[/column]'=> 'One Column',
				'[column span=6]text[/column][column span=6 last=yes]text[/column]'=> 'Two Column',
				'[column span=4]text[/column][column span=4]text[/column][column span=4 last=yes]text[/column]'=> 'Three Column',
				'[column span=3]text[/column][column span=3]text[/column][column span=3]text[/column][column span=3 last=yes]text[/column]'=> 'Four Column',
				'[column span=2]text[/column][column span=2]text[/column][column span=2]text[/column][column span=2]text[/column][column span=2]text[/column][column span=2 last=yes]text[/column]'=> 'Six Column',
			)
		)
		
	),
	'shortcode' => '{{columns}}',
	'popup_title' => __('Insert Columns', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	FontAwesome Generator
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['fontawesome'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add Icons', 'mthemelocal'),
	'params' => array(

		'icon' => array(
			'std' => 'fa fa-anchor',
			'type' => 'fontawesome-iconpicker',
			'label' => __('Select Icon', 'mthemelocal'),
			'desc' => __('Click an icon to select, click again to deselect', 'mthemelocal'),
			'options' => $fontawesome_icons
		),
		'size' => array(
			'std' => '14',
			'type' => 'text',
			'label' => __('Size of Icon', 'mthemelocal'),
			'desc' => __('Size in pixels. Numerical valye', 'mthemelocal'),
		),
		'iconcolor' => array(
			'std' => '',
			'type' => 'color',
			'label' => __('Icon Color', 'mthemelocal'),
			'desc' => __('Leave blank for default', 'mthemelocal')
		)
	),
	'shortcode' => '[icongenerator icon="{{icon}}" size="{{size}}" iconcolor="{{iconcolor}}"]',
	'popup_title' => __( 'Icon generator Shortcode', 'mthemelocal' )
);

/*-----------------------------------------------------------------------------------*/
/*	Anchor
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['anchor'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add an anchor to the page. Anchors can be used with href links as jump sections.', 'mthemelocal'),
	'params' => array(
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Assign a unique ID to anchor', 'mthemelocal'),
			'desc' => __('Assign a unique ID to anchor', 'mthemelocal'),
		)
		
	),
	'shortcode' => '[anchor id="{{id}}"]',
	'popup_title' => __('Insert Anchor Shortcode', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	FontAwesome Generator
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['count'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add From-To Count Shortcode blocks', 'mthemelocal'),
	'params' => array(
        'title' => array(
            'std' => 'Fusce Magna Elit',
            'type' => 'text',
            'label' => __('Title', 'mthemelocal'),
            'desc' => __('Title', 'mthemelocal'),
        ),
        'description' => array(
            'std' => 'Count description text',
            'type' => 'text',
            'label' => __('Description', 'mthemelocal'),
            'desc' => __('Description', 'mthemelocal'),
        ),
        'to' => array(
            'std' => '9',
            'type' => 'text',
            'label' => __('Count to', 'mthemelocal'),
            'desc' => __('Count to', 'mthemelocal'),
        ),
		'icon' => array(
			'std' => 'et-icon-alarmclockr',
			'type' => 'fontawesome-iconpicker',
			'label' => __('Select Icon', 'mthemelocal'),
			'desc' => __('Click an icon to select, click again to deselect', 'mthemelocal'),
			'options' => $fontawesome_icons
		),
		'iconcolor' => array(
			'std' => '',
			'type' => 'color',
			'label' => __('Icon Color', 'mthemelocal'),
			'desc' => __('Leave blank for default', 'mthemelocal')
		)
	),
	'shortcode' => '[count title="{{title}}" icon="{{icon}}" iconcolor="{{iconcolor}}" to="{{to}}"]{{description}}[/count]',
	'popup_title' => __( 'From-To Count Shortcode', 'mthemelocal' )
);

/*-----------------------------------------------------------------------------------*/
/*	WooCommerce Best Selling
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['woobestselling'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('WooCommerce best selling products', 'mthemelocal'),
	'params' => array(
        'limit' => array(
            'std' => '8',
            'type' => 'text',
            'label' => __('Limit', 'mthemelocal'),
            'desc' => __('Limit the number of products', 'mthemelocal'),
        )
	),
	'shortcode' => '[woocommerce_carousel_bestselling limit="{{limit}}"]',
	'popup_title' => __( 'WooCommerce Best Selling', 'mthemelocal' )
);

/*-----------------------------------------------------------------------------------*/
/*	Work type albums
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['worktype_albums'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add a slideshow of portfolio items', 'mthemelocal'),
	'params' => array(
		'worktype_slugs' => array(
			'type' => 'multilist',
			'std' => '',
			'label' => __('Enter Work type slugs to list', 'mthemelocal'),
			'desc' => __('Leave blank to list all. Enter comma seperated work type categories. eg. artwork,photography,prints ', 'mthemelocal'),
			'options' => $portfolio_categories
		),
		'columns' => array(
			'type' => 'select',
			'label' => __('Grid Columns', 'mthemelocal'),
			'desc' => __('No. of Grid Columns', 'mthemelocal'),
			'options' => array(
				'4' => '4',
				'3' => '3',
				'2' => '2',
				'1' => '1'
			)
		),
    'worktype_icon' => array(
        'std' => 'fa fa-th',
        'type' => 'fontawesome-iconpicker',
        'label' => __('Icon', 'mthemelocal'),
        'desc' => __('Select a hover icon', 'mthemelocal'),
        'options' => $fontawesome_icons
    ),
    'item_count' => array(
      'type' => 'select',
      'label' => __('Display item count', 'mthemelocal'),
      'desc' => __('Display item count', 'mthemelocal'),
      'options' => array(
        'true' => 'true',
        'false' => 'false'
      )
    ),
		'title' => array(
			'type' => 'select',
			'label' => __('Display title', 'mthemelocal'),
			'desc' => __('Display title', 'mthemelocal'),
			'options' => array(
				'true' => 'true',
				'false' => 'false'
			)
		),
		'description' => array(
			'type' => 'select',
			'label' => __('Display description', 'mthemelocal'),
			'desc' => __('Display description', 'mthemelocal'),
			'options' => array(
				'true' => 'true',
				'false' => 'false'
			)
		)
	),
	'shortcode' => '[worktype_albums worktype_slugs="{{worktype_slugs}}" columns="{{columns}}" worktype_icon="{{worktype_icon}}" title="{{title}}" description="{{description}}" item_count="{{item_count}}"]',
	'popup_title' => __('Display work type albums', 'mthemelocal')
);

/*-----------------------------------------------------------------------------------*/
/*	Hero Image
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['heroimage'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode_desc' => __('Display Hero image', 'mthemelocal'),
    'shortcode' => '[heroimage image="{{image}}" text="{{text}}" link="{{link}}" icon="{{icon}}" offsetclass="{{offsetclass}}"] {{child_shortcode}} <br/>[/heroimage]',
    'popup_title' => __('Generate a Hero image', 'mthemelocal'),
	'params' => array(
        'image' => array(
            'std' => '',
            'type' => 'uploader',
            'label' => __('Add image', 'mthemelocal'),
            'desc' => __('Upload an image', 'mthemelocal'),
        ),
		'text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Hero image assist text', 'mthemelocal'),
			'desc' => __('Text to display. Displays as a title on bottom of hero image', 'mthemelocal')
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Link', 'mthemelocal'),
			'desc' => __('Link for hero image navigation', 'mthemelocal')
		),
		'icon' => array(
			'type' => 'select',
			'std' => 'true',
			'label' => __('Display icon', 'mthemelocal'),
			'desc' => __('Display icon', 'mthemelocal'),
			'options' => array(
				'true' => 'true',
				'false' => 'false'
			)
		)
	),
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Title', 'mthemelocal'),
                'desc' => __('Title', 'mthemelocal'),
            ),
            'subtitle' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Subtitle', 'mthemelocal'),
                'desc' => __('Subtitle', 'mthemelocal'),
            )
        ),
        'shortcode' => '<br/> [heroimage_text title="{{title}}" subtitle="{{subtitle}}"]',
        'clone_button' => __('+ Add another hero title', 'mthemelocal')
    )
);

/*-----------------------------------------------------------------------------------*/
/*	Photocard
/*-----------------------------------------------------------------------------------*/

$mtheme_shortcodes['photocard'] = array(
	'no_preview' => true,
	'shortcode_desc' => __('Add a Photocard', 'mthemelocal'),
	'params' => array(
		'image_block' => array(
			'type' => 'select',
			'label' => __('Image block align', 'mthemelocal'),
			'desc' => __('Image block align', 'mthemelocal'),
			'options' => array(
				'left' => 'left',
				'right' => 'right'
			)
		),
        'image' => array(
            'std' => '',
            'type' => 'uploader',
            'label' => __('Add image', 'mthemelocal'),
            'desc' => __('Upload image', 'mthemelocal'),
        ),
		'video_mp4' => array(
		    'std' => '',
		    'type' => 'text',
		    'label' => __('For HTML5 Video MP4', 'mthemelocal'),
		    'desc' => __('MP4 url.', 'mthemelocal'),
		),
		'video_webm' => array(
		    'std' => '',
		    'type' => 'text',
		    'label' => __('For HTML5 Video WEBM', 'mthemelocal'),
		    'desc' => __('WEBM url', 'mthemelocal'),
		),
		'video_ogv' => array(
		    'std' => '',
		    'type' => 'text',
		    'label' => __('For HTML5 Video OGV', 'mthemelocal'),
		    'desc' => __('OGV url', 'mthemelocal'),
		),
		'text_align' => array(
			'type' => 'select',
			'label' => __('Text align', 'mthemelocal'),
			'desc' => __('Text align', 'mthemelocal'),
			'options' => array(
				'center' => 'center',
				'left' => 'left',
				'right' => 'right'
			)
		),
        'title' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Title Text', 'mthemelocal'),
            'desc' => __('Title Text', 'mthemelocal'),
        ),
        'subtitle' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Subtitle text', 'mthemelocal'),
            'desc' => __('Subtitle text', 'mthemelocal'),
        ),
        'button' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Button Text', 'mthemelocal'),
            'desc' => __('Button Text', 'mthemelocal'),
        ),
        'button_link' => array(
            'std' => '',
            'type' => 'text',
            'label' => __('Button link', 'mthemelocal'),
            'desc' => __('Button link', 'mthemelocal'),
        ),
        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => __('Text for contents', 'mthemelocal'),
            'desc' => __('Text for contents', 'mthemelocal'),
        ),
	),
	'shortcode' => '[photocard image_block="{{image_block}}" video_mp4="{{video_mp4}}" video_ogv="{{video_ogv}}" video_webm="{{video_webm}}" text_align="{{text_align}}" button="{{button}}" button_link="{{button_link}}" image="{{image}}" title="{{title}}" subtitle="{{subtitle}}"]{{content}}[/photocard]',
	'popup_title' => __('Add a Photocard', 'mthemelocal')
);
?>