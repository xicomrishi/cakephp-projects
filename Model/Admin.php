<?php
class Admin extends AppModel 
{	
	public $actsAs = array('Containable');
	
	
	function get_user_tab_data($tablet_url = null)
	{
		$this->bindModel(array(
				'hasMany'=>array(
					'AdminClientDeal'=>array(
						'className'=>'AdminClientDeal',
						'foreignKey'=>'user_id',
						'conditions'=>array(
							'AdminClientDeal.status'=>'active', 
							'OR'=>array(
								array('AdminClientDeal.start_date'=>NULL, 'AdminClientDeal.end_date'=>NULL),
								array('AdminClientDeal.start_date !='=>NULL, 'AdminClientDeal.end_date'=>NULL, 'AdminClientDeal.start_date <='=>date('Y-m-d')),
								array('AdminClientDeal.start_date'=>NULL, 'AdminClientDeal.end_date !='=>NULL, 'AdminClientDeal.end_date >='=>date('Y-m-d')),
								array('AdminClientDeal.start_date !='=>NULL, 'AdminClientDeal.end_date !='=>NULL, 'AdminClientDeal.start_date <='=>date('Y-m-d'), 'AdminClientDeal.end_date >='=>date('Y-m-d'))
							)
						),
						'fields'=>array('id', 'deal_icon', 'title', 'disclaimer', 'description', 'type', 'price', 'product')
					)
				),
				'hasOne'=>array(
					'DefaultDeal'=>array(
						'className'=>'AdminClientDeal',
						'foreignKey'=>'user_id',
						'conditions'=>array('DefaultDeal.status'=>'active', 'DefaultDeal.start_date <='=>date('Y-m-d') , 'DefaultDeal.end_date >='=>date('Y-m-d')),
						'fields'=>array('id', 'deal_icon', 'disclaimer', 'title', 'description', 'price', 'type')
					)
				)
			)
		);
		
		$this->AdminClientDeal->bindModel(array(
				'belongsTo'=>array(
					'AdminIcon'=>array(
						'className'=>'AdminIcon',
						'foreignKey'=>'deal_icon',
					)
				)
			)
		);
		
		return $this->find('first', array(
								'conditions'=>array(
									'tablet_url '=>trim(str_replace('-',' ',$tablet_url))
								),
								
								'contain'=>array(
									'AdminClientDeal'=>array(
										'AdminIcon'=>array(
											'fields'=>array('image')
										)
									),
									'DefaultDeal'
								)								
							)
						);
	}
	
	function get_user_web_data($website_url=null)
	{
		$this->bindModel(array(
				'hasMany'=>array(
					'AdminClientSlider'=>array(
						'className'=>'AdminClientSlider',
						'foreignKey'=>'user_id',
						'fields'=>array('text', 'image')
					)
				),
				'hasOne'=>array(
					'AdminClientDeal'=>array(
						'className'=>'AdminClientDeal',
						'foreignKey'=>'user_id',
						'fields'=>array('title', 'description', 'disclaimer', 'price', 'image','created'),
						'order' => 'AdminClientDeal.created DESC'
					)
				)
			)
		);
		
		return $this->find('first', array(
								'conditions'=>array(
									'Admin.website_url'=>trim($website_url),
									'Admin.website_url !='=>''
								)
							)
						);
	}
    
}
