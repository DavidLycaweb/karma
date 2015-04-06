<?php
function karma_init() {	
elgg_extend_view('profile/owner_block','karma/counter', 23); 
elgg_extend_view("css/elgg", "css/karma");
}
elgg_register_event_handler('init','system','karma_init'); 
elgg_register_action("karma/save", elgg_get_plugins_path() . "karma/actions/karma/save.php");
elgg_register_action("karma/negativesave", elgg_get_plugins_path() . "karma/actions/karma/negativesave.php");


