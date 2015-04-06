<?php 
$karmapoints = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'karmapoint',
	'owner_guid' => elgg_get_page_owner_guid(),
	'count' => true
));

$negativekarmapoints = elgg_get_entities(array(
	'types' => 'object',
	'subtypes' => 'negativekarmapoint',
	'owner_guid' => elgg_get_page_owner_guid(),
	'count' => true
));

$thecount = ($karmapoints - $negativekarmapoints);

if ($thecount < 0){
echo "<style> div.karmacounter { background:#ce061e!important; } </style>";
}

$cont = "$thecount";
	 
echo <<<HTML
	 
	 <script>
$( document ).ready(function() {   
	$('.elgg-avatar-large').append('<div class="karmacounter">$cont<span class="lett">Karma</span></div>');		
});
</script>

HTML;


