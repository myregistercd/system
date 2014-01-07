<?php 



class Site extends Controller {

	function Site(){

		parent::Controller();

		

	}

	

	function index()

	{

		$data = $this->getCommonData(); 
		$data['title'] = "Buy Diamond Ring|Earrings|Pendant|Three Stone Ring|Online Jewellary Store|Jewellary Ring Online";
			$data['meta_tags'] = '<meta http-equiv="Content-Type" content="text/html; iso-8859-1">
	<meta name="title" content="Buy Diamond Ring|Earrings|Pendant|Three Stone Ring|Online Jewellary Store|Jewellary Ring Online">
	<meta name="ROBOTS" content="INDEX,FOLLOW">
	<meta name="description" content="Online Jewellary Store offers to Buy Discounted Rate Engagement Diamond Ring, Earings, Three Stone Ring, Diamond Pendant, Loose Diamonds, Premium Diamond. Build your own Ring, Earrings, Three Stone Ring, Diamond Pendant Online. Purchase Engagement Ring at Discounted Price at Intercarts.">
	<meta name="abstract" content="Diamond Rings, Wholesale Diamonds, Estate Jewelry, Custom Engagement Rings, New York, Chicago, California, Boston, Las Vegas, Columbia, Montgomery">
	<meta name="keywords" content="Online Jewellary Store, Engagement Diamond Ring, Earings, Three Stone Ring, Diamond Pendant, Loose Diamonds, Premium Diamond. Build your own Ring, Diamond Pendant Online, Purchase Engagement Ring">
	<meta name="author" content="7techniques">
	<meta name="publisher" content="7techniques">
	<meta name="copyright" content="7techniques">
	<meta http-equiv="Reply-to" content="">
	<meta name="creation_Date" content="12/12/2008">
	<meta name="expires" content="">
	<meta name="revisit-after" content="7 days">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';

	    $output = $this->load->view('diamond/index' , $data , true);

		$this->output($output , $data);		

	}

	

	private function getCommonData($banner='')

	{

	    

	 	$data = array();

		$data = $this->commonmodel->getPageCommonData();

		return $data;

	 

	}

	

	function output($layout = null , $data = array() , $isleft = true , $isright = true)

	{

		$data['loginlink'] = $this->user->loginhtml();

		$output = $this->load->view($this->config->item('template').'header' , $data , true);

	   	if($isleft)$output .= $this->load->view($this->config->item('template').'left' , $data , true);

		$output .= $layout;

		//if($isright)$output .= $this->load->view($this->config->item('template').'right' , $data , true);

		$output .= $this->load->view($this->config->item('template').'footer', $data , true);

		$this->output->set_output($output);

	}

	

	

	function page($topic = 'aboutus')

	{		 

  		$data = $this->getCommonData($topic); 

  		$data['title'] =  ucfirst($topic);	    

		$data['content']  	= $this->commonmodel->getcompanyinfo($topic);		
		
		if($topic == 'aboutus') {
			$data['title'] = "3 Stone Diamond Ring|Antique Diamond Ring|Set Engagement Ring|Pave Diamond Rings";
			$data['meta_tags'] = '<meta http-equiv="Content-Type" content="text/html; iso-8859-1">
	<meta name="title" content="3 Stone Diamond Ring|Antique Diamond Ring|Set Engagement Ring|Pave Diamond Rings">
	<meta name="ROBOTS" content="INDEX,FOLLOW">
	<meta name="description" content="Buy online emerald cut diamond rings, three stone diamond rings, 3 stone diamond ring, antique diamond ring, set engagement ring, tension engagement rings, affordable engagement ring, 3 stone diamond ring, antique diamond ring, set engagement ring, pave diamond rings">
	<meta name="keywords" content="emerald cut diamond rings, three stone diamond rings, 3 stone diamond ring, antique diamond ring, set engagement ring, tension engagement rings, affordable engagement ring, 3 stone diamond ring, antique diamond ring, set engagement ring, pave diamond rings">
	<meta name="author" content="7techniques">
	<meta name="publisher" content="7techniques">
	<meta name="copyright" content="7techniques">
	<meta http-equiv="Reply-to" content="">
	<meta name="creation_Date" content="12/12/2008">
	<meta name="expires" content="">
	<meta name="revisit-after" content="7 days">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
		}
		
		$output = $this->load->view($this->config->item('template').'printcontent' , $data , true); 		

		$this->output($output , $data);		

	}

	

	function setsession($sessionvar = 'temp', $sessionvalue = ''){
		$sessionvalue = str_ireplace('_' , '.' , $sessionvalue);
		$this->session->set_userdata($sessionvar,$sessionvalue);
	}

	

	function ringdetails($stockno = '', $ringoption='',$lot = ''){

		$data = $this->getCommonData();

		$lot 		= ($lot == 'undefined') ? 0 : $lot ;

	    $this->load->model('diamondmodel');

		$this->load->model('engagementmodel');

		$this->load->model('jewelrymodel');

		$data['products'] = $this->diamondmodel->getDetailsByLot($lot);

		$data['details'] = $this->jewelrymodel->getAllByStock($stockno);				

		$data['stockno'] = $stockno;

		$data['ringoption'] = $ringoption;

		$data['lot'] = $lot;

		

		$data['flashfiles']	= $this->engagementmodel->getFlashByStockId($stockno);			

						

		if($data['details']){


			$output = $this->load->view('erd/ringdetails' , $data , true);

			echo $output;

		}	

	 

   }



   function productdetails($stockno = '', $ringoption='',$lot = ''){
	
	$data = $this->getCommonData();

		$lot 		= ($lot == 'undefined') ? 0 : $lot ;

	    $this->load->model('diamondmodel');

		$this->load->model('engagementmodel');

		$this->load->model('jewelrymodel');

		$data['products'] = $this->diamondmodel->getDetailsByLotproduct($stockno);

		$data['details'] = $this->jewelrymodel->getAllByStock($stockno);				

		$data['stockno'] = $stockno;

		$data['ringoption'] = $ringoption;

		$data['lot'] = $lot;

		$data['type'] = 'product';

		$data['flashfiles']	= $this->engagementmodel->getFlashByStockId($stockno);			

//						print_r();

		if($data['products']){

			$output = $this->load->view('erd/ringdetails' , $data , false);


			echo $output;

		}	

	 

   }

   
   

   function threestoneringdetails($stockno = '', $centerid = '',$sidestone1 = '',$sidestoen2 = ''){

   		$data = $this->getCommonData();

		$this->load->model('engagementmodel');

		$this->load->model('jewelrymodel');

			

		$data['details'] = $this->jewelrymodel->getAllByStock($stockno);

		$data['stockno'] = $stockno;

		//$data['ringoption'] = $ringoption;

		$data['centreid'] = $centerid;

		$data['sidestoneid1'] = $sidestone1;

		$data['sidestoneid2'] = $sidestoen2;

		

		$data['flashfiles']	= $this->engagementmodel->getFlashByStockId($stockno);	
				

		$data['centerStoneDetails']  = $this->jewelrymodel->getDetailsByLot($centerid);

		$data['sideStone1Details']  = $this->jewelrymodel->getDetailsByLot($sidestone1);
		
		$data['sideStone2Details']  = $this->jewelrymodel->getDetailsByLot($sidestoen2);
		

		if($data['details']){

			$output = $this->load->view('erd/threestoneringdetails' , $data , true);

			echo $output;

		}	

   }

   

   function errormsg() {

   	$msg = ($this->commonmodel->errordb());

   	echo $msg[0]->msg;

   	

   }
   function qualitydetail($id){
   
   	$data = $this->getCommonData();
   	$this->load->model('jewelleriesmodel');
   	$data['details'] = $this->jewelleriesmodel->getqualitydetail($id);
	
	if(isset($data['details']['data'][0]['Item_Type'])){
		$data['itemtype'] = $data['details']['data'][0]['Item_Type'];
	}else{
		$data['itemtype'] = '';
	}

	$data['radomprodects'] = $this->jewelleriesmodel->getrandomproduct($id);//for random product display on right

   	//$data['userdetail'] = $this->jewelleriesmodel->getUserdetailByID($data['details']['data'][0]['seller_id']);
   	//$output = $this->load->view('jewelleries/qualitydetail' , $data , false);//old


		//ezvalues
		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue'];
		
 /* 	echo '<pre>';
	print_r($data);
	exit;  */  
  
	$this->load->view($this->config->item('template').'header' , $data);
	$this->load->view('jewelleries/qualitydetailview' , $data);
	$this->load->view($this->config->item('template').'footer', $data);

   	//$this->output($out , $data);
   }
   function uniquedetail($id){
   	 
   	$data = $this->getCommonData();
   	$this->load->model('jewelleriesmodel');
   	$data['details'] = $this->jewelleriesmodel->getuniquedetail($id);
   	//$data['userdetail'] = $this->jewelleriesmodel->getUserdetailByID($data['details']['data'][0]['seller_id']);
   	//$output = $this->load->view('jewelleries/uniquedetail' , $data , false);
	$output = $this->load->view('jewelleries/uniquedetail' , $data , false);
   	echo $output;
   }
   
   function stullerdetail($id){
   	 
   	$data = $this->getCommonData();
   	$this->load->model('jewelleriesmodel');
   	$data['details'] = $this->jewelleriesmodel->getstullerdetail($id);
	if(isset($data['details']['data'][0]['Item_Type'])){
		$data['itemtype'] = $data['details']['data'][0]['MerchandisingCategory2'];
	}else{
		$data['itemtype'] = '';
	}
	$data['radomprodects'] = $this->jewelleriesmodel->getrandomproductstuller($id);//for random product display on right
   	//$data['userdetail'] = $this->jewelleriesmodel->getUserdetailByID($data['details']['data'][0]['seller_id']);
   	//$output = $this->load->view('jewelleries/stullerdetail' , $data , false);//old

/* 	echo '<pre>';
	print_r($data);
	exit; */ 
		//ezvalues
		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue'];
	
	
	$this->load->view($this->config->item('template').'header' , $data);
	$this->load->view('jewelleries/stullerdetailnew' , $data);
	$this->load->view($this->config->item('template').'footer', $data);

   	echo $output;
   }
      function jewellerydetails($id){

		$data = $this->getCommonData();
		$this->load->model('jewelleriesmodel');
		$data['details'] = $this->jewelleriesmodel->getJewellerydetailByID($id);
		$data['userdetail'] = $this->jewelleriesmodel->getUserdetailByID($data['details']['data'][0]['seller_id']);	
		$output = $this->load->view('jewelleries/jewellerydetail' , $data , false);
		echo $output;
	}
	
   function enagagementqualitydetail($id,$cuprice){
   
   	$data = $this->getCommonData();
   	$this->load->model('jewelleriesmodel');
   	$data['details'] = $this->jewelleriesmodel->getuniquedetail2($id);
   	$data['uniqueprice'] = $this->jewelleriesmodel->getUniquePrice($data['details']['data'][0]['style_group']);
   	//echo $data['details']['data'][0]['style_group'];
	$data['radomprodects'] = $this->jewelleriesmodel->getrandomproduct($id);//for random product display on right
	$data['cuprice'] = $cuprice;

   	//$data['userdetail'] = $this->jewelleriesmodel->getUserdetailByID($data['details']['data'][0]['seller_id']);
   	//$output = $this->load->view('jewelleries/qualitydetail' , $data , false);//old

		//ezvalues
		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue']; 
		//$data['ez3value'] = $data['ez5value'] = 12;

	$this->load->view($this->config->item('template').'header' , $data);
	$this->load->view('jewelleries/uniquedetailview' , $data);
	$this->load->view($this->config->item('template').'footer', $data);

   	//$this->output($out , $data);
   }
	
   function uniqeDetailMetalAjax(){
   		$this->load->model('jewelleriesmodel');
		$ringsizes = $this->jewelleriesmodel->uniqeDetailMetalAjax($_POST['metal'],$_POST['product']);
		//var_dump($ringsizes);
		$value = '';
		foreach($ringsizes as $ringsize) {
			$value .= "<option value='".$ringsize['ringSize']."'>".$ringsize['ringSize']."</option>";
		}
		echo $value;
   }
	
   function uniqeDetailPriceAjax(){
   		$this->load->model('jewelleriesmodel');
   		$ez = $_POST['ez'];
		$price = $this->jewelleriesmodel->getUniquePriceAjax($_POST['metal'],$_POST['ring'],$_POST['product']);

		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$ez3value = $ezvalues[0]['ezvalue'];
		$ez5value = $ezvalues[1]['ezvalue'];
		
		if($ez){
			/*
			$ez3 = $price['price']+(($ez3value*$price['price'])/100);
			$ez5 = $price['price']+(($ez5value*$price['price'])/100);
			$ez3s=$ez3/3;
			$ez3s1 = number_format($ez3s,0);
			$ez5s=$ez5/5;
			$ez5s1 = number_format($ez5s,0);
			
			$priceout = "<input type='radio' name='price' value='{$price['price']},normal'>$ {$price['price']} </br>
						<input type='radio' name='price' value='$ez3,3EZ'>3EZ = $ $ez3s1 </br>
						<input type='radio' name='price' value='$ez5,5EZ'>5EZ = $ $ez5s1 </br>";
			*/
			$org_price= $price['price'];
			$cuprice = $org_price*2.5;
			$cuprice1=$cuprice;
			$cuprice15=$cuprice*15/100;
			$cuprice=$cuprice-$cuprice15;
										
			$ez3 = $org_price+(($org_price*$ez3value)/100); $fez3=$ez3; $ez3=$cuprice1-$ez3; 
			$ez3s=$ez3/2;
			
			$ez5=$org_price+(($ez5value*$org_price)/100); $fez5=$ez5; $ez5=$cuprice1-$ez5;
			$ez5s=$ez5/4;
						
			$priceout = "Item Price : ". number_format($cuprice1,0)."<br>
						<input type='radio' name='price' value='".intval(number_format($cuprice,0,'.','')).",normal'>
									BEST VALUE - $".number_format($cuprice,0)." Price after 15% discount when paid by Visa/MC. 
									<br/><input type='radio' name='price' value='". intval(number_format($ez3,0,'.','')).",3EZ'>
						3 EZ Pay - $".number_format($cuprice1,0)." Price $".number_format($fez3,0)." payment then 2 EZ payments of ".number_format($ez3s,0)." monthly
						<br/> 
						<input type='radio' name='price' value='". intval(number_format($fez5,0,'.','')).",5EZ'>
						5 EZ Pay - $".number_format($cuprice1,0)." Price $".number_format($fez5,0)." payment then 4 EZ payments of $".number_format($ez5s,0)."monthly.
						<input type='hidden' name='3ez_price' value='". intval(number_format($ez3,0,'.',''))."'>
						<input type='hidden' name='5ez_price' value='". intval(number_format($ez5,0,'.',''))."'>
						<input type='hidden' name='main_price' value='". intval(number_format($cuprice1,0,'.',''))."'>";
		}
		else {
			//$priceout = "<input type='radio' name='price' value='{$price['price']},normal'>$ {$price['price']}</br>";
			
			$priceout = "Item Price : ".number_format($cuprice1,0)."<br>
						<input type='radio' name='price' value='".number_format($cuprice,0).",normal'>
									BEST VALUE - $".number_format($cuprice,0)." Price after 15% discount when paid by Visa/MC. 
									<br/><input type='radio' name='price' value='".$fez3.",3EZ>";
		}
		
		echo $priceout;
   }
}
?>
