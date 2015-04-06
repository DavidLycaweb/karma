<?php
$elguid = elgg_get_page_owner_guid();
$eluno = elgg_view('input/hidden',array('name' => 'elguid', 'value' =>$elguid)); 
$elotro = elgg_view('input/submit', array('value' => elgg_echo('good:karma')));
$rollo = "<div>$eluno</div><div>$elotro</div>"; 
echo $rollo;


