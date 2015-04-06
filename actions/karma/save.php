<?php
//Karmapointer guid
$user = elgg_get_logged_in_user_guid();
//Owner guid
$elguid = get_input('elguid');

// Create a new karmapoint object
$karmapoint = new ElggObject();

// Create a new karmapoint subtype
$karmapoint->subtype = "karmapoint";


//Checking for negativekarmapoints

$checkingnegative = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'negativekarmapoint',
    'owner_guid' => $elguid,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $user)),
    'count' => true
));

$negatives = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'negativekarmapoint',
    'owner_guid' => $elguid,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $user)),
    'count' => false
));


if ($checkingnegative != 0) {
foreach ($negatives as $negative) {
elgg_set_ignore_access	( true	);
    $deletenegative =  $negative->delete();
elgg_set_ignore_access	( false	);
}

if ($deletenegative) {
   $mensa = elgg_echo('remove:bad:previus');
   system_message("$mensa");
   forward(REFERER);
   }
else {
$mensa = elgg_echo('remove:bad:previus:error');
register_error("$mensa");
forward(REFERER); // REFERER is a global variable that defines the previous page
}

}


//Checking for karmapoints with the name of the karmapointer
$checking = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'karmapoint',
    'owner_guid' => $elguid,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $user)),
    'count' => true
));
if ($checking != 0) {
$mensa = elgg_echo('already:good:send');
register_error("$mensa");
forward(REFERER); // REFERER is a global variable that defines the previous page
}



// Ignoring default access
elgg_set_ignore_access	( true	);
		
// Making all karmapoints public
$karmapoint->access_id = ACCESS_PUBLIC;

// Setting owner of karmapoint
$karmapoint->owner_guid = $elguid;


// Setting name of karmapointer
$karmapoint->name = $user;


// save to database and get id of the new karmapoint
$karmapoint_guid = $karmapoint->save();

//Restoring default access
elgg_set_ignore_access	( false	);

// Otherwise, we want to register an error and forward back to the form
if ($karmapoint_guid) {
   $mensa = elgg_echo('good:karma:success');
   system_message("$mensa");
   forward(REFERER);
} else {
   $mensa = elgg_echo('good:karma:error');
   register_error("$mensa");
   forward(REFERER); // REFERER is a global variable that defines the previous page
}