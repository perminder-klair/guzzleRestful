<?php

require(__DIR__ . '/vendor/autoload.php');
Yii::import('application.extensions.guzzleRestful.models.TokenRecord');
use Guzzle\Http\Client;

class GuzzleRestful extends CApplicationComponent {

     public function getData($name, $uri, $lastChecked=false)     
     {        
     	$tokenRecord = TokenRecord::model()->findByAttributes(array('name'=>$name));

     	if($tokenRecord) {
     			     	
	     	//$uri = $tokenRecord->uri;
			$encodedToken = base64_encode($tokenRecord->token);

			$client = new Client($uri);
			
			try {
			
			    $request = $client->get();
				$requestHeaders = $request->setHeader('Authorization', 'Basic '.$encodedToken);
				$response = $requestHeaders->send();
			    
			} catch (Guzzle\Http\Exception\BadResponseException $e) {
			
			    try {
			    
			    	$request = $client->get();
					$requestHeaders = $request->setAuth($tokenRecord->username, $tokenRecord->password);
					$response = $requestHeaders->send();
					
					//Add token to db
					$tokenRecord->token = $response->getHeader('token');
					$tokenRecord->token_updated=date('Y-m-d H:i:s', time());
					if(!$tokenRecord->save())
						throw new CHttpException(404, 'Cannot update API token.');
					
			    } catch (Guzzle\Http\Exception\BadResponseException $e) {
			    	throw new CHttpException(404, $e->getMessage());
			    }
			    
			}
		
			//upload last checked time
			if($lastChecked) {
				$tokenRecord->last_checked=date('Y-m-d H:i:s', time());
				$tokenRecord->save();
			}
			
			//dump($request); die();
			return $response;
		
		} else
			throw new CHttpException(404, 'Invalid API credentials provided.');
		
     }
     
     public function getLastChecked($name)
     {
	     $tokenRecord = TokenRecord::model()->findByAttributes(array('name'=>$name));
	     
	     return $tokenRecord->last_checked;
     } 

}