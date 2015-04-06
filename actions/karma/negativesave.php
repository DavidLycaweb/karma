<?php
//Karmapointer guid
$user = elgg_get_logged_in_user_guid();
//Owner guid
$elguid = get_input('elguid');

// Create a new karmapoint object
$karmapoint = new ElggObject();

// Create a new karmapoint subtype
$karmapoint->subtype = "negativekarmapoint";


//Checking for positivekarmapoints

$checkingpositive = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'karmapoint',
    'owner_guid' => $elguid,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $user)),
    'count' => true
));

$positives = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'karmapoint',
    'owner_guid' => $elguid,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $user)),
    'count' => false
));



if ($checkingpositive != 0) {
foreach ($positives as $positive) {
elgg_set_ignore_access	( true	);
    $deletepositive =  $positive->delete();
elgg_set_ignore_access	( false	);
}

if ($deletepositive) {
    $mensa = elgg_echo('retired:good:karma');
   system_message("$mensa");
   forward(REFERER);
   }
else {
$mensa = elgg_echo('not:retired:good:karma');
register_error("$mensa");
forward(REFERER); // REFERER is a global variable that defines the previous page
}

}


//Checking for negativekarmapoints with the name of the karmapointer
$checking = elgg_get_entities_from_metadata(array(
    'types' => 'object',
    'subtypes' => 'negativekarmapoint',
    'owner_guid' => $elguid,
	'metadata_name_value_pair' => array(array('name' => 'name', 'value' => $user)),
    'count' => true
));
if ($checking != 0) {
$mensa = elgg_echo('bad:karma:already');
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
   $mensa = elgg_echo('bad:karma:success');
   system_message("$mensa");
   forward(REFERER);
} else {
   $mensa = elgg_echo('error:send:bad:karma');
   register_error("$mensa");
   forward(REFERER); // REFERER is a global variable that defines the previous page
}