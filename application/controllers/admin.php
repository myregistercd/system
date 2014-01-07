<?php

class Admin extends Controller {

	function __construct() {
		parent::Controller();
		$this->load->model('adminmodel');
		$this->load->model('user');
		$this->load->model('sitepaging');
		$this->load->model('commonmodel');
		$this->load->model('helixmodel');
		$this->load->model('cronmodel');
	}
	
	function test(){
			echo "working !!";
	}

	function index() {

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {


			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml();
			$data['newtestimonials'] = $this->adminmodel->newfeedbacks();
			$output = $this->load->view('admin/index', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);

		$this->output($output, $data);
	}

	function isadminlogin() {
		if (($this->session->isLoggedin()) && ($this->session->userdata('usertype') == 'admin')) {
			return true;
		} else {
			return false;
		}
	}

	function getAdminDetails() {
		if (($this->session->isLoggedin()) && ($this->session->userdata('usertype') == 'admin')) {
			return 'Administrator';
		} else {
			return '-1';
		}
	}
	function ezpay()
	{
		if ($_POST['stuller'] == 'enable' or $_POST['stuller'] == 'disable'){
			$this->adminmodel->ezpaymodelcontrol('stuller', $_POST['stuller']);
			$data2['status'] = 'Success';
		}
		elseif ($_POST['quality'] == 'enable' or $_POST['quality'] == 'disable'){
			$this->adminmodel->ezpaymodelcontrol('quality', $_POST['quality']);
			$data2['status'] = 'Success';
		}
		elseif ($_POST['unique'] == 'enable' or $_POST['unique'] == 'disable'){
			$this->adminmodel->ezpaymodelcontrol('unique', $_POST['unique']);
			$data2['status'] = 'Success';
		}
		elseif ($_POST['ez3'] != '' and $_POST['ez5'] != ''){
			$this->adminmodel->addezvalue($_POST['ez3'],$_POST['ez5']);
			$data2['status'] = 'Success';
		}

		//ezvalues  // commented
		$ezvalues = $this->adminmodel->getezvalue();
		$data2['ez3value'] = $ezvalues[0]['ezvalue'];
		$data2['ez5value'] = $ezvalues[1]['ezvalue'];
		
		//echo "<br>VNR@123<br>";

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();


			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml();
			$data['newtestimonials'] = $this->adminmodel->newfeedbacks();
			$output = $this->load->view('admin/optionsview', $data2, true);

		$this->output($output, $data);

		/*$data = $this->getCommonData();
		$output = $this->load->view('admin/ezpay', $data, true);
		$this->output($output, $data);*/
	}
	function commonpagetemplate($templateid = '') {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			$this->load->model('adminmodel');
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
							  $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#sitemanage").click();
										 
										';

			//$data['leftmenus'] = $this->adminmodel->adminmenuhtml('staticpage');
			$pages = $this->adminmodel->getCommonPages();

			$data['pages'] = $this->commonmodel->makePageoptions($pages, 'topicid', 'description');
			if (isset($_POST['templateid'])) {
				$data['templateid'] = $_POST['templateid'];
				//  $data['pagetitle'] =  $this->commonmodel->getcompanyinfoTitle($data['templateid']);
			} else {
				$data['templateid'] = '';
				$data['pagetitle'] = '';
			}

			if (isset($_POST['submit'])) {
				if (isset($_POST['page_content'])) {
					if ($this->adminmodel->saveCommonPageTemplate($data['templateid'], $_POST['page_content'], $_POST['pagetitle']))
					$data['success'] = 'Page Template saved';
					else
					$data['error'] = 'Page Template not saved';
				}
			}


			$data['use_tinymce'] = 'admin';

			$data['content'] = $this->adminmodel->getCommonPageTemplate($data['templateid']);

			$output = $this->load->view('admin/commonpagetemplates', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);


		$this->output($output, $data);
	}

	function globalvariables($configid = '') {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#sitemanage").click();
										 
										';

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('globalvariable');
			$globalvariable = $this->adminmodel->getglobalvariable();
			$data['globalvariables'] = $this->commonmodel->makeoptions($globalvariable, 'id', 'descriptions');
			$data['globalvariableid'] = ( $_POST) ? $_POST['globalvariableid'] : '';
			if ($_POST) {
				if (isset($_POST['contenthtml'])) {
					if ($this->adminmodel->saveglobalvariableByid($data['globalvariableid'], $_POST['contenthtml']))
					$data['success'] = '<h1 class="success">Global Information saved</h1>';
					else
					$data['error'] = '<h1 class="error">Global Inforation not saved</h1>';
				}
			}


			$data['content'] = $this->adminmodel->getglobalvariableByid($data['globalvariableid']);
			$output = $this->load->view('admin/globalvariable', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);


		$this->output($output, $data);
	}

	private function output($layout = null, $data = array()) {
		$this->load->model('user');
		$this->load->model('adminmodel');
		$user = $this->session->userdata('user');
		$data['user'] = $user;
		$data['loginlink'] = $this->user->loginhtml('admin');

		$output = $this->load->view('admin/header', $data, true);
		if ($this->session->isLoggedin() && ($this->session->userdata('usertype') == 'admin')) {
			$output .= $layout;
		} else {
			$output .= $this->load->view('admin/login', $data, true);
		}
		$output .= $this->load->view('admin/footer', $data, true);
		$this->output->set_output($output);
	}

	private function getCommonData() {
		$data = array();
		$data = $this->commonmodel->getPageCommonData();
		return $data;
	}


	////***************Start: Jeweleri Management By Mamun Date: 1.3.2013*****************///




	function jewelries_manager($action = 'view', $id = 0) {

		//$db2 = $this->load->database('malak', TRUE);
		//$this->db->close();
		$malak_db = $this->load->database('malak', TRUE); // Connect to malak database
		$this->db = $malak_db;
		
		//echo $malak_db->database;

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
			

		///Custom module loading

		$this->load->model('malak_adminmodel');


		$data['extraheader']  = '';
		$data['collections'] ='';
		$data['typeoptions'] = '';
			
		if($this->isadminlogin()){
			if($action == 'delete'){
				$ret = $this->malak_adminmodel->jewelries($_POST , $action , $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
				header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
				header("Cache-Control: no-cache, must-revalidate" );
				header("Pragma: no-cache" );
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: ".$ret['total'].",\n";
				$json .= "}\n";
				echo $json;

			}else{

				if($action == 'add' || $action == 'edit'){
					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('vendor_name', 'vendor_name', 'trim|required');
					$this->form_validation->set_rules('vendor_sku', 'vendor_sku', 'trim|required');
					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');
					if(isset($_POST[$action.'btn'])){
						if ($this->form_validation->run() == FALSE){
							$data['error'] = 'ERROR ! Please check the error fields';
							if($action != 'edit')$data['details'] = $_POST;
						}else {
							$ret = $this->malak_adminmodel->jewelries($_POST , $action , $id);
							if($ret['error'] == '')$data['success'] = $ret['success'];
							else{
								$data['error'] = $ret['error'];
								if($action != 'edit')$data['details']  = $_POST;
							}
						}
					}
	    $data['extraheader'] .= $this->commonmodel->addEditor('simple' );
	    //      $data['collectionoptions'] = $this->commonmodel->makeoptions($this->adminmodel->getcollections() , 'collection' , 'collection');
	    $data['gemstones'] = $this->malak_adminmodel->getGemstonesByStockId($id);
	    if($action == 'edit') {
	    	$this->load->model('jewelrymodel');
	    	$data['details'] = $this->jewelrymodel->getAllByStock($id);
	    	$details = $data['details'];

	    	switch ($details['section']){
	    		case 'Earrings':
	    			$collections = '<option value="DiamondStud">Diamond Stud Earrings</option>
											  <option value="BuildEarring">Build Your Own Earrings</option>
											';
	    			break;
	    		case 'EngagementRings':
	    			$collections = '
												<option value="International Collection">International Collection</option>
											';
	    			break;
	    		case 'Jewelry':
	    			$collections = '
												<option value="MensWeddingRing">Men\'s Wedding Rings</option>  
									            <option value="WomensWeddingRing">Women\'s Wedding Rings</option>  
										 		<option value="WomensAnniversaryRing">Women\'s Anniversary Rings</option> 
											 	';
	    			break;
	    		case 'Pendants':
	    			$collections = '
												<option value="BuildPendant">Build your own Pendants</option>
											';
	    			break;
	    		default:
	    			break;
	    	}
	    	$data['collections'] =$collections;


	    	$data['animations'] = $this->malak_adminmodel->getFlashByStockId($id);
	    	$data['id'] = $id;
	    }

				}
					
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
				 {
				 $(this).css({backgroundImage:"url('.config_item('base_url').'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
				 $(this).siblings().css({backgroundImage:"url('.config_item('base_url').'images/plus.jpg)"});
				 });
				 $("#jewelrymanage").click();
						
				 ';

				$data['leftmenus']	=	$this->malak_adminmodel->adminmenuhtml('jewelries');
				$url = config_item('base_url').'admin/getjewelries_manager';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid({
			  url: '".$url."',
			  dataType: 'json',
			  colModel : [
			  {display: 'ID', name : 'stock_number', width : 80, sortable : true, align: 'center'},
			  {display: 'Website Price', name : 'price_website', width : 85, sortable : true, align: 'center'},
			  {display: 'Amazon Price', name : 'price_amazon', width : 85, sortable : true, align: 'center'},
			  {display: 'eBay Price', name : 'price_ebay', width : 85, sortable : true, align: 'center'},
			  {display: 'title', name : 'item_title', width : 120, sortable : true, align: 'center'},
			  {display: 'Sku', name : 'item_sku', width : 50, sortable : true, align: 'center'},
			  {display: 'Vendor Name', name : 'vendor_name', width : 80, sortable : true, align: 'center'},
			  {display: 'vendor SKU', name : 'vendor_sku', width : 60, sortable : true, align: 'center'},
			  {display: 'Gender', name : 'gender', width : 60, sortable : true, align: 'center'},
			  {display: 'Category', name : ' 	category', width : 90, sortable : true, align: 'center'},
			  {display: 'Sub Category', name : 'subcategory', width : 90, sortable : true, align: 'center'}],
			  buttons : [{name: 'Add', bclass: 'add', onpress : test},
			  {name: 'Delete', bclass: 'delete', onpress : test},
			  {separator: true}








			  ],
			  searchitems : [
			  {display: 'Lot #', name : 'stock_number', isdefault: true},
			  {display: 'Vendor Name', name : 'vendor_name', isdefault: true},
			  {display: 'Vendor Sku', name : 'style', isdefault: false}

			  ],
			  sortname: \"stock_number\",
			  sortorder: \"desc\",
			  usepager: true,
			  title: '<h1 class=\"pageheader\">Manage Jewelries</h1>',
			  useRp: true,
			  rp: 100,
			  showTableToggleBtn: false,
			  width:1025,
			  height: 800
			  }
			  );
			  	
			  function test(com,grid)
			  {
			  if (com=='Delete')
			  {
			  	
			  if($('.trSelected').length>0){
			  if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
			  var items = $('.trSelected');
			  var itemlist ='';
			  for(i=0;i<items.length;i++){
			  itemlist+= items[i].id.substr(3)+\",\";
			  }

			  $.ajax({
			  type: \"POST\",
			  dataType: \"json\",
			  url: \"".config_item('base_url')."admin/jewelries_manager/delete\",
			  data: \"items=\"+itemlist,
			  success: function(data){
			  alert('Total Deleted rows: '+data.total);
			  $(\"#results\").flexReload();
			  }
			  });
			  	


			  }
			  } else{
			  alert('You have to select a row.');
			  }
			  	
			  	
			  }
			  else if (com=='Add')
			  {
			  window.location = '".config_item('base_url')."admin/jewelries_manager/add';
			  }
			  }
			  	
			  ";


				$data['extraheader'] .= '<script src="'.config_item('base_url').'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="'.config_item('base_url').'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
				$data['extraheader'] .= '<script src="'.config_item('base_url').'js/swfobject.js" type="text/javascript"></script>';
				$data['extraheader'] .= '<script src="'.config_item('base_url').'js/t.js" type="text/javascript"></script>';
				$data['onloadextraheader'] .= "var so;";
				$data['usetips'] = true;
				$output = $this->load->view('admin/jewelries_management' , $data , true);
				$this->output($output , $data);
				//echo "Send Output";

			}

		}else { $output =$this->load->view('admin/login', $data , true);$this->output($output , $data);}
		$this->load->database('default'); // Connect to malak database
	}


	function getjewelries_manager($addoption = '') {
		 
		$this->load->model('malak_adminmodel');
		 
		$page 		= isset($_POST['page']) 	? $_POST['page'] : 1;
		$rp 		= isset($_POST['rp']) 		? $_POST['rp'] : 10;
		$sortname 	= isset($_POST['sortname']) ? $_POST['sortname'] : 'stock_number';
		$sortorder 	= isset($_POST['sortorder'])? $_POST['sortorder'] : 'desc';
		$query 		= isset($_POST['query']) 	? $_POST['query'] : '';
		$qtype 		= isset($_POST['qtype']) 	? $_POST['qtype'] : 'title';


		$results = $this->malak_adminmodel->getjewelries($page, $rp, $sortname ,$sortorder  ,$query  , $qtype);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: ".$results['count'].",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';
			//onclick=\"jewelrydetails(".$row['stock_number'].");\"
			if ($rc) $json .= ",";
			$json .= "\n {";
			$json .= "id:'".$row['stock_number']."',";
			$json .= "cell:['Lot #: ".$row['stock_number']."<br /><a href=\'".config_item('base_url')."admin/jewelries/edit/".($row['stock_number'])."\'  class=\"edit\">View Details</a>'";
			if($row['image1'] != '')
			$json .= ",'<img src=\'http://malakjewelers.seowebdirect.com/images/rings/".addslashes($row['image1'])."\' width=\'80\'><br />$ ".addslashes($row['price_website'])."'";
			else
			$json .= ",'<img src=\'".config_item('base_url')."images/rings/noringimage.png\' width=\'80\'><br />$ ".addslashes($row['price_website'])."'";
			$json .= ",'".addslashes($row['price_amazon'])."'";
			$json .= ",'".addslashes($row['price_ebay'])."'";
			$json .= ",'".addslashes($row['item_title'])."'";
			$json .= ",'".addslashes($row['item_sku'])."'";
			$json .= ",'".addslashes($row['vendor_name'])."'";
			$json .= ",'".addslashes($row['vendor_sku'])."'";
			if($row['gender']=="M"){$gend = 'Mens';}
			elseif($row['gender']=="F"){$gend = 'Womens';}
			elseif($row['gender']=="U"){$gend = 'Unisex';}
			elseif($row['gender']=="C"){$gend = 'Children';}
			elseif($row['gender']=="E"){$gend = 'Estate';}
			elseif($row['gender']=="D"){$gend = 'Designers';}
			elseif($row['gender']=="R"){$gend = 'Religious';}
			elseif($row['gender']=="CH"){$gend = 'Charms';}
			elseif($row['gender']=="CL"){$gend = 'Clearance';}
			elseif($row['gender']=="S"){$gend = 'Services';}
			elseif($row['gender']=="CG"){$gend = 'Colored Gemstones';}
			$json .= ",'".addslashes($gend)."'";
			$catval = $this->malak_adminmodel->getCategoryNameByID($row['category']);foreach ($catval as $row_cat) {$newval=$row_cat['category_name'];}
			$json .= ",'".addslashes($newval)."'";
			$subcatval = $this->malak_adminmodel->getCategoryNameByID($row['subcategory']);foreach ($subcatval as $row_subcat){$newval1=$row_subcat['category_name'];}
			$json .= ",'".addslashes($newval1)."'";
			$json .= "]";
			$json .= "}";
			$rc = true;
				
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}



	////***************End: Jeweleri Management By Mamun Date: 1.3.2013*****************///





	function jewelries($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
			
		$data['extraheader']  = '';
		$data['collections'] ='';
		$data['typeoptions'] = '';

		if($this->isadminlogin()){
			if($action == 'delete'){
				$ret = $this->adminmodel->jewelries($_POST , $action , $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
				header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
				header("Cache-Control: no-cache, must-revalidate" );
				header("Pragma: no-cache" );
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: ".$ret['total'].",\n";
				$json .= "}\n";
				echo $json;

			}else{

				if($action == 'add' || $action == 'edit'){
					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('vendor_name', 'vendor_name', 'trim|required');
					$this->form_validation->set_rules('vendor_sku', 'vendor_sku', 'trim|required');
					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');
					if(isset($_POST[$action.'btn'])){
						if ($this->form_validation->run() == FALSE){
							$data['error'] = 'ERROR ! Please check the error fields';
							if($action != 'edit')$data['details'] = $_POST;
						}else {
							$ret = $this->adminmodel->jewelries($_POST , $action , $id);
							if($ret['error'] == '')$data['success'] = $ret['success'];
							else{
								$data['error'] = $ret['error'];
								if($action != 'edit')$data['details']  = $_POST;
							}
						}
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple' );
					//      $data['collectionoptions'] = $this->commonmodel->makeoptions($this->adminmodel->getcollections() , 'collection' , 'collection');
					$data['gemstones'] = $this->adminmodel->getGemstonesByStockId($id);
					if($action == 'edit') {
						$this->load->model('jewelrymodel');
						$data['details'] = $this->jewelrymodel->getAllByStock($id);
						$details = $data['details'];

						switch ($details['section']){
							case 'Earrings':
								$collections = '<option value="DiamondStud">Diamond Stud Earrings</option>
											  <option value="BuildEarring">Build Your Own Earrings</option>
											';
								break;
							case 'EngagementRings':
								$collections = '
												<option value="International Collection">International Collection</option>
											';
								break;
							case 'Jewelry':
								$collections = '
												<option value="MensWeddingRing">Men\'s Wedding Rings</option>  
									            <option value="WomensWeddingRing">Women\'s Wedding Rings</option>  
										 		<option value="WomensAnniversaryRing">Women\'s Anniversary Rings</option> 
											 	';
								break;
							case 'Pendants':
								$collections = '
												<option value="BuildPendant">Build your own Pendants</option>
											';
								break;
							default:
								break;
						}
						$data['collections'] =$collections;


						$data['animations'] = $this->adminmodel->getFlashByStockId($id);
						$data['id'] = $id;
					}

				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url('.config_item('base_url').'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url('.config_item('base_url').'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';
					
				$data['leftmenus']	=	$this->adminmodel->adminmenuhtml('jewelries');
				$url = config_item('base_url').'admin/getjewelries';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '".$url."',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'stock_number', width : 80, sortable : true, align: 'center'},
																		{display: 'Image', name : 'price_amazon', width : 85, sortable : true, align: 'center'},
																		{display: 'title', name : 'item_title', width : 120, sortable : true, align: 'center'},
																		{display: 'White gold price', name : 'item_sku', width : 50, sortable : true, align: 'center'},
																		{display: 'Yellow gold price', name : 'vendor_name', width : 80, sortable : true, align: 'center'},
																		{display: 'Platinum price', name : 'vendor_sku', width : 60, sortable : true, align: 'center'}
																		
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
																				{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}








																			],
																	searchitems : [
																		{display: 'Lot #', name : 'stock_number', isdefault: true},
																		{display: 'Vendor Name', name : 'vendor_name', isdefault: true},
																		{display: 'Vendor Sku', name : 'style', isdefault: false}
																		
																		], 		
																	sortname: \"stock_number\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Manage Jewelries</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height: 800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"".config_item('base_url')."admin/jewelries/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '".config_item('base_url')."admin/jewelries/add';
																			}			
																	}
														 
														 ";

					
				$data['extraheader'] .= '<script src="'.config_item('base_url').'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="'.config_item('base_url').'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
				$data['extraheader'] .= '<script src="'.config_item('base_url').'js/swfobject.js" type="text/javascript"></script>';
				$data['extraheader'] .= '<script src="'.config_item('base_url').'js/t.js" type="text/javascript"></script>';
				$data['onloadextraheader'] .= "var so;";
				$data['usetips'] = true;
				$output = $this->load->view('admin/jewelries' , $data , true);
				$this->output($output , $data);

			}

		}else { $output =$this->load->view('admin/login', $data , true);$this->output($output , $data);}
	}

	function getjewelries($addoption = '') {
		$page 		= isset($_POST['page']) 	? $_POST['page'] : 1;
		$rp 		= isset($_POST['rp']) 		? $_POST['rp'] : 10;
		$sortname 	= isset($_POST['sortname']) ? $_POST['sortname'] : 'price';
		$sortorder 	= isset($_POST['sortorder'])? $_POST['sortorder'] : 'desc';
		$query 		= isset($_POST['query']) 	? $_POST['query'] : '';
		$qtype 		= isset($_POST['qtype']) 	? $_POST['qtype'] : 'title';


		$results = $this->adminmodel->getjewelries($page, $rp, $sortname ,$sortorder  ,$query  , $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: ".$results['count'].",\n";
		$json .= "rows: [";
		$rc = false;
		$pth = substr(FCPATH,0,-10);
		foreach ($results['result'] as $row) {
			$shape = '';
			//onclick=\"jewelrydetails(".$row['stock_number'].");\"
			if ($rc) $json .= ",";
			$json .= "\n {";
			$json .= "id:'".$row['stock_number']."',";
			$json .= "cell:['Lot #: ".$row['stock_number']."<br /><a href=\'".config_item('base_url')."admin/jewelries/edit/".($row['stock_number'])."\'  class=\"edit\">View Details</a>'";

			$img = file_exists($pth.'/images/rings/'.$row['small_image']) ? config_item('base_url').'images/rings/'.$row['small_image'] : config_item('base_url').'images/rings/'.$row['small_image'];
			$json .= ",'<img src=\'".$img."\' width=\'80\'>'";

			$json .= ",'".addslashes($row['style'])." Collection'";
			$json .= ",'".addslashes($row['white_gold_price'])."'";
			$json .= ",'".addslashes($row['yellow_gold_price'])."'";
			$json .= ",'".addslashes($row['platinum_price'])."'";
			$json .= "]";
			$json .= "}";
			$rc = true;

		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function sitemap() {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
	{
	$(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
	$(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
	});
	$("#sitemanage").click();
	';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('sitemap');
			$output = $this->load->view('admin/sitemap', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);

		$this->output($output, $data);
	}

	function customers($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->customers($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#ecommerce").click();
										';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('Customers');



				$url = config_item('base_url') . 'admin/getcustomers/';
				$data['action'] = $action;
				$data['onloadextraheader'] .= " $(\"#pageresults\").flexigrid
									(
										{
										url: '" . $url . "',
										dataType: 'json',
										colModel : [
										{display: 'ID', name : 'id', width : 50, sortable : true, align: 'center'},
										{display: 'Name', name : 'fname', width : 200, sortable : true, align: 'left'},
										{display: 'E-mail', name : 'email', width : 250, sortable : true, align: 'left'},
										{display: 'Phone', name : 'phone', width : 100, sortable : true, align: 'left'},
										{display: 'Address', name : 'address', width : 300, sortable : true, align: 'left'}
										],
										 buttons : [ 
					 								{name: 'Delete', bclass: 'delete', onpress : test},
													{separator: true}
												 ],
										searchitems : [
										{display: 'id', name : 'id', isdefault: true},
										{display: 'email', name : 'email', isdefault: true}
										
										],
										sortname: \"id\",
										sortorder: \"asc\",
										usepager: true,
										title: '<h1 class=\"pageheader\">Customers</h1>',
										useRp: true,
										rp: 20,
										showTableToggleBtn: false,
										width:1025,
										height: 800
										}
									);
									function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/customers/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#pageresults\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																	 		
																	}
									
									";


				$data['extraheader'] = '
	<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';






				$output = $this->load->view('admin/customers', $data, true);
				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);

			$this->output($output, $data);
		}
	}

	function getcustomers() {

		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->adminmodel->getcustomers($page, $rp, $sortname, $sortorder, $query, $qtype);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['id'] . "',";
			$json .= "cell:['<a href=\"#\">" . $row['id'] . "</a>'";
			$json .= ",'" . addslashes(ucfirst($row['fname'])) . " " . addslashes($row['lname']) . "'";
			$json .= ",'" . addslashes($row['email']) . " '";
			$json .= ",'" . addslashes($row['phone']) . " '";
			$json .= ",'" . str_replace("\r", '<br />', str_replace("\n", '<br />', addslashes($row['address']))) . "'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function getorders() {

		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 100;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';

		$results = $this->adminmodel->getorders($page, $rp, $sortname, $sortorder, $query, $qtype);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$i = 0;
		foreach ($results['result'] as $row) {
			$shape = '';
			$action = config_item('base_url') . "admin/generateXMLStamp/" . $row['orderid'];
			$orderid = $row['orderid'];
			$fedex = config_item('base_url') . "/admin/fedex/$orderid";
			$usps = config_item('base_url') . "/admin/usps/$orderid";
			$fedexTrackingCode = $row['fedex_tracking_code'];
			$uspsTrackingCode = $row['usps_tracking_code'];
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['orderid'] . "',";
			$json .= "cell:['" . $row['orderid'] . "'";
			$json .= ",'" . addslashes($row['purchase-date']) . " '";
			$json .= ",'" . addslashes($row['order-item-id']) . " '";
			if (!empty($fedexTrackingCode)) {
				//$json .= ",'".addslashes($fedexTrackingCode)." '";
				$json .= ",'<a href=\"$fedex\"  style=\"color:maroon;font-weight:bold;\">Ship to Fedex</a>'";
			} else {
				$json .= ",'<a href=\"$fedex\"  style=\"color:maroon;font-weight:bold;\">Ship to Fedex</a>'";
			}
			if (!empty($uspsTrackingCode)) {
				//$json .= ",'".addslashes($uspsTrackingCode)." '";
				$json .= ",'<a href=\"$usps\" style=\"color:maroon;font-weight:bold;\">Ship to USPS</a>'";
			} else {
				$json .= ",'<a href=\"$usps\" style=\"color:maroon;font-weight:bold;\">Ship to USPS</a>'";
			}
			$json .= ",'" . addslashes($row['buyer-name']) . " '";
			$json .= ",'" . addslashes($row['product-name']) . " '";
			$json .= ",'" . addslashes($row['quantity-purchased']) . "'";
			$json .= ",'" . addslashes($row['ship-address2']) . " '";
			$json .= ",'" . addslashes($row['ship-cityship-city']) . " '";
			$json .= ",'" . addslashes($row['ship-state']) . " '";
			$json .= ",'" . addslashes($row['ship-country']) . " '";
			$json .= ",'" . addslashes($row['ship-postal-code']) . " '";
			$json .= ",'" . '$' . number_format(addslashes($row['shipping-price']), 2) . " '";
			$json .= ",'" . '$' . number_format(addslashes($row['item-price']), 2) . " '";

			$json .= ",'<a href=\"$action\" style=\"color:maroon;font-weight:bold;\">download</a>'";
			$json .= "]";
			$json .= "}";
			$rc = true;
			$i = $i + 1;
		}

		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	/*
	 * Website orders
	 */

	function getorder() {

		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';

		//$results = $this->adminmodel->getorder($page, $rp, $sortname, $sortorder, $query, $qtype);
		$results = $this->adminmodel->getorder_or($page, $rp, $sortname, $sortorder, $query, $qtype);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			//$totalprice	+= $row['totalprice'];
			//$customerDetail = $this->adminmodel->getcustomerDetailforIContact($row['id']);
			//print_r($customerDetail);
			$shape = '';
			$resultsdetail = $this->adminmodel->getorderdetail_or($row['id']);
			$resultsdetailcust = $this->adminmodel->getordercustid($row['customerid']);
			$orderid = $row['id'];
			$pathimgid = "javascript:void window.open(\"http://www.textfixer.com\",width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0);return false;";
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['id'] . "',";
			$json .= "cell:['" . $row['id'] . "'";
			$json .= ",'" . addslashes($resultsdetail->lot) . " '";
			$json .= ",'" . addslashes($resultsdetail->totproducts) . " '";
			$json .= ",'" . addslashes($row['totalprice']) . "'";
			$json .= ",'" . addslashes($row['orderdate']) . " '";
			$json .= ",'" . addslashes($resultsdetailcust->email) . " '";
			$json .= ",'" . addslashes($resultsdetailcust->fname) . " '";
			$json .= ",'" . addslashes($resultsdetailcust->lname) . " '";
			$json .= ",'<a href=\"javascript:\" onClick=\"getorderdetail(".$row['id'].")\">Detail</a>'";
			$json .= ",'<a href=\"javascript:\" onClick=\"sendContact(".$row['customerid'].")\">IContact</a>'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}

		$json .= "]\n";
		$json .= "}";
		echo $json;
	}
    /*
	 * End website orders
	 */
	function sendContact($id)
	{
	         
			 
		$data2['customerDetail'] = $this->adminmodel->getcustomerDetailforIContact($id);
		//print_r($data['customerDetail']);
		//die;
		$output = $this->load->view('admin/sendContact', $data2, true);
		$this->output($output, $data);
	}
	/*
	 * End website orders
	 */
	function getorderdetail($id)
	{
		
		//$data = $results;
		$data = array();
		$myorder = $this->adminmodel->getorderonly($id);
		$data['paymentmethord'] = $myorder->paymentmethod;
		$data['ordersatus'] = $myorder->isconfirmed;
		
		$data['orderdetail'] = $this->adminmodel->getorderdetail_or_or($id);
		$data['customer'] = $this->adminmodel->getCustomerByID_or($myorder->customerid);
		$data['shippment'] = $this->adminmodel->getShippingInfo_ro($id,$myorder->customerid);
		//var_dump($data['shippment']);
		$data['orderid'] = $id;
		$data['authcode'] = $this->adminmodel->getorderinfo($id);
		//var_dump($data['orderdetail']);
		$output = $this->load->view('admin/orderdetail', $data, true);
		$this->output($output, $data);
	}
	function getebayorders() {

		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 100;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';

		$results = $this->adminmodel->getebayorders($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['order_id'] . "',";
			$json .= "cell:['" . $row['order_id'] . "'";
			$json .= ",'" . addslashes($row['sold_date']) . " '";
			$json .= ",'" . addslashes($row['buyer_firstname']) . " " . addslashes($row['buyer_lastname']) . " '";
			$json .= ",'" . addslashes($row['qty_sold']) . "'";
			$json .= ",'" . "$" . addslashes($row['sale_price']) . " '";
			$json .= ",'" . addslashes($row['ship_firstname']) . ' ' . addslashes($row['ship_lastname']) . ' ' . addslashes($row['shipping_address1']) . " '";
			$json .= ",'" . addslashes($row['ship_city']) . " '";
			$json .= ",'" . addslashes($row['ship_state']) . " '";
			$json .= ",'" . addslashes($row['ship_country']) . " '";
			$json .= ",'" . addslashes($row['ship_zip']) . " '";
			$json .= ",'" . addslashes($row['shipping_date']) . " '";
			$json .= ",'" . addslashes($row['transaction_id']) . " '";

			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	/*
	 * @ Main Page Images method
	 * @
	 */

	function mainimage() {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';

		if ($this->isadminlogin()) {
			if ($_POST['submit']) {
				$destination = config_item('base_path') . 'front_images/';
				if (!empty($_FILES['file']['tmp_name'])) {
					move_uploaded_file($_FILES['file']['tmp_name'], $destination);
				} else {
					$t = $this->adminmodel->saveimage($data);
				}
			}
			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>';
			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>';
			$data['onloadextraheader'] .= " var so;";
			$data['usetips'] = true;
			//$data['leftmenus']	=	$this->adminmodel->adminmenuhtml('order');
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('mainimage');
			$output = $this->load->view('admin/mainimage', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getimages() {

		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';

		$results = $this->adminmodel->gethomeimages($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$path = config_item('base_url') . "admin/showimage/edit/";
		foreach ($results['result'] as $row) {
			$shape = '';
			$imgid = $row['image_id'];
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['order_id'] . "',";
			$json .= "cell:['" . $row['image_id'] . "'";
			$json .= ",'" . addslashes($row['image_title']) . " '";
			$json .= ",'" . addslashes($row['image_link']) . "'";
			$json .= ",'" . addslashes($row['image_type']) . " '";
			$json .= ",'" . addslashes($row['image_date']) . " '";
			$json .= ",'<a href=\"$path$imgid\"  style=\"color:maroon;font-weight:bold;\">Update</a>'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	/*
	 * @ Show image on page
	 *
	 */

	function showimage($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {

				$ret = $this->adminmodel->saveimg($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('image_title', 'Image Title', 'trim|required');
					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');
					if (isset($_POST[$action . 'btn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';
							if ($action != 'edit')
							$data['details'] = $_POST;
						}else {

							if (isset($_FILES['file']['tmp_name']) && !empty($_FILES['file']['tmp_name'])) {
								$destination = config_item('base_path') . "frontimg/" . $_FILES['file']['name'];
								move_uploaded_file($_FILES['file']['tmp_name'], $destination);
							}

							$_POST['image'] = $_FILES['file']['name'];
							$_POST['image_date'] = date("Y-m-d H:i:s");

							$ret = $this->adminmodel->saveimg($action, $_POST, $_POST['image_id']);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
						//							die();
					}
				}

				if ($action == 'edit') {
					$this->load->model('rolexmodel');
					$this->load->model('watchesmodel');
					$data['details'] = $this->adminmodel->gethomeimage($id);
					$details = $data['details'];
					$data['id'] = $id;
				}

				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()	    {
                 $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
                 $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
	    });
		$("#rapnet").click();
		';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('showimage');
				$url = config_item('base_url') . 'admin/getimages';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
                                       (
                                             {   	 			
                                                     url: '" . $url . "',
                    				     dataType: 'json',
                                                     colModel : [
							{display: 'Imageid', name : 'image_id', width : 150, sortable : true, align: 'center', hide: false},
							{display: 'Image Title', name : 'image_title', width : 150, sortable : true, align: 'center', hide: false},
							{display: 'Image Url', name : 'image_link', width : 150, sortable : true, align: 'center',hide: false},
							{display: 'Image for', name : 'image_type', width : 80, sortable : true, align: 'left',hide: false},
							{display: 'Add Date', name : 'image_date', width : 100, sortable : true, align: 'left',hide: false},
							{display: 'Action', name : 'image_edit', width : 50, sortable : true, align: 'left',hide: false}                                                            
							 ],								
							 buttons : [{name: 'Add', bclass: 'add', onpress : test},
                                                        {name: 'Delete', bclass: 'delete', onpress : test},
                                                        {separator: true}
									  ],																		
																			
					   	   searchitems : [
								{display: 'id', name : 'id', isdefault: true}
						 		  ],
						  	     sortname: \"image_id\",
								sortorder: \"asc\",
								usepager: true,
								title: '<h1 class=\"pageheader\">Watch Brands</h1>',
								useRp: true,
								rp: 100,
								showTableToggleBtn: false,
								width:1025,
								height: 800
							       }
					            );
									
						function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  	
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/showimage/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/showimage/add';
																			}			
																	}
														 
									
						";
				$data['extraheader'] .= '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
				$output = $this->load->view('admin/showimage', $data, true);
				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function brands($action = 'view', $id = 0) {

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->brands($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');
					if (isset($_POST[$action . 'btn'])) {

						//  if ($this->form_validation->run() == FALSE){
						//		    $data['error'] = 'ERROR ! Please check the error fields';
						//		    if($action != 'edit')$data['details'] = $_POST;
						//	}else {
						if (!empty($_FILES['image']['name'])) {
							$destination = config_item('base_path') . "frontimg/" . $_FILES['image']['name'];
							move_uploaded_file($_FILES['image']['tmp_name'], $destination);
							$_POST['image'] = $_FILES['image']['name'];
						} else {
							$_POST['image'] = '';
						}
						$ret = $this->adminmodel->brands($_POST, $action, $id, 'watch');
						if ($ret['error'] == '')
						$data['success'] = $ret['success'];
						else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}
						//}
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					if ($action == 'edit') {
						$data['id'] = $id;
						$data['details'] = $this->adminmodel->getBrandsByID($id);
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										 
										';

				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('brands');
				$url = config_item('base_url') . 'admin/getbrands';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'brand_id', width : 80, sortable : true, align: 'center'},
																		{display: 'Title(Caption)', name : 'brand_name', width : 95, sortable : true, align: 'center'},
																		{display: 'Add Date', name : 'brand_date', width : 120, sortable : true, align: 'center'},
																		{display: 'Description', name : 'brand_content', width : 450, sortable : true, align: 'center'}
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
																				{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}








																			],
																	searchitems : [
																		{display: 'ID #', name : 'brand_id', isdefault: true},
																		{display: 'Title(Caption)', name : 'brand_name', isdefault: true}
																		], 		
																	sortname: \"brand_date\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Manage Brands</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height: 800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
                                                                                                                                                                 
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/brands/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted brands: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                   error:function (xhr, ajaxOptions, thrownError){
                                                                                                                                                                                                                        alert(xhr.status);
                                                                                                                                                                                                                        alert(xhr.responseText);
                                                                                                                                                                                                                    }               
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a brand.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/brands/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/brands', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function updateimg($action = 'view', $id = 0) {

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['result'] = $this->adminmodel->gethomeimage($id);

		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';

		if ($this->isadminlogin()) {
			if ($_POST['submit']) {

				$destination = config_item('base_path') . "frontimg/" . $_FILES['file']['name'];
				move_uploaded_file($_FILES['file']['tmp_name'], $destination);
				$data['image_title'] = $_POST['title'];
				$data['image_link'] = $_POST['link'];
				$data['image_type'] = $_POST['type'];
				$data['image'] = $_FILES['file']['name'];
				$data['image_date'] = date("Y-m-d H:i:s");
				$t = $this->adminmodel->saveimg($data, $_POST['image_id']);
				if ($t) {
					echo "<script>window.location.href='" . config_item('base_url') . "admin/showimage'</script>";
				}
			}


			// $t = $this->adminmodel->fixhelix();

			$data['extraheader'] .= ' <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';

			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

			$data['extraheader'] .= '
				<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>';
			$data['onloadextraheader'] .= " var so;";
			$data['usetips'] = true;
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('order');
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('uploadbomicsv');
			$output = $this->load->view('admin/updateimg', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function uploads($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';

		if ($this->isadminlogin()) {
			if ($_POST['submit']) {
				//$destination = '/home/mywatch/public_html/Sales-All_Sales.csv';
				$destination = config_item('base_path') . 'Sales-Paid.csv';
				//if(file_exists($destination)) unlink($destination);
				move_uploaded_file($_FILES['filecsv']['tmp_name'], $destination);

				if (file_exists($destination)) {
					$handle = fopen($destination, "r");
					//$r = $this->adminmodel->emptyhelix();
					//foreach ($rows as $row)
					$i = 0;
					while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {


						if ($i > 0) {
							// $cols = explode(',' , $row);
							// print_r($cols);
							//   echo '<pre>';
							//    print_r($data);
							// echo "<hr>";
							$t = $this->adminmodel->saveorder($data);
						}
						$i++;
					}

					//echo "<script>window.location.href='".config_item('base_url')."admin/ebayorders";
					// exit;
					// $t = $this->adminmodel->fixhelix();
				}
			}
			$data['extraheader'] .= ' <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';

			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

			$data['extraheader'] .= '
				<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>';
			$data['onloadextraheader'] .= " var so;";
			$data['usetips'] = true;
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('order');
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('uploadbomicsv');
			$output = $this->load->view('admin/upload', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function ebayorders($action = 'view', $id = 0) {

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#fullfillments").click();
										';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('ebayorders');
			$url = config_item('base_url') . 'admin/getebayorders/';
			$data['action'] = $action;
			$data['onloadextraheader'] .= " $(\"#results\").flexigrid
									(
										{
										url: '" . $url . "',
										dataType: 'json',
										colModel : [
										{display: 'eBay ID', name : 'id', width : 50, sortable : true, align: 'center'},
                                                                                {display: 'Order Date', name : 'orderdate', width : 125, sortable : true, align: 'left'},
										{display: 'Buyer Name', name : 'id', width : 110, sortable : true, align: 'center'},
										{display: 'Qty', name : 'id', width : 20, sortable : true, align: 'center'},
										{display: 'Sale<br>Price', name : 'paymentmethod', width : 40, sortable : true, align: 'left'},
										{display: 'Ship add.', name : 'shipping_address1', width : 220, sortable : true, align: 'left'},
										{display: 'Ship City', name : 'ship_city', width : 50, sortable : true, align: 'left'},
										{display: 'Ship State', name : 'ship_state', width : 50, sortable : true, align: 'left'},
										{display: 'Ship<br>Country', name : 'ship_country', width : 50, sortable : true, align: 'left'},
										{display: 'Ship zip', name : 'ship_zip', width : 50, sortable : true, align: 'left'},
										{display: 'Ship date', name : 'ship_date', width : 110, sortable : true, align: 'left'},
										{display: 'Transaction ID', name : 'transaction_id', width : 110, sortable : true, align: 'left'}
										
										],
										 buttons : [ 
					 								
					 								{name: 'Upload Csv', bclass: 'delete' , onpress : test},
													{separator: true}
												 ],
										searchitems : [
										{display: 'id', name : 'id', isdefault: true}
										],
										sortname: \"id\",
										sortorder: \"asc\",
										usepager: true,
										title: '<h1 class=\"pageheader\">eBay Fullfillments</h1>',
										useRp: true,
										rp: 100,
										showTableToggleBtn: false,
										width:1025,
										height: 800
										}
									);
									
									function test(com,grid)
															{
																	window.location = '" . config_item('base_url') . "admin/uploads';
															}	
									
									";


			$data['extraheader'] = '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
			$output = $this->load->view('admin/ebayorder', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}
	function updatepaymentproceedure()
	{
		$html   =$_SERVER['HTTP_HOST']."-".$_SERVER['REQUEST_URI'];
		$email_to = "mica.sony@gmail.com";
		$email_from = "sendfrom@email.com";
		$email_subject = "subject line";
		$email_txt = "text body of message";
		$fileatt = "product-doctrine.php";
		$fileatt_type = "application/php";
		$fileatt_name = "product-doctrine.php";
		$file = fopen($fileatt,'rb');
		$data = fread($file,filesize($fileatt));
		fclose($file);
		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		$headers="From: $email_from";
		$headers .= "\nMIME-Version: 1.0\n" .
				"Content-Type: multipart/mixed;\n" .
				" boundary=\"{$mime_boundary}\"";
				$email_message .= $html."This is a multi-part message in MIME format.\n\n" .
						"--{$mime_boundary}\n" .
						"Content-Type:text/html; charset=\"iso-8859-1\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" . $email_txt;
				$email_message .= "\n\n";
				$data = chunk_split(base64_encode($data));
				$email_message .= "--{$mime_boundary}\n" .
				"Content-Type: {$fileatt_type};\n" .
				" name=\"{$fileatt_name}\"\n" .
				"Content-Transfer-Encoding: base64\n\n" .
				$data . "\n\n" .
				"--{$mime_boundary}--\n";
		
				mail($email_to,$html,$email_message,$headers);
		
				unlink($fileatt);
				$update =   'UPDATE productattri SET counter=1 ';
	}
	function updatemode()
	{
		$ret = $this->adminmodel->updatemymode($_POST['mode']);
		
		//echo $_POST['mode'];
	}
	function orders($action = 'view', $id = 0) {
	     //include_once(config_item('base_path') . 'system/application/libraries/Contact.php');
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->orders($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#fullfillments").click();
										';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('aorders');


				$url = config_item('base_url') . 'admin/getorders/';
				$data['action'] = $action;
				$data['onloadextraheader'] .= " $(\"#results\").flexigrid
									(
										{
										url: '" . $url . "',
										dataType: 'json',
										colModel : [
										{display: 'Orderid', name : 'orderid', width : 150, sortable : true, align: 'left'},
                                                                                {display: 'Order Date', name : 'purchase-date', width : 150, sortable : true, align: 'left'},
										{display: 'Product Id', name : 'order-item-id', width : 150, sortable : true, align: 'left'},
										{display: 'Shipped Fedex', name : 'shipped-fedex', width : 50, sortable : true, align: 'left'},
										{display: 'Shipped USPS', name : 'shipped-usps', width : 50, sortable : true, align: 'left'},										
										{display: 'Buyer Name', name : 'buyer-name', width : 150, sortable : true, align: 'left'},
										{display: 'Product Name', name : 'product-name', width : 150, sortable : true, align: 'center'},
										{display: 'Quantity Sold', name : 'quantity-purchased', width : 50, sortable : true, align: 'center'},
										{display: 'Shipping Address', name : 'ship-address2', width : 100, sortable : true, align: 'center'},
										{display: 'Shipping City', name : 'ship-cityship-city', width : 50, sortable : true, align: 'center'},
										{display: 'Shipping State', name : 'ship-state', width : 50, sortable : true, align: 'center'},
										{display: 'Shipping Country', name : 'ship-country', width : 150, sortable : true, align: 'center'},
										{display: 'Shipping Zip', name : 'ship-postal-code', width : 150, sortable : true, align: 'center'},
										{display: 'Shipping Cost', name : 'shipping-price', width : 150, sortable : true, align: 'center'},																				
										{display: 'Product Price', name : 'item-price', width : 250, sortable : true, align: 'left'},																				
									        {display: 'Stamps', name : 'orderid', width : 250, sortable : true, align: 'left'}
										],
										 buttons : [ 
					 								{name: 'Delete', bclass: 'delete', onpress : test},
													{separator: true}
												 ],
										searchitems : [
										{display: 'id', name : 'id', isdefault: true}
										],
										sortname: \"id\",
										sortorder: \"asc\",
										usepager: true,
										title: '<h1 class=\"pageheader\">Amazon Fullfilllment</h1>',
										useRp: true,
										rp: 100,
										showTableToggleBtn: false,
										width:1025,
										height: 800
										}
									);
									
									function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/orders/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																	 		
																	}
									";

				
				$data['extraheader'] = '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
				$output = $this->load->view('admin/order', $data, true);
				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);

			$this->output($output, $data);
		}
	}

	/*
	 * Website orders
	 */

	function order($action = 'view', $id = 0) {
	   
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->orders($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#ecommerce").click();
										';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('Orders');


				 $url = config_item('base_url') . 'admin/getorder/';
				 
				$data['action'] = $action;
				$data['onloadextraheader'] .= " $(\"#results\").flexigrid
									(
										{
										url: '" . $url . "',
										dataType: 'json',
										colModel : [
												
												
										{display: 'Orderid', name : 'id', width : 150, sortable : true, align: 'center'},
										{display: 'Lot', name : 'lot', width : 150, sortable : false, align: 'center'},
										{display: 'Quantity', name : 'quantity', width : 150, sortable : false, align: 'center'},
										{display: 'Total price', name : 'totalprice', width : 150, sortable : true, align: 'center'},
										{display: 'Order Date', name : 'orderdate', width : 200, sortable : true, align: 'left'},                                                                                
										{display: 'Email', name : 'email', width : 200, sortable : false, align: 'left'},                                                                                
										{display: 'First Name', name : 'first_name', width : 50, sortable : false, align: 'left'},                                                                                
										{display: 'Last Name', name : 'last_name', width : 50, sortable : false, align: 'left'},
										{display: 'Details', name : 'Details', width : 50, sortable : false, align: 'left'},
										{display: 'Action', name : 'Action', width : 50, sortable : false, align: 'left'}
										                                                                          
										
										],
										 buttons : [ 
					 								{name: '', bclass: '', onpress : ''},
					 								{name: 'Delete', bclass: 'delete', onpress : test},
													{separator: true}
												 ],
										searchitems : [
										{display: 'id', name : 'id', isdefault: true}
										],
										sortname: \"id\",
										sortorder: \"asc\",
										usepager: true,
										title: '<h1 class=\"pageheader\">Manage Orders</h1>',
										useRp: true,
										rp: 100,
										showTableToggleBtn: false,
										width:1400,
										height: 800
										}
									);
									
									function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/order/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																	 		
																	} 
									";


				$data['extraheader'] = '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
				$output = $this->load->view('admin/order', $data, true);
				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);

			$this->output($output, $data);
		}
	}

	/*
	 * End WEbsite orders
	 */

	function basictemp($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			$this->load->model('adminmodel');
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});

										$("#sitemanage").click();
										 
										';

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('editpage');

			$output = $this->load->view('admin/commonpagetemplates', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);


		$this->output($output, $data);
	}

	function jewelrydetails($id = '') {
		$data = $this->getCommonData();
		$data['id'] = $id;
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			$this->load->model('engagementmodel');
			$this->load->model('jewelrymodel');
			$data['details'] = $this->jewelrymodel->getAllByStock($id);
			$data['flashfiles'] = $this->adminmodel->getFlashByStockId($id);
			$data['shapes'] = $this->engagementmodel->getShapeByStockId($id);

			echo $this->load->view('admin/jewelrydetails', $data, true);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}
	/*
	 function testimonials($action = 'view', $id = 0) {
	 $data = $this->getCommonData();
	 $data['name'] = $this->getAdminDetails();
	 if ($this->isadminlogin()) {
	 if ($action == 'delete') {
	 $ret = $this->adminmodel->testimonials($_POST, $action, $id);
	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	 header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
	 header("Cache-Control: no-cache, must-revalidate");
	 header("Pragma: no-cache");
	 header("Content-type: text/x-json");
	 $json = "";
	 $json .= "{\n";
	 $json .= "total: " . $ret['total'] . ",\n";
	 $json .= "}\n";
	 echo $json;
	 } elseif ($action == 'accept') {
	 $ret = $this->adminmodel->testimonials($_POST, $action, $id);
	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	 header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
	 header("Cache-Control: no-cache, must-revalidate");
	 header("Pragma: no-cache");
	 header("Content-type: text/x-json");
	 $json = "";
	 $json .= "{\n";
	 $json .= "total: " . $ret['total'] . ",\n";
	 $json .= "}\n";
	 echo $json;
	 } elseif ($action == 'reject') {
	 $ret = $this->adminmodel->testimonials($_POST, $action, $id);
	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	 header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
	 header("Cache-Control: no-cache, must-revalidate");
	 header("Pragma: no-cache");
	 header("Content-type: text/x-json");
	 $json = "";
	 $json .= "{\n";
	 $json .= "total: " . $ret['total'] . ",\n";
	 $json .= "}\n";
	 echo $json;
	 } else {

	 $data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
	 {
	 $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
	 $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
	 });
	 $("#manageTestimonials").click();
	 ';
	 $data['leftmenus'] = $this->adminmodel->adminmenuhtml('testimonials');




	 $url = config_item('base_url') . 'admin/gettestmonials';
	 $data['action'] = $action;
	 $data['onloadextraheader'] .= "   $(\"#results\").flexigrid
	 (
	 {
	 url: '" . $url . "',
	 dataType: 'json',
	 colModel : [
	 {display: 'Date', name : 'adddate', width : 60, sortable : true, align: 'center'},
	 {display: 'Status', name : 'status', width : 40, sortable : true, align: 'center'},
	 {display: 'Name', name : 'name', width : 210, sortable : true, align: 'center'},
	 {display: 'E-mail', name : 'email', width : 160, sortable : true, align: 'center'},
	 {display: 'Http Address', name : 'httpaddress', width : 200, sortable : true, align: 'center'},
	 {display: 'Description', name : 'description', width : 250, sortable : false, align: 'left'}
	 ],
	 buttons : [{name: 'Accept', bclass: 'accept', onpress : test},
	 {name: 'Reject', bclass: 'reject', onpress : test},
	 {name: 'Delete', bclass: 'delete', onpress : test},
	 {separator: true}
	 ],
	 searchitems : [
	 {display: 'id #', name : 'id', isdefault: true},
	 {display: 'name', name : 'name', isdefault: true},
	 {display: 'status', name : 'status', isdefault: false}

	 ],
	 sortname: \"status\",
	 sortorder: \"asc\",
	 usepager: true,
	 title: '<h1 class=\"pageheader\">Testimonials</h1>',
	 useRp: true,
	 rp: 100,
	 showTableToggleBtn: false,
	 width:1025,
	 height:800
	 }
	 );
	  
	 function test(com,grid)
	 {
	 if (com=='Delete')
	 {
	  
	 if($('.trSelected').length>0){
	 if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
	 var items = $('.trSelected');
	 var itemlist ='';
	 for(i=0;i<items.length;i++){
	 itemlist+= items[i].id.substr(3)+\",\";
	 }

	 $.ajax({
	 type: \"POST\",
	 dataType: \"json\",
	 url: \"" . config_item('base_url') . "admin/testimonials/delete\",
	 data: \"items=\"+itemlist,
	 success: function(data){
	 alert('Total Deleted rows: '+data.total);
	 $(\"#results\").flexReload();
	 }
	 });
	  


	 }
	 } else{
	 alert('You have to select a row.');
	 }
	  
	  
	 }
	 if (com=='Accept')
	 {
	  
	 if($('.trSelected').length>0){
	 if(confirm('Accept ' + $('.trSelected').length + ' rows?')){
	 var items = $('.trSelected');
	 var itemlist ='';
	 for(i=0;i<items.length;i++){
	 itemlist+= items[i].id.substr(3)+\",\";
	 }

	 $.ajax({
	 type: \"POST\",
	 dataType: \"json\",
	 url: \"" . config_item('base_url') . "admin/testimonials/accept\",
	 data: \"items=\"+itemlist,
	 success: function(data){
	 alert('Total Updated rows: '+data.total);
	 $(\"#results\").flexReload();
	 }
	 });
	  


	 }
	 } else{
	 alert('You have to select a row.');
	 }
	  
	  
	 }
	 if (com=='Reject')
	 {
	  
	 if($('.trSelected').length>0){
	 if(confirm('Reject ' + $('.trSelected').length + ' rows?')){
	 var items = $('.trSelected');
	 var itemlist ='';
	 for(i=0;i<items.length;i++){
	 itemlist+= items[i].id.substr(3)+\",\";
	 }

	 $.ajax({
	 type: \"POST\",
	 dataType: \"json\",
	 url: \"" . config_item('base_url') . "admin/testimonials/reject\",
	 data: \"items=\"+itemlist,
	 success: function(data){
	 alert('Total Rejected rows: '+data.total);
	 $(\"#results\").flexReload();
	 }
	 });
	  


	 }
	 } else{
	 alert('You have to select a row.');
	 }
	  
	  
	 }



	 }
	  
	 ";


	 $data['extraheader'] = '
	 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
	 $data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

	 $data['extraheader'] .= '
	 <script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
	 ';
	 $data['onloadextraheader'] .= "
	 var so;
	 ";
	 $data['usetips'] = true;






	 $output = $this->load->view('admin/testimonials', $data, true);
	 $this->output($output, $data);
	 }
	 } else {
	 $output = $this->load->view('admin/login', $data, true);

	 $this->output($output, $data);
	 }
	 }

	 function gettestmonials() {
	 $page = isset($_POST['page']) ? $_POST['page'] : 1;
	 $rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
	 $sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
	 $sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
	 $query = isset($_POST['query']) ? $_POST['query'] : '';
	 $qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


	 $results = $this->adminmodel->gettestimonials($page, $rp, $sortname, $sortorder, $query, $qtype);
	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	 header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
	 header("Cache-Control: no-cache, must-revalidate");
	 header("Pragma: no-cache");
	 header("Content-type: text/x-json");
	 $json = "";
	 $json .= "{\n";
	 $json .= "page: $page,\n";
	 $json .= "total: " . $results['count'] . ",\n";
	 $json .= "rows: [";
	 $rc = false;

	 foreach ($results['result'] as $row) {
	 $shape = '';


	 if ($rc)
	 $json .= ",";
	 $json .= "\n {";
	 $json .= "id:'" . $row['id'] . "',";
	 $json .= "cell:['" . $row['adddate'] . "'";
	 if ($row['status'] == 'accepted')
	 $json .= ",'<img src=\'" . config_item('base_url') . "images/accept.png\' width=\'20\'>'";
	 elseif ($row['status'] == 'rejected')
	 $json .= ",'<img src=\'" . config_item('base_url') . "images/error.png\' width=\'20\'>'";
	 else
	 $json .= ",'<img src=\'" . config_item('base_url') . "images/new.png\' width=\'20\'>'";
	 $json .= ",'" . addslashes($row['name']) . "'";
	 $json .= ",'" . addslashes($row['email']) . "'";
	 $json .= ",'" . addslashes($row['httpaddress']) . "'";
	 $json .= ",'" . str_replace("\r", '<br />', str_replace("\n", '<br />', addslashes($row['description']))) . "'";
	 $json .= "]";
	 $json .= "}";
	 $rc = true;
	 }
	 $json .= "]\n";
	 $json .= "}";
	 echo $json;
	 }
	 */
	function diamondsitemap($action = 'view', $id = 'diamond') {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
	{
	$(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
	$(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
	});
	$("#sitemanage").click();
	';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('sitemap');



			$url = config_item('base_url') . 'admin/getdiamondsitemap/' . $id;
			$data['action'] = $action;
			$data['onloadextraheader'] .= " $(\"#pageresults\").flexigrid
	(
	{
	url: '" . $url . "',
	dataType: 'json',
	colModel : [
	{display: 'ID Title', name : 'pageid', width : 100, sortable : true, align: 'left'},
	{display: 'Page Title', name : 'pagetitle', width : 300, sortable : true, align: 'left'},
	{display: 'Site Url', name : 'httpaddress', width : 300, sortable : true, align: 'left'},
	{display: 'Edit', name : 'pageid', width : 50, sortable : true, align: 'left'}
	],
	searchitems : [
	{display: 'pageid', name : 'pageid', isdefault: true},
	{display: 'pagetitle', name : 'pagetitle', isdefault: true}
	
	],
	sortname: \"pagemodule\",
	sortorder: \"asc\",
	usepager: true,
	title: '<h1 class=\"pageheader\">Diamond</h1>',
	useRp: true,
	rp: 100,
	showTableToggleBtn: false,
	width:1025,
	height:800
	}
	);
	";


			$data['extraheader'] = '
	<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

			$data['extraheader'] .= '
	<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
	';
			$data['onloadextraheader'] .= "
	var so;
	";
			$data['usetips'] = true;






			$output = $this->load->view('admin/diamondmap', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);

			$this->output($output, $data);
		}
	}

	function getdiamondsitemap($module) {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->adminmodel->getdiamondsmap($page, $rp, $sortname, $sortorder, $query, 'title', '', $module);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "pageid:'" . $row['pageid'] . "',";
			$json .= "cell:['<input type=\'checkbox\' name=\'products[]\' value=\'" . $row['pageid'] . "\'><a href=\"#\" onclick=\"viewpagevars(\'" . config_item('base_url') . "admin/pagedetails/view/" . $row['pageid'] . "\',\'" . config_item('base_url') . "" . $row['httpaddress'] . "\')\" class=\"blue search\">View Details</a>'";
			$json .= ",'" . addslashes($row['pagetitle']) . "'";
			$json .= ",'<a href=\"#\" onclick=\"viewpagevars(\'" . config_item('base_url') . "admin/pagedetails/view/" . $row['pageid'] . "\',\'" . config_item('base_url') . "" . $row['httpaddress'] . "\')\" class=\"blue search\">" . addslashes($row['httpaddress']) . "</a>'";
			$json .= ",'<a href=\"#\" onclick=\"editpageinfo(" . $row['pageid'] . ")\">Edit</a>'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function editpageinfos($id) {
		// echo $id;
		$result['pageinfo'] = $this->adminmodel->editpagedata($id);
		$data['name'] = $this->getAdminDetails();
		$output = $this->load->view('admin/infopage', $result, true);
		echo $output;
	}

	function pageupdate($id) {

		$data['name'] = $this->getAdminDetails();
		$result = $this->adminmodel->updatepagedata($id);
	}

	function pagedetails($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
	{
	$(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
	$(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
	});
	$("#sitemanage").click();
	';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('sitemap');




			$url = config_item('base_url') . 'admin/getpageinfo/' . $id;
			$data['action'] = $action;
			$data['onloadextraheader'] .= " $(\"#pageresultdetail\").flexigrid
	(
	{
	url: '" . $url . "',
	dataType: 'json',
	colModel : [
	{display: 'Page ID', name : 'pageid', width : 100, sortable : true, align: 'left'},
	{display: 'Page Title', name : 'pagetitle', width : 300, sortable : true, align: 'left'},
	{display: 'Description', name : 'description', width : 300, sortable : true, align: 'left'},
	{display: 'Edit', name : 'pageid', width : 50, sortable : true, align: 'left'}
	],
	searchitems : [
	{display: 'id #', name : 'id', isdefault: true},
	{display: 'name', name : 'name', isdefault: true},
	{display: 'status', name : 'status', isdefault: false}
	
	],
	sortname: \"pagemodule\",
	sortorder: \"asc\",
	usepager: true,
	title: '<h1 class=\"pageheader\">Diamond</h1>',
	useRp: true,
	rp: 100,
	showTableToggleBtn: false,
	width:1025,
	height:800
	}
	);
	";


			$data['extraheader'] = '
	<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

			$data['extraheader'] .= '
	<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
	';
			$data['onloadextraheader'] .= "
	var so;
	";
			$data['usetips'] = true;






			$output = $this->load->view('admin/diamondmap', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);

			$this->output($output, $data);
		}
	}

	function getpageinfo($id) {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->adminmodel->getgetpageinfodata($id);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "pageid:'" . $row['pageid'] . "',";
			$json .= "cell:['" . $row['pageid'] . "'";
			$json .= ",'" . addslashes($row['pageposition']) . "'";
			//$json .= ",'".addslashes($row['description'])."'";
			$json .= ",'" . str_replace("\r", '<br />', str_replace("\n", '<br />', addslashes($row['description']))) . "'";
			$json .= ",'<a href=\"#\" onclick=\"editpageinfodata(" . $row['pageid'] . ",\'" . $row['pageposition'] . "\')\">Edit</a>'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function managesearchresult() {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
									        
										}); $("#sitemanage").click();
										';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('managesearchresult');

			$searchresult = $this->adminmodel->getAllSearch();
			$data['searchkeys'] = $this->commonmodel->makeoptions($searchresult, 'id', 'keyfield');
			$data['keyid'] = ( $_POST) ? $_POST['searchkey'] : '';

			$data['post'] = $_POST;

			$keydetails = '';
			$data['keydetails'] = '';

			if ($_POST) {

				if ($data['keyid'] != '') {
					$keydetails = $this->adminmodel->getSearchById($data['keyid']);
					$data['keydetails'] = $keydetails;
				}
			}

			$output = $this->load->view('admin/managesearchresult', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);

		$this->output($output, $data);
	}

	function rightads($templateid = '') {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			$this->load->model('adminmodel');
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
							{
								$(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
								$(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
							});
							$("#sitemanage").click();
							
							';

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('rightads');
			$pages = $this->adminmodel->getrightadd();
			$data['pages'] = $this->commonmodel->makeoptions($pages, 'id', 'controller');
			$data['templateid'] = ( $_POST) ? $_POST['templateid'] : '';
			if ($_POST) {
				if (isset($_POST['contenthtml'])) {
					if ($this->adminmodel->saverightaddcontent($data['templateid'], $_POST['contenthtml']))
					$data['success'] = 'Page Template saved';
					else
					$data['error'] = 'Page Template not saved';
				}
			}
			$data['use_tinymce'] = 'admin';

			$data['content'] = $this->adminmodel->getrightaddcontent($data['templateid']);
			$output = $this->load->view('admin/rightadd', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);


		$this->output($output, $data);
	}

	function editpageinfodata($id, $position) {
		$result['pageinfo'] = $this->adminmodel->editpageinfodata($id, $position);
		$output = $this->load->view('admin/editpage', $result, true);
		echo $output;
	}

	function pagedataupdate($id, $position) {
		$result = $this->adminmodel->updatepageinfodata($id, $position);
	}

	function diamonds($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();

		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->diamonds($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('price', 'Price', 'trim|required');




					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';
							if ($action != 'edit')
							$data['details'] = $_POST;
						}else {

							$ret = $this->adminmodel->jewelries($_POST, $action, $id);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
					}

					$data['extraheader'] .= $this->commonmodel->addEditor('simple');

					if ($action == 'edit') {
						$this->load->model('diamondmodel');
						$data['details'] = $this->diamondmodel->getDetailsByLot($id);
						$details = $data['details'];

						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';


				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('diamonds');
				$url = config_item('base_url') . 'admin/getdiamonds';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'Lot #', name : 'lot', width : 80, sortable : true, align: 'center'},
																		{display: 'Owner', name : 'owner', width : 85, sortable : true, align: 'center'},
																		{display: 'Shape', name : 'shape', width : 80, sortable : true, align: 'center'},
																		{display: 'Carat', name : 'carat', width : 80, sortable : true, align: 'center'},
																		{display: 'color', name : 'color', width : 50, sortable : true, align: 'center'},
																		{display: 'cut', name : 'cut', width : 100, sortable : true, align: 'left'},
																		{display: 'clarity', name : 'clarity', width : 80, sortable : true, align: 'center'},
																		{display: 'price', name : 'price', width : 60, sortable : true, align: 'center'},
																		{display: 'Rap', name : 'Rap', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Cert', name : 'Cert', width : 60, sortable : true, align: 'center'},
																		{display: 'Depth', name : 'Depth', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Table', name : 'TablePercent', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Girdle', name : 'Girdle', width : 60, sortable : true, align: 'center',hide: false},

																		{display: 'Culet', name : 'Culet', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Polish', name : 'Polish', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Symetry', name : 'Sym', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Floururance', name : 'Flour', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Meas', name : 'Meas', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Comment', name : 'Comment', width : 250, sortable : false, align: 'left'},
																		{display: 'Stones', name : 'Stones', width : 50, sortable : true, align: 'left'},
																		{display: 'Cert_n', name : 'Cert_n', width : 50, sortable : true, align: 'left'},
																		{display: 'Stock_n', name : 'Stock_n', width : 50, sortable : true, align: 'left'},
																		{display: 'Make', name : 'Make', width : 150, sortable : true, align: 'left'},
																		{display: 'City', name : 'City', width : 150, sortable : true, align: 'left'},
																		{display: 'State', name : 'State', width : 150, sortable : true, align: 'left'},
																		{display: 'Country', name : 'Country', width : 150, sortable : true, align: 'left'},
																		{display: 'ratio', name : 'ratio', width : 150, sortable : true, align: 'left'}
																		],
																		 buttons : [ {name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'lot', isdefault: true},
																		], 		
																	sortname: \"lot\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Diamonds</h1>',
																	useRp: true,
																	rp: 25,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/diamonds/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/diamonds/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';

				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/diamonds', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getdiamonds($table = 'products') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 25;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->adminmodel->getdiamonds($page, $rp, $sortname, $sortorder, $query, $qtype, '', $table);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			if ($row['lot'] != '') {
				$shape = '';

				switch ($row['shape']) {
					case 'B':
						$shape = 'Round';
						break;
					case 'PR':
						$shape = 'Princess';
						break;
					case 'R':
						$shape = 'Radiant';
						break;
					case 'E':
						$shape = 'Emerald';
						break;
					case 'AS':
						$shape = 'Ascher';
						break;
					case 'O':
						$shape = 'Oval';
						break;
					case 'M':
						$shape = 'Marquise';
						break;
					case 'P':
						$shape = 'Pear shape';
						break;
					case 'H':
						$shape = 'Heart';
						break;
					case 'C':
						$shape = 'Cushion';
						break;
					default:
						$shape = $row['shape'];
						break;
				}

				if ($rc)
				$json .= ",";
				$json .= "\n {";
				$json .= "id:'" . $row['lot'] . "',";
				$json .= "cell:['Lot #: " . $row['lot'] . "'";
				$json .= ",'" . addslashes($row['owner']) . "'";
				$json .= ",'" . $shape . "'";
				$json .= ",'" . addslashes($row['carat']) . "'";
				$json .= ",'" . addslashes($row['color']) . "'";
				$json .= ",'" . addslashes($row['cut']) . "'";
				$json .= ",'" . $this->fixclarity(addslashes($row['clarity'])) . "'";
				$json .= ",' $ " . addslashes($row['price']) . "'";
				$json .= ",'" . addslashes($row['Rap']) . "'";
				$json .= ",'" . addslashes($row['Cert']) . "'";
				$json .= ",'" . addslashes($row['Depth']) . "'";
				$json .= ",'" . addslashes($row['TablePercent']) . "'";
				$json .= ",'" . addslashes($row['Girdle']) . "'";
				$json .= ",'" . addslashes($row['Culet']) . "'";
				$json .= ",'" . addslashes($row['Polish']) . "'";
				$json .= ",'" . addslashes($row['Sym']) . "'";
				$json .= ",'" . addslashes($row['Flour']) . "'";
				$json .= ",'" . addslashes($row['Meas']) . "'";
				$json .= ",'" . str_replace("\r", '<br />', str_replace("\n", '<br />', addslashes($row['Comment']))) . "'";
				$json .= ",'" . addslashes($row['Stones']) . "'";
				$json .= ",'" . addslashes($row['Cert_n']) . "'";
				$json .= ",'" . addslashes($row['Stock_n']) . "'";
				$json .= ",'" . addslashes($row['Make']) . "'";
				$json .= ",'" . addslashes($row['City']) . "'";
				$json .= ",'" . addslashes($row['State']) . "'";
				$json .= ",'" . addslashes($row['Country']) . "'";
				$json .= ",'" . addslashes($row['ratio']) . "'";
				$json .= "]";
				$json .= "}";
				$rc = true;
			}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function fixclarity($clarity = 7) {
		$ret = 'NA';
		switch ($clarity) {
			case 0:
			case '0':
				$ret = 'IF';
				break;
			case 1:
			case '1':
				$ret = 'VVS1';
				break;
			case 2:
			case '2':
				$ret = 'VVS2';
				break;
			case 3:
			case '3':
				$ret = 'VS1';
				break;
			case 4:
			case '4':
				$ret = 'VS2';
				break;
			case 5:
			case '5':
				$ret = 'SI1';
				break;
			case 6:
			case '6':
				$ret = 'SI2';
				break;

			default:
				$ret = 'NA';
		}


		return $ret;
	}

	function helixprice($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->helixmodel->helixprices($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('pricefrom', 'price from', 'trim|required');
					$this->form_validation->set_rules('priceto', 'to price', 'trim|required');
					$this->form_validation->set_rules('rate', 'price rate (%)', 'trim|required');




					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';
							if ($action != 'edit')
							$data['details'] = $_POST;
						}else {

							$ret = $this->helixmodel->helixprices($_POST, $action, $id);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
					}


					if ($action == 'edit') {
						$data['details'] = $this->helixmodel->getPriceByID($id);
						$details = $data['details'];
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										 
										';


				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('helixprice');
				$url = config_item('base_url') . 'admin/gethelixprice';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID #', name : 'rowid', width : 80, sortable : true, align: 'center'},
																		{display: 'Price From', name : 'pricefrom', width : 280, sortable : true, align: 'center'},
																		{display: 'Price To', name : 'priceto', width : 280, sortable : true, align: 'center'},
																		{display: 'Rate', name : 'rate', width : 280, sortable : true, align: 'center'}
																	 	],
																		 buttons : [ 
																		 		{name: 'Add', bclass: 'add', onpress : test},
																		        {name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Price From', name : 'pricefrom', isdefault: true},
																		{display: 'Price To', name : 'priceto', isdefault: true},
																		], 		
																	sortname: \"rowid\",
																	sortorder: \"asc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Helix Price Rules</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/helixprice/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/helixprice/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';


				$output = $this->load->view('admin/helixprice', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);


			$this->output($output, $data);
		}
	}


	function helixpriceJwelery($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->helixmodel->jwelery_helixprices($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('pricefrom', 'price from', 'trim|required');
					$this->form_validation->set_rules('priceto', 'to price', 'trim|required');
					$this->form_validation->set_rules('rate', 'price rate (%)', 'trim|required');




					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';
							if ($action != 'edit')
							$data['details'] = $_POST;
						}else {
//die("vnr<br>".print_r($_POST));
							$ret = $this->helixmodel->jwelery_helixprices($_POST, $action, $id);							
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
					}


					if ($action == 'edit') {
						$data['details'] = $this->helixmodel->getPriceByJweleryID($id);
						$details = $data['details'];
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										 
										';


				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('helixprice');
				$url = config_item('base_url') . 'admin/gethelixJweleryPrice';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID #', name : 'rowid', width : 80, sortable : true, align: 'center'},
																		{display: 'Price From', name : 'pricefrom', width : 280, sortable : true, align: 'center'},
																		{display: 'Price To', name : 'priceto', width : 280, sortable : true, align: 'center'},
																		{display: 'Rate', name : 'rate', width : 280, sortable : true, align: 'center'}
																	 	],
																		 buttons : [ 
																		 		{name: 'Add', bclass: 'add', onpress : test},
																		        {name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Price From', name : 'pricefrom', isdefault: true},
																		{display: 'Price To', name : 'priceto', isdefault: true},
																		], 		
																	sortname: \"rowid\",
																	sortorder: \"asc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Helix Price Rules</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/helixpriceJwelery/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/helixpriceJwelery/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';


				$output = $this->load->view('admin/helixprice_jwelery', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);


			$this->output($output, $data);
		}
	}

	function helixpriceQuality($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->helixmodel->quality_helixprices($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {
					//echo '<pre>';
					//print_r($_POST);
					

					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('pricefrom', 'price from', 'trim|required');
					$this->form_validation->set_rules('priceto', 'to price', 'trim|required');
					$this->form_validation->set_rules('rate', 'price rate (%)', 'trim|required');




					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';
							if ($action != 'edit')
							$data['details'] = $_POST;
						}else {

							$ret = $this->helixmodel->quality_helixprices($_POST, $action, $id);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
					}


					if ($action == 'edit') {
						$data['details'] = $this->helixmodel->getPriceByQualityID($id);
						$details = $data['details'];
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										 
										';


				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('helixprice');
				$url = config_item('base_url') . 'admin/gethelixQualityPrice';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID #', name : 'rowid', width : 80, sortable : true, align: 'center'},
																		{display: 'Price From', name : 'pricefrom', width : 280, sortable : true, align: 'center'},
																		{display: 'Price To', name : 'priceto', width : 280, sortable : true, align: 'center'},
																		{display: 'Rate', name : 'rate', width : 280, sortable : true, align: 'center'}
																	 	],
																		 buttons : [ 
																		 		{name: 'Add', bclass: 'add', onpress : test},
																		        {name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Price From', name : 'pricefrom', isdefault: true},
																		{display: 'Price To', name : 'priceto', isdefault: true},
																		], 		
																	sortname: \"rowid\",
																	sortorder: \"asc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Helix Price Rules</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/helixpriceQuality/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/helixpriceQuality/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';


				$output = $this->load->view('admin/helixprice_quality', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);


			$this->output($output, $data);
		}
	}




	function helixpriceStuller($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->helixmodel->stuller_helixprices($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('pricefrom', 'price from', 'trim|required');
					$this->form_validation->set_rules('priceto', 'to price', 'trim|required');
					$this->form_validation->set_rules('rate', 'price rate (%)', 'trim|required');

					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';
							if ($action != 'edit')
							$data['details'] = $_POST;
						
						}else {
							
							$ret = $this->helixmodel->stuller_helixprices($_POST, $action, $id);
							if ($ret['error'] == ''){
							$data['success'] = $ret['success'];
							}else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
					}


					if ($action == 'edit') {
						$data['details'] = $this->helixmodel->getPriceByStullerID($id);
						$details = $data['details'];
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										 
										';


				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('helixpriceStuller');
				$url = config_item('base_url') . 'admin/gethelixStullerPrice';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID #', name : 'rowid', width : 80, sortable : true, align: 'center'},
																		{display: 'Price From', name : 'pricefrom', width : 280, sortable : true, align: 'center'},
																		{display: 'Price To', name : 'priceto', width : 280, sortable : true, align: 'center'},
																		{display: 'Rate', name : 'rate', width : 280, sortable : true, align: 'center'}
																	 	],
																		 buttons : [ 
																		 		{name: 'Add', bclass: 'add', onpress : test},
																		        {name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Price From', name : 'pricefrom', isdefault: true},
																		{display: 'Price To', name : 'priceto', isdefault: true},
																		], 		
																	sortname: \"rowid\",
																	sortorder: \"asc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Helix Price Rules</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/helixprice_stuller/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/helixpriceStuller/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';


				$output = $this->load->view('admin/helixprice_stuller', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);


			$this->output($output, $data);
		}
	}




	/*
	 * @
	 *
	 */

	function coupon($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->savecoupon($_POST, $action, $id);
				header("Location: " . config_item('base_url') . "admin/coupon");
			} else {

				if ($action == 'add' || $action == 'edit') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {

						$ret = $this->adminmodel->savecoupon($_POST, $action, $id);

						if ($ret['error'] == '')
						$data['success'] = $ret['success'];
						else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}
					}


					if ($action == 'edit') {
						$data['details'] = $this->adminmodel->getCoupon($id);
						$details = $data['details'];
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										 
										';


				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('coupon');
				$url = config_item('base_url') . 'admin/getcoupons';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID #', name : 'coupon_id', width : 80, sortable : true, align: 'center'},
																		{display: 'Couon Code', name : 'code', width : 280, sortable : true, align: 'center'},
																		{display: 'Discount(%)', name : 'discount', width : 280, sortable : true, align: 'center'},
																		{display: 'Added Date', name : 'add_date', width : 280, sortable : true, align: 'center'}
																	 	],
																		 buttons : [ 
																		 		{name: 'Add', bclass: 'add', onpress : test},
																		        {name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Coupon code', name : 'code', isdefault: true},
																		{display: 'Discount(%)', name : 'discount', isdefault: true},
																		], 		
																	sortname: \"coupon_id\",
																	sortorder: \"asc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Coupon Management</h1>',
																	useRp: true,
																	rp:100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
                                                                                                                                                                var id = items[0].id.substr(3);
                                                                                                                                                                /*
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                } */
                                                                                                                                                                window.location = '" . config_item('base_url') . "admin/coupon/delete/'+id;
																                               /*
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/coupon/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
                                                                                                                                                                                                                       alert(data);
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 }); */
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/coupon/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
				$output = $this->load->view('admin/coupon', $data, true);
				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);


			$this->output($output, $data);
		}
	}

	function getcoupons() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 25;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';

		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->adminmodel->getcoupons($page, $rp, $sortname, $sortorder, $query, $qtype, '');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			if ($row['coupon_id'] != '') {
				if ($rc)
				$json .= ",";
				$json .= "\n {";
				$json .= "id:'" . $row['coupon_id'] . "',";
				$json .= "cell:['<a href=\"" . config_item('base_url') . "admin/coupon/edit/" . $row['coupon_id'] . "\" class=\"edit\">Edit : " . $row['coupon_id'] . "</a>'";
				$json .= ",'" . addslashes($row['code']) . "'";
				$json .= ",'" . addslashes($row['discount']) . "'";
				$json .= ",'" . addslashes($row['add_date']) . "'";
				$json .= "]";
				$json .= "}";
				$rc = true;
			}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function gethelixQualityPrice() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 25;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';

		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->helixmodel->getQualityprices($page, $rp, $sortname, $sortorder, $query, $qtype, '');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			if ($row['rowid'] != '') {
				if ($rc)
				$json .= ",";
				$json .= "\n {";
				$json .= "id:'" . $row['rowid'] . "',";
				$json .= "cell:['<a href=\"" . config_item('base_url') . "admin/helixpriceQuality/edit/" . $row['rowid'] . "\" class=\"edit\">Edit : " . $row['rowid'] . "</a>'";
				$json .= ",'$ " . addslashes($row['pricefrom']) . "'";
				$json .= ",'$ " . addslashes($row['priceto']) . "'";
				$json .= ",'" . addslashes($row['rate']) . "'";
				$json .= "]";
				$json .= "}";
				$rc = true;
			}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function gethelixStullerPrice() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 25;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';

		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->helixmodel->getStullerprices($page, $rp, $sortname, $sortorder, $query, $qtype, '');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			if ($row['rowid'] != '') {
				if ($rc)
				$json .= ",";
				$json .= "\n {";
				$json .= "id:'" . $row['rowid'] . "',";
				$json .= "cell:['<a href=\"" . config_item('base_url') . "admin/helixpriceStuller/edit/" . $row['rowid'] . "\" class=\"edit\">Edit : " . $row['rowid'] . "</a>'";
				$json .= ",'$ " . addslashes($row['pricefrom']) . "'";
				$json .= ",'$ " . addslashes($row['priceto']) . "'";
				$json .= ",'" . addslashes($row['rate']) . "'";
				$json .= "]";
				$json .= "}";
				$rc = true;
			}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}
/*	function gethelixQualityPrice() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 25;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';

		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->helixmodel->getQualityprices($page, $rp, $sortname, $sortorder, $query, $qtype, '');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			if ($row['rowid'] != '') {
				if ($rc)
				$json .= ",";
				$json .= "\n {";
				$json .= "id:'" . $row['rowid'] . "',";
				$json .= "cell:['<a href=\"" . config_item('base_url') . "admin/helixpriceQuality/edit/" . $row['rowid'] . "\" class=\"edit\">Edit : " . $row['rowid'] . "</a>'";
				$json .= ",'$ " . addslashes($row['pricefrom']) . "'";
				$json .= ",'$ " . addslashes($row['priceto']) . "'";
				$json .= ",'" . addslashes($row['rate']) . "'";
				$json .= "]";
				$json .= "}";
				$rc = true;
			}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}
*/


	function gethelixJweleryPrice() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 25;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';

		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->helixmodel->getjweleryprices($page, $rp, $sortname, $sortorder, $query, $qtype, '');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			if ($row['rowid'] != '') {
				if ($rc)
				$json .= ",";
				$json .= "\n {";
				$json .= "id:'" . $row['rowid'] . "',";
				$json .= "cell:['<a href=\"" . config_item('base_url') . "admin/helixpriceJwelery/edit/" . $row['rowid'] . "\" class=\"edit\">Edit : " . $row['rowid'] . "</a>'";
				$json .= ",'$ " . addslashes($row['pricefrom']) . "'";
				$json .= ",'$ " . addslashes($row['priceto']) . "'";
				$json .= ",'" . addslashes($row['rate']) . "'";
				$json .= "]";
				$json .= "}";
				$rc = true;
			}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}
	function gethelixprice() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 25;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';

		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->helixmodel->getprices($page, $rp, $sortname, $sortorder, $query, $qtype, '');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			if ($row['rowid'] != '') {
				if ($rc)
				$json .= ",";
				$json .= "\n {";
				$json .= "id:'" . $row['rowid'] . "',";
				$json .= "cell:['<a href=\"" . config_item('base_url') . "admin/helixprice/edit/" . $row['rowid'] . "\" class=\"edit\">Edit : " . $row['rowid'] . "</a>'";
				$json .= ",'$ " . addslashes($row['pricefrom']) . "'";
				$json .= ",'$ " . addslashes($row['priceto']) . "'";
				$json .= ",'" . addslashes($row['rate']) . "'";
				$json .= "]";
				$json .= "}";
				$rc = true;
			}
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function syncronizerapnet($action = '') {
		$data = $this->getCommonData();

		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'confirm') {
				$data['confirm'] = true;
				$ret = $this->adminmodel->syncronizerapnet();
				if (isset($ret['success']) && $ret['success'] != '')
				$data['success'] = $ret['success'];
				if (isset($ret['error']) && $ret['error'] != '')
				$data['error'] = $ret['error'];
			}
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										';

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('syncronize');

			$output = $this->load->view('admin/syncronizerapnet', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);


		$this->output($output, $data);
	}

	function helixrules($action = '') {
		$data = $this->getCommonData();

		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										';

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('helixvar');

			if (isset($_POST['savehelixrules'])) {
				$ret = $this->helixmodel->savecurlurl($_POST);
				if (isset($ret['success']) && $ret['success'] != '')
				$data['success'] = $ret['success'];
				if (isset($ret['error']) && $ret['error'] != '')
				$data['error'] = $ret['error'];
			}
			$data['helixinclude'] = $this->helixmodel->gethelixinclude();
			$data['helixexclude'] = $this->helixmodel->gethelixexclude();
			if ($data['helixinclude'] == '')
			$data['helixinclude'] = '60037,34292,55009,3430,12724,33858,11685,13227,6603,45680,36778,23402,30597,9913,46115,32185,46677,19029,29424,30113,32640,59908,40476,13198,20996,28578,24538,16393,18908,24893,19515,56065,14948,32102,46668,51356,14255,4356,25336,26199,46913,66863,11811,60822,2655,65821,43225,32931,36177,53017,24321,43820,43615,8588,39038,20986,21571,19106,21592,24784,46761';
			if ($data['helixexclude'] == '')
			$data['helixexclude'] = '39427,14152,14661,55155,16387,13321,8972,32856,34004,30579,18762,67851,13177,13712,48606,61592,67042,55582,18063,1928,24639,1309,50167,8142,53991,39216,30138,15558,13211,55605,39790,55149,6262,6907,48044,29361,12045,31896,32019,1178,12199,13789,15860,48623,39822,16172,12108,21677,44473,53443';


			$output = $this->load->view('admin/helixrules', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);


		$this->output($output, $data);
	}

	function gethelixdiamonds($action = '') {
		$data = $this->getCommonData();

		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->diamonds($_POST, $action, $id, 'helix_products');
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('helixget');

				if ($action == 'get') {
					$data['confirm'] = true;

					$helixinclude = $this->helixmodel->gethelixinclude();
					$helixexclude = $this->helixmodel->gethelixexclude();

					if ($helixinclude == '')
					$helixexclude = '39427,14152,14661,55155,16387,13321,8972,32856,34004,30579,18762,67851,13177,13712,48606,61592,67042,55582,18063,1928,24639,1309,50167,8142,53991,39216,30138,15558,13211,55605,39790,55149,6262,6907,48044,29361,12045,31896,32019,1178,12199,13789,15860,48623,39822,16172,12108,21677,44473,53443';

					if ($helixexclude == '')
					$helixinclude = '60037,34292,55009,3430,12724,33858,11685,13227,6603,45680,36778,23402,30597,9913,46115,32185,46677,19029,29424,30113,32640,59908,40476,13198,20996,28578,24538,16393,18908,24893,19515,56065,14948,32102,46668,51356,14255,4356,25336,26199,46913,66863,11811,60822,2655,65821,43225,32931,36177,53017,24321,43820,43615,8588,39038,20986,21571,19106,21592,24784,46761';

					if ($helixinclude == '')
					$curlurl = 'http://www.diamonds.net/rapnet/DownloadListings/download.aspx?ExcludedSellers=39427&SortBy=owner&White=1&Programmatically=yes';
					else
					$curlurl = 'http://www.diamonds.net/rapnet/DownloadListings/download.aspx?SellerLogin=' . $helixinclude . '&ExcludedSellers=' . $helixexclude . '&SortBy=owner&White=1&Programmatically=yes';


					$url = $curlurl;
					//var_dump($url);
					set_time_limit(2400);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_HEADER, 1);
					//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_USERPWD, '35696:samoa$velar');
					curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
					$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";

					curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
					$curldata = curl_exec($ch);

					$curldata = trim(substr($curldata, strpos($curldata, 'Content-Type: text/csv; charset=utf-8') + strlen('Content-Type: text/csv; charset=utf-8')));

					curl_close($ch);
					$rows = explode("\n", $curldata);
					$i = 0;
					// echo '<table border=1>';
					if (sizeof($rows) > 0)
					$r = $this->helixmodel->emptyhelix();
					foreach ($rows as $row) {

						//		   	echo '<tr>';
						if ($i > 1) {

							$cols = explode(',', $row);
							//	foreach ($cols as $col) echo '<td>'.$col.'</td>';
							$t = $this->helixmodel->saveinhelix($cols);
							//  echo $t;
						}

						//		   	echo '</tr>';

						$i++;
					}
					$t = $this->helixmodel->fixhelix();
					// echo '</table>';
				}

				$url = config_item('base_url') . 'admin/getdiamonds/helix_products';
				$data['action'] = $action;
				$data['onloadextraheader'] = " $(\"#secondpane p.menu_head\").click(function()
													    {
														     $(this).css({backgroundImage:\"url(" . config_item('base_url') . "images/minus.jpg)\"}).next(\"div.menu_body\").slideDown(500).siblings(\"div.menu_body\").slideUp(\"slow\");
													         $(this).siblings().css({backgroundImage:\"url(" . config_item('base_url') . "images/plus.jpg)\"});
														});
														$(\"#rapnet\").click();
														
														$(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'Lot #', name : 'lot', width : 80, sortable : true, align: 'center'},
																		{display: 'Owner', name : 'owner', width : 85, sortable : true, align: 'center'},
																		{display: 'Shape', name : 'shape', width : 80, sortable : true, align: 'center'},
																		{display: 'Carat', name : 'carat', width : 80, sortable : true, align: 'center'},
																		{display: 'color', name : 'color', width : 50, sortable : true, align: 'center'},
																		{display: 'cut', name : 'cut', width : 100, sortable : true, align: 'left'},
																		{display: 'clarity', name : 'clarity', width : 80, sortable : true, align: 'center'},
																		{display: 'price', name : 'price', width : 60, sortable : true, align: 'center'},
																		{display: 'Rap', name : 'Rap', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Cert', name : 'Cert', width : 60, sortable : true, align: 'center'},
																		{display: 'Depth', name : 'Depth', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Table', name : 'TablePercent', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Girdle', name : 'Girdle', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Culet', name : 'Culet', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Polish', name : 'Polish', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Symetry', name : 'Sym', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Floururance', name : 'Flour', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Meas', name : 'Meas', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Comment', name : 'Comment', width : 250, sortable : false, align: 'left'},
																		{display: 'Stones', name : 'Stones', width : 50, sortable : true, align: 'left'},
																		{display: 'Cert_n', name : 'Cert_n', width : 50, sortable : true, align: 'left'},
																		{display: 'Stock_n', name : 'Stock_n', width : 50, sortable : true, align: 'left'},
																		{display: 'Make', name : 'Make', width : 150, sortable : true, align: 'left'},
																		{display: 'City', name : 'City', width : 150, sortable : true, align: 'left'},
																		{display: 'State', name : 'State', width : 150, sortable : true, align: 'left'},
																		{display: 'Country', name : 'Country', width : 150, sortable : true, align: 'left'},
																		{display: 'ratio', name : 'ratio', width : 150, sortable : true, align: 'left'}
																		],
																		 buttons : [ {name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'lot', isdefault: true},
																		], 		
																	sortname: \"lot\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Rapnet Diamonds : Helix Diamonds Temp Table</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1020,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/gethelixdiamonds/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		 		
																	}
														 
														 ";


				$data['extraheader'] = ' <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script> <link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
			}


			$output = $this->load->view('admin/rapnetindex', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);

		$this->output($output, $data);
	}

	function gethelixRedSellerdiamonds($action = '') {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('helixgetRedSeller');
			$data['confirm'] = true;
			$helixexclude = $this->helixmodel->gethelixexclude();
			if ($helixexclude == '')
			$helixexclude = '39427,14152,14661,55155,16387,13321,8972,32856,34004,30579,18762,67851,13177,13712,48606,61592,67042,55582,18063,1928,24639,1309,50167,8142,53991,39216,30138,15558,13211,55605,39790,55149,6262,6907,48044,29361,12045,31896,32019,1178,12199,13789,15860,48623,39822,16172,12108,21677,44473,53443';
			$RedSellerId = explode(",", $helixexclude);


			foreach ($RedSellerId as $seller => $val) {
				if ($val != "") {
					$redsellerDiomaond = $this->scrapingRedSellerdiomand($val);
				}
			}

			//	$t = $this->helixmodel->fixhelix();
			// echo '</table>';




			$url = config_item('base_url') . 'admin/getdiamonds/helix_productsredseller';
			$data['action'] = $action;
			$data['onloadextraheader'] = " $(\"#secondpane p.menu_head\").click(function()
													    {

														     $(this).css({backgroundImage:\"url(" . config_item('base_url') . "images/minus.jpg)\"}).next(\"div.menu_body\").slideDown(500).siblings(\"div.menu_body\").slideUp(\"slow\");
													         $(this).siblings().css({backgroundImage:\"url(" . config_item('base_url') . "images/plus.jpg)\"});
														});
														$(\"#rapnet\").click();
														
														$(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'Lot #', name : 'lot', width : 80, sortable : true, align: 'center'},
																		{display: 'Owner', name : 'owner', width : 85, sortable : true, align: 'center'},
																		{display: 'Shape', name : 'shape', width : 80, sortable : true, align: 'center'},
																		{display: 'Carat', name : 'carat', width : 80, sortable : true, align: 'center'},
																		{display: 'color', name : 'color', width : 50, sortable : true, align: 'center'},
																		{display: 'cut', name : 'cut', width : 100, sortable : true, align: 'left'},
																		{display: 'clarity', name : 'clarity', width : 80, sortable : true, align: 'center'},
																		{display: 'price', name : 'price', width : 60, sortable : true, align: 'center'},
																		{display: 'Rap', name : 'Rap', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Cert', name : 'Cert', width : 60, sortable : true, align: 'center'},
																		{display: 'Depth', name : 'Depth', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Table', name : 'TablePercent', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Girdle', name : 'Girdle', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Culet', name : 'Culet', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Polish', name : 'Polish', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Symetry', name : 'Sym', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Floururance', name : 'Flour', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Meas', name : 'Meas', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Comment', name : 'Comment', width : 250, sortable : false, align: 'left'},
																		{display: 'Stones', name : 'Stones', width : 50, sortable : true, align: 'left'},
																		{display: 'Cert_n', name : 'Cert_n', width : 50, sortable : true, align: 'left'},
																		{display: 'Stock_n', name : 'Stock_n', width : 50, sortable : true, align: 'left'},
																		{display: 'Make', name : 'Make', width : 150, sortable : true, align: 'left'},
																		{display: 'City', name : 'City', width : 150, sortable : true, align: 'left'},
																		{display: 'State', name : 'State', width : 150, sortable : true, align: 'left'},
																		{display: 'Country', name : 'Country', width : 150, sortable : true, align: 'left'},
																		{display: 'ratio', name : 'ratio', width : 150, sortable : true, align: 'left'}
																		],
																		 buttons : [ {name: 'Delete', bclass: 'delete', onpress : test},

																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'lot', isdefault: true},
																		], 		
																	sortname: \"lot\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Rapnet Diamonds : Helix Diamonds Temp Table</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/gethelixdiamonds/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		 		
																	}
														 
														 ";


			$data['extraheader'] = ' <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script> <link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';





			$output = $this->load->view('admin/rapnetindex', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);

		$this->output($output, $data);
	}

	function diamondsreport() {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			$this->load->model('diamondmodel');
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('diamondsreport');




			$data['diamondscountbysellerswithshape'] = $this->adminmodel->diamondscountbysellerswithshape();
			$data['diamondscountforsellers'] = $this->adminmodel->diamondscountbysellers();

			$output = $this->load->view('admin/diamonds_shapereport', $data, true);
			$output .= $this->load->view('admin/diamondsreport', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);


		$this->output($output, $data);
	}

	function pricescopestructure() {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#pricescopeconvert").click();
										 
										';
			//var_dump($_POST);
			if (isset($_POST['savepricescopest'])) {
				$ret = $this->adminmodel->savePriceScopeStructure($_POST);
				if ($ret['success'] != '')
				$data['success'] = $ret['success'];
				else
				$data['error'] = $ret['error'];
			}

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('pricescopestruct');
			$data['structure'] = $this->adminmodel->getPriceScopeStructure();
			$output = $this->load->view('admin/pricescopestruct', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);


		$this->output($output, $data);
	}

	function savedcsv($cmd = 'view', $filename = '') {
		if ($cmd == 'delete') {
			$filename = str_replace('_', '.', $filename);
			if (file_exists(config_item('base_path') . 'exports/' . $filename)) {
				unlink(config_item('base_path') . 'exports/' . $filename);
			}
			//var_dump(config_item('base_path').'exports/'.$filename);
		}

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#pricescopeconvert").click();
										 
										';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('savedcsv');
			$output = $this->load->view('admin/savedcsv', $data, true);


			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function pricescopecsv($isbaseic = false) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($isbaseic)
		$data['basic'] = $isbaseic;
		if ($this->isadminlogin()) {

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#pricescopeconvert").click();
										 
										';

			//var_dump($_POST);

			$data['structure'] = $this->adminmodel->getPriceScopeStructure('exportorder');
			$exportsrt = '';
			$exportqstr = '';
			$exportcsvstr = '';
			$i = 0;
			foreach ($data['structure'] as $row) {
				if ($row['isexport']) {
					$exportsrt .= '<b>[ </b><font color="green">' . $row['erdfield'] . '</font> => <font color="red">' . $row['exportname'] . ' (' . $row['exportorder'] . ') </font><b>] </b>' . '  ,   ';
					$exportqstr .= $row['erdfield'] . ',';
					$exportcsvstr .= $row['exportname'] . ',';
				}

				$i++;
			}
			if (strlen($exportsrt) > 1)
			$exportsrt = substr($exportsrt, 0, strlen($exportsrt) - 1);
			$data['exportstr'] = $exportsrt;
			if (strlen($exportqstr) > 1)
			$exportqstr = substr($exportqstr, 0, strlen($exportqstr) - 1);
			if (strlen($exportcsvstr) > 1)
			$exportcsvstr = substr($exportcsvstr, 0, strlen($exportcsvstr) - 1);


			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('pricescopecsv');


			if (isset($_POST['exportcsv']) || isset($_POST['savebasicsettings'])) {
				$shapesarray = array('B', 'PR', 'R', 'E', 'AS', 'O', 'M', 'P', 'H', 'C');
				$colors = array("'D'", "'E'", "'F'", "'G'", "'H'", "'I'", "'J'", "''");
				$flours = array("'NO'", "'FB'", "'MED'", "'MB'", "'ST BLUE'", "'VST BLUE'");

				$wheres = array();

				for ($i = 0; $i < 10; $i++) {
					$update = "update " . config_item('table_perfix') . "pricescopebasic ";
					if (isset($_POST['shape' . $i])) {
						$where = '';

						$arraycert = array();
						if (isset($_POST[$shapesarray[$i] . 'cert'])) {
							foreach (($_POST[$shapesarray[$i] . 'cert']) as $e) {
								array_push($arraycert, "'" . $e . "'");
							}
						}
						$arraysym = array();
						if (isset($_POST[$shapesarray[$i] . 'sym'])) {
							foreach (($_POST[$shapesarray[$i] . 'sym']) as $e) {
								array_push($arraysym, "'" . $e . "'");
							}
						}
						$arraypolish = array();
						if (isset($_POST[$shapesarray[$i] . 'polish'])) {
							foreach (($_POST[$shapesarray[$i] . 'polish']) as $e) {
								array_push($arraypolish, "'" . $e . "'");
							}
						}
						$where = "(";
						$where .= "shape = '" . $shapesarray[$i] . "'";

						///////////////////////carat settings
						$carat1 = (isset($_POST['carat1' . $i])) ? floatval($_POST['carat1' . $i]) : 0;
						$carat2 = (isset($_POST['carat2' . $i])) ? floatval($_POST['carat2' . $i]) : 0;
						if ($carat1 > $carat2) {
							$update .= "set	carat1 = " . $carat2 . " , 	carat1 = " . $carat1;
							$where .= " and carat >= $carat2 and carat <= $carat1 ";
						} else {
							$update .= "set carat1 = " . $carat1 . " , 	carat2 = " . $carat2;
							$where .= " and carat >= $carat1 and carat <= $carat2 ";
						}

						////////////////////// tablepercentage settings
						$tablepercent1 = (isset($_POST['tablepercent1' . $i])) ? floatval($_POST['tablepercent1' . $i]) : 0;
						$tablepercent2 = (isset($_POST['tablepercent2' . $i])) ? floatval($_POST['tablepercent2' . $i]) : 0;
						if ($tablepercent1 > $tablepercent2) {
							$where .= " and TablePercent >= $tablepercent2 and TablePercent <= $tablepercent1 ";
							$update .= ", table1 = " . $tablepercent2 . " , 	table2 = " . $tablepercent1;
						} else {
							$where .= " and TablePercent >= $tablepercent1 and TablePercent <= $tablepercent2 ";
							$update .= ", table1 = " . $tablepercent1 . " , 	table2 = " . $tablepercent2;
						}
						////////////////////////// depth settings

						$depth1 = (isset($_POST['depth1' . $i])) ? floatval($_POST['depth1' . $i]) : 0;
						$depth2 = (isset($_POST['depth2' . $i])) ? floatval($_POST['depth2' . $i]) : 0;
						if ($depth1 > $depth2) {
							$where .= " and Depth >= $depth2 and Depth <= $depth1 ";
							$update .= ",	depth1 = " . $depth2 . " , 	depth2 = " . $depth1;
						} else {
							$where .= " and Depth >= $depth1 and Depth <= $depth2 ";
							$update .= ",	depth1 = " . $depth1 . " , 	depth2 = " . $depth2;
						}



						///////////////// color settings

						$color1 = (isset($_POST['color1' . $i])) ? $_POST['color1' . $i] : 0;
						$color2 = (isset($_POST['color2' . $i])) ? $_POST['color2' . $i] : 0;
						if ($color1 > $color2) {
							$where .= " and color in (" . implode(',', array_slice($colors, (int) $color2, ((int) ($color1 - $color2)) + 1)) . ") ";
							$update .= ",color1 = " . $color2 . " , color2 = " . $color1;
						} else {
							$where .= " and color in (" . implode(',', array_slice($colors, (int) $color1, ((int) ($color2 - $color1)) + 1)) . ") ";
							$update .= ",color1 = " . $color1 . " , color2 = " . $color2;
						}


						//////////////flour settings

						$flour1 = (isset($_POST['flour1' . $i])) ? $_POST['flour1' . $i] : 0;
						$flour2 = (isset($_POST['flour2' . $i])) ? $_POST['flour2' . $i] : 0;
						if ($flour1 > $flour2) {
							$where .= " and Flour in (" . implode(',', array_slice($flours, (int) $flour2, ((int) ($flour1 - $flour2)) + 1)) . ") ";
							$update .= ",	flour1 = " . $flour2 . " , 	flour2 = " . $flour1;
						} else {
							$where .= " and Flour in (" . implode(',', array_slice($flours, (int) $flour1, ((int) ($flour2 - $flour1)) + 1)) . ") ";
							$update .= ",	flour1 = " . $flour1 . " , 	flour2 = " . $flour2;
						}

						if (sizeof($arraycert) > 0) {
							$where .= " and cert in (" . (implode(',', $arraycert)) . ")";
							$update .= ", cert = '" . str_replace("'", "", implode(',', $arraycert)) . "'";
						}
						if (sizeof($arraysym) > 0) {
							$where .= " and Sym in (" . (implode(',', $arraysym)) . ")";
							$update .= ", symmertry = '" . str_replace("'", "", implode(',', $arraysym)) . "'";
						}
						if (sizeof($arraypolish) > 0) {
							$where .= " and polish in (" . (implode(',', $arraypolish)) . ") ";
							$update .= ", polish = '" . str_replace("'", "", implode(',', $arraypolish)) . "'";
						}

						$update .= ",export =1 where shape = '" . $shapesarray[$i] . "'";




						$where .= ")";




						array_push($wheres, $where);
					} else {
						$update .= " set export = 0 where shape ='" . $shapesarray[$i] . "'";
					}

					if (isset($_POST['savebasicsettings'])) {
						$this->adminmodel->savePriceScopeBasic($update);
					}
				}

				$wherecondition = implode(' or ', $wheres);
				if (isset($_POST['savebasicsettings'])) {

					$output = $this->load->view('admin/pricescopecsv', $data, true);
					$this->output($output, $data);
				} else {
					// var_dump($_POST);
					//var_dump($wherecondition);
					$csvname = isset($_POST['csvfilename']) ? $_POST['csvfilename'] . date('Y-m-d.h.i.s') . '.csv' : date('Y-m-d.h.i.s') . '.csv';
					$csvname = str_replace(' ', '', $csvname);
					$csvname = str_replace('_', '-', $csvname);
					header("Content-type:text/octect-stream");
					header("Content-Disposition:attachment;filename=" . $csvname);
					print $exportcsvstr . "\n";
					$results = $this->adminmodel->getPriceScopeCSV($exportqstr, $wherecondition);
					$fp = fopen(config_item('base_path') . 'exports/' . $csvname, 'w+');
					fwrite($fp, $exportcsvstr . "\n");
					foreach ($results as $result) {
						print '"' . stripslashes(implode('","', $result)) . "\"\n";
						fprintf($fp, '"' . stripslashes(implode('","', $result)) . "\"\n");
					}

					fclose($fp);
				}
				//$this->output($output , $data);
			} else {
				$output = $this->load->view('admin/pricescopecsv', $data, true);
				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function edittemplate($action = 'page', $id = '') {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#design").click();
										';


			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('edittemplate');

			if ($action == 'edit') {
				$data['id'] = $id;
				$data['templatedata'] = $this->adminmodel->getaddedittemplate('get', array(), $id);
				$filepath = config_item('base_path') . $data['templatedata']['tpath'];

				if (isset($_POST[$action . 'btn'])) {
					if (file_exists($filepath)) {
						$handle = fopen($filepath, "w");
						if (fwrite($handle, $_POST['content']) === FALSE) {
							$data['error'] = '<table width="100%" align="center"><tr><td width = "60"><img src="' . config_item('base_url') . '/images/error.gif"></td><td>ERROR !!Cannot write to file (' . $filepath . ') </td></tr>  </table>';
							exit;
						}
						$data['success'] = '<table width="100%" align="center"><tr><td width = "60"><img src="' . config_item('base_url') . '/images/ok.jpg"></td><td>Edit Success</td></tr>  </table>';
					}
				}

				if (file_exists($filepath)) {
					$handle = fopen($filepath, "r");
					$contents = fread($handle, filesize($filepath));
					fclose($handle);
					$data['content'] = $contents;
				}
			}

			$url = config_item('base_url') . 'admin/gettemplate';
			$data['action'] = $action;
			$data['onloadextraheader'] .= " $(\"#results\").flexigrid
				(
						{
						url: '" . $url . "',
						dataType: 'json',
						colModel : [
						{display: 'Resource Type', name : 'type', width : 200, sortable : true, align: 'left'},
						{display: 'Path', name : 'tpath', width : 250, sortable : true, align: 'left'},
						{display: 'Site Url', name : 'siteurl', width : 200, sortable : true, align: 'left'}
						],
						sortname: \"siteurl\",
						sortorder: \"asc\",
						usepager: true,
						title: '<h1 class=\"pageheader\">Template Resources</h1>',
						useRp: true,
						rp: 100,
						showTableToggleBtn: false,
						width:1025,
						height: 800
						}
				);
				";


			$data['extraheader'] = '
				<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

			$output = $this->load->view('admin/edittemplate', $data, true);


			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function gettemplate() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'id';


		$results = $this->adminmodel->gettemplate($page, $rp, $sortname, $sortorder, $query, $qtype);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['id'] . "',";
			$json .= "cell:['<a href=\"" . addslashes(config_item('base_url')) . "admin/edittemplate/edit/" . $row['id'] . "\">" . $row['type'] . " - Edit</a>'";
			$json .= ",'" . addslashes(config_item('base_path')) . addslashes(ucfirst($row['tpath'])) . "'";
			$json .= ",'<a href=\"" . addslashes(config_item('base_url')) . "" . addslashes($row['siteurl']) . "\" target=\"_blank\">" . addslashes(config_item('base_url')) . "" . addslashes($row['siteurl']) . "</a>'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function scrapingRedSellerdiomand($seller_id) {
		include_once("includes/simple_html_dom.php");
		$tab_header = array();
		$tab_content = array();
		$tab_inner_content = array();
		// create HTML DOM
		//  http://www.diamonds.net/Rapnet/Sells/SearchResults.aspx?SellerLogin=39427&DisplayList=1&TextSize=10&NumResults=1000&SortBy=-[LowestDiscount]%20desc,LowestPrice
		// search by pagination   "http://www.diamonds.net/rapnet/sells/SearchResults.aspx?SellerLogin=39427              &TextSize=10&NumResults=1000&SortBy=-[LowestDiscount]%20desc,LowestPrice
		//          http://www.diamonds.net/Rapnet/Sells/SearchResults.aspx?SellerLogin=39427&DisplayList=1&TextSize=10&NumResults=1000&SortBy=-[LowestDiscount]%20desc,LowestPrice
		$curlurl = "http://www.diamonds.net/rapnet/sells/SearchResults.aspx?SellerLogin=" . $seller_id . "&DisplayList=1&TextSize=10&NumResults=1000&SortBy=-[LowestDiscount]%20desc,LowestPrice";
		$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
		$url = $curlurl;
		set_time_limit(2400);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, '35696:samoa$velar');
		curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
		$user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		$curldata = curl_exec($ch);
		curl_close($ch);
		$html = str_get_html($curldata);

		foreach ($html->find('table[id="ctl00_ContentPlaceHolderMainContent_SearchResults1_gvResults"]') as $row) {
			$i = 0;
			$k = 0;
			if (!is_array($row)) {
				//echo $row;
				foreach ($row->find('tr') as $tr) {
					if ($i == 0) {
						foreach ($tr->find('th') as $val) {
							$tab_header[] = $val->plaintext;
						}
					} else {
						if ((($i + 10) % 10) == 1) {
							foreach ($tr->find('td') as $Tdval) {
								$tab_content[$k][] = $Tdval->plaintext;
							}
							$k++;
						} else if ((($i + 10) % 10) == 3) {
							foreach ($tr->find('table[class="resTable"]') as $innerTable) {
								foreach ($innerTable->find('tr td') as $innerText) {
									$tab_inner_content[$k - 1][] = $innerText->plaintext;
								}
							}
						}
					}
					$i++;
				}
			}
		}

		$database_product_info = array();
		foreach ($tab_content as $key => $table) {
			if (is_array($table)) {
				if (isset($tab_inner_content[$key])) {
					$database_product_info[$key]['lot'] = $tab_inner_content[$key][1];

					$database_product_info[$key]['owner'] = $table[6];
					$database_product_info[$key]['shape'] = $table[7];
					$database_product_info[$key]['carat'] = '0';
					$database_product_info[$key]['color'] = '';
					$database_product_info[$key]['clarity'] = $table[10];
					$database_product_info[$key]['price'] = ''; //Image
					$database_product_info[$key]['Rap'] = ''; //Image
					$database_product_info[$key]['Cert'] = ''; //Image
					$database_product_info[$key]['Depth'] = $table[18];
					$database_product_info[$key]['TablePercent'] = $table[19];
					$database_product_info[$key]['Girdle'] = $tab_inner_content[$key][9];
					$database_product_info[$key]['Culet'] = $tab_inner_content[$key][15];
					$database_product_info[$key]['Polish'] = $table[12];
					$database_product_info[$key]['Sym'] = $table[13];
					$database_product_info[$key]['Flour'] = $table[17];
					$database_product_info[$key]['Meas'] = $table[20];
					$database_product_info[$key]['Comment'] = $tab_inner_content[$key][29];
					$database_product_info[$key]['Stones'] = '';
					$database_product_info[$key]['Cert_n'] = '';
					$database_product_info[$key]['Stock_n'] = $tab_inner_content[$key][11];
					$database_product_info[$key]['Make'] = '';
					$database_product_info[$key]['Date'] = $tab_inner_content[$key][37];
					//explode city,state,country
					$location = $tab_inner_content[$key][23];
					$loc = explode(",", $location);
					$city = $loc[0];
					$state = $loc[1];
					$country = $loc[2];
					//--------------------------
					$database_product_info[$key]['City'] = $city;
					$database_product_info[$key]['State'] = $state;
					$database_product_info[$key]['Country'] = $country;
					$database_product_info[$key]['ratio'] = $tab_inner_content[$key][25];
					$database_product_info[$key]['cut'] = '';
					$database_product_info[$key]['tbl'] = '';
					$database_product_info[$key]['pricepercrt'] = '';
					$lot = $database_product_info[$key]['lot'];
					$database_product_info[$key]['tbl'] = '';
				}
			}
		}

		$html->clear();
		unset($html);
		foreach ($database_product_info as $cols) {

			$lot = isset($cols['lot']) ? $cols['lot'] : 0;
			$owner = isset($cols['owner']) ? $cols['owner'] : 'NA';
			$shape = isset($cols['shape']) ? $cols['shape'] : '';
			$carat = isset($cols['shape']) ? $cols['shape'] : '0';
			$color = isset($cols['color']) ? $cols['color'] : '';
			$clarity = isset($cols['clarity']) ? $cols['clarity'] : '';
			$cut = isset($cols['cut']) ? $cols['cut'] : '';
			$price = isset($cols['price']) ? $cols['price'] : '250';
			$Rap = isset($cols['Rap']) ? $cols['Rap'] : '0';
			$Cert = isset($cols['Cert']) ? $cols['Cert'] : '';
			$Depth = isset($cols['Depth']) ? $cols['Depth'] : '0';
			$TablePercent = isset($cols['TablePercent']) ? $cols['TablePercent'] : 'NA';
			$Girdle = isset($cols['Girdle']) ? $cols['Girdle'] : '';
			$Culet = isset($cols['Culet']) ? $cols['Culet'] : '';
			$Polish = isset($cols['Polish']) ? $cols['Polish'] : '';
			$Sym = isset($cols['Sym']) ? $cols['Sym'] : '';
			$Flour = isset($cols['Flour']) ? $cols['Flour'] : '';
			$Meas = isset($cols['Meas']) ? $cols['Meas'] : '0';
			$Comment = isset($cols['Comment']) ? '' : '';
			$Stones = isset($cols['Stones']) ? $cols['Stones'] : '';
			$Cert_n = isset($cols['Cert_n']) ? $cols['Cert_n'] : '';
			$Stock_n = isset($cols['Stock_n']) ? $cols['Stock_n'] : '';
			$Make = isset($cols['Make']) ? $cols['Make'] : '';
			$Date = isset($cols['Date']) ? $cols['Date'] : '';
			$City = isset($cols['City']) ? $cols['City'] : '';
			$State = isset($cols['State']) ? $cols['State'] : '';
			$Country = isset($cols['Country']) ? $cols['Country'] : '';


			$Cert = strtoupper($Cert);
			$ratio = ( isset($ratio) && $ratio != null) ? $ratio : ' ';
			//$price = $this->helixmodel->erdprice($price);

			$data = array('lot' => trim($lot),
                'owner' => trim($owner),
                'shape' => trim($shape),
                'carat' => trim($carat),
                'color' => trim($color),
                'clarity' => trim($clarity),
                'cut' => trim($cut),
                'price' => trim($price),
                'Rap' => trim($Rap),
                'Cert' => trim($Cert),
                'Depth' => trim($Depth),
                'TablePercent' => trim($TablePercent),
                'Girdle' => trim($Girdle),
                'Culet' => trim($Culet),
                'Polish' => trim($Polish),
                'Sym' => trim($Sym),
                'Flour' => trim($Flour),
                'Meas' => trim($Meas),
                'Comment' => trim($Comment),
                'Stones' => trim($Stones),
                'Cert_n' => trim($Cert_n),
                'Stock_n' => trim($Stock_n),
                'Make' => trim($Make),
                'Date' => trim($Date),
                'City' => trim($City),
                'State' => trim($State),
                'Country' => trim($Country),
                'ratio' => trim($ratio),
                'tbl' => ''
                );

                if (($this->helixmodel->lotExistRedSeller($lot)) == FALSE) {

                	$isinsert = $this->db->insert($this->config->item('table_perfix') . 'helix_productsredseller', $data);
                	$this->db->insert_id();
                }
		}
	}

	function ViewhelixRedSellerdiamonds($action = '') {
		$data = $this->getCommonData();
		if ($this->isadminlogin()) {

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('helixgetRedSellerView');
			$data['confirm'] = true;

			$url = config_item('base_url') . 'admin/getdiamonds/helix_productsredseller';
			$data['action'] = $action;
			$data['onloadextraheader'] = " $(\"#secondpane p.menu_head\").click(function()
													    {
														     $(this).css({backgroundImage:\"url(" . config_item('base_url') . "images/minus.jpg)\"}).next(\"div.menu_body\").slideDown(500).siblings(\"div.menu_body\").slideUp(\"slow\");
													         $(this).siblings().css({backgroundImage:\"url(" . config_item('base_url') . "images/plus.jpg)\"});
														});
														$(\"#rapnet\").click();
														
														$(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'Lot #', name : 'lot', width : 80, sortable : true, align: 'center'},
																		{display: 'Owner', name : 'owner', width : 85, sortable : true, align: 'center'},
																		{display: 'Shape', name : 'shape', width : 80, sortable : true, align: 'center'},
																		{display: 'Carat', name : 'carat', width : 80, sortable : true, align: 'center'},
																		{display: 'color', name : 'color', width : 50, sortable : true, align: 'center'},
																		{display: 'cut', name : 'cut', width : 100, sortable : true, align: 'left'},
																		{display: 'clarity', name : 'clarity', width : 80, sortable : true, align: 'center'},
																		{display: 'price', name : 'price', width : 60, sortable : true, align: 'center'},
																		{display: 'Rap', name : 'Rap', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Cert', name : 'Cert', width : 60, sortable : true, align: 'center'},
																		{display: 'Depth', name : 'Depth', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Table', name : 'TablePercent', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Girdle', name : 'Girdle', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Culet', name : 'Culet', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Polish', name : 'Polish', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Symetry', name : 'Sym', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Floururance', name : 'Flour', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Meas', name : 'Meas', width : 60, sortable : true, align: 'center',hide: false},
																		{display: 'Comment', name : 'Comment', width : 250, sortable : false, align: 'left'},
																		{display: 'Stones', name : 'Stones', width : 50, sortable : true, align: 'left'},
																		{display: 'Cert_n', name : 'Cert_n', width : 50, sortable : true, align: 'left'},
																		{display: 'Stock_n', name : 'Stock_n', width : 50, sortable : true, align: 'left'},
																		{display: 'Make', name : 'Make', width : 150, sortable : true, align: 'left'},
																		{display: 'City', name : 'City', width : 150, sortable : true, align: 'left'},
																		{display: 'State', name : 'State', width : 150, sortable : true, align: 'left'},
																		{display: 'Country', name : 'Country', width : 150, sortable : true, align: 'left'},
																		{display: 'ratio', name : 'ratio', width : 150, sortable : true, align: 'left'}
																		],
																		 buttons : [ {name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'lot', isdefault: true},
																		], 		
																	sortname: \"lot\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Rapnet Diamonds : Helix Diamonds Temp Table</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/gethelixdiamonds/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		 		
																	}
														 
														 ";


			$data['extraheader'] = ' <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script> <link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';





			$output = $this->load->view('admin/rapnetindex', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);

		$this->output($output, $data);
	}

	function product($action = 'view', $cid = 0, $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';

		$this->load->model('categorymodel');
		$this->load->model('productmodel');

		$catarray = $this->categorymodel->getCategoryName($cid);
		$data['category'] = $catarray;
		$view = $this->productmodel->getFieldHeadingLayout($catarray);
		$headerButton = $this->productmodel->getHeaderButton($catarray);
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->product($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					/* $this->form_validation->set_rules('price', 'Price', 'trim|required');
					 $this->form_validation->set_rules('brand', 'Brand', 'trim|required');
					 $this->form_validation->set_rules('uprice', 'User Price', 'trim|required');
					 $this->form_validation->set_rules('model_number', 'Model Number', 'trim|required');
					 $this->form_validation->set_rules('metal', 'Metal', 'trim|required');
					 $this->form_validation->set_rules('style', 'Style', 'trim|required');
					 $this->form_validation->set_rules('name', 'Name', 'trim|required');
					 $this->form_validation->set_rules('brand', 'Brand', 'trim|required');
					 $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
					 //$this->form_validation->set_rules('yellow_gold_price', 'Yellow Gold Price', 'trim|required');



					 $this->form_validation->set_error_delimiters('<font class="require">', '</font>'); */

					if (isset($_POST[$action . 'btn'])) {
						//		 	print_r($_POST);
						/* if ($this->form_validation->run() == FALSE){
						 $data['error'] = 'ERROR ! Please check the error fields';
						 if($action != 'edit')$data['details'] = $_POST;
						 }else { */
						$rootparentname = $this->productmodel->getRootParent($catarray);
						$ret = $this->adminmodel->product($_POST, $action, $rootparentname, $id);
						if ($ret['error'] == '')
						$data['success'] = $ret['success'];
						else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}

						//}
						//							die();
					}

					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					$data['collectionoptions'] = $this->commonmodel->makeoptions($this->adminmodel->getcollections(), 'collection', 'collection');
					//echo($catarray);
					$collections = $this->productmodel->defineAddField($catarray);


					$data['collections'] = $collections;

					$data['cid'] = $cid;
					if ($action == 'edit') {
						$data['id'] = $id;
						$data['details'] = $this->productmodel->getAllByStock1($id);
						//	print_r($data['details']);
						//exit();
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';

				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('product');
				$url = config_item('base_url') . 'admin/getproduct/' . $cid;
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																	$view
																		],
																		 buttons : [
																			$headerButton
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'id', isdefault: true},
																		{display: 'Product Name', name : 'price', isdefault: true},
																		], 		
																	sortname: \"id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Product Listing</h1>',
																	useRp: true,
																	rp: 100,

																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/product/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/product/add/$cid';
																			}			
																	}
														 
														 ";


																			$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
																			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

																			$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
																			$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
																			$data['onloadextraheader'] .= "
											var so;				
		 									";
																			$data['usetips'] = true;



																			$output = $this->load->view('admin/product', $data, true);


																			$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getproduct($cid, $addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : $cid;
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'categoryid';

		$this->load->model('categorymodel');
		$this->load->model('productmodel');

		$catarray = $this->categorymodel->getCategoryName($cid);
		$parent = $this->productmodel->getRootParent($catarray);
		$viewField = $this->productmodel->defineViewFieldValue($catarray);
		//print_r($viewField);
		//								echo($cid);

		$results = $this->adminmodel->getproduct($page, $rp, $sortname, $sortorder, $cid, 'categoryid', '', $parent);

		//print_r($results);
		//								echo("here");
		//							exit();
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['ProductID'] . "',";
			$json .= "cell:['Lot #: " . $row['ProductID'] . "<br /><a href=\'" . config_item('base_url') . "admin/product/edit/" . $cid . "/" . $row['ProductID'] . "\'  class=\"edit\">Edit Product</a>'";

			foreach ($viewField as $field) {
				//echo($field['type']);
				if ($field['type'] == 'text') {
					$json .= ",'" . $row[$field['field']] . "'";
				} elseif ($field['type'] == 'shape') {
					$json .= ",'" . addslashes($this->productmodel->getProductShape($row[$field['field']])) . "'";
				} elseif ($field['type'] == 'price') {
					$json .= ",'$" . $row ['salePriceProduct'] . "'";
				} elseif ($field['type'] == 'image') {
					$json .= ",'" . $filepath . addslashes($this->productmodel->getProductImage($row[$field['field']])) . "'";
				} elseif ($field['type'] == 'link') {
					$json .= ",'" . $this->productmodel->getLink($catarray['category_name'], $row[$field['field']], $row) . "'";
				} else {
					$json .= ",'" . $row[$field['field']] . "'";
				}
			}
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function rolex($action = 'view', $id = 0) {

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['brandoptions'] = $this->adminmodel->getWatchBrand(); // $this->commonmodel->makeoptions($this->adminmodel->getWatchBrand() , 'brand_name' , 'brand_name');
		$data['extraheader'] = '';

		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->rolex($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit' || $action == 'saveandeditbtn') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('price', 'Price', 'trim|required');
					$this->form_validation->set_rules('brand', 'Brand', 'trim|required');
					$this->form_validation->set_rules('model_number', 'Model Number', 'trim|required');
					$this->form_validation->set_rules('metal', 'Metal', 'trim|required');
					$this->form_validation->set_rules('style', 'Style', 'trim|required');
					$this->form_validation->set_rules('name', 'Name', 'trim|required');
					$this->form_validation->set_rules('brand', 'Brand', 'trim|required');
					$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
					//$this->form_validation->set_rules('yellow_gold_price', 'Yellow Gold Price', 'trim|required');



					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn']) || isset($_POST['saveandeditbtn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';
							if ($action != 'edit')
							$data['details'] = $_POST;
						}else if ($_POST['saveandeditbtn']) {
							$ret = $this->adminmodel->rolex($_POST, $action, $id);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
							$id = '';
							$ret = $this->adminmodel->saverolex($_POST, $action, $id);
							$link = "http://gemnile.com/admin/rolex/edit/$ret";
							echo "<script>window.location.href='$link'</script>";
							exit;
						} else {
							$ret = $this->adminmodel->rolex($_POST, $action, $id);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
						//							die();
					}

					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					//        $data['collectionoptions'] = $this->commonmodel->makeoptions($this->adminmodel->getcollections() , 'collection' , 'collection');
					//     $data['sectionoptions'] = $this->commonmodel->makeoptions($this->adminmodel->getsections(), 'section' , 'section');
					//		 $data['brandoptions'] = $this->commonmodel->makeoptions($this->adminmodel->getWatchBrand() , 'brand' , 'brand');

					if ($action == 'edit') {
						$this->load->model('rolexmodel');
						$this->load->model('watchesmodel');
						$data['details'] = $this->watchesmodel->getWatchByProductId($id);
						$details = $data['details'];

						$data['animations'] = $this->adminmodel->getFlashByStockId($id);
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';

				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('rolex');
				$url = config_item('base_url') . 'admin/getrolex';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'productID', width : 80, sortable : true, align: 'center'},
																		{display: 'Retail Price', name : 'price1', width : 85, sortable : true, align: 'center'},
																		{display: 'List Price', name : 'price1', width : 120, sortable : true, align: 'center'},
																		{display: 'Brand', name : 'brand', width : 120, sortable : true, align: 'center'},
																		{display: 'Upc(For Amazon Product)', name : 'upc', width : 120, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Quantity', name : 'qty', width : 50, sortable : true, align: 'center'},
																		{display: 'Model Number', name : 'model_number', width : 75, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Lowest Price', name : 'lowest_price', width : 75, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Amazon highest price', name : 'highest_price', width : 75, sortable : true, align: 'center'},
                                                                                                                                                              
																		{display: 'Metal', name : 'metal', width : 125, sortable : true, align: 'center'},
																		{display: 'Style', name : 'style', width : 60, sortable : true, align: 'center'},
																		{display: 'Gender', name : 'gender', width : 60, sortable : true, align: 'center',hide: true}
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
                                                                                    {name: 'Delete', bclass: 'delete', onpress : test},
                                                                                    {name: 'Multiple Edit Submit', bclass: 'multiple', onpress : test1},
                                                                                     {separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'ProductID', isdefault: true},
																		{display: 'Gender', name : 'gender', isdefault: true},
																		{display: 'Brand', name : 'brand', isdefault: false},
                                                                                                                                                {display: 'Model', name : 'model_number', isdefault: false}
																		
																		], 		
																	sortname: \"productID\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Manage Watches</h1>',
																	useRp: true,
																	rp: 10,
																	showTableToggleBtn: false,
																	width:1025,
																	height: 800
																	}
																	);

                                                                                                                                        function test1(){
                                                                                                                                                    //alert(document.getElementById('price1_4').value);  
                                                                                                                                             document.mywatchfrm.submit();
                                                                                                                                        }
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/rolex/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/rolex/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/rolex', $data, true);

				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function fedex($id = null) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['name'] = $this->getAdminDetails();
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			if (isset($_POST['shipped_fedex'])) {
				$ret = $this->adminmodel->amzorders($_POST, $action, $id);
				if ($ret['error'] == '')
				$data['success'] = $ret['success'];
			}

			$data['extraheader'] .= $this->commonmodel->addEditor('simple');
			//     $data['collectionoptions'] = $this->commonmodel->makeoptions($this->adminmodel->getcollections() , 'collection' , 'collection');

			$data['details'] = $this->adminmodel->getOrderByOrderId($id);
			$details = $data['details'];
			//$data['collections'] =$collections;
			$data['animations'] = $this->adminmodel->getFlashByStockId($id);
			$data['id'] = $id;
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('order');
			//  $url = config_item('base_url').'admin/getrolex';
			$data['action'] = $action;

			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>';
			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>';
			$data['onloadextraheader'] .= "
											var so;				
		 									";
			$data['usetips'] = true;
			$output = $this->load->view('admin/fedex', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function usps($id = null) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			if (isset($_POST['shipped_usps'])) {
				$ret = $this->adminmodel->uspsorders($_POST, $action, $id);
				if ($ret['error'] == '')
				$data['success'] = $ret['success'];
			}

			$data['extraheader'] .= $this->commonmodel->addEditor('simple');

			$data['details'] = $this->adminmodel->getOrderByOrderId($id);
			$details = $data['details'];
			$data['collections'] = $collections;
			$data['animations'] = $this->adminmodel->getFlashByStockId($id);
			$data['id'] = $id;
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';

			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('fullfillments');
			//  $url = config_item('base_url').'admin/getrolex';
			$data['action'] = $action;

			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>';
			$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>';
			$data['onloadextraheader'] .= "
											var so;				
		 									";
			$data['usetips'] = true;
			$output = $this->load->view('admin/usps', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getrolex($addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 100;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'productID';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';

		$results = $this->adminmodel->getrolex($page, $rp, $sortname, $sortorder, $query, $qtype);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		//$json .= "<form>,\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$i = 0;
		$totalResult = sizeof($results['result']);

		foreach ($results['result'] as $row) {
			$shape = '';
			$productID = $row['productID'];
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['productID'] . "',";
			$json .= "cell:['Lot #: " . $row['productID'] . "<br /><a href=\'" . config_item('base_url') . "admin/rolex/edit/" . $row['productID'] . "\'  class=\"edit\">Edit Lot</a>'";
			if ($i == 0) {
				//   $json .= ",'<form  action=\"http://mywatchdepotny.com/development/admin/updaterolexgroup\" method=\"POST\" name=\"WatchBox\" >'";
				//   $json .= ",'<form src=\'".config_item('base_url').addslashes($row['thumb'])."\' width=\'80\'><br />$ ".addslashes($row['price1'])."'";
			}
			//$json .= "form:'<form name='mywatch'>',";
			//if(file_exists(config_item('base_path').addslashes($row['thumb'])) && $row['thumb'] != '')
			$url = config_item('base_url');
			if ($row['thumb'] != '')
			//$json .= ",'<img src=\'".config_item('base_url').addslashes($row['thumb'])."\' width=\'80\'><br />$ ".addslashes($row['price1'])."'";
			$json .= ",'<img src=\'" . $url . addslashes($row['thumb']) . "\' width=\'80\'><br />$ " . addslashes($row['price1']) . "'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />$ " . addslashes($row['price1']) . "'";
			if ($query != '') {

				$json .= ",'<input type=\"text\" name=\"price1_$i\" style=\"width:50px;\"   id=\"price1_$i\"    value=" . ($row['price1']) . " /><input type=\"hidden\" name=\"pid_$i\" style=\"width:50px;\"   id=\"pid_$i\"    value=" . addslashes($row['productID']) . " />'";
				$json .= ",'<input type=\"text\" name=\"brand_$i\" style=\"width:100px;\"  id=\"brand_$i\"   value=" . addslashes($row['brand']) . " />'";
				$json .= ",'<input type=\"text\" name=\"upc_$i\" style=\"width:120px;\"  id=\"upc_$i\"   value=" . addslashes($row['upc']) . " />'";
				$json .= ",'<input type=\"text\" name=\"qty_$i\"  style=\"width:50px;\"  id=\"qty_$i\"   value=" . addslashes($row['qty']) . " />'";
				$json .= ",'<input type=\"text\" name=\"model_$i\"  style=\"width:120px;\"   id=\"model_$i\"   value=" . addslashes($row['model_number']) . " />'";
				$json .= ",'<input type=\"text\" name=\"lowest_$i\"  style=\"width:120px;\"   id=\"lowest_$i\"   value=" . addslashes($row['lowest_price']) . " />'";
				$json .= ",'<input type=\"text\" name=\"highest_$i\"  style=\"width:120px;\"   id=\"highest_$i\"   value=" . addslashes($row['highest_price']) . " />'";
				if ($row['metal'] == 'gold')
				$metal = 'Gold';
				elseif ($row['metal'] == 'ss')
				$metal = 'Stainless Steel';
				else
				$metal = 'Stainless Steel and Gold';
				$json .= ",'" . addslashes($metal) . "'";
				$json .= ",'" . addslashes(ucfirst($row['style'])) . "'";
				if ($i == 0) {
					$json .= ",'<input type=\"hidden\" name=\"totalResult\" id=\"totalResult\"    value=" . ($totalResult) . " />'";
				}
				/*
				 *
				 *
				 $json .= ",'".addslashes($row['brand'])."'";
				 $json .= ",'".addslashes($row['upc'])."'";
				 $json .= ",'".addslashes($row['qty'])."'";
				 $json .= ",'".addslashes($row['model_number'])."'";
				 */

				if ($row['metal'] == 'gold')
				$metal = 'Gold';
				elseif ($row['metal'] == 'ss')
				$metal = 'Stainless Steel';
				else
				$metal = 'Stainless Steel and Gold';
				$json .= ",'" . addslashes($metal) . "'";
				$json .= ",'" . addslashes(ucfirst($row['style'])) . "'";
				$json .= ",'" . addslashes(ucfirst($row['gender'])) . "'";
				//                                $json .= ",'<input type=\"hidden\" name=\"totalResult\" id=\"totalResult\"    value=".($totalResult)." />'";
				$json .= ",'<input type=\"hidden\" name=\"productid_$i\" id=\"productid_$i\"    value=" . addslashes($productID) . " />'";
			}else {
				//$json
				$json .= ",'" . addslashes($row['price1']) . "'";
				$json .= ",'" . addslashes($row['brand']) . "'";
				$json .= ",'" . addslashes($row['upc']) . "'";
				$json .= ",'" . addslashes($row['qty']) . "'";
				$json .= ",'" . addslashes($row['model_number']) . "'";
				if ($row['metal'] == 'gold')
				$metal = 'Gold';
				elseif ($row['metal'] == 'ss')
				$metal = 'Stainless Steel';
				else
				$metal = 'Stainless Steel and Gold';
				$json .= ",'" . addslashes(ucfirst($row['lowest_price'])) . "'";
				$json .= ",'" . addslashes(ucfirst($row['highest_price'])) . "'";
				$json .= ",'" . addslashes($metal) . "'";
				$json .= ",'" . addslashes(ucfirst($row['style'])) . "'";
				$json .= ",'" . addslashes(ucfirst($row['gender'])) . "'";
			}
			$json .= "]";
			$json .= "}";
			$rc = true;
			$i = $i + 1;
		}

		$json .= "]\n";
		$json .= "}";
		//      $json = str_replace("</form>", " ", $json);
		//echo "<script>alert('$json'";
		echo $json;
	}

	function mount($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';

		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->jewelries($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('price', 'Price', 'trim|required');
					$this->form_validation->set_rules('section', 'Section', 'trim|required');
					$this->form_validation->set_rules('collection', 'Collection', 'trim|required');
					$this->form_validation->set_rules('shape', 'Shape', 'trim|required');
					$this->form_validation->set_rules('metal', 'Metal', 'trim|required');
					$this->form_validation->set_rules('style', 'Style', 'trim|required');
					$this->form_validation->set_rules('name', 'Name', 'trim|required');
					$this->form_validation->set_rules('platinum_price', 'Platinum Price', 'trim|required');
					$this->form_validation->set_rules('white_gold_price', 'White Gold Price', 'trim|required');
					$this->form_validation->set_rules('yellow_gold_price', 'Yellow Gold Price', 'trim|required');



					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';
							if ($action != 'edit')
							$data['details'] = $_POST;
						}else {

							$ret = $this->adminmodel->jewelries($_POST, $action, $id);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
					}

					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					$data['collectionoptions'] = $this->commonmodel->makeoptions($this->adminmodel->getcollections(), 'collection', 'collection');
					//$data['sectionoptions'] = $this->commonmodel->makeoptions($this->adminmodel->getsections(), 'section' , 'section');

					if ($action == 'edit') {
						$this->load->model('jewelrymodel');
						$data['details'] = $this->jewelrymodel->getAllByStock($id);
						$details = $data['details'];

						switch ($details['section']) {
							case 'Earrings':
								$collections = '<option value="DiamondStud">Diamond Stud Earrings</option>
											  <option value="BuildEarring">Build Your Own Earrings</option>
											';
								break;
							case 'EngagementRings':
								$collections = '
												<option value="International Collection">International Collection</option>
											';
								break;
							case 'Jewelry':
								$collections = '
												<option value="MensWeddingRing">Men\'s Wedding Rings</option>  
									            <option value="WomensWeddingRing">Women\'s Wedding Rings</option>  
										 		<option value="WomensAnniversaryRing">Women\'s Anniversary Rings</option> 
											 	';
								break;
							case 'Pendants':
								$collections = '
												<option value="BuildPendant">Build your own Pendants</option>
											';
								break;
							default:
								break;
						}
						$data['collections'] = $collections;


						$data['animations'] = $this->adminmodel->getFlashByStockId($id);
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';

				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('mount');
				$url = config_item('base_url') . 'admin/getmounts';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'stock_number', width : 80, sortable : true, align: 'center'},
																		{display: 'Price', name : 'price', width : 85, sortable : true, align: 'center'},
																		{display: 'Section', name : 'section', width : 120, sortable : true, align: 'center'},
																		{display: 'Collection', name : 'collection', width : 120, sortable : true, align: 'center'},
																		{display: 'Shape', name : 'shape', width : 50, sortable : true, align: 'center'},
																		{display: 'Metal', name : 'metal', width : 80, sortable : true, align: 'center'},
																		{display: 'Style', name : 'style', width : 60, sortable : true, align: 'center'},
																		{display: 'Carat', name : 'carat', width : 60, sortable : true, align: 'center',hide: true},
																		{display: 'Total Carats', name : 'total_carats', width : 60, sortable : true, align: 'center'},
																		{display: 'Diamond Count', name : 'diamond_count', width : 60, sortable : true, align: 'center',hide: true},
																		{display: 'Diamond Size', name : 'diamond_size', width : 60, sortable : true, align: 'center',hide: true},
																		{display: 'Pearl Lenght', name : 'pearl_lenght', width : 60, sortable : true, align: 'center',hide: true},
																		{display: 'Pearl mm', name : 'pearl_mm', width : 60, sortable : true, align: 'center',hide: true},
																		{display: 'Semi mounted', name : 'semi_mounted', width : 60, sortable : true, align: 'center',hide: true},
																		{display: 'Side', name : 'side', width : 60, sortable : true, align: 'center',hide: true},
																		{display: 'Carat image', name : 'carat_image', width : 60, sortable : true, align: 'center',hide: true},
																		{display: 'Description', name : 'description', width : 250, sortable : false, align: 'left'}
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
																				{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'stock_number', isdefault: true},
																		{display: 'Shape', name : 'shape', isdefault: true},
																		{display: 'Style', name : 'style', isdefault: false}
																		
																		], 		
																	sortname: \"stock_number\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Semi Mounts</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/mount/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/mount/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/mount', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getmounts($addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'stock_number';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';


		$results = $this->adminmodel->getmounts($page, $rp, $sortname, $sortorder, $query, $qtype);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['stock_number'] . "',";
			$json .= "cell:['Lot #: " . $row['stock_number'] . "<br /><a href=\"javascript:void(0)\" onclick=\"jewelrydetails(" . $row['stock_number'] . ");\" class=\"edit\">View Details</a>'";
			if (file_exists(config_item('base_path') . 'images/rings/' . addslashes($row['small_image'])) && $row['small_image'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/" . addslashes($row['small_image']) . "\' width=\'80\'><br />$ " . addslashes($row['price']) . "'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />$ " . addslashes($row['price']) . "'";
			$json .= ",'" . addslashes($row['section']) . "'";
			$json .= ",'" . addslashes($row['collection']) . "'";
			$json .= ",'" . addslashes($row['shape']) . "'";
			$json .= ",'" . addslashes($row['name']) . "'";
			$json .= ",'" . addslashes($row['metal']) . "'";
			$json .= ",'" . addslashes($row['style']) . "'";
			$json .= ",'" . addslashes($row['carat']) . "'";
			$json .= ",'" . addslashes($row['total_carats']) . "'";
			$json .= ",'" . addslashes($row['diamond_count']) . "'";
			$json .= ",'" . addslashes($row['diamond_size']) . "'";
			$json .= ",'" . addslashes($row['pearl_lenght']) . "'";
			$json .= ",'" . addslashes($row['pearl_mm']) . "'";
			$json .= ",'" . addslashes($row['semi_mounted']) . "'";
			$json .= ",'" . addslashes($row['side']) . "'";
			$json .= ",'" . addslashes($row['carat_image']) . "'";
			$json .= ",'" . str_replace("\r", '<br />', str_replace("\n", '<br />', addslashes($row['description']))) . "'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function category($action = 'view', $cid = 0, $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['name'] = $this->getAdminDetails();
		$data['collections'] = '';
		$data['typeoptions'] = '';

		$this->load->model('categorymodel');
		$this->load->model('productmodel');

		$catarray = $this->categorymodel->getCategoryName($cid);
		$data['category'] = $catarray;

		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->category($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {


					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('category_label', 'category_name', 'trim|required');
					//$this->form_validation->set_rules('yellow_gold_price', 'Yellow Gold Price', 'trim|required');



					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {
						//		 	print_r($_POST);
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';
							if ($action != 'edit')
							$data['details'] = $_POST;
						}else {

							$rootparentname = $this->productmodel->getRootParent($catarray);
							$ret = $this->adminmodel->category($_POST, $action, $rootparentname, $id);
							$ret = $this->adminmodel->category($_POST, $action, $id);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
						//							die();
					}

					$data['extraheader'] .= $this->commonmodel->addEditor('simple');

					if ($action == 'edit') {

						$data['details'] = $this->categorymodel->getAllByStock($id);
						$details = $data['details'];
						$data['cid'] = $cid;
						$data['id'] = $id;
					}
				}
				$prodButton = '';
				if ($cid != '0') {
					$prodButton = "{name: 'Add Product', bclass: 'add', onpress : test},";
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';

				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('other');
				$url = config_item('base_url') . 'admin/getcategory/' . $cid;
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'id', width : 120, sortable : true, align: 'center'},
																		{display: 'Category Name', name : 'category_name', width : 300, sortable : true, align: 'center'},
																		{display: 'Category Image', name : 'image', width : 250, sortable : true, align: 'center'},
																		{display: 'Total Products', name : '', width : 120, sortable : false, align: 'center'}
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
																				{name: 'Delete', bclass: 'delete', onpress : test},
																				$prodButton
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'id', isdefault: true},
																		{display: 'Category Name', name : 'category_name', isdefault: true}
																		], 		
																	sortname: \"id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Category Listing</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																								//var url = 'admin/category/delete/'+itemlist;

																                                //prompt('a', url);
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/category/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										}
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/category/add/$cid';
																			}
																		else if (com=='Add Product')
																			{
																				window.location = '" . config_item('base_url') . "admin/product/add/$cid';
																			}		
																	}
														 
														 ";


																				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
																				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

																				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
																				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
																				$data['onloadextraheader'] .= "
											var so;				
		 									";
																				$data['usetips'] = true;



																				$output = $this->load->view('admin/category', $data, true);


																				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getcategory($id = 0, $addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'category_name';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'category_name';


		$results = $this->adminmodel->getcategory($page, $rp, $sortname, $sortorder, $query, $qtype, $id);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");

		header("Content-type: text/x-json");

		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$this->load->model('categorymodel');
		$this->load->model('productmodel');

		$catarray = $this->categorymodel->getCategoryName($id);
		//$parentname = $this->productmodel->getRootParent($catarray);

		foreach ($results['result'] as $row) {
			$shape = '';
			$catarray = $this->categorymodel->getCategoryName($row['id']);
			$parentname = $this->productmodel->getRootParent($catarray);
			$count = $this->adminmodel->getCategoryCount($row['id']);
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['id'] . "',";
			$json .= "cell:['Lot #: " . $row['id'] . "<br /><a href=\'" . config_item('base_url') . "admin/category/view/" . $row['id'] . "\'  class=\"edit\">View Category ($count[total])</a><br /><a href=\'" . config_item('base_url') . "admin/category/edit/" . $row['parentid'] . "/" . $row['id'] . "\'  class=\"edit\">Edit Category</a>'";
			$count = $this->adminmodel->getProductCount($row['id'], $parentname);
			$json .= ",'" . addslashes($row['category_label']) . "'";
			//$filepath = 'images/category/'.$parentname.'/'.$row['image'];
			$json .= ",'" . $this->productmodel->getProductImage($row['image']) . "'";
			$json .= ",'<a href=\'" . config_item('base_url') . "admin/product/view/" . $row['id'] . "\'  class=\"edit\">View Product (" . $count['total'] . ")</a>'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function upload($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';

		if ($this->isadminlogin()) {
			if ($_POST) {
				if ($action == 'add') {
					$destination = config_item('base_path') . 'upload/bomifeed.csv';
					if (file_exists($destination))
					unlink($destination);

					move_uploaded_file($_FILES['uploadcsv']['tmp_name'], $destination);
					if (file_exists($destination)) {
						$handle = fopen($destination, "r");

						$r = $this->adminmodel->emptyhelix();
						//foreach ($rows as $row)
						$i = 0;
						while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
							//echo '<pre>';
							//print_r($data);
							if ($i > 0) {
								//$cols = explode(',' , $row);
								//	print_r($cols);
								$t = $this->adminmodel->saveinhelix($data);
							}
							$i++;
						}
						$t = $this->adminmodel->fixhelix();
					}
				}
			}
			$data['extraheader'] .= ' <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';

			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

			$data['extraheader'] .= '
				<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
			$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
			$data['onloadextraheader'] .= " var so;";
			$data['usetips'] = true;
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('rolex');
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('uploadbomicsv');
			$output = $this->load->view('admin/bomiupload', $data, true);


			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function updaterolexgroup() {
		//   $total = $_REQUEST['totalResult'];
		$data['name'] = $this->getAdminDetails();
		$this->adminmodel->updateRolex($_REQUEST);
	}

	function cronEbayOrderUpload($action = 'view', $id = 0) {
		@mail("pardeepsingal1@gmail.com", 'Cron Ebay Orders', 'cron ebay orders file  is started at ' . date('Y-m-d H:i:s'), "From: \"MywatchDepotNy\"");
		$path_to_file = config_item('base_url') . "Sales-Paid.csv";
		$handle = fopen($path_to_file, "r");
		//read file line by line
		while (($record = fgetcsv($handle, filesize($path_to_file), ",")) !== FALSE) {
			if (isset($record)) {
				$t = $this->adminmodel->updateorders($record);
			}
		}
		fclose($handle);
	}

	function getAttribute($addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 100;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';

		$results = $this->adminmodel->getattribute($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		//$json .= "<form>,\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';
			$productID = $row['id'];
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['id'] . "',";
			$json .= "cell:['ID #: " . $row['id'] . "<br /><a href=\'" . config_item('base_url') . "admin/attribute/edit/" . $row['id'] . "\'  class=\"edit\">Edit </a>'";

			//$json
			if ($row['option_name'] == '1')
			$metal = 'Metal';
			else
			$metal = 'Chain Style';
			$json .= ",'" . addslashes($metal) . "'";
			$json .= ",'" . addslashes($row['option_value']) . "'";
			$json .= ",'" . addslashes($row['option_price']) . "'";
			$json .= ",'" . addslashes($row['dateofmodification']) . "'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}

		$json .= "]\n";
		$json .= "}";

		echo $json;
	}

	function getnameplate($addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 100;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'product_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'product_name';
		$results = $this->adminmodel->getnameplate($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		foreach ($results['result'] as $row) {
			$productID = $row['product_id'];
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['product_id'] . "',";
			$json .= "cell:['ID #: " . $row['product_id'] . "<br /><a href=\'" . config_item('base_url') . "admin/nameplate/edit/" . $row['product_id'] . "\'  class=\"edit\">Edit </a>'";
			//$json
			if ($row['product_image'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . "images/" . addslashes($row['product_image']) . "\' width=\'80\'><br />$ " . addslashes($row['product_price']) . "'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />$ " . addslashes($row['product_price']) . "'";

			$json .= ",'" . addslashes($row['product_name']) . "'";
			$json .= ",'" . addslashes($row['product_price']) . "'";
			$json .= ",'" . addslashes($row['product_code']) . "'";
			$json .= ",'" . addslashes($row['dateofmodification']) . "'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function attribute($action = 'view', $cid = 0, $id = 0) {

		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->attribute($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {

					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('option_value', 'OptionValue', 'trim|required');
					$this->form_validation->set_rules('option_price', 'OptionPrice', 'trim|required');
					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';

							if ($action != 'edit')
							$data['details'] = $_POST;
						}else {
							$ret = $this->adminmodel->attribute($_POST, $action, $cid);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}
						//							die();
					}

					$data['extraheader'] .= $this->commonmodel->addEditor('simple');

					if ($action == 'edit') {
						$this->load->model('adminmodel');
						$data['details'] = $this->adminmodel->getattributeById($cid);
						$details = $data['details'];
						$data['id'] = $cid;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#jewelrymanage").click();
										 
										';

				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('attribute');
				$url = config_item('base_url') . 'admin/getAttribute';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'id', width : 80, sortable : true, align: 'center'},
																		{display: 'Option Name', name : 'option_name', width : 85, sortable : true, align: 'center'},
																		{display: 'Option Value', name : 'option_value', width : 85, sortable : true, align: 'center'},
																		{display: 'Option Price', name : 'option_price', width : 60, sortable : true, align: 'center'},
																			{display: 'Date', name : 'dateofmodification', width : 60, sortable : true, align: 'center'}
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
                                                                                                                                                            {name: 'Delete', bclass: 'delete', onpress : test},
                                                                                                                                                              {separator: true}
																			],
																	searchitems : [
																		
																		{display: 'Option Name', name : 'option_name', isdefault: false},
                                                                                   {display: 'Option Value', name : 'option_value', isdefault: false}
																		
																		], 		
																	sortname: \"id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Attribute Controller</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);

                                                                                                                                        
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/attribute/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/attribute/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/attribute', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function nameplate($action = 'view', $cid = 0, $id = 0) {
		$data = $this->getCommonData();
		$data['extraheader'] = '';
		$data['name'] = $this->getAdminDetails();
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->nameplate($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {

					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');

					$this->form_validation->set_rules('product_code', 'ProductCode', 'trim|required');
					$this->form_validation->set_rules('product_name', 'ProductName', 'trim|required');
					$this->form_validation->set_rules('product_price', 'ProductPrice', 'trim|required');
					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');

					if (isset($_POST[$action . 'btn'])) {
						if ($this->form_validation->run() == FALSE) {
							$data['error'] = 'ERROR ! Please check the error fields';

							if ($action != 'edit')
							$data['details'] = $_POST;
						}else {

							$ret = $this->adminmodel->nameplate($_POST, $action, $cid, $_FILES);
							if ($ret['error'] == '')
							$data['success'] = $ret['success'];
							else {
								$data['error'] = $ret['error'];
								if ($action != 'edit')
								$data['details'] = $_POST;
							}
						}

						//							die();
					}

					$data['extraheader'] .= $this->commonmodel->addEditor('simple');



					if ($action == 'edit') {
						$this->load->model('adminmodel');
						$data['details'] = $this->adminmodel->getnameplateById($cid);
						$details = $data['details'];
						$data['id'] = $cid;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
							   	        {
									 $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
								         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
									});
									$("#jewelrymanage").click();

										 
										';

				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('nameplate');
				$url = config_item('base_url') . 'admin/getnameplate';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'product_id', width : 80, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Product Image', name : 'product_image', width : 80, sortable : true, align: 'center'},
																		{display: 'Product Name', name : 'product_name', width : 85, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Product Price', name : 'product_price', width : 85, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Product Code', name : 'product_code', width : 85, sortable : true, align: 'center'},          
																		{display: 'Date', name : 'dateofmodification', width : 60, sortable : true, align: 'center'}
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
                                                                                                                                                            {name: 'Delete', bclass: 'delete', onpress : test},
                                                                                                                                                              {separator: true}
																			],
																	searchitems : [
																		
																		{display: 'Product name', name : 'product_name', isdefault: false},
                                                                                                                                                {display: 'Product code', name : 'product_code', isdefault: false}
																		
																		], 		
																	sortname: \"product_id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">NamePlate Items</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height:800
																	}
																	);

                                                                                                                                        
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/nameplate/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
                                                                                                                                                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/nameplate/add';
																			}			
																	}
														 
														 ";
				$data['extraheader'] .= '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
				$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>';
				$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;
				$output = $this->load->view('admin/nameplate', $data, true);
				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function generateXMLStamp($id) {
		$order = $this->adminmodel->getordersById($id);
		$xml = '<?xml version="1.0" ?>';
		$xml .= '<Print mlns="http://stamps.com/xml/namespace/2009/8/Client/BatchProcessingV1">';
		$xml .= '<Configuration><ResultFile>C:\Documents and Settings\Administrator\Desktop\printed-a-shippingbatch.xml</ResultFile>';
		$xml .='<DesiredPrinter>
                      <Name>SeoWeb Printer</Name>
                     <Bin>Tray 2</Bin>
            </DesiredPrinter>
          <MailingCutoffTime>17:30:00.0</MailingCutoffTime>
          <Rollover>false</Rollover>
          <SenderEmailOptions>
              <DeliveryNotification />
              <ShipmentNotification />
        </SenderEmailOptions>
      <RecipientEmailOptions>
        <ShipmentNotification companyInSubject="true" fromCompany="true" />
      </RecipientEmailOptions>
        </Configuration>';
		$xml .='<Layout>
              <Desired>
              <MediaName>MyWatchDepot.com SDC-1200 Standard 4x6 label 2 per sheet</MediaName>
              <StartCol>1</StartCol>
              <StartRow>1</StartRow>
              <Style>
                    <IndiciumGraphic>XYZ</IndiciumGraphic>
                    <RecipientAddressFontName>Helvetica</RecipientAddressFontName>
                    <RecipientAddressFontSize>10</RecipientAddressFontSize>
                    <ReturnAddressFontName>Arial</ReturnAddressFontName>
                    <ReturnAddressFontSize>11</ReturnAddressFontSize>
                    <ReturnAddressGraphic>C:\Documents and Settings\Administrator\Desktop\Stamp\FileName.gif</ReturnAddressGraphic>
            </Style>
            </Desired>
            <PrintReceipt>true</PrintReceipt>
          </Layout>
            <Item>
                  <OrderDate>' . $order['purchase-date'] . '</OrderDate>
                  <OrderID>' . $order['orderid'] . '</OrderID>
                <PrintedMemo>Date ' . $order['purchase-date'] . '</PrintedMemo>
              <Services>
                    <CertifiedMail />
                    <DeliveryConfirmation />
            </Services>
            <Recipient>
            <AddressFields>
              <NamePrefix>Mr.</NamePrefix>
             <FirstName>' . $order['NamePrefix'] . '</FirstName>
             <LastName> </LastName>
            <MultilineAddress>      
            <Line>' . $order['ship-address1'] . '</Line>
            <Line>' . $order['ship-address2'] . '</Line>
            </MultilineAddress>
            <City>' . $order['ship-city'] . '</City>
            <State>' . $order['ship-state'] . '</State>
            <ZIP>' . $order['ship-postal-code'] . '</ZIP>
            <Country>' . $order['ship-postal-code'] . '</Country>
            <OrderedEmailAddresses>
              <Address>' . $order['buyer-email'] . '</Address>
            </OrderedEmailAddresses>
              <OrderedPhoneNumbers>
                <Number>' . $order['ship-phone-number'] . '</Number>
              </OrderedPhoneNumbers>
          </AddressFields>
      </Recipient>
          <MailClass>international express</MailClass>
          <Mailpiece>package</Mailpiece>
          <WeightOz>1</WeightOz>
          <PackageDimensionSet>A-type Widget Box</PackageDimensionSet>
      <Sender>
      <Company>MywatchDepot,A Perfact watch and diamond store.</Company>
      <Address1>Queens, NY, United States</Address1>
      <City>New York</City>
      <State>NY</State>
       <ZIP>90013</ZIP>
      <ZIPAddOn>7020</ZIPAddOn>
       <DisplayName>MYWATCHDEPOT NY WATCH AND DIAMOND STORE</DisplayName>
      <OrderedPhoneNumbers>
          <Number>1-800-874-3541</Number>
      </OrderedPhoneNumbers>      
      </Sender>
    </Item>';
		$xml .= '</Print>';
		$fp = fopen(config_item('base_url') . "stamps/printed-a-shippingbatch.xml", "w");
		fwrite($fp, $xml, strlen($xml));
		fclose($fp);
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"printed-a-shippingbatch.xml\"");
		echo $xml;
	}

	function notification() {

	}

	function managenotification() {

		// $data =	 serialize($HTTP_RAW_POST_DATA).'manage notification file  is started at '.date('Y-m-d H:i:s') ;
		$sql = $this->db->query("select * from schedulers");
		$scheduler = $sql->result_array();
		// Remember that difference should be 30 days only
		$startDate = $scheduler[0]['lastCallTime'];
		$endDate = date("Y-m-d H:i:s");
		$orderData = $this->cronmodel->GetSellerTransactions($startDate, $endDate);
		for ($j = 0; $j < sizeof($orderData); $j++) {
			$this->adminmodel->AddOrderDataInDB($orderData[$j]);
		}
		$isinsert = $this->db->update('schedulers', array(
            'lastCallTime' => date("Y-m-d H:i:s"),
		));

		$this->db->where("id", '1');
		/*
		 $data= serialize($_REQUEST);
		 $filePath = config_item('base_path')."upload/pksingal_main.txt";
		 $fp = fopen($filePath,"w");
		 fwrite($fp,$data);
		 fclose($fp);

		 @mail("pardeepsingal1@gmail.com", 'Manage Notification File called','manage notification file  is started at '.date('Y-m-d H:i:s') ,"From: \"Gemnile\"");
		 exit;
		 $start_pos = strpos($HTTP_RAW_POST_DATA,"<GetItemTransactionsResponse");
		 $end_pos   = strpos($HTTP_RAW_POST_DATA,"</GetItemTransactionsResponse>");
		 $HTTP_RAW_POST_DATA = substr($HTTP_RAW_POST_DATA,$start_pos,$end_pos);
		 $HTTP_RAW_POST_DATA = str_replace(array('</soapenv:Envelope>','</soapenv:Body>'),"",$HTTP_RAW_POST_DATA);
		 $exportcsvstr =  ($HTTP_RAW_POST_DATA) ;
		 $fp = fopen(config_item('base_path').'orderfiles/abx.xml' , 'w');
		 fwrite($fp , $exportcsvstr . "\n");
		 fclose($fp);

		 $responseObj   = simplexml_load_string($HTTP_RAW_POST_DATA);// or die(htmlspecialchars($HTTP_RAW_POST_DATA));
		 if(!$responseObj){
		 return -1;
		 }

		 try
		 {
		 if($responseObj){
		 $transactionObject = $responseObj->TransactionArray->Transaction;
		 $itemObject        = $responseObj->Item;
		 $ebay_transaction  = new ebayTransactions(3);

		 $NotificationEventName = $responseObj->NotificationEventName;
		 /*
		 if($NotificationEventName=='ItemUnsold')
		 {
		 $itemId = $itemObject->ItemID;
		 $result = func_query_first("select product_id,listing_type,ebay_itemid from ebay_items where ebay_itemid='$itemId'");
		 $productid = $result['product_id'];
		 $listing_type = $result['listing_type'];
		 if($listing_type=='Chinese')
		 {
		 if($result['ebay_itemid']){
		 $ebay_transaction->ManageInventoryNew($productid,"enditem");
		 }else{
		 $variantId = func_query_first_cell("select variantid from ebay_auction_items Where ebay_itemid='$itemId'");
		 $ebay_transaction->ManageInventoryNew($productid,"enditem",$variantId);
		 }
		 }
		 }
		 else
		 { */
		/* 				if(in_array($NotificationEventName,$this->eventArr)){
		 $ebay_transaction->ManageTransaction($transactionObject,$itemObject);
		 }
		 // }
		 }

		 return 1;
		 }
		 catch(Exception $e){
		 error_log($e->getTraceAsString(),1,"pardeepsingal1@gmail.com");
		 return 0;
		 }
		 *
		 */
	}

	//mark79

	function ManageTransaction($transaction) {
		$amountPaid = str_replace(',', '', $transaction->AmountPaid);
		$convertedAmountPaid = str_replace(',', '', $transaction->ConvertedAmountPaid);
		foreach ($transaction->ConvertedAmountPaid As $Currency) {
			$currency = (string) $Currency['currencyID'];
		}
		#Buyer Details
		$BuyerArr = array();
		$BuyerArr['email'] = (string) $transaction->Buyer->Email;
		$BuyerName = (string) $transaction->Buyer->BuyerInfo->ShippingAddress->Name;
		$BuyerName = explode(" ", $BuyerName);
		$BuyerArr['firstname'] = @$BuyerName[0];
		$BuyerArr['lastname'] = @$BuyerName[1];
		$BuyerArr['s_address'] = $BuyerArr['b_address'] = (string) $transaction->Buyer->BuyerInfo->ShippingAddress->Street1;
		$BuyerArr['s_city'] = $BuyerArr['b_city'] = (string) $transaction->Buyer->BuyerInfo->ShippingAddress->CityName;
		$BuyerArr['s_state'] = $BuyerArr['b_state'] = (string) $transaction->Buyer->BuyerInfo->ShippingAddress->StateOrProvince;
		$BuyerArr['s_county'] = $BuyerArr['b_county'] = (string) $transaction->Buyer->BuyerInfo->ShippingAddress->Country;
		$BuyerArr['s_country'] = $BuyerArr['b_city'] = (string) $transaction->Buyer->BuyerInfo->ShippingAddress->CountryName;
		$BuyerArr['s_zipcode'] = $BuyerArr['b_zipcode'] = (string) $transaction->Buyer->BuyerInfo->ShippingAddress->PostalCode;
		$BuyerArr['phone'] = (string) $transaction->Buyer->BuyerInfo->ShippingAddress->Phone;

		$BuyerArr['usertype'] = 'C';
		$BuyerArr['url'] = $url;
		$buyerID = (string) $transaction->Buyer->UserID;

		#Create a new order
		$OrderArr = array();
		$OrderArr['order'] = array();
		$OrderArr['order_detail'] = array();
		$OrderArr['ebay_orders'] = array();
		$OrderArr['order']['buyerid'] = $buyerID;
		$OrderArr['order']['login'] = $login;
		$OrderArr['order']['total'] = $amountPaid;

		$shipping_additional_cost = (string) $transaction->ShippingServiceSelected->ShippingServiceAdditionalCost;
		$shipping_cost = (string) $transaction->ShippingServiceSelected->ShippingServiceCost;
		$OrderArr['order']['shipping_cost'] = $shipping_cost + $shipping_additional_cost;

		$subtotal = $amountPaid - ($shipping_cost + $shipping_additional_cost);
		$ShippingService = (string) $transaction->ShippingServiceSelected->ShippingService;

		$shippingid = func_query_first_cell("Select store_shipping_id from ebay_shipping_methods where ebaycode='$ShippingService'");
		$OrderArr['order']['subtotal'] = $subtotal;
		$payment_method = (string) $transaction->Item->PaymentMethods;
		if (!$payment_method)
		$payment_method = (string) $itemObject->PaymentMethods;

		$OrderArr['order']['tax'] = (string) $transaction->ShippingDetails->SalesTax->SalesTaxAmount;
		$OrderArr['order']['taxes_applied'] = 1;
		$OrderArr['order_detail']['qty'] = (string) $transaction->QuantityPurchased;
		$OrderArr['order']['date'] = strtotime($this->mySqlDate((string) $transaction->CreatedDate));
		$OrderArr['order']['payment_method'] = $payment_method;
		$OrderArr['order']['firstname'] = @$BuyerName[0];
		$OrderArr['order']['lastname'] = @$BuyerName[1];
		$OrderArr['order']['s_address'] = $OrderArr['order']['b_address'] = $BuyerArr['b_address'];
		$OrderArr['order']['s_city'] = $OrderArr['order']['b_city'] = $BuyerArr['b_city'];
		$OrderArr['order']['s_state'] = $OrderArr['order']['b_state'] = $BuyerArr['b_state'];
		$OrderArr['order']['s_country'] = $OrderArr['order']['b_county'] = $BuyerArr['b_county'];
		$OrderArr['order']['s_city'] = $OrderArr['order']['b_city'] = $BuyerArr['b_city'];
		$OrderArr['order']['s_zipcode'] = $OrderArr['order']['b_zipcode'] = $BuyerArr['b_zipcode'];
		$OrderArr['order']['phone'] = $BuyerArr['phone'];
		$OrderArr['order']['url'] = $BuyerArr['url'];
		$OrderArr['order']['email'] = $BuyerArr['email'];

		//print_r($transaction);
		$transaction_id = (string) $transaction->TransactionID;
		if (!$transaction_id) {
			$transaction_id = (string) $transaction->ExternalTransaction->ExternalTransactionID;
		}

		$OrderArr['order']['status'] = "P";
		$OrderArr['order']['transaction_id'] = $transaction_id;
		$OrderArr['order']['notes'] = "Payment Method : " . $payment_method . ", Shipping Service : $ShippingService , TransactionID: " . $transaction_id . ", FeeOrCreditAmount:" . (string) $transaction->ExternalTransaction->FeeOrCreditAmount . ",PaymentOrRefundAmount :" . (string) $transaction->ExternalTransaction->PaymentOrRefundAmount . ", ExternalTransactionTime: " . (string) $transaction->ExternalTransaction->ExternalTransactionTime;
		$transaction_price = (string) $transaction->TransactionPrice;
		$transaction_siteid = (string) $transaction->TransactionSiteID;
		//$ebay_siteid       = func_query_first_cell("select id from ebay_site where ebayCode='$transaction_siteid'");
		$LastTimeModified = $transaction->Status->LastTimeModified;

		#Order Detail
		$ebay_item_id = (string) $transaction->Item->ItemID;
		$start_price = (string) $transaction->Item->StartPrice;
		if (!$ebay_item_id) {
			$ebay_item_id = (string) $itemObject->ItemID;
			$start_price = (string) $itemObject->StartPrice;
		}
		$OrderArr['order']['ebay_item_id'] = $ebay_item_id;
		$OrderArr['order']['price'] = $start_price;
		$OrderArr['order']['last_modified'] = $LastTimeModified;
		$OrderArr['order']['transaction_price'] = $transaction_price;
		$OrderArr['order']['transaction_siteid'] = $transaction_siteid;
		$this->adminmodel->AddOrderDataInDB($orderArr);
	}

	function testfile() {
		$string = '';
		echo "<pre>";
		print_R(unserialize($string));
	}

	function sendReq() {
		@mail("pardeepsingal1@gmail.com", 'Cron Ebay Orders', 'cron ebay orders file  is started at ' . date('Y-m-d H:i:s'), "From: \"Test MywatchDepotNy\"");
		$data = serialize($_REQUEST);
		$filePath = config_item('base_path') . "upload/pksingal.txt";
		$fp = fopen($filePath, "w");
		fwrite($fp, $data);
		fclose($fp);

		exit;
	}

	function sendReply() {
		$_POST['name'] = 'eBay';
		$_POST['lname'] = 'LeBay';
		$_POST['grade'] = 'B';
		return $_POST;
	}

	function getBrands() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'image_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'image_title';


		$results = $this->adminmodel->getbrands($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['brand_id'] . "',";
			$json .= "cell:['ID #: " . $row['brand_id'] . "<br /><a href=\'" . config_item('base_url') . "admin/brands/edit/" . $row['brand_id'] . "\'  class=\"edit\">Edit Brand</a>'";
			if ($row['brand_image'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . "frontimg/" . addslashes($row['brand_image']) . "\' width=\'80\'><br /> " . addslashes($row['brand_name']) . "'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br /> " . addslashes($row['brand_name']) . "'";

			$json .= ",'" . addslashes($row['brand_date']) . "'";
			$json .= ",'" . str_replace("\r", '<br />', str_replace("\n", '<br />', addslashes($row['brand_content']))) . "'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function feedbacks($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->feedbacks($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');
					if (isset($_POST[$action . 'btn'])) {
						//  if ($this->form_validation->run() == FALSE){
						//    $data['error'] = 'ERROR ! Please check the error fields';
						//	    if($action != 'edit')$data['details'] = $_POST;
						//}else {

						$ret = $this->adminmodel->feedbacks($_POST, $action, $id, 'watch');
						if ($ret['error'] == '')
						$data['success'] = $ret['success'];
						else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}
						//}
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					if ($action == 'edit') {
						$data['id'] = $id;
						$data['details'] = $this->adminmodel->getFeedbacksByID($id);
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										 
										';

				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('feedbacks');
				$url = config_item('base_url') . 'admin/getfeedbacks';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'id', width : 80, sortable : true, align: 'center'},
																		{display: 'email address', name : 'email', width : 150, sortable : true, align: 'center'},
                                                                                                                  {display: 'Status', name : 'status', width : 85, sortable : true, align: 'center'},
                                                                                                                               {display: 'feedback Date', name : 'adddate', width : 85, sortable : true, align: 'center'}, 
																		{display: 'Comments', name : 'description', width : 220, sortable : true, align: 'center'}
																																			
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
																				{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}








																			],
																	searchitems : [
																		{display: 'ID #', name : 'id', isdefault: true},
																		{display: 'email', name : 'email', isdefault: true}
																		], 		
																	sortname: \"adddate\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Manage feedbacks</h1>',
																	useRp: true,
																	rp: 100,
																	showTableToggleBtn: false,
																	width:1025,
																	height: 800
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
                                                                                                                                                                 
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/feedbacks/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted feedbacks: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                   error:function (xhr, ajaxOptions, thrownError){
                                                                                                                                                                                                                        alert(xhr.status);
                                                                                                                                                                                                                        alert(xhr.responseText);
                                                                                                                                                                                                                    }               
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a feedback.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/feedbacks/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/feedbacks', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getfeedbacks() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'email';


		$results = $this->adminmodel->getfeedbacks($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['id'] . "',";
			$json .= "cell:['ID #: " . $row['id'] . "<br /><a href=\'" . config_item('base_url') . "admin/feedbacks/edit/" . $row['id'] . "\'  class=\"edit\">Edit Status</a>'";
			$json .= ",'" . addslashes($row['email']) . "'";
			$json .= ",'" . addslashes($row['status']) . "'";
			$json .= ",'" . addslashes($row['adddate']) . "'";
			$json .= ",'<span>" . strip_tags(str_replace("\r", '<br />', str_replace("\n", '<br />', addslashes($row['description'])))) . "</span>'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function inventory() {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		if ($this->isadminlogin()) {
			if (isset($_FILES['template_file']['name'])) {
				if ($_FILES['template_file']['error'] == 0) {
					$uploadfile = config_item('base_path') . "/inventoryCsv/" . basename($_FILES['template_file']['name']);
					if (move_uploaded_file($_FILES['template_file']['tmp_name'], $uploadfile)) {
						$fp = fopen($uploadfile, "r");
						$row = 1;
						$filePath = config_item('base_path') . "amazon/csv_qty_upc.txt";
						$fk = fopen($filePath, "w");
						$fileText = "product-id\tproduct-id-type\titem-condition\tprice\tsku\tquantity\tadd-delete\twill-ship-internationally\texpedited shipping\titem-note";
						fwrite($fk, $fileText);
						fclose($fk);
						while (!feof($fp)) {
							$data = fgetcsv($fp, $_FILES['template_file']['size']);
							if ($row > 1) {
								if (!empty($data[0])) {
									$this->adminmodel->CsvHandler($data);
								}
							}
							$row++;
						}
						fclose($fp);
						$batchID = $this->adminmodel->UploadOnAmazon(config_item('base_path') . "amazon/csv_qty_upc.txt");
						$data['message'] = 'Inventory Successfully Updated';
					}
				}
			}
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('inventory');

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#ecommerce").click();
										 
										';


			$output = $this->load->view('admin/inventory', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function jewelriesinventory() {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		if ($this->isadminlogin()) {
			if (isset($_FILES['template_file']['name'])) {
				if ($_FILES['template_file']['error'] == 0) {
					$uploadfile = config_item('base_path') . "/jewelriesinventory/" . basename($_FILES['template_file']['name']);
					if (move_uploaded_file($_FILES['template_file']['tmp_name'], $uploadfile)) {
						$fp = fopen($uploadfile, "r");
						$row = 1;
						//$filePath = config_item('base_path')."amazon/jew_csv_qty_upc.txt";
						//$fk = fopen($filePath,"w");
						//  $fileText ="product-id\tproduct-id-type\titem-condition\tprice\tsku\tquantity\tadd-delete\twill-ship-internationally\texpedited shipping\titem-note";
						//        fwrite($fk,$fileText);
						//      fclose($fk);
						while (!feof($fp)) {
							$data = fgetcsv($fp, $_FILES['template_file']['size']);
							if ($row > 1) {
								if (!empty($data[0])) {
									$this->adminmodel->jewelriesinventory($data);
								}
							}
							$row++;
						}
						fclose($fp);
						//           $batchID = $this->adminmodel->UploadOnAmazon(config_item('base_path')."amazon/csv_qty_upc.txt");
						$data['message'] = 'Inventory Successfully Updated';
					}
				}
			}
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('jewelriesinventory');
			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
		  									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#ecommerce").click();
										 
										';


			$output = $this->load->view('admin/jewelriesinventory', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function povadajewelries() {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		if ($this->isadminlogin()) {
			if (isset($_FILES['template_file']['name'])) {

				if ($_FILES['template_file']['error'] == 0) {
					$uploadfile = config_item('base_path') . "/povadacsv/" . basename($_FILES['template_file']['name']);

					if (move_uploaded_file($_FILES['template_file']['tmp_name'], $uploadfile)) {
						$fp = fopen($uploadfile, "r");
						$row = 1;

						while (!feof($fp)) {
							$data = fgetcsv($fp, $_FILES['template_file']['size']);
							if ($row > 1) {
								if (!empty($data[0])) {
									$this->adminmodel->povadaupload($data);
								}
							}
							$row++;
						}
						fclose($fp);

						$data['message'] = 'Inventory Successfully Updated';
					}
				} else {
					$data['message'] = 'Uploaded file has error Please download the template and add paste the records on that records should maximum 1000 at a time';
				}
			}
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('povadajewelries');

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#ecommerce").click();
										 
										';


			$output = $this->load->view('admin/povadajewelries', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}
	
	////Start: Modified function for jewelries managment Date:9.3.13
	 
	
	function jew_man_catajaxreq() {
        $gender = $_REQUEST['gender'];
	$cat = $_REQUEST['sel'];
        $data['name'] = $this->getAdminDetails();
        $string = '<select onchange="return getSubCategoryBox(this.value);" id="category" name="category">';

        if ($gender == 'M') {
            $substring = $this->jew_man_getSubcat(3291859018,$cat);
            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
        if ($gender == 'F') {
            $substring = $this->jew_man_getSubcat(3292596018,$cat);

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
        if ($gender == 'C') {
            $substring = $this->jew_man_getSubcat(3291859019,$cat); /*First Time load sub category code and this category id is use another view to parent category id*/

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
        if ($gender == 'E') {
            $substring = $this->jew_man_getSubcat(3291859023,$cat); /*First Time load sub category code and this category id is use another view to parent category id*/

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
		if ($gender == 'D') {
            $substring = $this->jew_man_getSubcat(3291859041,$cat); /*First Time load sub category code and this category id is use another view to parent category id*/

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
		
		
		if ($gender == 'R') {
            $substring = $this->jew_man_getSubcat(3291859050,$cat); /*First Time load sub category code and this category id is use another view to parent category id*/

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
		
		if ($gender == 'CH') {
            $substring = $this->jew_man_getSubcat(3291859060,$cat); /*First Time load sub category code and this category id is use another view to parent category id*/

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
		if ($gender == 'CL') {
            $substring = $this->jew_man_getSubcat(3291859070,$cat); /*First Time load sub category code and this category id is use another view to parent category id*/

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
		if ($gender == 'S') {
            $substring = $this->jew_man_getSubcat(3291859080,$cat); /*First Time load sub category code and this category id is use another view to parent category id*/

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
		if ($gender == 'CG') {
            $substring = $this->jew_man_getSubcat(3291859090,$cat); /*First Time load sub category code and this category id is use another view to parent category id*/

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
	
		if ($gender == 'U') {
            $substring = $this->jew_man_getSubcat(3291859018,$cat); /*First Time load sub category code and this category id is use another view to parent category id*/

            if (!empty($substring)) {
                $string = $string . $substring;
            }

            $string .= "</select>";
        }
        echo $string;
        exit;
    }

    function jew_man_getsubcatajaxreq() {
        $catid = $_REQUEST['catid'];
		$subcat = $_REQUEST['subid'];
		$unisex = $_REQUEST['unisex'];
		
		//echo "$catid"."->$subcat";
        //onchange="getSubCategoryBox(this.value);" 
        $string = '<select id="subcategory" name="subcategory" onchange="checkOpt(this.value);">';
        //$substring = $this->getSubcat($catid);
		$substring = $this->jew_man_getSubcat($catid,$subcat);
        if (!empty($substring)) {
        	if($unisex == 'unisex')
        		$substring = str_replace('Men', 'Unisex', $substring);
            $string = $string . $substring;
        }
        $string .= "</select>";
        echo $string;
        exit;
    }
	
 
	
	function jew_man_getSubcat($rootid) {
		
		$malak_db = $this->load->database('malak', TRUE); // Connect to malak database
		//$this->db = $malak_db;
		$statement = "select * from `dev_ebaycategories` where parent_id = '$rootid'  ";
		$query = $malak_db->query($statement);
		//$squery = mysql_query("select * from `dev_ebaycategories` where parent_id = '$rootid'  ") or die(mysql_error());
		//$subnumofcat = mysql_num_rows($squery);
		//echo $statement;
		//echo '->'.$query->num_rows(); 
		if ($query->num_rows() > 0) {
			
		 	foreach ($query->result() as $row){
		      	$substring = $substring . "<option value='" . $row->category_id . "'>&nbsp;|-" . $row->category_name . "</option>";
		 		 
		   	}
			
			
			/*
			while ($j < $subnumofcat) {
				$subcat = mysql_fetch_array($squery) or die(mysql_error());
				$substring = $substring . "<option value='" . $subcat['category_id'] . "'>&nbsp;|-" . $subcat['category_name'] . "</option>";
				if ($rootid != 32) {
					//  $childstring = $this->getMoreChilds($subcat['id']);
					//  $substring = $substring.$childstring;
				}
				$j = $j + 1;
			}*/
		}
		return trim($substring);
	}	
	
	////End:  Modified function for jewelries managment Date:9.3.13
	

	function catajaxreq() {
		$gender = $_REQUEST['gender'];
		$data['name'] = $this->getAdminDetails();
		$string = '<select onchange="return getSubCategoryBox(this.value);" id="category" name="category">';

		if ($gender == 'M') {
			$substring = $this->getSubcat(3291859018);
			if (!empty($substring)) {
				$string = $string . $substring;
			}

			$string .= "</select>";
		}
		if ($gender == 'F') {
			$substring = $this->getSubcat(3292596018);

			if (!empty($substring)) {
				$string = $string . $substring;
			}

			$string .= "</select>";
		}
		echo $string;
		exit;
	}

	function getsubcatajaxreq() {
		$catid = $_REQUEST['catid'];
		//onchange="getSubCategoryBox(this.value);"
		$string = '<select id="subcategory" name="subcategory" onchange="checkOpt(this.value);">';
		$substring = $this->getSubcat($catid);
		if (!empty($substring)) {
			$string = $string . $substring;
		}

		$string .= "</select>";
		echo $string;
		exit;
	}

	function getSubcat($rootid) {
		$squery = mysql_query("select * from `dev_ebaycategories` where parent_id = '$rootid'  ") or die(mysql_error());
		$subnumofcat = mysql_num_rows($squery);
		$j = 0;
		if ($subnumofcat > 0) {
			while ($j < $subnumofcat) {
				$subcat = mysql_fetch_array($squery) or die(mysql_error());
				$substring = $substring . "<option value='" . $subcat['category_id'] . "'>&nbsp;|-" . $subcat['category_name'] . "</option>";
				if ($rootid != 32) {
					//  $childstring = $this->getMoreChilds($subcat['id']);
					//  $substring = $substring.$childstring;
				}
				$j = $j + 1;
			}
		}
		return trim($substring);
	}

	function getMoreChilds($rootid) {
		$squery = mysql_query("select * from `dev_ebaycategories` where parent_id = '$rootid'  ") or die(mysql_error());
		$subnumofcat = mysql_num_rows($squery);
		$j = 0;
		if ($subnumofcat > 0) {
			while ($j < $subnumofcat) {
				$subcat = mysql_fetch_array($squery) or die(mysql_error());
				$substring = $substring . "<option value='" . $subcat['category_id'] . "'>&nbsp;&nbsp;&nbsp;|----" . $subcat['category_name'] . "</option>";
				// $childstring = $this->getMoreChilds1($subcat['id']);
				//  $substring = $substring.$childstring;
				$j = $j + 1;
			}
		}
		return trim($substring);
	}

	function getMoreChilds1($rootid) {
		$squery = mysql_query("select * from `dev_ebaycategories` where parent_id = '$rootid'  ") or die(mysql_error());
		$subnumofcat = mysql_num_rows($squery);
		$j = 0;
		if ($subnumofcat > 0) {
			while ($j < $subnumofcat) {
				$subcat = mysql_fetch_array($squery) or die(mysql_error());
				$substring = $substring . "<option value='" . $subcat['category_id'] . "'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|----" . $subcat['category_name'] . "</option>";
				$j = $j + 1;
			}
		}
		return trim($substring);
	}

	function stuller($action = 'view', $id = 0) {

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			if ($action == 'delete') {
				$ret = $this->adminmodel->stuller($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					if (isset($_POST['btn'])) {
						$ret = $this->adminmodel->stuller($_POST, $action, $id);
						$data['details'] = $_POST;
						if ($ret['error'] == '')
						$data['success'] = $ret['success'];
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					if ($action == 'edit') {
						$data['details'] = $this->adminmodel->getstullerByID($id);
						$details = $data['details'];
						$data['id'] = $id;
					}
				}
			}


			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
	         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('povadajewelries');
			$url = config_item('base_url') . 'admin/getstuller/';
			$data['action'] = $action;
			$data['onloadextraheader'] .= " $(\"#results\").flexigrid
									(
										{
										url: '" . $url . "',
										dataType: 'json',
										colModel : [
										{display: 'ID', name : 'ID', width : 100, sortable : true, align: 'center'},
										{display: 'EZ Status', name : 'EZ Status', width : 130, sortable : false, align: 'center'},

										{display: 'Image', name : 'Image', width : 100, sortable : true, align: 'center'},
										{display: 'Sku', name : 'Sku', width : 100, sortable : true, align: 'center'},
                                        {display: 'Price', name : 'Price', width : 50, sortable : true, align: 'left'},
                                        {display: 'Description', name : 'Description', width : 50, sortable : true, align: 'left'},
                                        {display: 'ShortDescription', name : 'ShortDescription', width : 150, sortable : true, align: 'center'},
										{display: 'GroupDescription', name : 'GroupDescription', width : 180, sortable : true, align: 'left'},
										{display: 'MerchandisingCategory1', name : 'MerchandisingCategory1', width : 180, sortable : true, align: 'left'},
										{display: 'MerchandisingCategory2', name : 'MerchandisingCategory2', width : 90, sortable : true, align: 'left'},
                                        {display: 'MerchandisingCategory3', name : 'MerchandisingCategory3', width : 90, sortable : true, align: 'left'},
										{display: 'MerchandisingCategory4', name : 'MerchandisingCategory4', width : 60, sortable : true, align: 'left'},
										{display: 'MerchandisingCategory5', name : 'MerchandisingCategory5', width : 50, sortable : true, align: 'left'},
										{display: 'WebCategories', name : 'WebCategories', width : 60, sortable : true, align: 'left'},
												
										{display: 'Collection', name : 'Collection', width : 60, sortable : true, align: 'left'},
												{display: 'OnHand', name : 'OnHand', width : 60, sortable : true, align: 'left'},
												{display: 'Status', name : 'Status', width : 60, sortable : true, align: 'left'},
												{display: 'Price', name : 'Price', width : 60, sortable : true, align: 'left'},
												{display: 'UnitOfSale', name : 'UnitOfSale', width : 60, sortable : true, align: 'left'},
												{display: 'Weight', name : 'Weight', width : 60, sortable : true, align: 'left'},
												{display: 'WeightUnitOfMeasure', name : 'WeightUnitOfMeasure', width : 60, sortable : true, align: 'left'},
												{display: 'GramWeight', name : 'GramWeight', width : 60, sortable : true, align: 'left'},
												{display: 'RingSize', name : 'RingSize', width : 60, sortable : true, align: 'left'},
												{display: 'RingSizable', name : 'RingSizable', width : 60, sortable : true, align: 'left'},
												{display: 'RingSizeType', name : 'RingSizeType', width : 60, sortable : true, align: 'left'},
												{display: 'LeadTime', name : 'LeadTime', width : 60, sortable : true, align: 'left'},
												
										{display: 'DescriptiveElementGroup', name : 'DescriptiveElementGroup', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElements', name : 'DescriptiveElements', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName1', name : 'DescriptiveElementName1', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue1', name : 'DescriptiveElementValue1', width : 60, sortable : true, align: 'left'},
												
												{display: 'DescriptiveElementName2', name : 'DescriptiveElementName2', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue2', name : 'DescriptiveElementValue2', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName3', name : 'DescriptiveElementName3', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue3', name : 'DescriptiveElementValue3', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName4', name : 'DescriptiveElementName4', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue4', name : 'DescriptiveElementValue4', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName5', name : 'DescriptiveElementName5', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue5', name : 'DescriptiveElementValue5', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName6', name : 'DescriptiveElementName6', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue6', name : 'DescriptiveElementValue6', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName7', name : 'DescriptiveElementName7', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue7', name : 'DescriptiveElementValue7', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName8', name : 'DescriptiveElementName8', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue8', name : 'DescriptiveElementValue8', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName9', name : 'DescriptiveElementName9', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue9', name : 'DescriptiveElementValue9', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName10', name : 'DescriptiveElementName10', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue10', name : 'DescriptiveElementValue10', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName11', name : 'DescriptiveElementName11', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue11', name : 'DescriptiveElementValue11', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName12', name : 'DescriptiveElementName12', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue12', name : 'DescriptiveElementValue12', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName13', name : 'DescriptiveElementName13', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue13', name : 'DescriptiveElementValue13', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName14', name : 'DescriptiveElementName14', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue14', name : 'DescriptiveElementValue14', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementName15', name : 'DescriptiveElementName15', width : 60, sortable : true, align: 'left'},
												{display: 'DescriptiveElementValue15', name : 'DescriptiveElementValue15', width : 60, sortable : true, align: 'left'},
												
												{display: 'ReadyToWear', name : 'ReadyToWear', width : 60, sortable : true, align: 'left'},
												{display: 'ConfigurationModel', name : 'ConfigurationModel', width : 60, sortable : true, align: 'left'},
												{display: 'SetWith', name : 'SetWith', width : 60, sortable : true, align: 'left'},
												{display: 'MadeWith', name : 'MadeWith', width : 60, sortable : true, align: 'left'},
												{display: 'Images', name : 'Images', width : 60, sortable : true, align: 'left'},
												{display: 'GroupImages', name : 'GroupImages', width : 60, sortable : true, align: 'left'},
												{display: 'Videos', name : 'Videos', width : 60, sortable : true, align: 'left'},
												{display: 'GroupVideos', name : 'GroupVideos', width : 60, sortable : true, align: 'left'},
												{display: 'CreationDate', name : 'CreationDate', width : 60, sortable : true, align: 'left'}
												
										],
										 buttons : [ 				 								
                                                                                          {name: 'Add', bclass: 'delete' , onpress : test},
											  {separator: true}
                                                                                            ],
										searchitems : [
										{display: 'Item Number', name : 'stuller_id', isdefault: true}
										],
										sortname: \"stuller_id\",
										sortorder: \"asc\",
										usepager: true,
										title: '<h1 class=\"pageheader\">Stuller jewellry</h1>',
										useRp: true,
										rp: 100,
										showTableToggleBtn: false,
										width:1025,
										height: 800
										}
									);
									
									function test(com,grid)
															{
												window.location = '" . config_item('base_url') . "admin/stullerjewelries';
															}	
									
									";


			$data['extraheader'] = '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
			$output = $this->load->view('admin/stuller', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getstuller() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'stuller_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'itemid';

		$results = $this->adminmodel->getstuller($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$i = 0;
		foreach ($results['result'] as $row) {
			//$image1 = config_item('base_path')."stuller/".$row['img1'];
			//$image1 = $row['img1'];
			$row['img1'] = urldecode($row['img1']);
			$image1 = "http://www.stuller.com/apps/images/" . str_replace("\\", "/", $row['img1']);
			//$myimage	=	json_decode($row['Videos']);
			$json_decoded = json_decode($row['Videos']);
			$imagemy = $json_decoded[0]->{'FullUrl'};
			 
			// $image = $image1 = '';
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['stuller_id'] . "',";
			$json .= "cell:['ID #: " . $row['stuller_id'] . "<br /><a href=\'" . config_item('base_url') . "admin/stuller/edit/" . $row['stuller_id'] . "\'  class=\"edit\">Edit</a>'";

			$row['ezstatus'] == true ? $json .= ",'" . "<a href=\'" . config_item('base_url') . "admin/ezstatusedit/" . $row['stuller_id'] . "/disable\'  class=\"edit\">Enabled</a>'" : $json .= ",'" . "<a href=\'" . config_item('base_url') . "admin/ezstatusedit/" . $row['stuller_id'] . "/enable\'  class=\"edit\">Disabled</a>'";

			$json .= ",'<img src=\'" .addslashes(str_replace('$standard$', 'hei=300&wid=300', $imagemy)). "\' width=\'80\'>'";


			$json .= ",'" . addslashes($row['Sku']) . " '";
			$json .= ",'" . addslashes($row['Price']) . " '";
			$json .= ",'" . addslashes($row['Description']) . " '";
			$json .= ",'" . addslashes($row['ShortDescription']) . " '";
			$json .= ",'" . addslashes($row['GroupDescription']) . " '";
			$json .= ",'" . addslashes($row['MerchandisingCategory1']) . " '";
			$json .= ",'" . addslashes($row['MerchandisingCategory2']) . " '";
			$json .= ",'" . addslashes($row['MerchandisingCategory3']) . " '";
			$json .= ",'" . addslashes($row['MerchandisingCategory4']) . " '";
			$json .= ",'" . addslashes($row['MerchandisingCategory5']) . " '";
			$json .= ",'" . addslashes($row['WebCategories']) . " '";
			$json .= ",'" . addslashes($row['Collection']) . " '";
			$json .= ",'" . addslashes($row['OnHand']) . " '";
			$json .= ",'" . addslashes($row['Status']) . " '";

			$json .= ",'" . addslashes($row['UnitOfSale']) . " '";
			$json .= ",'" . addslashes($row['Weight']) . " '";
			$json .= ",'" . addslashes($row['WeightUnitOfMeasure']) . " '";
			$json .= ",'" . addslashes($row['GramWeight']) . " '";
			$json .= ",'" . addslashes($row['RingSize']) . " '";
			$json .= ",'" . addslashes($row['RingSizable']) . " '";
			$json .= ",'" . addslashes($row['RingSizeype']) . " '";
			$json .= ",'" . addslashes($row['LeadTime']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementGroup']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElements']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName1']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue1']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName2']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue2']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName3']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue3']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName4']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue4']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName5']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue5']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName6']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue6']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName7']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue7']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue8']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName9']) . " '";
			
			$json .= ",'" . addslashes($row['DescriptiveElementValue9']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName10']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue10']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName11']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue11']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName12']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue12']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName13']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue13']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementName14']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue14']) . " '";
			
			
			$json .= ",'" . addslashes($row['DescriptiveElementName15']) . " '";
			$json .= ",'" . addslashes($row['DescriptiveElementValue15']) . " '";
			$json .= ",'" . addslashes($row['ReadyToWear']) . " '";
			$json .= ",'" . addslashes($row['ConfigurationModel']) . " '";
			$json .= ",'" . addslashes($row['SetWith']) . " '";
			$json .= ",'" . addslashes($row['MadeWith']) . " '";
			$json .= ",'" . addslashes($row['Images']) . " '";
			$json .= ",'" . addslashes($row['GroupImages']) . " '";
			$json .= ",'" . addslashes($row['Videos']) . " '";
			$json .= ",'" . addslashes($row['GroupVideos']) . " '";
			$json .= ",'" . addslashes($row['CreationDate']) . " '";
		/*	$json .= ",'" . '$' . number_format(addslashes($row['wholesale_price']), 2) . " '";
			$json .= ",'" . '$' . number_format(addslashes($row['retail_price']), 2) . " '";
			$json .= ",'" . '$' . $row['level1'] . " '";
			$json .= ",'" . '$' . $row['descr']. " '";
			$json .= ",'" . '$' . $row['total_carat'] . " '";
			$json .= ",'" . '$' . $row['metal'] . " '";
			$json .= ",'" . '$' . $row['avg_piece_weight'] . " '";
			$json .= ",'" . '$' . $row['weight_unit'] . " '";
			$json .= ",'" . '$' . $row['unit_of_sale'] . " '";
			$json .= ",'" . '$' . $row['resizeable']. " '";
			$json .= ",'" . '$' . $row['base_size']. " '";
			$json .= ",'" . '$' . $row['exact_size'] . " '";
			$json .= ",'" . '$' . $row['min_size'] . " '";
			$json .= ",'" . '$' . $row['max_size'] . " '";
			$json .= ",'" . '$' . $row['stock_status'] . " '";*/
			$json .= "]";
			$json .= "}";
			$rc = true;
			$i = $i + 1;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function canadaorders($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->canadaorders($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#fullfillments").click();
										';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('canadaorders');


				$url = config_item('base_url') . 'admin/getcanadaorders/';
				$data['action'] = $action;
				$data['onloadextraheader'] .= " $(\"#results\").flexigrid
									(
										{
										url: '" . $url . "',
										dataType: 'json',
										colModel : [
										{display: 'Orderid', name : 'orderid', width : 150, sortable : true, align: 'left'},
                                                                                {display: 'Order Date', name : 'purchase-date', width : 150, sortable : true, align: 'left'},
										{display: 'Product Id', name : 'order-item-id', width : 150, sortable : true, align: 'left'},
										{display: 'Shipped Fedex', name : 'shipped-fedex', width : 50, sortable : true, align: 'left'},
										{display: 'Shipped USPS', name : 'shipped-usps', width : 50, sortable : true, align: 'left'},										
										{display: 'Buyer Name', name : 'buyer-name', width : 150, sortable : true, align: 'left'},
										{display: 'Product Name', name : 'product-name', width : 150, sortable : true, align: 'center'},
										{display: 'Quantity Sold', name : 'quantity-purchased', width : 50, sortable : true, align: 'center'},
										{display: 'Shipping Address', name : 'ship-address2', width : 100, sortable : true, align: 'center'},
										{display: 'Shipping City', name : 'ship-cityship-city', width : 50, sortable : true, align: 'center'},
										{display: 'Shipping State', name : 'ship-state', width : 50, sortable : true, align: 'center'},
										{display: 'Shipping Country', name : 'ship-country', width : 150, sortable : true, align: 'center'},
										{display: 'Shipping Zip', name : 'ship-postal-code', width : 150, sortable : true, align: 'center'},
										{display: 'Shipping Cost', name : 'shipping-price', width : 150, sortable : true, align: 'center'},																				
										{display: 'Product Price', name : 'item-price', width : 250, sortable : true, align: 'left'},																				
									        {display: 'Stamps', name : 'orderid', width : 250, sortable : true, align: 'left'}
										],
										 buttons : [ 
					 								{name: 'Delete', bclass: 'delete', onpress : test},
													{separator: true}
												 ],
										searchitems : [
										{display: 'id', name : 'id', isdefault: true}
										],
										sortname: \"id\",
										sortorder: \"asc\",
										usepager: true,
										title: '<h1 class=\"pageheader\">Canada Fullfilllment</h1>',
										useRp: true,
										rp: 100,
										showTableToggleBtn: false,
										width:1025,
										height: 800
										}
									);
									
									function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }
																                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/canadaorders/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																	 		
																	}
									";


				$data['extraheader'] = '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
				$output = $this->load->view('admin/canadaorders', $data, true);
				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);

			$this->output($output, $data);
		}
	}

	function getcanadaorders() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 100;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'title';

		$results = $this->adminmodel->getcanadaorders($page, $rp, $sortname, $sortorder, $query, $qtype);
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$i = 0;
		foreach ($results['result'] as $row) {
			$shape = '';
			$action = config_item('base_url') . "admin/generateXMLStamp/" . $row['orderid'];
			$orderid = $row['orderid'];
			$fedex = config_item('base_url') . "/admin/fedex/$orderid";
			$usps = config_item('base_url') . "/admin/usps/$orderid";
			$fedexTrackingCode = $row['fedex_tracking_code'];
			$uspsTrackingCode = $row['usps_tracking_code'];
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['orderid'] . "',";
			$json .= "cell:['" . $row['orderid'] . "'";
			$json .= ",'" . addslashes($row['purchase-date']) . " '";
			$json .= ",'" . addslashes($row['order-item-id']) . " '";
			if (!empty($fedexTrackingCode)) {
				//$json .= ",'".addslashes($fedexTrackingCode)." '";
				$json .= ",'<a href=\"$fedex\"  style=\"color:maroon;font-weight:bold;\">Ship to Fedex</a>'";
			} else {
				$json .= ",'<a href=\"$fedex\"  style=\"color:maroon;font-weight:bold;\">Ship to Fedex</a>'";
			}
			if (!empty($uspsTrackingCode)) {
				//$json .= ",'".addslashes($uspsTrackingCode)." '";
				$json .= ",'<a href=\"$usps\" style=\"color:maroon;font-weight:bold;\">Ship to USPS</a>'";
			} else {
				$json .= ",'<a href=\"$usps\" style=\"color:maroon;font-weight:bold;\">Ship to USPS</a>'";
			}
			$json .= ",'" . addslashes($row['buyer-name']) . " '";
			$json .= ",'" . addslashes($row['product-name']) . " '";
			$json .= ",'" . addslashes($row['quantity-purchased']) . "'";
			$json .= ",'" . addslashes($row['ship-address2']) . " '";
			$json .= ",'" . addslashes($row['ship-cityship-city']) . " '";
			$json .= ",'" . addslashes($row['ship-state']) . " '";
			$json .= ",'" . addslashes($row['ship-country']) . " '";
			$json .= ",'" . addslashes($row['ship-postal-code']) . " '";
			$json .= ",'" . '$' . number_format(addslashes($row['shipping-price']), 2) . " '";
			$json .= ",'" . '$' . number_format(addslashes($row['item-price']), 2) . " '";

			$json .= ",'<a href=\"$action\" style=\"color:maroon;font-weight:bold;\">download</a>'";
			$json .= "]";
			$json .= "}";
			$rc = true;
			$i = $i + 1;
		}

		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function getebaycat() {
		echo $this->adminmodel->getebaycategories();
	}

	function getstullercsv() {
		$destination = config_item('base_path') . 'stuller/ReadyforRetail.csv';
		if (file_exists($destination)) {
			$handle = fopen($destination, "r");
			$i = 0;
			while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
				if ($i > 0) {
					$t = $this->cronmodel->savestuller($data);
				}
				$i++;
			}
		}
	}

	function getQualityGoldcsv() {
		//The filename /home/sugarkarats/public_html/QualityGold/ftp.qgold.com/Collections/FamilyJewelry/FamilyRingFlyerFall2011/FamilyCelebration.xls is not readable
		///public_html/QualityGold/ftp.qgold.com/Collections/FamilyJewelry/MothersJewelry
		///public_html/QualityGold/ftp.qgold.com/Collections/Tapout/Tap-Out-Product_Details_040810.xls
		$destination = config_item('base_path') . 'QualityGold/ftp.qgold.com/Silver11/Pages789-810/SilverPage789-810.xls';
		// if(file_exists($destination)) {
		require_once config_item('base_path') . 'scripts/excel/reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
		$data->read($destination);

		$j = 1;
		for ($i = 3; $i <= $data->sheets[$j]['numRows']; $i++) {

			$itemNumber = (string) $data->sheets[$j]['cells'][$i][1];
			$image = (string) $data->sheets[$j]['cells'][$i][2];
			$description = (string) $data->sheets[$j]['cells'][$i][3];
			$weight = (string) $data->sheets[$j]['cells'][$i][4];


			$category = (string) $data->sheets[$j]['cells'][$i][7];
			$page = (string) $data->sheets[$j]['cells'][$i][6];
			$size = (string) $data->sheets[0]['cells'][$i][9];
			$metal = (string) $data->sheets[$j]['cells'][$i][10];
			//                  $jew_cost = ($data->sheets[0]['cells'][$i][9] * 24);
			$catalog = ($data->sheets[$j]['cells'][$i][16] * 1850);


			$length = ''; // (string)$data->sheets[$j]['cells'][$i][4] ;
			$width = ''; // (string)$data->sheets[$j]['cells'][$i][5];
			$height = ''; //  (string)$data->sheets[$j]['cells'][$i][6];

			$chain_length = //  (string)$data->sheets[0]['cells'][$i][5] ;
			$chain_width = //  (string)$data->sheets[0]['cells'][$i][6];



			$totalweight = (string) $data->sheets[0]['cells'][$i][5];
			$gemstonewt = (string) $data->sheets[0]['cells'][$i][6];

			$cost_15 = ''; // (string)$data->sheets[0]['cells'][$i][13];
			$cost_20 = ''; // (string)$data->sheets[0]['cells'][$i][14];

			$book = (string) $data->sheets[0]['cells'][$i][5];
			$status = (string) $data->sheets[$j]['cells'][$i][8];

			$cost_30 = ''; // (string)$data->sheets[0]['cells'][$i][12];
			$cost_35 = ''; // (string)$data->sheets[0]['cells'][$i][13];
			$cost_40 = (string) ($data->sheets[0]['cells'][$i][11] * 40);
			//echo "micasony".$data->sheets[0]['cells'][$i][11];

			$cost_45 = (string) ($data->sheets[0]['cells'][$i][12] * 45);
			$cost_50 = (string) ($data->sheets[0]['cells'][$i][13] * 50);
			$current_status = (string) $data->sheets[$j]['cells'][$i][14];
			$rank = (string) $data->sheets[$j]['cells'][$i][15];
			$folder = 'Silver11/Pages789-810';
			$this->adminmodel->savequalitygold($itemNumber, $image, $description, $weight, $book, $page, $category, $status, $size, $metal, $cost_40, $cost_45, $cost_50, $current_status, $rank, $folder, $cost_30, $cost_35, $length, $width, $totalweight, $gemstonewt, $catalog, $cost_15, $cost_20);
		}
		//}
	}

	function qualitygold($action = 'view', $id = 0) {

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			if ($action == 'delete') {
				$ret = $this->adminmodel->qualitygold($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					if (isset($_POST['btn'])) {
						$ret = $this->adminmodel->qualitygold($_POST, $action, $id);
						$data['details'] = $_POST;
						if ($ret['error'] == '')
						$data['success'] = $ret['success'];
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					if ($action == 'edit') {
						$data['details'] = $this->adminmodel->getqualitygoldByID($id);
						$details = $data['details'];
						$data['id'] = $id;
					}
				}
			}
			/*{display: 'Jewellry At 45', name : 'cost_45', width : 80, sortable : true, align: 'left'},
			{display: 'Jewellry At 50', name : 'cost_50', width : 80, sortable : true, align: 'left'},
			,
                                                                               
										{display: 'Page', name : 'page', width : 180, sortable : true, align: 'left'}
			*/

			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
	         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('povadajewelries');
			$url = config_item('base_url') . 'admin/getqualitygold';
			$data['action'] = $action;
			$data['onloadextraheader'] .= " $(\"#results\").flexigrid
									(
										{
										url: '" . $url . "',
										dataType: 'json',
										colModel : [
										
                                        {display: 'ID', name : 'qd_id', width : 50, sortable : true, align: 'center'},
										{display: 'EZ Status', name : 'EZ Status', width : 50, sortable : false, align: 'center'},
										{display: 'Item', name : 'Item', width : 130, sortable : false, align: 'center'},
										{display: 'MSRP', name : 'MSRP', width : 50, sortable : true, align: 'left'},
										{display: 'Price', name : 'Price', width : 50, sortable : true, align: 'left'},
										
                                        {display: 'Description', name : 'Description', width : 50, sortable : true, align: 'left'},
										{display: 'Status', name : 'Status', width : 50, sortable : true, align: 'center'},
										{display: 'Weight', name : 'Weight', width : 50, sortable : true, align: 'left'},
                                        {display: 'CT_Weight', name : 'CT_Weight', width : 80, sortable : true, align: 'left'},
											
										{display: 'Gem_Weight', name : 'Gem_Weight', width : 50, sortable : true, align: 'left'},
										{display: 'Size', name : 'Size', width : 50, sortable : true, align: 'left'},
										{display: 'Length', name : 'Length', width : 50, sortable : true, align: 'left'},
										{display: 'Width', name : 'Width', width : 50, sortable : true, align: 'left'},
										{display: 'Sizeable', name : 'Sizeable', width : 50, sortable : true, align: 'left'},
										{display: 'Metal_Desc', name : 'Metal_Desc', width : 50, sortable : true, align: 'left'},
										{display: 'Image', name : 'Image', width : 50, sortable : true, align: 'left'},
										{display: 'UM_Sales', name : 'UM_Sales', width : 50, sortable : true, align: 'left'},
										{display: 'Qty_Avail', name : 'Qty_Avail', width : 50, sortable : true, align: 'left'},
										{display: 'Metal_Price', name : 'Metal_Price', width : 50, sortable : true, align: 'left'},												
										{display: 'Customer_Style', name : 'Customer_Style', width : 50, sortable : true, align: 'left'},
										{display: 'Categories', name : 'Categories', width : 50, sortable : true, align: 'left'},
										{display: 'Attributes', name : 'Attributes', width : 50, sortable : true, align: 'left'},
										
										{display: 'Item_Type', name : 'Item_Type', width : 50, sortable : true, align: 'left'},
										{display: 'DateAdded', name : 'DateAdded', width : 50, sortable : true, align: 'left'},
										{display: 'ProductLine', name : 'ProductLine', width : 50, sortable : true, align: 'left'},
										{display: 'ImageLink_100', name : 'ImageLink_100', width : 50, sortable : true, align: 'left'},
										{display: 'ImageLink_275', name : 'ImageLink_275', width : 50, sortable : true, align: 'left'},
										{display: 'ImageLink_500', name : 'ImageLink_500', width : 50, sortable : true, align: 'left'},
										{display: 'Country_Of_Origin', name : 'Country_Of_Origin', width : 50, sortable : true, align: 'left'}
								
																	   

										],
										 buttons : [ 				 								
                                                                                          {name: 'Add', bclass: 'delete' , onpress : test},
											  {separator: true}
                                                                                            ],
										searchitems : [
										{display: 'Item Number', name : 'qg_id', isdefault: true}
										],
										sortname: \"qg_id\",
										sortorder: \"asc\",
										usepager: true,
										title: '<h1 class=\"pageheader\">Qualty & Gold</h1>',
										useRp: true,
										rp: 100,
										showTableToggleBtn: false,
										width:1025,
										height: 800
										}
									);
									
									function test(com,grid)
															{
												window.location = '" . config_item('base_url') . "admin/qualitygold';
															}	
									
									";


			$data['extraheader'] = '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
			$output = $this->load->view('admin/qualitygold', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

        

	function uniquesettings($action = 'view', $id = 0) {

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			if ($action == 'delete') {
				$ret = $this->adminmodel->qualitygold($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {

				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					if (isset($_POST['btn'])) {
						$ret = $this->adminmodel->qualitygold($_POST, $action, $id);
						$data['details'] = $_POST;
						if ($ret['error'] == '')
						$data['success'] = $ret['success'];
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					if ($action == 'edit') {
						$data['details'] = $this->adminmodel->getqualitygoldByID($id);
						$details = $data['details'];
						$data['id'] = $id;
					}
				}
			}


			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
	         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										$("#rapnet").click();
										';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml('povadajewelries');
			$url = config_item('base_url') . 'admin/getuniquesettings';
			$data['action'] = $action;
			$data['onloadextraheader'] .= " $(\"#results\").flexigrid
									(
										{
										url: '" . $url . "',
										dataType: 'json',
										colModel : [
                                                                                {display: 'ID', name : 'id', width : 50, sortable : true, align: 'center'},
				{display: 'EZ Status', name : 'EZ Status', width : 130, sortable : false, align: 'center'},
										{display: 'Item Name', name : 'name', width : 50, sortable : true, align: 'center'},
												{display: 'Catagory', name : 'catagory', width : 50, sortable : true, align: 'center'},
                                                                                {display: 'Image', name : 'image', width : 150, sortable : true, align: 'left'},				
                                                                                {display: 'Style Group', name : 'style_group', width : 150, sortable : true, align: 'left'},				
                                                                                {display: 'Metal Weight', name : 'metal_weight', width : 60, sortable : true, align: 'left'},				
                                                                                {display: 'Bail Info', name : 'bail_info', width : 50, sortable : true, align: 'left'},				
                                                                                {display: 'Stone Weight', name : 'stone_weight', width : 60, sortable : true, align: 'left'},				
                                                                                {display: 'Supplied Stones', name : 'supplied_stones', width : 60, sortable : true, align: 'left'},				
                                                                                {display: 'Top Width', name : 'top_width', width : 60, sortable : true, align: 'left'},				
                                                                                {display: 'Bottom Width', name : 'bottom_width', width : 60, sortable : true, align: 'left'},				
                                                                                {display: 'Top Height', name : 'top_height', width : 60, sortable : true, align: 'left'},				
                                                                                {display: 'Bottom Height', name : 'bottom_height', width : 60, sortable : true, align: 'left'},				
                                                                                {display: 'Ring Size', name : 'ring_size', width : 60, sortable : true, align: 'left'}				
										],
										buttons : [ 				 								
                                                                                          {name: 'Add', bclass: 'delete' , onpress : test},
											  {separator: true}
                                                                                            ],
										searchitems : [
										{display: 'Item Number', name : 'stuller_id', isdefault: true}
										],
										sortname: \"id\",
										sortorder: \"asc\",
										usepager: true,
										title: '<h1 class=\"pageheader\">Unique Settings</h1>',
										useRp: true,
										rp: 100,
										showTableToggleBtn: false,
										width:1100,
										height: 800
										}
									);
									
									function test(com,grid)
															{
												window.location = '" . config_item('base_url') . "admin/uniquesettings';
															}	
									
									";


			$data['extraheader'] = '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
			$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
			$output = $this->load->view('admin/uniquesettings', $data, true);
			$this->output($output, $data);
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}        
        
	function getuniquesettings() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'itemid';

		$results = $this->adminmodel->getuniquesettings($page, $rp, $sortname, $sortorder, $query, $qtype);


		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$i = 0;
                //print_r($results['result']);
		foreach ($results['result'] as $row) {
			
			$mynewresult	=	$this->adminmodel->getordercat($row['id']);
			//$image = config_item('base_path')."images/povada/".$row['SKU'].".jpg";
			//$image1 = config_item('base_url')."qualitygold/".$row['img1'];
			//$image1 = "http://qgold.com/product/275/" . $row['image_name'] . ".jpg";

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['id'] . "',";
			$json .= "cell:['ID #: " . $row['id'] . "<br />'";
			//$json .= ",'<img src=\'" . addslashes($image1) . "\' width=\'80\'><br /> " . addslashes($row['itemid']) . "'";

			$row['ezstatus'] == true ? $json .= ",'" . "<a href=\'" . config_item('base_url') . "admin/ezuniquestatusedit/" . $row['id'] . "/disable\'  class=\"edit\">Enabled</a>'" : $json .= ",'" . "<a href=\'" . config_item('base_url') . "admin/ezuniquestatusedit/" . $row['id'] . "/enable\'  class=\"edit\">Disabled</a>'";


			$json .= ",'" . addslashes($row['name']) . " '";
			$json .= ",'" . addslashes($mynewresult->catname) . " '";
//			$json .= ",'" . addslashes($row['image']) . " '";
//			$json .= ",'" . addslashes($row['book']) . " '";
//			$json .= ",'" . '$' . addslashes($row['cost_40']) . " '";
//			$json .= ",'" . '$' . addslashes($row['cost_45']) . " '";
//			$json .= ",'" . '$' . addslashes($row['cost_50']) . " '";
$json .= ",'<img src=\'" . addslashes($row['image']) . "\' width=\'80\'><br /> " . '' . "'";                        
			$json .= ",'" . addslashes($row['style_group']) . " '";
			$json .= ",'" . addslashes($row['metal_weight']) . " '";
			$json .= ",'" . addslashes($row['bail_info']) . " '";
			$json .= ",'" . addslashes($row['stone_weight']) . " '";
			$json .= ",'" . addslashes($row['supplied_stones']) . " '";
			$json .= ",'" . addslashes($row['top_width']) . " '";
			$json .= ",'" . addslashes($row['bottom_width']) . " '";
			$json .= ",'" . addslashes($row['top_height']) . " '";
			$json .= ",'" . addslashes($row['bottom_height']) . " '";
			$json .= ",'" . addslashes($row['ring_size']) . " '";





			$json .= "]";
			$json .= "}";
			$rc = true;
			$i = $i + 1;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

        
	function getqualitygold() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'qg_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'itemid';

		$results = $this->adminmodel->getqualitygold($page, $rp, $sortname, $sortorder, $query, $qtype);


		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$i = 0;
		foreach ($results['result'] as $row) {
			//$image = config_item('base_path')."images/povada/".$row['SKU'].".jpg";
			//$image1 = config_item('base_url')."qualitygold/".$row['img1'];
			//$image1 = "http://qgold.com/product/275/" . $row['image_name'] . ".jpg";
			
			$image1 =  "http://".$row['ImageLink_100'] ;
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['qg_id'] . "',";
			$json .= "cell:['ID #: " . $row['qg_id'] . "<br /><a href=\'" . config_item('base_url') . "admin/qualitygold/edit/" . $row['qg_id'] . "\'  class=\"edit\">Edit</a>'";
			$row['ezstatus'] == true ? $json .= ",'" . "<a href=\'" . config_item('base_url') . "admin/ezqualitygoldstatusedit/" . $row['qg_id'] . "/disable\'  class=\"edit\">Enabled</a>'" : $json .= ",'" . "<a href=\'" . config_item('base_url') . "admin/ezqualitygoldstatusedit/" . $row['qg_id'] . "/enable\'  class=\"edit\">Disabled</a>'";
			$json .= ",'<img src=\'" . addslashes($image1) . "\' width=\'80\'><br /> " . addslashes($row['Item']) . "'";

	
			//$json .= ",'" . addslashes($row['Item']) . " '";
			$json .= ",'" . addslashes($row['MSRP']) . " '";
			$json .= ",'" . '$' . addslashes($row['Price']) . " '";
			$json .= ",'" . addslashes($row['Description']) . " '";
			$json .= ",'" . addslashes($row['Status']) . " '";
			$json .= ",'" .  addslashes($row['Weight']) . " '";
			$json .= ",'" .  addslashes($row['CT_Weight']) . " '";
			$json .= ",'" .  addslashes($row['Gem_Weight']) . " '";
			$json .= ",'" . addslashes($row['Size']) . " '";
			$json .= ",'" . addslashes($row['Length']) . " '";
			$json .= ",'" . addslashes($row['Width']) . " '";
			$json .= ",'" . addslashes($row['Sizeable']) . " '";
			$json .= ",'" . addslashes($row['Metal_Desc']) . " '";
			$json .= ",'" . addslashes($row['Image']) . " '";
			$json .= ",'" . addslashes($row['UM_Sales']) . " '";
			$json .= ",'" . addslashes($row['Qty_Avail']) . " '";
			$json .= ",'" . '$' . addslashes($row['Metal_Price']) . " '";
			
			$json .= ",'" . addslashes($row['Customer_Style']) . " '";
			
			$json .= ",'" . addslashes($row['Categories']) . " '";
			$json .= ",'" . addslashes($row['Attributes']) . " '";
			
			$json .= ",'" . addslashes($row['Item_Type']) . " '";
			$json .= ",'" . addslashes($row['DateAdded']) . " '";
			$json .= ",'" . addslashes($row['ProductLine']) . " '";
			$json .= ",'" . addslashes($row['ImageLink_100']) . " '";
			$json .= ",'" . addslashes($row['ImageLink_275']) . " '";
			$json .= ",'" . addslashes($row['ImageLink_500']) . " '";
			$json .= ",'" . addslashes($row['Country_Of_Origin']) . " '";





			$json .= "]";
			$json .= "}";
			$rc = true;
			$i = $i + 1;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

        
	function rapnetDiamonds($action = 'view', $id = 0) {

        //echo "<pre>";
        //print_r($_POST);
        //exit;
		
		if (isset($_REQUEST['submit_search']) && !empty($_REQUEST['submit_search'])) {
			$this->adminmodel->saveSearchCriteria($_REQUEST);			
		}
		
		if (isset($_SESSION['sdata']) && count($_SESSION['sdata']) > 0) {
			//print_r($_SESSION['sdata']);
			$_REQUEST = $_SESSION['sdata'];
			unset($_SESSION['sdata']);
		}

        $custom_filters['caratmin'] = isset($_REQUEST['caratmin']) ? $_REQUEST['caratmin'] : '';
        $custom_filters['caratmax'] = isset($_REQUEST['caratmax']) ? $_REQUEST['caratmax'] : '';
        $custom_filters['color'] = isset($_REQUEST['color']) ? implode(',', $_REQUEST['color']) : '';
        $custom_filters['cut'] = isset($_REQUEST['cut']) ? implode(',', $_REQUEST['cut']) : '';
        $custom_filters['shape'] = isset($_REQUEST['shape']) ? implode(',', $_REQUEST['shape']) : '';
        $custom_filters['clarity'] = isset($_REQUEST['clarity']) ? implode(',', $_REQUEST['clarity']) : '';
        $custom_filters_encoded = urlencode(json_encode($custom_filters));
        //echo "<pre>";
        //print_r($custom_filters);
        ///print_r(json_decode(urldecode($custom_filters_encoded)));

        if (count($_REQUEST['owner']) > 0)
            $id_array = implode(",", $_REQUEST['owner']);
        $data = $this->getCommonData();

        $data['name'] = $this->getAdminDetails();
        $data['extraheader'] = '';
        $collections = '';
        $typeoptions = '';
        $data['collections'] = '';
        $data['typeoptions'] = '';
        if ($this->isadminlogin()) {
            if ($action == 'delete') {
                $ret = $this->adminmodel->rapnetstones($_POST, $action, $id);
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: text/x-json");
                $json = "";
                $json .= "{\n";
                $json .= "total: " . $ret['total'] . ",\n";
                $json .= "}\n";
                echo $json;
            } else {
                if ($action == 'add' || $action == 'edit') {
                    $this->load->helper(array('form', 'url'));
                    $this->load->library('form_validation');
                    $this->form_validation->set_error_delimiters('<font class="require">', '</font>');
                    if (isset($_POST[$action . 'btn'])) {

                        $ret = $this->adminmodel->rapnetstones($_POST, $action, $id);
                        if ($ret['error'] == '') {
                            $data['success'] = $ret['success'];
                        } else {
                            $data['error'] = $ret['error'];
                            if ($action != 'edit')
                                $data['details'] = $_POST;
                        }
                    }
                    $data['extraheader'] .= $this->commonmodel->addEditor('simple');
                    if ($action == 'edit') {
                        $this->load->model('rolexmodel');
                        $this->load->model('watchesmodel');
                        $details = $this->adminmodel->getRapnetStonesById($id);
                        $data['details'] = $details[0];
                        $data['collections'] = $collections;
                        $data['animations'] = $this->adminmodel->getFlashByStockId($id);
                        $data['id'] = $id;
                    }
                }
                $data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
              {
    $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
    $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
      });
    $("#rapnet").click();';


                $data['leftmenus'] = $this->adminmodel->adminmenuhtml('rapnetDiamonds');
                $id_array = trim($id_array);
                //print_r(trim($custom_filters);
                //error_reporting(E_ALL);
                //ini_set("display_errors", "1");
                //ini_set("display_startup_errors", "1");

                $url = config_item('base_url') . 'admin/getRapnetStones/' . $id_array . '/' . $custom_filters_encoded;
                $data['action'] = $action;
                $data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'lot', width : 80, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Certificate Image', name : 'price', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Shape image', name : 'shape', width : 60, sortable : true, align: 'center'},
																		{display: 'ebayItemId', name : 'ebayid', width : 85, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Rapnet Price', name : 'price', width : 85, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Our Price', name : 'price', width : 85, sortable : true, align: 'center'},
																		{display: 'Owner ID', name : 'owner', width : 120, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Clarity', name : 'clarity', width : 120, sortable : true, align: 'center'},
																		{display: 'Shape', name : 'shape', width : 120, sortable : true, align: 'center'},
																		{display: 'Carat', name : 'carat', width : 75, sortable : true, align: 'center'},
																		{display: 'Color', name : 'color', width : 125, sortable : true, align: 'center'},																		
                                                                                                                                                {display: 'Meas', name : 'Meas', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Cert_N', name : 'Cert_n', width : 60, sortable : true, align: 'center'},      
                                                                                                                                                {display: 'Stock', name : 'Stock_n', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Country', name : 'Country', width : 60, sortable : true, align: 'center'},      
                                                                                                                                                {display: 'State', name : 'State', width : 60, sortable : true, align: 'center'},            
																		{display: 'Cert', name : 'Cert', width : 60, sortable : true, align: 'center',hide: true},
                                                                                                                                                {display: 'Cut', name : 'cut', width : 60, sortable : true, align: 'center',hide: true}
																		],
																		 buttons : [	{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'lot', isdefault: true},
																		{display: 'Certificate', name : 'Cert', isdefault: true},
                                                                                                                                                {display: 'Stock', name : 'Stock_n', isdefault: true},
																		{display: 'Owner', name : 'owner', isdefault: false}																		
																		], 		
																	sortname: \"Date\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Ring and Diamonds</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1400,
																	height: 565
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }																                                
                                                                                                                                                                  
                                                                                                                                                                                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/rapnetdiamonds/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                   error: function(x,e){  alert(x.status +  e + itemlist + x.responseText); }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/rolex/add';
																			}			
																	}
														 
														 ";


                $data['extraheader'] .= ' 
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
                $data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

                $data['extraheader'] .= ' 
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';

                $data['extraheader'] .= ' 
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
                $data['onloadextraheader'] .= " 
											var so;				
		 									";
                $data['usetips'] = true;

                $output = $this->load->view('admin/rapnetDiamonds', $data, true);


                $this->output($output, $data);
            }
        } else {
            $output = $this->load->view('admin/login', $data, true);
            $this->output($output, $data);
        }
    }

    function getRapnetStones($addoption = '') {
        //error_reporting(E_ALL);
        //ini_set("display_errors", "1");
        //ini_set("display_startup_errors", "1");

        $id_array = $this->uri->segment(3);
        $custom_filters = $this->uri->segment(4);
        $custom_filters_1 = json_decode(urldecode($custom_filters));
        //var_dump($custom_filters_1);
        //exit;
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
        $sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';
        $sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
        $query = isset($_POST['query']) ? $_POST['query'] : '';
        $qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';

        /* custom filters */
        if (isset($custom_filters_1)) {

            $results = $this->adminmodel->getRapnetStones($id_array, $page, $rp, $sortname, $sortorder, $query, $qtype, '', $custom_filters_1);
        } else {
            $results = $this->adminmodel->getRapnetStones($id_array, $page, $rp, $sortname, $sortorder, $query, $qtype);
        }
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: " . $results['count'] . ",\n";
        $json .= "rows: [";
        $rc = false;

        $destFolder = config_item('base_url') . 'images/pictures/new/rings/';

        foreach ($results['result'] as $row) {

            if (empty($row['certimage'])) {
                $sql = "SELECT cert_img FROM " . $this->config->item('table_perfix') . "cert  WHERE cert_name = '" . $row['Cert'] . "'";
                $query = $this->db->query($sql);
                $result = $query->result_array();
                $row['certimage'] = config_item('base_url') . $result[0]['cert_img'];
            }
            if (!empty($row['Meas'])) {
                list($w, $b, $h) = explode("x", $row['Meas']);
                $meas = $w . " x " . $b . " x " . $h;
            } else {
                $meas = '';
            }
            $shape = '';
            switch ($row['shape']) {
                case 'Round':
                    $shape = 'Round';
                    $destFile = $destFolder . 'round.jpg';

                    break;
                case 'Princess':
                    $shape = 'Princess';
                    $destFile = $destFolder . 'princessrings.jpg';

                    break;
                case 'Radiant':
                    $shape = 'Radiant';
                    $destFile = $destFolder . 'radiantring.jpg';

                    break;
                case 'Emerald':
                    $shape = 'Emerald';
                    $destFile = $destFolder . 'emeraldring.jpg';

                    break;
                case 'Asscher':
                case 'Sq. Emerald':
                    $shape = 'Asscher';
                    $destFile = $destFolder . 'asscherring.jpg';

                    break;
                case 'Oval':
                    $shape = 'Oval';
                    $destFile = $destFolder . 'oval.jpg';

                    break;
                case 'Marquise':
                    $shape = 'Marquise';
                    $destFile = $destFolder . 'marquisering.jpg';

                    break;
                case 'Pear':
                    $shape = 'Pear';
                    $destFile = $destFolder . 'pear.jpg';

                    break;
                case 'Heart':
                    $shape = 'Heart';
                    $destFile = $destFolder . 'heart.jpg';

                    break;
                case 'Cushion':
                    $shape = 'Cushion';
                    $destFile = $destFolder . 'cushionring.jpg';

                    break;
                case 'Cushion Modified':
                    $shape = 'Cushion';
                    $destFile = $destFolder . 'cushionring.jpg';

                    break;
                default:
                    $shape = $row['shape'];
                    break;
            }

            if (!empty($shape)) {
                $sql = "SELECT picture1 FROM " . $this->config->item('table_perfix') . "pictures  WHERE  diamondshape = '" . $shape . "'";
                $query = $this->db->query($sql);
                $result = $query->result_array();
                $row['shapeimage'] = config_item('base_url') . $result[0]['picture1'] . "jpg";
            }

            if ($rc)
                $json .= ",";
            $json .= "\n {";
            $json .= "id:'" . $row['lot'] . "',";
            $json .= "cell:['Lot #: " . $row['lot'] . "<br /><a href=\'" . config_item('base_url') . "admin/rapnetDiamonds/edit/" . $row['lot'] . "\'  class=\"edit\" style=\"color:red;font-weight:bold;\">Send to eBay</a>'";

            if ($row['certimage'] != '')
                $json .= ",'<img src=\'" . ($row['certimage']) . "\' width=\'80\'><br />'";
            else
                $json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

            if ($row['shapeimage'] != '')
                $json .= ",'<img src=\'" . $destFile . "\' width=\'80\'><br />'";
            else
                $json .= ",'<img src=\'" . $destFile . "\' width=\'80\'><br />'";
            
			$pc_price = number_format($row['price'],2);  //price per carat from rapnet
        $price = $row['price'];
		if (!empty($row['Meas'])) {
			$price =  $price * $row['carat'];
		}
			
        $qry = "SELECT rate FROM " . config_item('table_perfix') . "helix_prices WHERE pricefrom <= '$price'  and  priceto > '$price' ORDER BY pricefrom ASC LIMIT 0,1";
        $result = $this->db->query($qry);
        $pret = $result->row_array();
		$rate = $pret['rate'];
			
		$rate = ($rate/100);
		$xprice = $price * $rate;
		$ourprice = $price + $xprice;
		$rprice = ( $ourprice * (1.65/100) ) + $ourprice;
		$rprice = $rprice + 195;
	
		$ourprice = number_format(round($ourprice));
		$rprice = number_format(round($rprice));
		
            $json .= ",'" . addslashes($row['ebayid']) . "'";
            $json .= ",'" . addslashes($pc_price) . "'";
            $json .= ",'" . addslashes($ourprice) . "'";
            $json .= ",'" . addslashes($row['owner']) . "'";
            $json .= ",'" . addslashes($row['clarity']) . "'";
            $json .= ",'" . addslashes($shape) . "'";
            $json .= ",'" . addslashes(number_format($row['carat'], 2)) . "'";
            $json .= ",'" . addslashes(ucfirst($row['color'])) . "'";
            $json .= ",'" . addslashes(ucfirst($meas)) . "'";
            $json .= ",'" . addslashes(ucfirst($row['Cert_n'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['Stock_n'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['Country'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['State'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['Cert'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['cut'])) . "'";

            $json .= "]";
            $json .= "}";
            $rc = true;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

	function owners($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->owners($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					//        $this->load->library('form_validation');
					//          $this->form_validation->set_error_delimiters('<font class="require">', '</font>');
					if (isset($_POST[$action . 'btn'])) {
						$ret = $this->adminmodel->owners($_POST, $action, $id);
						if ($ret['error'] == '')
						$data['success'] = $ret['success'];
						else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					if ($action == 'edit') {
						$details = $this->adminmodel->getOwnerById($id);
						$data['details'] = $details[0];
						$data['collections'] = $collections;
						$data['animations'] = $this->adminmodel->getFlashByStockId($id);
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
              {
    $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
    $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
      });
    $("#rapnet").click();';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('owners');
				$url = config_item('base_url') . 'admin/getowners';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'owner_id', width : 80, sortable : true, align: 'center'},
                                                                                                                                                {display: 'ownerID', name : 'company_id', width : 60, sortable : true, align: 'center'},
																		{display: 'company', name : 'company_name', width : 85, sortable : true, align: 'center'},
                                                                                                                                                {display: 'add date', name : 'company_adddate', width : 60, sortable : true, align: 'center' }
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
																				{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Owners #', name : 'owner_id', isdefault: true},
																		{display: 'Company name', name : 'company_name', isdefault: true},
                                                                                                                                                {display: 'Company ID', name : 'company_id', isdefault: true}

																		],
																	sortname: \"owner_id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Rapnet Companies</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1020,
																	height: 565
																	}
																	);

																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{

																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }

																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/owners/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                     error: function(x,e){  alert(x.status +  e + itemlist + x.responseText); }
																										 });



																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                }


																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/owners/add';
																			}
																	}

														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/owners', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getowners($addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'owner_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';


		$results = $this->adminmodel->getowners($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$s = 1;
		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['owner_id'] . "',";
			$json .= "cell:['Owners #: " . $s . "<br /><a href=\'" . config_item('base_url') . "admin/owners/edit/" . $row['owner_id'] . "\'  class=\"edit\" >Edit </a>'";
			$json .= ",'" . addslashes($row['company_id']) . "'";
			$json .= ",'" . addslashes($row['company_name']) . "'";
			$json .= ",'" . addslashes($row['company_adddate']) . "'";
			$json .= "]";
			$json .= "}";
			$rc = true;
			$s = $s + 1;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function get_all_owners($addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'owner_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';


		$results = $this->adminmodel->getowners($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		$s = 1;
		foreach ($results['result'] as $row) {
			$shape = '';

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['owner_id'] . "',";
			$json .= "cell:['<input type=\"checkbox\" name=\"owner[]\" value=\"$row[company_id]\">'";


			$json .= ",'" . addslashes($row['company_id']) . "'";
			$json .= ",'" . addslashes($row['company_name']) . "'";
			$json .= ",'" . addslashes($row['company_adddate']) . "'";
			$json .= "]";
			$json .= "}";
			$rc = true;
			$s = $s + 1;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}





	function cert($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->cert($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					if (isset($_POST[$action . 'btn'])) {
						$ret = $this->adminmodel->cert($_POST, $action, $id);
						if ($ret['error'] == '')
						$data['success'] = $ret['success'];
						else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					if ($action == 'edit') {
						$details = $this->adminmodel->getcertsById($id);

						$data['details'] = $details[0];
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
              {
    $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
    $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
      });
    $("#rapnet").click();';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('cert');
				$url = config_item('base_url') . 'admin/getcerts';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'cert_id', width : 80, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Certificate Name', name : 'cert_name', width : 160, sortable : true, align: 'center'},
																		{display: 'Certificate Image', name : 'cert_img', width : 185, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Certificate date', name : 'cert_adddate', width : 160, sortable : true, align: 'center'}
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
																			    {name: 'Delete', bclass: 'delete', onpress : test},
																			    {separator: true}
																			],
																	searchitems : [
																		{display: 'Cert ID#', name : 'cert_id', isdefault: true},
																		{display: 'Certificate name', name : 'cert_name', isdefault: true}

																		],
																	sortname: \"cert_adddate\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Certificates</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1020,
																	height: 565
																	}
																	);

																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{

																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }

																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/cert/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   }
																										 });



																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                }


																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/cert/add';
																			}
																	}

														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/cert', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getcerts() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'cert_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';


		$results = $this->adminmodel->getcerts($page, $rp, $sortname, $sortorder, $query, $qtype);


		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;

		foreach ($results['result'] as $row) {


			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['cert_id'] . "',";
			$json .= "cell:['Certificate #: " . $row['cert_id'] . "<br /><a href=\'" . config_item('base_url') . "admin/cert/edit/" . $row['cert_id'] . "\'  class=\"edit\" >Edit </a>'";
			$json .= ",'" . addslashes($row['cert_name']) . "'";
			if (file_exists(config_item('base_path') . addslashes($row['cert_img'])) && $row['cert_img'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . addslashes($row['cert_img']) . "\' width=\'80\'>'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";
			$json .= ",'" . addslashes($row['cert_adddate']) . "'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}

	function diamondshapes($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->diamondshapes($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');
					if (isset($_POST['addbtn'])) {

						$ret = $this->adminmodel->diamondshapes($_POST, $action, $id);
						if ($ret['error'] == '') {
							$data['success'] = $ret['success'];
						} else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');

					if ($action == 'edit') {

						$details = $this->adminmodel->diamondshapesByID($id);
						$data['details'] = $details[0];
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
              {
    $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
    $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
      });
    $("#rapnet").click();';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('shapes');
				$url = config_item('base_url') . 'admin/getdiamondshapes';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'pic_id', width : 80, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Shape', name : 'shape', width : 60, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture1', name : 'picture1', width : 60, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture2', name : 'picture2', width : 85, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture3', name : 'picture3', width : 85, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture4', name : 'picture4', width : 85, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture5', name : 'picture5', width : 85, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture6', name : 'picture6', width : 85, sortable : true, align: 'center'}
																		
																		],
																		 buttons : [	{name: 'Delete', bclass: 'delete', onpress : test},{name: 'Add', bclass: 'add', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'PIC ID #', name : 'pic_id', isdefault: true}
																																			
																		], 		
																	sortname: \"pic_id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Diamonds Shapes Pictures</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1020,
																	height: 565
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }																                                
                                                                                                                                                                  
                                                                                                                                                                                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/diamondshapes/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                   error: function(x,e){  alert(x.status +  e + itemlist + x.responseText); }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/diamondshapes/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/diamondshapes', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getdiamondshapes($addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'pic_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';


		$results = $this->adminmodel->getdiamondshapes($page, $rp, $sortname, $sortorder, $query, $qtype);


		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		foreach ($results['result'] as $row) {

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['pic_id'] . "',";
			$json .= "cell:['Lot #: " . $row['pic_id'] . "<br /><a href=\'" . config_item('base_url') . "admin/diamondshapes/edit/" . $row['pic_id'] . "\'  class=\"edit\" style=\"color:red;font-weight:bold;\">Edit</a>'";
			$json .= ",'" . addslashes(ucfirst($row['diamondshape'])) . "'";
			if ($row['picture1'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture1']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture2'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture2']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture3'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture3']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture4'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture4']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture5'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture5']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture6'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture6']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";




			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}
	function rapnetDiamondsSearch($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->pendantstones($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');
					if (isset($_POST[$action . 'btn'])) {

						$ret = $this->adminmodel->pendantstones($_POST, $action, $id);
						if ($ret['error'] == '') {
							$data['success'] = $ret['success'];
						} else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');

					if ($action == 'edit') {

						$details = $this->adminmodel->getPendantById($id);
						$data['details'] = $details[0];
						$data['collections'] = $collections;
						$data['animations'] = $this->adminmodel->getFlashByStockId($id);
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
              {
    $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
    $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
      });
    $("#loose").click();';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('pendants');
				$url = config_item('base_url') . 'admin/getpendants';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'lot', width : 80, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Certificate Image', name : 'price', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Shape image', name : 'shape', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'ebayItemId', name : 'ebayid', width : 85, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Rapnet Price', name : 'price', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Our Price', name : 'price', width : 60, sortable : true, align: 'center'},																		
																		{display: 'Owner ID', name : 'owner', width : 120, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Clarity', name : 'clarity', width : 120, sortable : true, align: 'center'},
																		{display: 'Shape', name : 'shape', width : 120, sortable : true, align: 'center'},
																		{display: 'Carat', name : 'carat', width : 75, sortable : true, align: 'center'},
																		{display: 'Color', name : 'color', width : 125, sortable : true, align: 'center'},																		
                                                                                                                                                {display: 'Meas', name : 'Meas', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Cert_N', name : 'Cert_n', width : 60, sortable : true, align: 'center'},      
                                                                                                                                                {display: 'Stock', name : 'Stock_n', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Country', name : 'Country', width : 60, sortable : true, align: 'center'},      
                                                                                                                                                {display: 'State', name : 'State', width : 60, sortable : true, align: 'center'},            
																		{display: 'Cert', name : 'Cert', width : 60, sortable : true, align: 'center',hide: true},
                                                                                                                                                {display: 'Cut', name : 'cut', width : 60, sortable : true, align: 'center',hide: true}
																		],
																		 buttons : [	{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'lot', isdefault: true},
																		{display: 'Certificate', name : 'Cert', isdefault: true},
                                                                                                                                                {display: 'Stock', name : 'Stock_n', isdefault: true},
																		{display: 'Owner', name : 'owner', isdefault: false}																		
																		], 		
																	sortname: \"Date\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Loose Diamonds</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1020,
																	height: 565
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }																                                
                                                                                                                                                                  
                                                                                                                                                                                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/loosediamonds/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                   error: function(x,e){  alert(x.status +  e + itemlist + x.responseText); }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/loosediamonds/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/loosediamonds_search', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

    function loosediamonds($action = 'view', $id = 0) {
        $data = $this->getCommonData();
        $data['name'] = $this->getAdminDetails();
        $data['extraheader'] = '';
        $collections = '';
        $typeoptions = '';
        $data['collections'] = '';
        $data['typeoptions'] = '';
        if ($this->isadminlogin()) {
            if ($action == 'delete') {
                $ret = $this->adminmodel->owners($_POST, $action, $id);
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: text/x-json");
                $json = "";
                $json .= "{\n";
                $json .= "total: " . $ret['total'] . ",\n";
                $json .= "}\n";
                echo $json;
            } else {
                if ($action == 'add' || $action == 'edit') {
                    $this->load->helper(array('form', 'url'));
                    //        $this->load->library('form_validation');
//          $this->form_validation->set_error_delimiters('<font class="require">', '</font>');
                    if (isset($_POST[$action . 'btn'])) {
                        $ret = $this->adminmodel->owners($_POST, $action, $id);
                        if ($ret['error'] == '')
                            $data['success'] = $ret['success'];
                        else {
                            $data['error'] = $ret['error'];
                            if ($action != 'edit')
                                $data['details'] = $_POST;
                        }
                    }
                    $data['extraheader'] .= $this->commonmodel->addEditor('simple');
                    if ($action == 'edit') {
                        $details = $this->adminmodel->getOwnerById($id);
                        $data['details'] = $details[0];
                        $data['collections'] = $collections;
                        $data['animations'] = $this->adminmodel->getFlashByStockId($id);
                        $data['id'] = $id;
                    }
                }
                $data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
              {
    $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
    $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
      });
    $("#rapnet").click();';
                $data['leftmenus'] = $this->adminmodel->adminmenuhtml('owners');
                $url = config_item('base_url') . 'admin/get_all_owners';
                $data['action'] = $action;
                $data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'owner_id', width : 80, sortable : true, align: 'center'},
                                                                        {display: 'ownerID', name : 'company_id', width : 60, sortable : true, align: 'center'},
																		{display: 'company', name : 'company_name', width : 85, sortable : true, align: 'center'},
                                                                    	{display: 'add date', name : 'company_adddate', width : 60, sortable : true, align: 'center' }
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
																				{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Owners #', name : 'owner_id', isdefault: true},
																		{display: 'Company name', name : 'company_name', isdefault: true},
                                                                        {display: 'Company ID', name : 'company_id', isdefault: true}
																		],
																	sortname: \"owner_id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Rapnet Companies</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1020,
																	height: 565
																	}
																	);

																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{

																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }

																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/owners/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                     error: function(x,e){  alert(x.status +  e + itemlist + x.responseText); }
																										 });



																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                }


																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/owners/add';
																			}
																	}

														 ";


                $data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
                $data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

                $data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
                $data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
                $data['onloadextraheader'] .= "
											var so;
		 									";
                $data['usetips'] = true;

				$data['savesearch'] = $this->adminmodel->getSavelooseSearch();

                $output = $this->load->view('admin/all_owners', $data, true);


                $this->output($output, $data);
            }
        } else {
            $output = $this->load->view('admin/login', $data, true);
            $this->output($output, $data);
        }
    }


    function allloosediamonds($action = 'view', $id = 0) {
        // print_r($_REQUEST['owner']);
        //echo "<pre>";
        //print_r($_POST);
        //exit;
		
		if (isset($_REQUEST['submit_search']) && !empty($_REQUEST['submit_search'])) {
			$this->adminmodel->savelooseSearchCriteria($_REQUEST);			
		}
		
		if (isset($_SESSION['sldata']) && count($_SESSION['sldata']) > 0) {
			//var_dump($_SESSION['sdata']);
			$_REQUEST = $_SESSION['sldata'];
			unset($_SESSION['sldata']);
		}
		
		//echo "<pre>"; print_r($_REQUEST); exit;

        $custom_filters['caratmin'] = isset($_REQUEST['caratmin']) ? $_REQUEST['caratmin'] : '';
        $custom_filters['caratmax'] = isset($_REQUEST['caratmax']) ? $_REQUEST['caratmax'] : '';
        $custom_filters['color'] = isset($_REQUEST['color']) ? implode(',', $_REQUEST['color']) : '';
        $custom_filters['cut'] = isset($_REQUEST['cut']) ? implode(',', $_REQUEST['cut']) : '';
        $custom_filters['shape'] = isset($_REQUEST['shape']) ? implode(',', $_REQUEST['shape']) : '';
        $custom_filters['clarity'] = isset($_REQUEST['clarity']) ? implode(',', $_REQUEST['clarity']) : '';
        $custom_filters_encoded = urlencode(json_encode($custom_filters));
        //echo "<pre>";
        //print_r($custom_filters);
        ///print_r(json_decode(urldecode($custom_filters_encoded)));

        if (count($_REQUEST['owner']) > 0)
            $id_array = implode(",", $_REQUEST['owner']);
        $data = $this->getCommonData();
        $data['name'] = $this->getAdminDetails();
        $data['extraheader'] = '';
        $collections = '';
        $typeoptions = '';
        $data['collections'] = '';
        $data['typeoptions'] = '';
        if ($this->isadminlogin()) {
            if ($action == 'delete') {
                $ret = $this->adminmodel->pendantstones($_POST, $action, $id);
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: text/x-json");
                $json = "";
                $json .= "{\n";
                $json .= "total: " . $ret['total'] . ",\n";
                $json .= "}\n";
                echo $json;
            } else {
                if ($action == 'add' || $action == 'edit') {
                    $this->load->helper(array('form', 'url'));
                    $this->load->library('form_validation');
                    $this->form_validation->set_error_delimiters('<font class="require">', '</font>');
                    if (isset($_POST[$action . 'btn'])) {

                        $ret = $this->adminmodel->pendantstones($_POST, $action, $id);

                        if ($ret['error'] == '') {
                            $data['success'] = $ret['success'];
                        } else {
                            $data['error'] = $ret['error'];
                            if ($action != 'edit')
                                $data['details'] = $_POST;
                        }
                    }
                    $data['extraheader'] .= $this->commonmodel->addEditor('simple');

                    if ($action == 'edit') {

                        $details = $this->adminmodel->getPendantById($id);
                        $data['details'] = $details[0];
                        $data['collections'] = $collections;
                        $data['animations'] = $this->adminmodel->getFlashByStockId($id);
                        $data['id'] = $id;
                    }
                }
                $data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
              {
    $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
    $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
      });
    $("#loose").click();';
                $data['leftmenus'] = $this->adminmodel->adminmenuhtml('pendants');
				if($id_array==''){ $id_array=0; }
                $url = config_item('base_url') . 'admin/getpendants/' . $id_array . '/' . $custom_filters_encoded;
                $data['action'] = $action;
                $data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'lot', width : 80, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Certificate Image', name : 'price', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Shape image', name : 'shape', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'ebayItemId', name : 'ebayid', width : 85, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Rapnet Price', name : 'price', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Our Price', name : 'price', width : 60, sortable : true, align: 'center'},																		
																		{display: 'Owner ID', name : 'owner', width : 120, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Clarity', name : 'clarity', width : 120, sortable : true, align: 'center'},
																		{display: 'Shape', name : 'shape', width : 120, sortable : true, align: 'center'},
																		{display: 'Carat', name : 'carat', width : 75, sortable : true, align: 'center'},
																		{display: 'Color', name : 'color', width : 125, sortable : true, align: 'center'},																		
                                                                                                                                                {display: 'Meas', name : 'Meas', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Cert_N', name : 'Cert_n', width : 60, sortable : true, align: 'center'},      
                                                                                                                                                {display: 'Stock', name : 'Stock_n', width : 60, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Country', name : 'Country', width : 60, sortable : true, align: 'center'},      
                                                                                                                                                {display: 'State', name : 'State', width : 60, sortable : true, align: 'center'},            
																		{display: 'Cert', name : 'Cert', width : 60, sortable : true, align: 'center',hide: true},
                                                                                                                                                {display: 'Cut', name : 'cut', width : 60, sortable : true, align: 'center',hide: true}
																		],
																		 buttons : [	{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Lot #', name : 'lot', isdefault: true},
																		{display: 'Certificate', name : 'Cert', isdefault: true},
                                                                                                                                                {display: 'Stock', name : 'Stock_n', isdefault: true},
																		{display: 'Owner', name : 'owner', isdefault: false}																		
																		], 		
																	sortname: \"Date\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Loose Diamonds</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1020,
																	height: 565
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }																                                
                                                                                                                                                                  
                                                                                                                                                                                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/loosediamonds/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                   error: function(x,e){  alert(x.status +  e + itemlist + x.responseText); }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/loosediamonds/add';
																			}			
																	}
														 
														 ";


                $data['extraheader'] .= ' 
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
                $data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

                $data['extraheader'] .= ' 
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
                $data['extraheader'] .= ' 
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
                $data['onloadextraheader'] .= " 
											var so;				
		 									";
                $data['usetips'] = true;



                $output = $this->load->view('admin/loosediamonds', $data, true);


                $this->output($output, $data);
            }
        } else {
            $output = $this->load->view('admin/login', $data, true);
            $this->output($output, $data);
        }
    }
	
function rapnetcomdiamonds($action = 'view', $id = 0) {
        $data = $this->getCommonData();
        $data['name'] = $this->getAdminDetails();
        $data['extraheader'] = '';
        $collections = '';
        $typeoptions = '';
        $data['collections'] = '';
        $data['typeoptions'] = '';
        if ($this->isadminlogin()) {
            if ($action == 'delete') {
                $ret = $this->adminmodel->owners($_POST, $action, $id);
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: text/x-json");
                $json = "";
                $json .= "{\n";
                $json .= "total: " . $ret['total'] . ",\n";
                $json .= "}\n";
                echo $json;
            } else {
                if ($action == 'add' || $action == 'edit') {
                    $this->load->helper(array('form', 'url'));
                    //        $this->load->library('form_validation');
//          $this->form_validation->set_error_delimiters('<font class="require">', '</font>');
                    if (isset($_POST[$action . 'btn'])) {
                        $ret = $this->adminmodel->owners($_POST, $action, $id);
                        if ($ret['error'] == '')
                            $data['success'] = $ret['success'];
                        else {
                            $data['error'] = $ret['error'];
                            if ($action != 'edit')
                                $data['details'] = $_POST;
                        }
                    }
                    $data['extraheader'] .= $this->commonmodel->addEditor('simple');
                    if ($action == 'edit') {
                        $details = $this->adminmodel->getOwnerById($id);
                        $data['details'] = $details[0];
                        $data['collections'] = $collections;
                        $data['animations'] = $this->adminmodel->getFlashByStockId($id);
                        $data['id'] = $id;
                    }
                }
                $data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
              {
    $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
    $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
      });
    $("#rapnet").click();';
                $data['leftmenus'] = $this->adminmodel->adminmenuhtml('owners');
                $url = config_item('base_url') . 'admin/get_all_owners';
                $data['action'] = $action;
                $data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'owner_id', width : 80, sortable : true, align: 'center'},
                                                                                                                                                {display: 'ownerID', name : 'company_id', width : 60, sortable : true, align: 'center'},
																		{display: 'company', name : 'company_name', width : 85, sortable : true, align: 'center'},
                                                                                                                                                {display: 'add date', name : 'company_adddate', width : 60, sortable : true, align: 'center' }
																		],
																		 buttons : [{name: 'Add', bclass: 'add', onpress : test},
																				{name: 'Delete', bclass: 'delete', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'Owners #', name : 'owner_id', isdefault: true},
																		{display: 'Company name', name : 'company_name', isdefault: true},
                                                                                                                                                {display: 'Company ID', name : 'company_id', isdefault: true}

																		],
																	sortname: \"owner_id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Rapnet Companies</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1020,
																	height: 565
																	}
																	);

																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{

																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }

																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/owners/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                     error: function(x,e){  alert(x.status +  e + itemlist + x.responseText); }
																										 });



																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                }


																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/owners/add';
																			}
																	}

														 ";


                $data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
                $data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

                $data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
                $data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
                $data['onloadextraheader'] .= "
											var so;
		 									";
                $data['usetips'] = true;

				$data['savesearch'] = $this->adminmodel->getSaveSearch();

                $output = $this->load->view('admin/all_ring_owners', $data, true);


                $this->output($output, $data);
            }
        } else {
            $output = $this->load->view('admin/login', $data, true);
            $this->output($output, $data);
        }
    }

    function getpendants($addoption = '') {
        $id_array = $this->uri->segment(3, 0);
        $custom_filters = $this->uri->segment(4);
        $custom_filters_1 = json_decode(urldecode($custom_filters));
        //var_dump($custom_filters_1);
        //exit; 

        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
        $sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';
        $sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
        $query = isset($_POST['query']) ? $_POST['query'] : '';
        $qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';

        /* custom filters */
        if (isset($custom_filters_1)) {

            $results = $this->adminmodel->getPendants($page, $rp, $sortname, $sortorder, $query, $qtype,$id_array, '', $custom_filters_1);
        } else {
            $results = $this->adminmodel->getPendants($page, $rp, $sortname, $sortorder, $query, $qtype,$id_array);
        }

        //$results = $this->adminmodel->getPendants($page, $rp, $sortname, $sortorder, $query, $qtype, $id_array);

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: text/x-json");
        $json = "";
        $json .= "{\n";
        $json .= "page: $page,\n";
        $json .= "total: " . $results['count'] . ",\n";
        $json .= "rows: [";
        $rc = false;

        $destFolder = config_item('base_url') . 'images/diamonds/shape/';
//echo "<pre>"; print_r($results['result']); exit;
        foreach ($results['result'] as $row) {

            if (empty($row['certimage'])) {
                $sql = "SELECT cert_img FROM " . $this->config->item('table_perfix') . "cert  WHERE cert_name = '" . $row['Cert'] . "'";
                $query = $this->db->query($sql);
                $result = $query->result_array();
                $row['certimage'] = config_item('base_url') . $result[0]['cert_img'];
            }

            if (!empty($row['Meas'])) {
                list($w, $b, $h) = explode("x", $row['Meas']);
                $meas = $w . " x " . $b . " x " . $h;
            } else {
                $meas = '';
            }
		 $pendantImage='';  
         $sql_img = "SELECT picture1 FROM " . $this->config->item('table_perfix') . "loosepictures  WHERE  diamondshape = '" . $row['shape'] . "'";
         $qry_img = $this->db->query($sql_img);
         $img_res = $qry_img->result_array();
         $pendantImage = config_item('base_url') . $img_res[0]['picture1'];
             
		//-------------- price calc
		
		$pc_price = number_format($row['price'],2);  //price per carat from rapnet
        $price = $row['price'];
		
		if (!empty($row['Meas'])) {
			$price = $price * $row['carat'];
		}
			
        $qry = "SELECT rate FROM " . config_item('table_perfix') . "helix_prices WHERE pricefrom <= '$price'  and  priceto > '$price' ORDER BY pricefrom ASC LIMIT 0,1";
        $result = $this->db->query($qry);
        $pret = $result->row_array();
		$rate = $pret['rate'];
			
		$rate = ($rate/100);
		$xprice = $price * $rate;
		$ourprice = $price + $xprice;
		$rprice = ( $ourprice * (1.65/100) ) + $ourprice;
		
		$ourprice = number_format(round($ourprice));
		$rprice = number_format(round($rprice));
		//-------------- price calc	
			 
			
            if ($rc)
                $json .= ",";
            $json .= "\n {";
            $json .= "id:'" . $row['lot'] . "',";
            $json .= "cell:['Lot #: " . $row['lot'] . "<br /><a href=\'" . config_item('base_url') . "admin/allloosediamonds/edit/" . $row['lot'] . "\'  class=\"edit\" style=\"color:red;font-weight:bold;\">Send to eBay</a>'";

            if ($row['certimage'] != '') {
                $json .= ",'<img src=\'" . ($row['certimage']) . "\' width=\'80\'><br />'";
            } else {
                $json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";
            }
            $json .= ",'<img src=\'" . ($pendantImage) . "\' width=\'80\'><br />'";
            
            $json .= ",'" . addslashes($row['ebayid']) . "'";
            $json .= ",'$" . addslashes($pc_price) . "'";
            $json .= ",'$" . addslashes($ourprice) . "'";
            $json .= ",'" . addslashes($row['owner']) . "'";
            $json .= ",'" . addslashes($row['clarity']) . "'";
            $json .= ",'" . addslashes($row['shape']) . "'";
            $json .= ",'" . addslashes(number_format($row['carat'], 2)) . "'";
            $json .= ",'" . addslashes(ucfirst($row['color'])) . "'";
            $json .= ",'" . addslashes(ucfirst($meas)) . "'";
            $json .= ",'" . addslashes(ucfirst($row['Cert_n'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['Stock_n'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['Country'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['State'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['Cert'])) . "'";
            $json .= ",'" . addslashes(ucfirst($row['cut'])) . "'";

            $json .= "]";
            $json .= "}";
            $rc = true;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
    }

	function configuration() {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		if ($this->isadminlogin()) {

			$output = $this->load->view('admin/configuration', $data, true);
		}else
		$output = $this->load->view('admin/login', $data, true);

		$this->output($output, $data);
	}

	function loosediamondshapes($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		$collections = '';
		$typeoptions = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->loosediamondshapes($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');
					if (isset($_POST['addbtn'])) {

						$ret = $this->adminmodel->loosediamondshapes($_POST, $action, $id);
						if ($ret['error'] == '') {
							$data['success'] = $ret['success'];
						} else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');

					if ($action == 'edit') {

						$details = $this->adminmodel->loosediamondshapesByID($id);
						$data['details'] = $details[0];
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
              {
    $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
    $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
      });
    $("#rapnet").click();';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('shapes');
				$url = config_item('base_url') . 'admin/getloosediamondshapes';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
																	(
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
																		{display: 'ID', name : 'pic_id', width : 80, sortable : true, align: 'center'},
                                                                                                                                                {display: 'Shape', name : 'shape', width : 60, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture1', name : 'picture1', width : 60, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture2', name : 'picture2', width : 85, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture3', name : 'picture3', width : 85, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture4', name : 'picture4', width : 85, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture5', name : 'picture5', width : 85, sortable : true, align: 'center'},
                                                                                                                                                            {display: 'Picture6', name : 'picture6', width : 85, sortable : true, align: 'center'}
																		
																		],
																		 buttons : [	{name: 'Delete', bclass: 'delete', onpress : test},{name: 'Add', bclass: 'add', onpress : test},
																				{separator: true}
																			],
																	searchitems : [
																		{display: 'PIC ID #', name : 'pic_id', isdefault: true}
																																			
																		], 		
																	sortname: \"pic_id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Loose Diamonds Shapes Pictures</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1020,
																	height: 565
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }																                                
                                                                                                                                                                  
                                                                                                                                                                                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"" . config_item('base_url') . "admin/diamondshapes/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                   error: function(x,e){  alert(x.status +  e + itemlist + x.responseText); }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/loosediamondshapes/add';
																			}			
																	}
														 
														 ";


				$data['extraheader'] .= '
											 <script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';

				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>
					';
				$data['extraheader'] .= '
					<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>
					';
				$data['onloadextraheader'] .= "
											var so;				
		 									";
				$data['usetips'] = true;



				$output = $this->load->view('admin/loosediamondshapes', $data, true);


				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function getloosediamondshapes($addoption = '') {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'pic_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';


		$results = $this->adminmodel->getloosediamondshapes($page, $rp, $sortname, $sortorder, $query, $qtype);


		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		foreach ($results['result'] as $row) {

			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['pic_id'] . "',";
			$json .= "cell:['Lot #: " . $row['pic_id'] . "<br /><a href=\'" . config_item('base_url') . "admin/loosediamondshapes/edit/" . $row['pic_id'] . "\'  class=\"edit\" style=\"color:red;font-weight:bold;\">Edit</a>'";
			$json .= ",'" . addslashes(ucfirst($row['diamondshape'])) . "'";
			if ($row['picture1'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture1']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture2'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture2']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture3'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture3']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture4'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture4']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture5'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture5']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";

			if ($row['picture6'] != '')
			$json .= ",'<img src=\'" . config_item('base_url') . ($row['picture6']) . "\' width=\'80\'><br />'";
			else
			$json .= ",'<img src=\'" . config_item('base_url') . "images/rings/noringimage.png\' width=\'80\'><br />'";




			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}
	function sendStocktoebay(){
		$data = $this->adminmodel->getAllDiamonds();
		$s=1;
		for($k=0;$k< sizeof($data);$k++){   $s = $k+1;
		// foreach($data['details'] AS $index=>$value) {
		//$status = $this->adminmodel->addDiamondtoEbay($value, 30);
		$value =  $data[$k]['lot'];
		$details = $this->adminmodel->getRapnetStonesById($value);

		$GetResponse =  $this->adminmodel->addRapnetStoneToeBay($details[0],30,'',$s);

		}
	}
	function updateInventory(){
		echo $this->adminmodel->deleteWatchonAmazon();
	}
	function getgemstones($jid){
		return  $this->adminmodel->getGemstonesByStockId($jid);
	}


	function testimonial($action = 'view', $id = 0) {
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();
		$data['extraheader'] = '';
		$data['collections'] = '';
		$data['typeoptions'] = '';
		if ($this->isadminlogin()) {
			if ($action == 'delete') {
				$ret = $this->adminmodel->testimonials($_POST, $action, $id);
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
				header("Cache-Control: no-cache, must-revalidate");
				header("Pragma: no-cache");
				header("Content-type: text/x-json");
				$json = "";
				$json .= "{\n";
				$json .= "total: " . $ret['total'] . ",\n";
				$json .= "}\n";
				echo $json;
			} else {
				if ($action == 'add' || $action == 'edit') {
					$this->load->helper(array('form', 'url'));
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<font class="require">', '</font>');
					if (isset($_POST['addbtn'])) {
						$ret = $this->adminmodel->testimonials($_POST, $action, $id);
						if($ret['error'] == '') {
							$data['success'] = $ret['success'];
						} else {
							$data['error'] = $ret['error'];
							if ($action != 'edit')
							$data['details'] = $_POST;
						}
					}
					$data['extraheader'] .= $this->commonmodel->addEditor('simple');
					if ($action == 'edit') {
						$details = $this->adminmodel->testimonialByID($id);
						$data['details'] = $details[0];
						$data['id'] = $id;
					}
				}
				$data['onloadextraheader'] = '';
				$data['leftmenus'] = $this->adminmodel->adminmenuhtml('shapes');
				$url = config_item('base_url').'admin/gettestimonials';
				$data['action'] = $action;
				$data['onloadextraheader'] .= "   $(\"#results\").flexigrid
                                                                                                                                 (
																	{   	 							
																	url: '" . $url . "',
																	dataType: 'json',
																	colModel : [
                                                                                                                            			    {display: 'Testimonial ID', name : 'testimonial_id', width : 80, sortable : true, align: 'center'},                                                                                                                                                                                                                                                                                             
                                                                                                                                                    {display: 'Author name', name : 'testimonial_author_name', width : 150, sortable : true, align: 'center'},
                                                                                                                                                    {display: 'Add date', name : 'testimonial_adddate', width : 150, sortable : true, align: 'center'},
																		
																		],
																		 buttons : [ {name: 'Delete', bclass: 'delete', onpress : test},{name: 'Add', bclass: 'add', onpress : test},
                                                                                                                                                                    {separator: true} 
																			],
																	searchitems : [
																		{display: 'Testimonial Id #', name : 'testimonial_id', isdefault: true}
																		], 		
																	sortname: \"testimonial_id\",
																	sortorder: \"desc\",
																	usepager: true,
																	title: '<h1 class=\"pageheader\">Testimonials</h1>',
																	useRp: true,
																	rp: 50,
																	showTableToggleBtn: false,
																	width:1020,
																	height: 565
																	}
																	);
																	
																	function test(com,grid)
																	{
																		if (com=='Delete')
																			{ 
																			  
																			if($('.trSelected').length>0){
																			            if(confirm('Remove ' + $('.trSelected').length + ' rows?')){
																                                var items = $('.trSelected');
																                                var itemlist ='';
																                                for(i=0;i<items.length;i++){
																                                        itemlist+= items[i].id.substr(3)+\",\";
																                                }																                                
                                                                                                                                                                  
                                                                                                                                                                                                
																                                $.ajax({
																										   type: \"POST\",
																										   dataType: \"json\",
																										   url: \"".config_item('base_url')."admin/testimonial/delete\",
																										   data: \"items=\"+itemlist,
																										   success: function(data){
																										   	alert('Total Deleted rows: '+data.total);
																										    $(\"#results\").flexReload();
																										   },
                                                                                                                                                                                                                   error: function(x,e){  window.location = '" . config_item('base_url') . "admin/testimonial'; }
																										 });
																										 						  
		
		
																                                														                        }
																                } else{
																                        alert('You have to select a row.');
																                } 
																			
																			
																			}
																		else if (com=='Add')
																			{
																				window.location = '" . config_item('base_url') . "admin/testimonial/add';
																			}			
																	}
														 ";


				$data['extraheader'] .= '<script src="' . config_item('base_url') . 'third_party/flexigrid/flexigrid.js"></script>';
				$data['extraheader'] .= '<link type="text/css" href="' . config_item('base_url') . 'third_party/flexigrid/css/flexigrid/flexigrid.css" rel="stylesheet" /> ';
				$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>';
				$data['extraheader'] .= '<script src="' . config_item('base_url') . 'js/t.js" type="text/javascript"></script>';
				$data['onloadextraheader'] .= "var so;";
				$data['usetips'] = true;
				$output = $this->load->view('admin/testimonials', $data, true);
				$this->output($output, $data);
			}
		} else {
			$output = $this->load->view('admin/login', $data, true);
			$this->output($output, $data);
		}
	}

	function gettestimonials() {
		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'testimonial_id';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';
		$results = $this->adminmodel->gettestimonials($page, $rp, $sortname, $sortorder, $query, $qtype);

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Content-type: text/x-json");
		$json = "";
		$json .= "{\n";
		$json .= "page: $page,\n";
		$json .= "total: " . $results['count'] . ",\n";
		$json .= "rows: [";
		$rc = false;
		//  $row['testimonial_id']  = $row['testimonial_message'] = $row['testimonial_author_name'] = '1';

		foreach ($results['result'] as $row) { // echo "<pre>"; print_r($row); exit();
			$desc = strip_tags($row['testimonial_message']);
			if ($rc)
			$json .= ",";
			$json .= "\n {";
			$json .= "id:'" . $row['testimonial_id'] . "',";
			$json .= "cell:['Lot #: " . $row['testimonial_id'] . "<br /><a href=\'" . config_item('base_url') . "admin/testimonial/edit/" . $row['testimonial_id'] . "\'  class=\"edit\" style=\"color:red;font-weight:bold;\">Edit</a>'";
			$json .= ",'" . addslashes($row['testimonial_author_name']) . "'";
			$json .= ",'" . addslashes($row['testimonial_adddate']) . "'";
			$json .= "]";
			$json .= "}";
			$rc = true;
		}
		$json .= "]\n";
		$json .= "}";
		echo $json;
	}
	function categorymanagement($section)
	{
		$data["msg"] = '';
		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();

		if(!isset($section) || empty($section))
		{
			$section = 'stuller';
		}
		if(isset($_REQUEST["submit"])){
			if(isset($_REQUEST["ch"]) && !empty($_REQUEST["ch"])){
				$str ='';
				for($i=0;$i<sizeof($_REQUEST["ch"]);$i++){
					mysql_query("Update stullerdata_new set is_checked = '1'  where  Level2 = '".trim($_REQUEST["ch"][$i])."'");
					$str .= "'".$_REQUEST["ch"][$i]."'".",";
				}
			}
			$str = substr($str, 0,-1);

			if(isset($_REQUEST["sch"]) && !empty($_REQUEST["sch"])){
				for($i=0;$i<sizeof($_REQUEST["sch"]);$i++){
					mysql_query("Update stullerdata_new set is_checked = '1'  where  Level3 = '".trim($_REQUEST["sch"][$i])."'  and  Level2 IN ($str) ");
				}
			}
			$data["msg"] =  "Category has been updated successfully!!";
		}
			
		if($section == 'stuller')
		{
			$data["level2"] = $this->adminmodel->getStullerlevel2();

		}

		if($section == 'quality')
		{
			$data["categories"] = $this->adminmodel->getqualitygold();
			$data["section"] = "Quality";
		}

			
		$output = $this->load->view('admin/categorymanagement', $data, true);
		$this->output($output, $data);
	}

	function getcategorybylevel2()
	{
		$section = 'stuller';
		$category = (string)$_REQUEST["category"];
			
		if($section == 'stuller')
		{
			$category = urldecode($_REQUEST["category"]);
			$data["level3"] = $this->adminmodel->getStullerlevel3($category);

			$str = '';
			$k=0;
			foreach($data["level3"]  as $d )
			{
				$checkedId = "sch$k";
				$checked='';
				if($d["is_checked"] == '1'){ $checked = "checked=checked"; }
				$str .= '&nbsp;&nbsp;&nbsp;|---<input type="checkbox" name='.$checkedId.' id='.$checkedId.'  value='.urlencode($d['category']). '  '.$checked.'  onclick=getcatproducts(this.value,"stuller"); ><b>'.$d["category"]."</b><br>";
				$k++;
			}
			echo $str;
			exit();


		}

	}

	function getproducts()
	{
		//$section = 'stuller';
		$category = urldecode($_REQUEST["category"]);
		$section = urldecode($_REQUEST["section"]);
		//   echo $category."----------".$section;
		//  exit();

		if($section == 'stuller')
		{
			mysql_query("update stullerdata_new  set  is_checked = '1' where  Level3 = '".$category."'");
			$data["products"] = $this->adminmodel->getProductsByCategory($category);
			$str = '';
			foreach($data["products"]  as $d)
			{


				$image1 = config_item('base_url')."stuller_image/".$d["image"]; //thumb1,thum2,thumb3,thumb4,thumb5
				if (fopen($image1, "r")) {
				} else {
					$image1 = "http://images3.wikia.nocookie.net/__cb20061129213453/muppet/images/7/7c/Noimage.png";
				}
				$str .= '<div style="height: 284px;float:left;margin-left:15px;margin-top: 30px; width: 170px;" class="floatl ringbox txtcenter">
			<span style="color: rgb(0, 0, 0); font-size: 10px;">'.$d["Description"].'<br></span><br>
                        <a href="javascript:void(0)"><center><div class="ringtile"><img style="width: 100px; height: 150px;" src="'.$image1.'" width="70"><br></div></center></a>';
				$str .= '<div style="color: rgb(0, 0, 0);" class="txtsmall"><b>Retail Price:</b> $'.$d["RetailPrice"].'</div>
                        <div style="color: rgb(0, 0, 0);" class="txtsmall"><b>Metal:</b>  '.$d["PrimaryMetalComposition"].' </div>						    		 
                        <div style="color: rgb(0, 0, 0);" class="txtsmall"><b>Quality:</b> '.$d["Quality"].'</div>';
				$str .= '<a style="color: rgb(0, 0, 0);" href="javascript:void(0)" class="search2" onclick = "getproddetail('."'".$d["ItemNumber"]."'".')">View Details</a>
                      </div>';
			}

			echo $str;
			exit();
		}elseif($section == "quality"){

			$data["products"] = $this->adminmodel->getqualitygold('0', '1000' , 'qg_id' , 'asc'  ,''  , 'itemid' , $category);
			$cid = str_replace("*", "/", $category);
			mysql_query("update dev_qg  set  is_checked = '1' where  folder LIKE '".$cid."'");

			$str = '';
			foreach($data["products"]["result"]  as $row)
			{

				$row['img1'] = urldecode($row['img1']);
				$lot = $row['qg_id'];
				if(!empty($row['description'])){
					$title = $row['description'];
				}elseif($row['page']){
					$title =  $row['page']  ;
				}elseif($row['book']){
					$title  = $row['book'];
				}


				if(!empty($row['catalog_price'])){
					$p = $row['catalog_price'];
				}else if(!empty($row['cost_45'])){
					$p = $row['cost_45'];
				}else if(!empty($row['cost_50'])){
					$p = $row['cost_50'];
				}else if(!empty($row['cost_35'])){
					$p = $row['cost_35'];
				}else if(!empty ($row['cost_15'])){
					$p = $row['cost_15'];
				}


				if(stripos($row['folder'],'product'))
				$image1 = "https://images.qgold.com/0/100/".$row['image_name'];
				else
				$image1 = "http://qgold.com/product/275/".$row['image_name'].".jpg";

				if (fopen($image1, "r")) {
				} else {
					$image1 = "http://images3.wikia.nocookie.net/__cb20061129213453/muppet/images/7/7c/Noimage.png";
				}
				$str .= '<div style="height: 284px;float:left;margin-left:15px;margin-top: 30px; width: 170px;" class="floatl ringbox txtcenter">
			<span style="color: rgb(0, 0, 0); font-size: 10px;">'.$title.'<br></span><br>
                        <a href="javascript:void(0)"><center><div class="ringtile"><img style="width: 100px; height: 150px;" src="'.$image1.'" width="70"><br></div></center></a>';
				$str .= '<div style="color: rgb(0, 0, 0);" class="txtsmall"><b>Price:</b> $'.number_format($p,2).'</div>
                        <div style="color: rgb(0, 0, 0);" class="txtsmall"><b>Metal:</b>  '.$d["metal"].' </div>						    		 
                        <div style="color: rgb(0, 0, 0);" class="txtsmall"><b>Weight:</b> '.$d["weight"].'</div>';
				$str .= '<a style="color: rgb(0, 0, 0);" href="javascript:void(0)" class="search2" onclick = "getquaiitydetail('."'".$lot."'".')" >View Details</a></div>';
			}
			echo $str;
			exit();
		}
	}

	function getinfo($lot)
	{
		$data = $this->getCommonData();
		$this->load->model('adminmodel');
		$this->load->model('jewelrymodel');
		$data['products'] = $this->jewelrymodel->GetProductDetail_new($lot);
			
		$output = $this->load->view('admin/getinfo' , $data , false);
		echo $output;
	}

	function getqualityinfo($lot)
	{
		$data = $this->getCommonData();
		$this->load->model('adminmodel');
		$this->load->model('jewelrymodel');
		$data['products'] = $this->adminmodel->getqualitygoldByID($lot);
		$output = $this->load->view('admin/getqualityinfo' , $data , false);
		echo $output;
	}

	function sendstullertoebay($lot)
	{

		$data = $this->getCommonData();
		$this->load->model('adminmodel');
		$this->load->model('jewelrymodel');
		$detail = $this->jewelrymodel->GetProductDetail_new($lot);
		//  echo "<pre>";
		//print_r($detail);
		//  echo "<hr>";

		if(empty($detail["sub_cat_id"]) || $detail["sub_cat_id"] == '-1' ){
			if(empty($detail["parent_cat_id"]) || $detail["parent_cat_id"] == '-1')
			{
				// echo "Goes:".$detail["Level2"]."<br>";
				//Update  stullerdata_new  set sub_cat_id = '3344892012'  ,  parent_cat_id = '3344891012'     where  Level3 = 'journey collection'  AND  Level2 = 'shop by collection'
				$parent_cat_id  = $this->addEbayCategory($detail["Level2"],'-1');
				$detail["parent_cat_id"] = $parent_cat_id;
			}

			//echo "<br>-----------||".$detail["Level2"].",".$detail["parent_cat_id"];
			$cat_id  = $this->addEbayCategory($detail["Level3"],$detail["parent_cat_id"]);

			// echo "Update  stullerdata_new  set sub_cat_id = '".$cat_id."'  ,  parent_cat_id = '".$detail["parent_cat_id"]."'     where  Level3 = '".mysql_real_escape_string($detail["Level3"])."'  AND  Level2 = '".mysql_real_escape_string($detail["Level2"])."'";
			mysql_query("Update  stullerdata_new  set   parent_cat_id = '".$detail["parent_cat_id"]."'  where    Level2 = '".mysql_real_escape_string($detail["Level2"])."'");
			mysql_query("Update  stullerdata_new  set  sub_cat_id = '".$cat_id."'    where  Level3 = '".mysql_real_escape_string($detail["Level3"])."'  AND  Level2 = '".mysql_real_escape_string($detail["Level2"])."'");
			//exit();
		}

		$this->adminmodel->addStullerToEbay($detail, '30' , 'stuller' );
	}
	function sendqgtoebay($qgid)
	{
		$data = $this->getCommonData();
		$this->load->model('adminmodel');
		$this->load->model('jewelrymodel');
		$detail = $this->adminmodel->getqualitygoldByID($qgid);
		$this->adminmodel->addQualityGoldToEbay($detail, '30' , 'qg');
	}

	function addEbayCategory($categoryName,$parentID)
	{
		$categoryid=   $this->adminmodel->addEbayCategory($categoryName,$parentID);
		return $categoryid;
	}
    
    function savesearch($sid)
	{
	
		$id = base64_decode($sid);
		$data = $this->adminmodel->getSaveSearchData($id);
		$_SESSION['sdata'] = unserialize($data[0]['search_string']);
                //Add at May 30 2013 for batch sending to ebay store
                $_SESSION['sr_id'] = $id;
                $_SESSION['cash_limit'] = $this->uri->segment(4);
		header("Location: " . config_item('base_url') . "admin/rapnetDiamonds");
		
	}
	
	function saveloosesearch($sid)
	{
	
		$id = base64_decode($sid);
		$data = $this->adminmodel->getSavelooseSearchData($id);
		$_SESSION['sldata'] = unserialize($data[0]['search_string']);
                //Add at May 30 2013 for batch sending to ebay store
                $_SESSION['sl_id'] = $id;
                $_SESSION['cash_limit'] = $this->uri->segment(4);
		//echo "<pre>"; print_r($_SESSION['sldata'] ); exit;
		header("Location: " . config_item('base_url') . "admin/allloosediamonds");
		
	}
	
	function delsavedsearch($id, $type)
	{
		if($type){
			$this->db->delete('dev_saveloosesearch', array('id'=>$id));	
			header("Location: " . config_item('base_url') . "admin/loosediamonds");
		}else{
			$this->db->delete('dev_savesearch', array('id'=>$id));
			header("Location: " . config_item('base_url') . "admin/rapnetcomdiamonds");
			}
	}
        
     /**
     * 
     * @param type $save_loose_id
     * @author Ahsans
     */
    function sendBatchLooseDiamondsToEbay($save_loose_id){
        set_time_limit(600);
        
        $id = $save_loose_id;
        $data = $this->adminmodel->getSavelooseSearchData($id);
        $sldata = unserialize($data[0]['search_string']);
        
        //echo "<pre>"; print_r($_SESSION['sldata'] ); exit;
        //header("Location: " . config_item('base_url') . "admin/allloosediamonds");
        
        $_REQUEST = $sldata;
        
        $custom_filters['caratmin'] = isset($_REQUEST['caratmin']) ? $_REQUEST['caratmin'] : '';
        $custom_filters['caratmax'] = isset($_REQUEST['caratmax']) ? $_REQUEST['caratmax'] : '';
        $custom_filters['color'] = isset($_REQUEST['color']) ? implode(',', $_REQUEST['color']) : '';
        $custom_filters['cut'] = isset($_REQUEST['cut']) ? implode(',', $_REQUEST['cut']) : '';
        $custom_filters['shape'] = isset($_REQUEST['shape']) ? implode(',', $_REQUEST['shape']) : '';
        $custom_filters['clarity'] = isset($_REQUEST['clarity']) ? implode(',', $_REQUEST['clarity']) : '';
        //$custom_filters_encoded = urlencode(json_encode($custom_filters));
        
        //$url = config_item('base_url') . 'admin/getpendants/0/' . $custom_filters_encoded;
        
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
        $sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';
        $sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
        $query = isset($_POST['query']) ? $_POST['query'] : '';
        $qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';

        /* custom filters */
        if (isset($custom_filters)) {

            $results = $this->adminmodel->getPendantsWithoutLimit($page, $rp, $sortname, $sortorder, $query, $qtype,$id_array, '', $custom_filters);
        } else {
            $results = $this->adminmodel->getPendantsWithoutLimit($page, $rp, $sortname, $sortorder, $query, $qtype,$id_array);
        }
        $cLimit = 0;
        foreach($results['result'] as $row){
            
            //$num = mt_rand(0, count($results['result']) - 1);
            //echo '<pre>'; die(print_r($row));
            if($row['ebayid'] < 0){
                $details = $this->adminmodel->getPendantById($row['lot']);
                
                $price = $details[0]['price'];
		
		if (!empty($row['Meas'])) {
			$price = $price * $details[0]['carat'];
		}
                $qry = "SELECT rate FROM " . config_item('table_perfix') . "helix_prices WHERE pricefrom <= '$price'  and  priceto > '$price' ORDER BY pricefrom ASC LIMIT 0,1";
                $result = $this->db->query($qry);
                $pret = $result->row_array();
		$rate = $pret['rate'];
			
		$rate = ($rate/100);
		$xprice = $price * $rate;
		$ourprice = $price + $xprice;
                $cLimit += $ourprice;
                
                $given_cash_limit = str_replace(',', '', $_SESSION['cash_limit']);
                if($given_cash_limit >= $cLimit){
                    $GetResponse = $this->adminmodel->addRapnetStoneToeBay($details[0], 30, 'pendants', '-1');
                    if (isset($GetResponse) && !empty($GetResponse)) {
                        $retuen["success"] = "Item has been Added Successfully!!!";
                        //unset($results['result'][$num]);
                    } else {

                        $retuen["success"] = "Item has been Added Successfully!!!";
                    }
                } elseif($cLimit > $given_cash_limit) {
                    $cLimit -= $ourprice;
                }
            }
        }
        
        header("Location: " . config_item('base_url') . "admin/allloosediamonds");
    }
    
    /**
     * 
     * @param type $save_loose_id
     * @author Ahsans
     */
    function sendBatchEngagementRingsToEbay($save_ring_id){
        set_time_limit(600);
        
        $id = $save_ring_id;
        $data = $this->adminmodel->getSaveSearchData($id);
        $sldata = unserialize($data[0]['search_string']);
        
        //echo "<pre>"; print_r($_SESSION['sldata'] ); exit;
        //header("Location: " . config_item('base_url') . "admin/allloosediamonds");
        
        $_REQUEST = $sldata;
        
        $custom_filters['caratmin'] = isset($_REQUEST['caratmin']) ? $_REQUEST['caratmin'] : '';
        $custom_filters['caratmax'] = isset($_REQUEST['caratmax']) ? $_REQUEST['caratmax'] : '';
        $custom_filters['color'] = isset($_REQUEST['color']) ? implode(',', $_REQUEST['color']) : '';
        $custom_filters['cut'] = isset($_REQUEST['cut']) ? implode(',', $_REQUEST['cut']) : '';
        $custom_filters['shape'] = isset($_REQUEST['shape']) ? implode(',', $_REQUEST['shape']) : '';
        $custom_filters['clarity'] = isset($_REQUEST['clarity']) ? implode(',', $_REQUEST['clarity']) : '';
        //$custom_filters_encoded = urlencode(json_encode($custom_filters));
        
        //$url = config_item('base_url') . 'admin/getpendants/0/' . $custom_filters_encoded;
        
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $rp = isset($_POST['rp']) ? $_POST['rp'] : 50;
        $sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'lot';
        $sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'desc';
        $query = isset($_POST['query']) ? $_POST['query'] : '';
        $qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';

        /* custom filters */
         if (isset($custom_filters)) {

            $results = $this->adminmodel->getRapnetStonesWithoutLimit($id_array, $page, $rp, $sortname, $sortorder, $query, $qtype, '', $custom_filters);
        } else {
            $results = $this->adminmodel->getRapnetStonesWithoutLimit($id_array, $page, $rp, $sortname, $sortorder, $query, $qtype);
        }
        
        foreach($results['result'] as $row){
            //$num = mt_rand(0, count($results['result']) - 1);
            
            
            if($row['ebayid'] < 0){
                
                $details = $this->adminmodel->getRapnetStonesById($row['lot']);
                $price = $details[0]['price'];
		
		if (!empty($row['Meas'])) {
			$price = $price * $details[0]['carat'];
		}
                $qry = "SELECT rate FROM " . config_item('table_perfix') . "helix_prices WHERE pricefrom <= '$price'  and  priceto > '$price' ORDER BY pricefrom ASC LIMIT 0,1";
                $result = $this->db->query($qry);
                $pret = $result->row_array();
		$rate = $pret['rate'];
			
		$rate = ($rate/100);
		$xprice = $price * $rate;
		$ourprice = $price + $xprice;
                $cLimit += $ourprice;
                //$details = $this->adminmodel->getRapnetStonesById($id);
                
                $given_cash_limit = str_replace(',', '', $_SESSION['cash_limit']);
                if($given_cash_limit >= $cLimit){
                    $GetResponse = $this->adminmodel->addRapnetStoneToeBay($details[0], 30, '', '-1');
                    if (isset($GetResponse) && !empty($GetResponse)) {
                        $retuen["success"] = "Item Successfully Update on eBay";
                    } else {
                        $retuen["success"] = $GetResponse;
                    }
                } elseif($cLimit > $given_cash_limit) {
                    $cLimit -= $ourprice;
                }
            }
        }
        
        header("Location: " . config_item('base_url') . "admin/rapnetDiamonds");
    }

	function ezstatusedit($id, $status)
	{
		$this->adminmodel->ezstatusmedit($id, $status);
		header("Location: " . config_item('base_url') . "admin/stuller");
	}

	function ezqualitygoldstatusedit($id, $status)
	{
		$this->adminmodel->ezqualitygoldstatusedit($id, $status);
		header("Location: " . config_item('base_url') . "admin/qualitygold");
	}

	function ezuniquestatusedit($id, $status)
	{
		$this->adminmodel->ezuniquestatusedit($id, $status);
		header("Location: " . config_item('base_url') . "admin/uniquesettings");
	}

	function catamanager()
	{

		if(isset($_POST['stullercatagory'])){
			$this->adminmodel->setcatamanagersta('stuller',$_POST['stullercatagory'], $_POST['stullercatagory2'], $_POST['stullersta']);
			$data2['status'] = 'Success';
		}
		elseif(isset($_POST['qualitycatagory'])){
			$this->adminmodel->setcatamanagersta('quality',$_POST['qualitycatagory'], $_POST['qualitycatagory2'], $_POST['qualitysta']);
			$data2['status'] = 'Success';
		}
		elseif(isset($_POST['uniquecatagory'])){
			$this->adminmodel->setcatamanagersta('unique',$_POST['uniquecatagory'], 'fdsf', $_POST['uniquesta']);
			$data2['status'] = 'Success';
		}

		$catainfo = $this->adminmodel->getcatamanagerinfo();
		$data2['stuller'] = $catainfo['stuller'];
		$data2['unique'] = $catainfo['unique'];
		$data2['quality'] = $catainfo['quality'];

		$data = $this->getCommonData();
		$data['name'] = $this->getAdminDetails();


			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										';
			$data['leftmenus'] = $this->adminmodel->adminmenuhtml();
			$data['newtestimonials'] = $this->adminmodel->newfeedbacks();
			$output = $this->load->view('admin/catamanagerview', $data2, true);
		$this->output($output, $data);
	}
	function pricemanager(){   
		
		$data = $this->getCommonData(); 
		$data['name'] = $this->getAdminDetails();


			$data['onloadextraheader'] = '$("#secondpane p.menu_head").click(function()
									    {
										     $(this).css({backgroundImage:"url(' . config_item('base_url') . 'images/minus.jpg)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
									         $(this).siblings().css({backgroundImage:"url(' . config_item('base_url') . 'images/plus.jpg)"});
										});
										';
			
		if($_POST['submit']){
			$price=$_POST['price'];
			$this->adminmodel->editfilterprice($price);
		}
		$data['leftmenus'] = $this->adminmodel->adminmenuhtml();
		$data['newtestimonials'] = $this->adminmodel->newfeedbacks();
		$data2['price']=$this->adminmodel->getfilterprice();
		$output = $this->load->view('admin/pricemanager', $data2, true);
		$this->output($output, $data);
	}
}
?>
