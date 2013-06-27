Guzzle Restful Api Client
=========

For TBL Cms based on Yii Framework

Setup:
------
Load in main config:
'guzzleRestful'=>array(
 	'class'=>'application.extensions.guzzleRestful.GuzzleRestful',
),

//insert into database
CREATE TABLE `rest_client` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_updated` timestamp NULL DEFAULT NULL,
  `last_checked` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
)

Usage Example:
--------------
$uri = 'http://www.api-url-here.com/api';
$result = Yii::app()->guzzleRestful->getData('api-name', $uri, true);
$xmlData = $result->xml();