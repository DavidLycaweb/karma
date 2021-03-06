<?php
/**
 * Profile owner block
 */

$user = elgg_get_page_owner_entity();

if (!$user) {
	// no user so we quit view
	echo elgg_echo('viewfailure', array(__FILE__));
	return TRUE;
}

$icon = elgg_view_entity_icon($user, 'large', array(
	'use_hover' => false,
	'use_link' => false,
	'img_class' => 'photo u-photo',
));

// grab the actions and admin menu items from user hover
$menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu();
$actions = elgg_extract('action', $menu, array());
$admin = elgg_extract('admin', $menu, array());

$profile_actions = '';
if (elgg_is_logged_in() && $actions) {
	$profile_actions = '<ul class="elgg-menu profile-action-menu mvm">';
	foreach ($actions as $action) {
		$item = elgg_view_menu_item($action, array('class' => 'elgg-button elgg-button-action'));
		$profile_actions .= "<li class=\"{$action->getItemClass()}\">$item</li>";
	}
	$profile_actions .= '</ul>';
}

// if admin, display admin links
$admin_links = '';
if (elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid()) {
	$text = elgg_echo('admin:options');

	$admin_links = '<ul class="profile-admin-menu-wrapper">';
	$admin_links .= "<li><a rel=\"toggle\" href=\"#profile-menu-admin\">$text&hellip;</a>";
	$admin_links .= '<ul class="profile-admin-menu" id="profile-menu-admin">';
	foreach ($admin as $menu_item) {
		$admin_links .= elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
	}
	$admin_links .= '</ul>';
	$admin_links .= '</li>';
	$admin_links .= '</ul>';
}

//KARMA

if (elgg_is_logged_in()) {
$eluser = elgg_get_logged_in_user_guid();
//Karma Buttons
$karmabutton = elgg_view_form("karma/save");
$negativebutton = elgg_view_form("karma/negativesave");

//Karma Check
$checkingnegatives = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'negativekarmapoint',
    'owner_guid' => elgg_get_page_owner_guid(),
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $eluser)),
    'count' => true
));

$checkingpositives = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'karmapoint',
    'owner_guid' => elgg_get_page_owner_guid(),
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $eluser)),
    'count' => true
));

if ($checkingnegatives != 0) { ?>
<script>
$( document ).ready(function() {   
	$('.elgg-avatar-large a').prepend('<div class="youhatethishuman"></div>');		
});
</script>
<?php }

elseif ($checkingpositives != 0) { ?>
<script>
$( document ).ready(function() {   
	$('.elgg-avatar-large a').prepend('<div class="youlovethishuman"></div>');		
});
</script>


<?php }

else {


}



}

else {
$karmabutton = "";
$negativebutton = "";
}

// content links
$content_menu = elgg_view_menu('owner_block', array(
	'entity' => elgg_get_page_owner_entity(),
	'class' => 'profile-content-menu',
));

echo <<<HTML

<div id="profile-owner-block">
	$icon
	<div class="karmaspace">
	$karmabutton
	$negativebutton
	</div>
	
	$profile_actions
	$content_menu
	$admin_links
</div>

HTML;
