<?php
require_once realpath(dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'bootstrap.php');

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use app\models\Settings;


$pubkey = Settings::value('APIs..amazonpubkey');
$privkey = Settings::value('APIs..amazonprivkey');
$asstag = Settings::value('APIs..amazonassociatetag');

$conf = new GenericConfiguration();
$client = new \GuzzleHttp\Client();
$request = new \ApaiIO\Request\GuzzleRequest($client);

$conf
	->setCountry('com')
	->setAccessKey($pubkey)
	->setSecretKey($privkey)
	->setAssociateTag($asstag)
	->setRequest($request)
	->setResponseTransformer(new \ApaiIO\ResponseTransformer\XmlToSimpleXmlObject());

$search = new Search();
$search->setCategory('VideoGames');
$search->setKeywords('Deus Ex Mankind Divided');
$search->setResponseGroup(['Large']);
$search->setPage(1);

$apaiIo = new ApaiIO($conf);

$response = $apaiIo->runOperation($search);

var_dump($response);
