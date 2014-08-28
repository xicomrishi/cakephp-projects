<?php
class AdminClientDeal extends AppModel 
{
	
	public $actsAs = array('Containable');
/**
 * if either password or confirm password do not exist, then omit this rule
 * @param type $check
 * @param type $object
 * @return boolean 
 */
    public function findDealById($deal_id=null)
    {
		return $this->find('first', array(
									'conditions'=>array(
										'AdminClientDeal.id'=>$deal_id,										
										'AdminClientDeal.status'=>UserDeinedStatus::Active
									),
									'order'=>array('AdminClientDeal.id desc')
								)
							);
    }
    
    //Get the nearest user by distance of i miles
    public function matchUser()
    {
		$userobj = ClassRegistry::init('Admin');
		App::import('Model', 'CakeSession');
		$Session = new CakeSession();
		//$result = getLnt($Session->read('Client.zip_code'));	
		
		$latitude = $Session->read('Client.latitude');
		$longitude = $Session->read('Client.longitude'); 
		$radius = RADIUS;
		
		if(!empty($latitude) && !empty($longitude))
		{
			
			
			
			$match_id = $userobj->find('all', array('conditions' => array('Admin.id !='=>$Session->read('Client.id')),
						'fields'=>array('id','('.$radius.' * acos(cos(radians('.$latitude.')) 
						* cos(radians(latitude)) * cos(radians(longitude) - radians('.$longitude.')) + sin(radians('.$latitude.')) * sin(radians(latitude)))) AS distance')
						,'group' => 'Admin.id HAVING distance <= '.DISTANCE.'','order'=>'distance'));		
			
			if(!empty($match_id))
			{
				foreach($match_id as $user)
				{
					$ids[] = $user['Admin']['id'];
				}
			}
			else
			{
				$ids ='';
			}
		}
		else
		{
			$ids ='';
		}
		return $ids;
    }
    
    
    
    public function clientAllDeal($options = array())
    {
		App::import('Model', 'CakeSession');
		$Session = new CakeSession();
		
		$match_user = $this->matchUser();
		
		$this->bindModel(array(
				'belongsTo'=>array(
					'AdminIcon'=>array(
						'className'=>'AdminIcon',
						'foreignKey'=>'deal_icon',
					),
					'Admin'=>array(
						'className'=>'Admin',
						'foreignKey'=>'user_id',
						'type'=>'INNER'
					)
				)
			)
		);
		
		return $this->find('all', array(
								'conditions'=>array(
									'AdminClientDeal.user_id'=> $match_user,
									'AdminClientDeal.status'=> UserDeinedStatus::Active,
									'OR'=>array(
										array('AdminClientDeal.start_date'=>NULL, 'AdminClientDeal.end_date'=>NULL),									
										array('AdminClientDeal.start_date !='=>NULL, 'AdminClientDeal.end_date'=>NULL, 'AdminClientDeal.start_date <='=>date('Y-m-d')),
										array('AdminClientDeal.start_date'=>NULL, 'AdminClientDeal.end_date !='=>NULL, 'AdminClientDeal.end_date >='=>date('Y-m-d')),
										array('AdminClientDeal.start_date !='=>NULL, 'AdminClientDeal.end_date !='=>NULL, 'AdminClientDeal.start_date <='=>date('Y-m-d'), 'AdminClientDeal.end_date >='=>date('Y-m-d'))
									)									
								),
								'order'=>array('AdminClientDeal.id desc'),
								'limit'=>10,								
								'contain'=>array(
									'AdminIcon'=>array('image'),
									'Admin'
								)
							)
						);
		
    }
    
    public function get_share_deal($id = NULL)
    {
		$this->bindModel(array(
						'belongsTo'=>array(
							'Admin'=>array(
								'className'=>'Admin',
								'foreignKey'=>'user_id',
							)
						)
					)
				);
				
		return $this->find('first', array(
						'conditions'=>array(
							'AdminClientDeal.id'=>$id
						),
						'contain'=>array(
							'Admin'=>array(
								'fields'=>array(
									'id', 'first_name', 'last_name', 'website_url', 'company', 'mobile', 'twitter_url', 'fb_fanpage_id'
								)
							)
						)
					)
				);
    }
}
