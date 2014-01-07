<?php

class Engagement extends Controller {

    function Engagement() {

        parent::Controller();

        $this->load->model('jewelrymodel');
		$this->load->helper('url');
    }

    function index() {

        $data = $this->getCommonData();

        $data['title'] = 'Engagement';

        $output = $this->load->view('engagement/index', $data, true);

        $this->output($output, $data);
    }

    private function getCommonData($banner = '') {

        $data = array();

        $data = $this->commonmodel->getPageCommonData();

        return $data;
    }

    function output($layout = null, $data = array(), $isleft = true, $isright = true) {

        $data['loginlink'] = $this->user->loginhtml();

        $output = $this->load->view($this->config->item('template') . 'header', $data, true);
        $curentSubManu = $this->uri->segment(2);
        if ($isleft)
            $output .= $this->load->view($this->config->item('template') . 'left', $data, true);

        $output .= $layout;

        if ($isright)
            $output .= $this->load->view($this->config->item('template') . 'right', $data, true);

        $output .= $this->load->view($this->config->item('template') . 'footer', $data, true);

        $this->output->set_output($output);
    }

    function ring() {



        $data = $this->getCommonData();

        $data['title'] = "Create Your Own Ring, Design Your Own Ring Online, Mens Titanium Rings,
Fancy Colored Diamonds";

        $data['meta_tags'] = '<meta http-equiv="Content-Type" content="text/html; iso-8859-1">
	<meta name="title" content="Create Your Own Ring, Design Your Own Ring Online, Mens Titanium Rings,
Fancy Colored Diamonds">
	<meta name="ROBOTS" content="INDEX,FOLLOW">
	<meta name="description" content="Buy diamond promise rings, mens titanium ring, mens titanium rings, fancy colored diamonds, create your own ring, design your own ring online. Purchase discounted rate mens titanium rings, fancy colored diamonds online">
	<meta name="abstract" content="Diamond Rings, Wholesale Diamonds, Estate Jewelry, Custom Engagement Rings, New York, Chicago, California, Boston, Las Vegas, Columbia, Montgomery">
	<meta name="keywords" content="Buy diamond promise rings, mens titanium ring, mens titanium rings, fancy colored diamonds, create your own ring, design your own ring online. Purchase discounted rate mens titanium rings, fancy colored diamonds online">
	<meta name="author" content="7techniques">
	<meta name="publisher" content="7techniques">
	<meta name="copyright" content="7techniques">
	<meta http-equiv="Reply-to" content="">
	<meta name="creation_Date" content="12/12/2008">
	<meta name="expires" content="">
	<meta name="revisit-after" content="7 days">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';

        $output = $this->load->view('engagement/ringguide', $data, true);

        $this->output($output, $data);
    }

    function engagement_ring_settings($diamondid = '', $addoption = '', $sidestone1 = '', $sidestone2 = '', $extraoption = '') {

//echo $addtoring."--".$addoption;
//die;
         //$diamondid='31198171';
        $data = $this->getCommonData();
		//print_r($data);

        $this->load->model('diamondmodel');

        $data['title'] = 'Engagement Ring Settings';

        $data['page'] = 'engagement';

        $data['addoption'] = $addoption;

        $data['lot'] = $diamondid;


        $minprice = 0; //$this->jewelrymodel->getMinPrice();

        $maxprice = 1000000; //$this->jewelrymodel->getMaxPrice();

        if (isset($_POST['min'])) {
            $minprice = $_POST['min'];
        }
        if (isset($_POST['max'])) {
            $maxprice = $_POST['max'];
        }
        $category = '';
        $cert = '';
        $cut = '';
        /* 	
          $this->session->set_userdata('category','');
          $this->session->set_userdata('cut','');
          $this->session->set_userdata('cert','');
         */
        $unset_data = array('cut' => '', 'category' => '', 'cert' => '');
        $this->session->unset_userdata($unset_data);

        if (isset($_POST['category'])) {
            $category = $_POST['category'];
            $this->session->set_userdata('category', $category);
        }

        if (isset($_POST['cert'])) {
            $cert = $_POST['cert'];
            $this->session->set_userdata('cert', $cert);
        }
        if (isset($_POST['cut'])) {
            $cut = $_POST['cut'];
            $this->session->set_userdata('cut', $cut);
        }

        $data['category'] = $category;

        $data['minprice'] = $minprice;

        $data['maxprice'] = $maxprice;

        $data['addoption'] = $addoption;

        $this->session->set_userdata('addoption', $addoption);

        $data['details'] = $this->diamondmodel->getDetailsByLot($diamondid);
		
		$aa = $this->commonmodel->getTabHeader('ring', $diamondid);
		//print_r($aa);
		//die;
		//print_r($data['details']);
		//die;
        $data['extraoption'] = '';

        $data['tabhtml'] = '';



        if ($diamondid != 'false') {



            if ($addoption == 'addtoring')
                $data['tabhtml'] = $this->commonmodel->getTabHeader('ring', $diamondid);

            if ($addoption == 'tothreestone')
                $data['tabhtml'] = $this->commonmodel->getThreeStoneTab('sidestone');



            //$data['tabhtml'] = $this->commonmodel->getTabHeader('ring',$diamondid);



            $this->session->set_userdata('mydiamondid', $diamondid);



            $data['extraheader'] = '';

            $data['extraheader'] .= '<script   language="javascript" src="' . config_item('base_url') . 'js/jquery.ui.js" type="text/javascript"></script>

					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>

					';

            $data['onloadextraheader'] = "getringresults();
			$('#pricerange').slider({ steps: 100, range: true, minValue : 1, slide:   function(e,ui) { 
			if($('#pricerange').slider('value',0) <= 30) {
				val = ($('#pricerange').slider('value',0)*25+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
			else if($('#pricerange').slider('value',0) > 30 && $('#pricerange').slider('value',0) <= 50) {
				val = ($('#pricerange').slider('value',0)*75+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
			else if($('#pricerange').slider('value',0) > 50 && $('#pricerange').slider('value',0) <= 70) {
				val = ($('#pricerange').slider('value',0)*250+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
	 		else if($('#pricerange').slider('value',0) > 70 && $('#pricerange').slider('value',0) <= 80) {								 																																							                val = ($('#pricerange').slider('value',0)*1000+(" . $minprice . "));						 																																																																		                $('#pricerange1').val(val);
			}
			else if($('#pricerange').slider('value',0) > 80 && $('#pricerange').slider('value',0) <= 90) {
				val = ($('#pricerange').slider('value',0)*10000+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
			else if($('#pricerange').slider('value',0) > 90 && $('#pricerange').slider('value',0) < 98)
			{
				val = ($('#pricerange').slider('value',0)*20000+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
			else
			{
				$('#pricerange1').val(" . $maxprice . ");
			}
			// pricerange2
			if($('#pricerange').slider('value',1) <= 30 && $('#pricerange').slider('value',1) >1){
				val = ((-1)*$('#pricerange').slider('value',1)*25+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 30 && $('#pricerange').slider('value',1) <= 50) {									 				val = ((-1)*$('#pricerange').slider('value',1)*75+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 50 && $('#pricerange').slider('value',1) <= 70){
				val = ((-1)*$('#pricerange').slider('value',1)*250+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 70 && $('#pricerange').slider('value',1) <= 80){
				val = ((-1)*$('#pricerange').slider('value',1)*1000+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 80 && $('#pricerange').slider('value',1) <= 90){
				val = ((-1)*$('#pricerange').slider('value',1)*10000+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 90 && $('#pricerange').slider('value',1) < 98) {
				val = ((-1)*$('#pricerange').slider('value',1)*20000+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1)==1) {
				$('#pricerange2').val(" . $minprice . ");
			}
			else {
				$('#pricerange2').val(" . $maxprice . ");
			}																																	
		}, change: function(e,ui) { 
				getringresults();	 
		} });
		var so;";

            $data['usetips'] = true;

            $output = $this->load->view('engagement/ring_settings', $data, true);

            $this->output($output, $data, false, false);
        }

        elseif ($extraoption != '') {



            $data['extraoption'] = $extraoption;
            $data['extraheader'] = '';
            $data['extraheader'] .= '<script    src="' . config_item('base_url') . 'js/jquery.ui.js" type="text/javascript"></script>

					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>

					';



            $data['onloadextraheader'] = "";

            if ($extraoption == "solitaire") {
                $data['onloadextraheader'] .= "$('#pavsechk').attr('checked',false);
   		     $('#solitairechk').attr('checked',true);
		     $('#sidestoneschk').attr('checked',false);
			 $('#threestonechk').attr('checked',false); 
			 $('#mathingchk').attr('checked',false); ";
            }

            if ($extraoption == "sidestones") {
                $data['onloadextraheader'] .= "$('#pavsechk').attr('checked',false);
   		     $('#solitairechk').attr('checked',false);
		     $('#sidestoneschk').attr('checked',true);
			 $('#threestonechk').attr('checked',false); 
			 $('#mathingchk').attr('checked',false); ";
            }

            if ($extraoption == "pave") {
                $data['onloadextraheader'] .= "$('#pavsechk').attr('checked',true);
   		     $('#solitairechk').attr('checked',false);
		     $('#sidestoneschk').attr('checked',false);
			 $('#threestonechk').attr('checked',false); 
			 $('#mathingchk').attr('checked',false); ";
            }

            if ($extraoption == "threestone") {
                $data['onloadextraheader'] .= "$('#pavsechk').attr('checked',false);
   		     $('#solitairechk').attr('checked',false);
		     $('#sidestoneschk').attr('checked',false);
			 $('#threestonechk').attr('checked',true); 
			 $('#mathingchk').attr('checked',false); ";
            }

            if ($extraoption == "matching") {
                $data['onloadextraheader'] .= "$('#pavsechk').attr('checked',false);
   		     $('#solitairechk').attr('checked',false);
		     $('#sidestoneschk').attr('checked',false);
			 $('#threestonechk').attr('checked',false); 
			 $('#mathingchk').attr('checked',true); ";
            }


            $data['onloadextraheader'] .= "$('#anniversarychk').attr('checked',false);	
			 $('#weddingbandchk').attr('checked',false); 
			 $('#halochk').attr('checked',false); 
			 
			 $('#patinumchk').attr('checked',false);
 		     $('#whitegoldchk').attr('checked',false);
			 $('#solitairechk').attr('checked',false);
 		     $('#sidestoneschk').attr('checked',false);
			 $('#threestonechk').attr('checked',false);
 		     $('#mathingchk').attr('checked',false);
			 $('#pavsechk').attr('checked',false);
			 $('#ringshape').val();
			 $('#pricerange1').val();
  	         $('#pricerange2').val();
			 $('#marktchk').attr('checked',true); 
			 $('#erdchk').attr('checked',true); 
			 $('#vatchechk').attr('checked',true); 
			 $('#daussichk').attr('checked',true); 
			 $('#antiquechk').attr('checked',true); 
			  $('#goldchk').attr('checked',false); 
			getringresults();

		 									$('#pricerange').slider({ steps: 100, range: true, minValue : 1, slide:function(e,ui) {  $('#pricerange1').val((parseInt($('#pricerange').slider('value', 0)))* ((" . $maxprice . "-" . $minprice . ")/100));

						 																$('#pricerange2').val(parseInt($('#pricerange').slider('value', 1)) * ((" . $maxprice . "-" . $minprice . ")/100));

		 									}, change: function(e,ui) { 

																						$('#pricerange1').val((parseInt($('#pricerange').slider('value', 0)))* ((" . $maxprice . "-" . $minprice . ")/100));

						 																$('#pricerange2').val(parseInt($('#pricerange').slider('value', 1)) * ((" . $maxprice . "-" . $minprice . ")/100));

						 																getringresults();	 

															} });

											

											var so;				

		 									";



            $data['usetips'] = true;

            $output = $this->load->view('engagement/ring_settings', $data, true);

            $this->output($output, $data, false, false);
        } else {


            ///echo 'working fine..............';
            header('location:' . config_item('base_url') . 'diamonds/search/true/false/addtoring');
        }
    }

    function engagement_product_settings($id, $addoption = '', $sidestone1 = '', $sidestone2 = '', $extraoption = '') {

        $data = $this->getCommonData();

        $this->load->model('diamondmodel');

        $data['title'] = 'Engagement Product Settings';


        $data['addoption'] = $addoption;

        $data['lot'] = $id;



        $minprice = 0; //$this->jewelrymodel->getMinPrice();

        $maxprice = 1000000; //$this->jewelrymodel->getMaxPrice();

        $data['minprice'] = $minprice;

        $data['maxprice'] = $maxprice;

        $data['addoption'] = $addoption;

        $this->session->set_userdata('addoption', $addoption);



        $data['details'] = $this->diamondmodel->getDetailsByLotproduct($id);

        $data['extraoption'] = '';

        $data['tabhtml'] = '';



        if ($id != '') {



            if ($addoption == 'addtoring')
                $data['tabhtml'] = $this->commonmodel->getTabHeader('ring', $id);

            if ($addoption == 'tothreestone')
                $data['tabhtml'] = $this->commonmodel->getThreeStoneTab('sidestone');



            //$data['tabhtml'] = $this->commonmodel->getTabHeader('ring',$diamondid);



            $this->session->set_userdata('mydiamondid', $id);



            $data['extraheader'] = '';

            $data['extraheader'] .= '<script   language="javascript" src="' . config_item('base_url') . 'js/jquery.ui.js" type="text/javascript"></script>

					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>

					';

            $data['onloadextraheader'] = "getproductresults('" . $id . "');
			$('#pricerange').slider({ steps: 100, range: true, minValue : 1, slide:   function(e,ui) { 
			if($('#pricerange').slider('value',0) <= 30) {
				val = ($('#pricerange').slider('value',0)*25+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
			else if($('#pricerange').slider('value',0) > 30 && $('#pricerange').slider('value',0) <= 50) {
				val = ($('#pricerange').slider('value',0)*75+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
			else if($('#pricerange').slider('value',0) > 50 && $('#pricerange').slider('value',0) <= 70) {
				val = ($('#pricerange').slider('value',0)*250+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
	 		else if($('#pricerange').slider('value',0) > 70 && $('#pricerange').slider('value',0) <= 80) {								 																																							                val = ($('#pricerange').slider('value',0)*1000+(" . $minprice . "));						 																																																																		                $('#pricerange1').val(val);
			}
			else if($('#pricerange').slider('value',0) > 80 && $('#pricerange').slider('value',0) <= 90) {
				val = ($('#pricerange').slider('value',0)*10000+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
			else if($('#pricerange').slider('value',0) > 90 && $('#pricerange').slider('value',0) < 98)
			{
				val = ($('#pricerange').slider('value',0)*20000+(" . $minprice . "));
				$('#pricerange1').val(val);
			}
			else
			{
				$('#pricerange1').val(" . $maxprice . ");
			}
			// pricerange2
			if($('#pricerange').slider('value',1) <= 30 && $('#pricerange').slider('value',1) >1){
				val = ((-1)*$('#pricerange').slider('value',1)*25+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 30 && $('#pricerange').slider('value',1) <= 50) {									 				val = ((-1)*$('#pricerange').slider('value',1)*75+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 50 && $('#pricerange').slider('value',1) <= 70){
				val = ((-1)*$('#pricerange').slider('value',1)*250+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 70 && $('#pricerange').slider('value',1) <= 80){
				val = ((-1)*$('#pricerange').slider('value',1)*1000+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 80 && $('#pricerange').slider('value',1) <= 90){
				val = ((-1)*$('#pricerange').slider('value',1)*10000+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1) > 90 && $('#pricerange').slider('value',1) < 98) {
				val = ((-1)*$('#pricerange').slider('value',1)*20000+(" . $maxprice . "));
				$('#pricerange2').val(val);
			}
			else if($('#pricerange').slider('value',1)==1) {
				$('#pricerange2').val(" . $minprice . ");
			}
			else {
				$('#pricerange2').val(" . $maxprice . ");
			}																																	
		}, change: function(e,ui) { 
				getringresults1();	 
		} });
		var so;";

            $data['usetips'] = true;

            $output = $this->load->view('engagement/ring_settings1', $data, true);

            $this->output($output, $data, false, false);
        }



        else {


            //echo 'working fine..............';
            header('location:' . config_item('base_url') . 'diamonds/search/true/false/addtoring');
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

    function getringresults($isPave = true, $Solitaire = true, $Sidestone = true, $platinum = true, $gold = true, $whitegold = true, $anniversary = true, $weddingband = true, $minprice = 0, $maxprice = 1000000, $shape = 'all', $page = 0, $isMarkt = '', $isErd = '', $isVatche = '', $isDaussi = '', $isAntique = '', $isThreestone = true, $isHalo = true, $isMatching = true, $lot = 0) {
		
        $start = ($page == 'undefined') ? 0 : $page;

        $lot = ($lot == 'undefined') ? 0 : $lot;

        $category = $this->session->userdata('category');
        $cert = $this->session->userdata('cert');
        $cut = $this->session->userdata('cut');

        $rp = 16;

        $this->load->model('engagementmodel');

        $results = $this->engagementmodel->getRings($start, $rp, $isPave, $Solitaire, $Sidestone, $platinum, $gold, $whitegold, $anniversary, $weddingband, $minprice, $maxprice, $shape, $isMarkt, $isErd, $isVatche, $isDaussi, $isAntique, $isThreestone, $isHalo, $isMatching, $category, $cert, $cut);


        $returnhtml = '';

        $this->load->model('sitepaging');

        $paginlinks = $this->sitepaging->getPageing($results['count'], 'rings', $start, 'price', $rp);

        //	echo htmlspecialchars($paginlinks);
        //echo($paginlinks);
        //exit(0);

        $returnhtml .= $paginlinks . '<div class="hr"></div>';

        $addoption = $this->session->userdata('addoption');

        if (!empty($results['result'])) {
            foreach ($results['result'] as $row) {

                /* 				 height: 204px;
                  margin-left: -121px;
                  margin-top: 55px;
                  width: 170px;
                 */

                $price = $this->jewelrymodel->get_update_price($row['price'], 'dev_helix_jwelery_prices');
                $white_gold_price = $this->jewelrymodel->get_update_price($row['white_gold_price'], 'dev_helix_jwelery_prices');
                $yellow_gold_price = $this->jewelrymodel->get_update_price($row['yellow_gold_price'], 'dev_helix_jwelery_prices');

                $returnhtml .= '

									
									
									<div style=" height: 224px; margin-left: 12px;margin-top: 30px;width: 170px;" class="floatl ringbox txtcenter" >

				    				<span style="  color: #929295;float: left;font-family: Times New Roman;font-size: 14px;font-weight: bold;margin-bottom: 9px;padding-left: 30px;">' . $row['style'] . ' collection</span>
													    				

						    		 <a href="javascript:void(0)" onclick="viewRingsDetails(' . $row['stock_number'] . ',' . $lot . ')">

							    		 <center>

								    		 <div class="ringtile">

								    		 <img  style=" width:120px;height: 122px;" id="ringbigimage' . $row['stock_number'] . '" src="';
$pth = substr(FCPATH,0,-10);
                if ($gold == 'gold') {

                    $img = file_exists($pth . '/images/rings/carat' . $row['carat_image']) ? config_item('base_url') . 'images/rings/carat' . $row['carat_image'] : config_item('base_url') . 'images/rings/noimage.jpg';
                    // $img = '';	
                } else {
                    $img = file_exists($pth . '/images/rings/' . $row['small_image']) ? config_item('base_url') . 'images/rings/' . $row['small_image'] : config_item('base_url') . 'images/rings/noimage.jpg';
                    // $img = '';
                }

                $returnhtml .= $img . '" width="70" ><br>															

								    		

								    		 </div>

							    		 </center>
									
						    		 <div class="txtsmall"> $' . $price . '-' . $row['metal'] . '

						    		 </div>
						    		  <div class="txtsmall"> $' . $yellow_gold_price . '- Yellow Gold' . '

						    		 </div>
						    		  <div class="txtsmall"> $' . $white_gold_price . '- White Gold' . '

						    		 </div>
						    		 
						    		 
						    		 
						    		 

						    		 <a href="javascript:void(0)"  onclick="viewRingsDetails(' . $row['stock_number'] . ',' . $lot . ')">View Details</a>

						    		 <div >';

                $shapes = $this->engagementmodel->getShapeByStockId($row['stock_number']);

                if (isset($shapes) && sizeof($shapes) > 0) {

                    $returnhtml .= '<div id="ringdiamondshapes' . $row['stock_number'] . '" >';

                    foreach ($shapes as $shape) {

                        $returnhtml .= '<div class="inline shapetile"><img  id="shape' . $shape['id'] . '" src="' . config_item('base_url') . '/images/diamonds/' . strtolower($shape['shape']) . '.jpg" height="20px" width="20px" title="' . $shape['shape'] . '"  onclick="$(\'#ringbigimage' . $row['stock_number'] . '\').attr(\'src\',\'' . config_item('base_url') . 'images/rings/' . $shape['image'] . '\'); $(\'#ringdiamondshapes' . $row['stock_number'] . ' img\').css(\'border\',\'0px solid #000\'); $(\'#shape' . $shape['id'] . '\').css(\'border\',\'1px solid #000\');"></div>';
                    }

                    //echo '<div class="clear"></div>';

                    $returnhtml .= ' </div>';
                }

                $returnhtml .= ' </div>

					                 

						    		 </a>

						    		 <br>

						    		 





				    </div>

				    ';
            }
        } else {
            $returnhtml .= '<p style=color:red;font-size:13px;font-weight:Bold;font-family:arial;>' . $returnhtml . '</p>';
        }

        //<div class="hr clear"></div>
        $returnhtml .= '' . $paginlinks;



        echo $returnhtml;
    }

    function getproductresults($id, $page = 0, $lot = 0) {

        $start = ($page == 'undefined') ? 0 : $page;

        $lot = ($lot == 'undefined') ? 0 : $lot;

        $rp = 16;

        $this->load->model('engagementmodel');
        $results = $this->engagementmodel->getproduct($id, $start, $rp);



        $returnhtml = '';

        $this->load->model('sitepaging');

        $paginlinks = $this->sitepaging->getPageing1($id, $results['count'], 'products', $start, 'price', $rp);

        //	echo htmlspecialchars($paginlinks);
        //echo($paginlinks);
        //exit(0);

        $returnhtml .= $paginlinks . '<div class="hr"></div>';

        $addoption = $this->session->userdata('addoption');

        //print_r($results['result']);

        foreach ($results['result'] as $row) {

            $returnhtml .= '

									<div style=" height: 224px; margin-left: 15px;margin-top: 30px;width: 170px;" class="floatl ringbox txtcenter" >

									
									<span style="color:#000000;">
				    				' . $row['Name'] . '
									</span>
									<br>				    				

						    		 <a href="javascript:void(0)" onclick="viewproductDetails2(' . $row['ProductID'] . ',' . $lot . ')">

							    		 <center>

								    		 <div class="ringtile">

								    		 <img style=" width:100px;height:150px;" id="ringbigimage' . $row['Name'] . '" src="';

            if ($gold == 'gold') {

                $img = config_item('base_url') . 'images/products/' . $row['main_pic'];
            } else {


                $img = config_item('base_url') . 'images/leaderimages/' . $row['ProductID'] . ".jpg";
            }

            $returnhtml .= $img . '" width="70" ><br>															

								    		 <!-- <img src="http://www.engagementringsdirect.com/images/rings/' . $row['small_image'] . '" width="70" ></a> <br>-->

								    		 </div>

							    		 </center>
									
						    		 <div style="color:#000000;" class="txtsmall"> $' . $row['SalePriceProduct'] . '

						    		 </div>
									  <div style="color:#000000;" class="txtsmall"> ' . $row['metal'] . '

						    		 </div>
						    		  <div style="color:#000000;" class="txtsmall"> ' . $row['item_info'] . '

						    		 </div>
						    		  <div style="color:#000000;" class="txtsmall"> ' . $row['color'] . '

						    		 </div>
						    		 
						    		 
						    		 
						    		 

						    		 <a  style="color:#000000;"  href="javascript:void(0)" class="search" onclick="viewproductDetails2(' . $row['ProductID'] . ',' . $lot . ')">View Details</a>

						    		 <div >';

            $shapes = $this->engagementmodel->getShapeBycatId($row['categoryid']);

            if (isset($shapes) && sizeof($shapes) > 0) {

                $returnhtml .= '<div class="hr"></div><div id="ringdiamondshapes' . $row['categoryid'] . '" >';

                foreach ($shapes as $shape) {

                    $returnhtml .= '<div class="inline shapetile"><img  id="shape' . $shape['id'] . '" src="' . config_item('base_url') . '/images/diamonds/' . strtolower($shape['shape']) . '.jpg" height="20px" width="20px" title="' . $shape['shape'] . '"  onclick="$(\'#ringbigimage' . $row['stock_number'] . '\').attr(\'src\',\'' . config_item('base_url') . 'images/rings/' . $shape['image'] . '\'); $(\'#ringdiamondshapes' . $row['stock_number'] . ' img\').css(\'border\',\'0px solid #000\'); $(\'#shape' . $shape['id'] . '\').css(\'border\',\'1px solid #000\');"></div>';
                }

                //echo '<div class="clear"></div>';

                $returnhtml .= ' </div>';
            }

            $returnhtml .= ' </div>

					                 

						    		 </a>

						    		 <br>

						    		 

				    </div>

				    ';
        }



        $returnhtml .= '<div class="hr clear"></div>' . $paginlinks;



        echo $returnhtml;
    }

    function search($option = '', $details = false) {



        $data = $this->getCommonData();

        $data['title'] = 'Engagement Ring';

        $this->load->model('diamondmodel');

        //$this->load->model('commonmodel');



        $minprice = 0; //$this->diamondmodel->getMinPrice();

        $maxprice = 1000000; //$this->diamondmodel->getMaxPrice();

        $data['totaldiamond'] = $this->diamondmodel->getCountDiamond($minprice, $maxprice);



        if ($details || $details == 'true') {



            $minprice = ($this->session->userdata('searchminprice') && ($this->session->userdata('searchminprice') > $minprice) && ($this->session->userdata('searchminprice') < $maxprice)) ? ($this->session->userdata('searchminprice')) : $minprice;

            $maxprice = ($this->session->userdata('searchmaxprice') && ($this->session->userdata('searchmaxprice') < $maxprice) && ($this->session->userdata('searchmaxprice') > $minprice)) ? ($this->session->userdata('searchmaxprice')) : $maxprice;



            $data['minprice'] = $minprice;

            $data['maxprice'] = $maxprice;
        } else {



            $data['minprice'] = $minprice;

            $data['maxprice'] = $maxprice;



            /* $this->session->set_userdata('searchminprice',$data['minprice'] );

              $this->session->set_userdata('searchmaxprice',$data['maxprice']); */



            $lastsearchMin = $this->session->userdata('searchminprice');

            $lastsearchMax = $this->session->userdata('searchmaxprice');

            $this->session->set_userdata('lastsearchMin', $lastsearchMin);

            $this->session->set_userdata('lastsearchMax', $lastsearchMax);



            $data['lastminpr'] = $lastsearchMin;

            $data['lastmaxpr'] = $lastsearchMax;



            $data['diashape'] = $this->session->userdata('shape');

            $data['shapename'] = $this->getShapeName($data['diashape']);
        }







        switch ($option) {

            case $option == 'diamonds':

                $data['tabhtml'] = $this->commonmodel->getTabHeader('diamonds');

                $output = $this->load->view('engagement/searchdiamond', $data, true);

                break;



            /* case $option == 'ring':

              $data['tabhtml'] = $this->commonmodel->getTabHeader('ring');

              $output =   $this->load->view('engagement/ringdetails' , $data , true)  ;

              break; */



            case $option == 'addbasket':

                $data['tabhtml'] = $this->commonmodel->getTabHeader('addbasket');

                $output = $this->load->view('engagement/addbasket', $data, true);

                break;

            default:

                $data['tabhtml'] = $this->commonmodel->getTabHeader();

                $output = $this->load->view('engagement/searchdiamond', $data, true);

                break;
        }

        $data['title'] = "Diamonds Engagement Ring|Diamond Solitaire|White Gold|Antique Engagement Ring|Three Stone";

        $data['meta_tags'] = '<meta http-equiv="Content-Type" content="text/html; iso-8859-1">
<meta name="title" content="Diamonds Engagement Ring|Diamond Solitaire|White Gold|Antique Engagement Ring|Three Stone">
<meta name="ROBOTS" content="INDEX,FOLLOW">
<meta name="description" content="Buy Online asscher cut engagement rings, diamond solitaire engagement ring, white gold engagement ring, antique engagement ring, discount diamond engagement rings, cheap diamond engagement rings, wholesale diamond engagement rings, unique diamond engagement rings, three stone engagement rings">
<meta name="abstract" content="Diamond Rings, Wholesale Diamonds, Estate Jewelry, Custom Engagement Rings, New York, Chicago, California, Boston, Las Vegas, Columbia, Montgomery">
<meta name="keywords" content="asscher cut engagement rings, diamond solitaire engagement ring, white gold engagement ring, antique engagement ring, discount diamond engagement rings, cheap diamond engagement rings, wholesale diamond engagement rings, unique diamond engagement rings, three stone engagement rings">
<meta name="author" content="7techniques">
<meta name="publisher" content="7techniques">
<meta name="copyright" content="7techniques">
<meta http-equiv="Reply-to" content="">
<meta name="creation_Date" content="12/12/2008">
<meta name="expires" content="">
<meta name="revisit-after" content="7 days">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';

        $this->output($output, $data, false);
    }

    function threestoneringsettings($centrestoneid = '', $sidestoneid1 = '', $sidestoneid2 = '', $addoption = '') {



        $data = $this->getCommonData();

        $data['title'] = 'Three-Stone Rings';



        $data['tabhtml'] = $this->commonmodel->getThreeStoneTab('ring', $centrestoneid, $sidestoneid1, $sidestoneid2);

        $data['centerstoneid'] = $centrestoneid;

        $data['sidestoneid1'] = $sidestoneid1;

        $data['sidestoneid2'] = $sidestoneid2;

        $data['addoption'] = $addoption;





        $data['extraheader'] = '';

        $data['extraheader'] .= '

					<script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>

					';



        $this->load->model('engagementmodel');

        $data['threestonerings'] = $this->jewelrymodel->getAllThreestoneRing();



        $output = $this->load->view('engagement/threestonerings', $data, true);

        $this->output($output, $data);
    }

    function ringdetails($stockno = '', $ringoption = '', $lotno = '') {

        $data = $this->getCommonData();

        $data['title'] = 'Engagement Ring Details';



        $this->load->model('engagementmodel');

        $this->load->model('jewelrymodel');



        $this->session->set_userdata('stocknumber', $stockno);





        $data['details'] = $this->jewelrymodel->getAllByStock($stockno);



        $data['tabhtml'] = $this->commonmodel->getTabHeader('ring', $lotno, $stockno);

        $data['lotno'] = $lotno; //$this->session->userdata('mydiamondid');

        $data['stockno'] = $stockno;



        if ($data['lotno'] && $data['details']) {

            $output = $this->load->view('engagement/ringdetails', $data, true);

            $this->output($output, $data);
        }
    }

    function productdetails($categoryid = '', $ringoption = '', $lotno = '') {

        $data = $this->getCommonData();

        $data['title'] = 'Engagement Ring Details';



        $this->load->model('engagementmodel');

        $this->load->model('jewelrymodel');



        $this->session->set_userdata('categoryid', $categoryid);





        $data['details'] = $this->jewelrymodel->getAllBycategoryid($categoryid);



        $data['tabhtml'] = $this->commonmodel->getTabHeader1('ring', $lotno, $categoryid);

        $data['lotno'] = $lotno; //$this->session->userdata('mydiamondid');

        $data['categoryid'] = $categoryid;



        if ($data['lotno'] && $data['details']) {

            $output = $this->load->view('engagement/ringdetails', $data, true);

            $this->output($output, $data);
        }
    }

    function addtobasket($diamondlotno = '', $stockno = '', $addoption = '', $sidestone1 = '', $sidestone2 = '', $dsize = '', $metaltype = '') {


        $data = $this->getCommonData();

        $this->load->model('engagementmodel');

        $this->load->model('diamondmodel');

        $this->load->model('jewelrymodel');

        $this->load->model('cartmodel');


        $data['title'] = 'Shopping Basket';

        $data['tabhtml'] = '';

        $data['addoption'] = $addoption;

        $data['lotno'] = $diamondlotno;

        $data['stockno'] = $stockno;

        $data['sidestone1'] = ($sidestone1 == 'false') ? '' : $sidestone1;

        $data['sidestone2'] = ($sidestone2 == 'false') ? '' : $sidestone2;

        //$data['sidestone2']	= $sidestone2;

        $data['dsize'] = $dsize;
        $data['metaltype'] = $metaltype;

        $data['side1'] = '';

        $data['side2'] = '';


        if ($sidestone1 != '' && $sidestone2 != '') {

            $data['side1'] = $this->diamondmodel->getDetailsByLot($sidestone1);

            $data['side2'] = $this->diamondmodel->getDetailsByLot($sidestone2);
        }

        if ($addoption == 'addtoring') {
            $data['tabhtml'] = $this->commonmodel->getTabHeader('addbasket', $diamondlotno, $stockno);
        }

        if ($addoption == 'tothreestone') {
            $data['tabhtml'] = $this->commonmodel->getTabHeader('addbasket', $diamondlotno, $stockno);
        } //$this->commonmodel->getThreeStoneTab('addbasket',$diamondlotno, $sidestone1,$sidestone2,$stockno);}
        //$data['ringdetails'] = $this->engagementmodel->getRingByStockId($stockno);

        $data['ringdetails'] = $this->jewelrymodel->getAllByStock($stockno);

        $data['diamonddetails'] = $this->diamondmodel->getDetailsByLot($diamondlotno);


        /* $success = false;

          switch ($addoption){

          case 'tothreestone':

          $success = $this->cartmodel->add3stonering($diamondlotno,$sidestone1,$sidestone2,$stockno);

          echo ($success) ? 'Successfully added' : 'Faild to add! Please try again properly.';

          break;

          default:

          break;

          } */



        $basket = $this->session->userdata('basket');

        $basket['ring']['diamond'] = $diamondlotno;

        $basket['ring']['setting'] = $stockno;

        $basket['ring']['metaytype'] = $metaltype;

        $basket['ring']['dsize'] = $dsize;



        $data['extraheader'] = ' <script src="' . config_item('base_url') . 'js/swfobject.js" type="text/javascript"></script>

					';

        $data['flashfiles'] = $this->engagementmodel->getFlashByStockId($stockno);

        $this->session->set_userdata('basket', $basket);

        $output = $this->load->view('engagement/addbasket', $data, true);

        $this->output($output, $data);
    }

    function test() {

        echo config_item('base_path') . '--------------' . dirname(__FILE__);
    }

    private function getShapeName($shapelist) {

        $shapename = '';

        $shapestr = '';

        if (($this->session->userdata('shape'))) {



            $shapes = $this->session->userdata('shape');

            $shapelist = explode('.', $shapes);



            if (sizeof($shapelist > 0)) {

                foreach ($shapelist as $val) {

                    if ($val != '') {

                        switch ($val) {

                            case 'B':

                                $shapename = 'Round';

                                break;

                            case 'PR':

                                $shapename = 'Princess';

                                break;

                            case 'R':

                                $shapename = 'Radiant';

                                break;

                            case 'E':

                                $shapename = 'Emerald';

                                break;

                            case 'AS':

                                $shapename = 'Ascher';

                                break;

                            case 'O':

                                $shapename = 'Oval';

                                break;

                            case 'M':

                                $shapename = 'Marquise';

                                break;

                            case 'P':

                                $shapename = 'Pear shape';

                                break;

                            case 'H':

                                $shapename = 'Heart';

                                break;

                            case 'C':

                                $shapename = 'Cushion';

                                break;

                            default:

                                $shapename = '';

                                break;
                        }

                        $shapestr .= $shapename . ", ";
                    }
                }

                $shapestr = substr($shapestr, 0, (strlen($shapestr) - 2));
            }
        }

        return $shapestr;
    }

    /* 	function searchresult(){

      $data = $this->getCommonData();

      $data['title'] = 'Search Result';

      $this->load->model('searchresultmodel');

      $this->load->model('diamondmodel');

      $this->load->model('watchesmodel');

      $getsearchresult = '';

      $inputvalue = '';

      $inputarray = array();

      $diamonddetails = '';

      $jewelrydetails = '';

      $watchesdetails = '';

      $keydetails =  array();



      $inputvalue = $_POST['searchkeyword'];

      $inputarray = explode(' ',$inputvalue);



      for($i=0; $i<sizeof($inputarray); $i++){



      if(is_numeric($inputarray[$i])){

      $diamonddetails = $this->diamondmodel->getDetailsByLot($inputarray[$i]);

      $jewelrydetails = $this->jewelrymodel->getAllByStock($inputarray[$i]);


      }

      $watchesdetails = $this->watchesmodel->getWatchBySKU($inputarray[$i]);

      $keydetails = $this->searchresultmodel->getAllSearchResultByKey($inputarray[$i]);



      }



      $data['inputvalue'] = $inputvalue;

      $data['diamonddetails'] = $diamonddetails;

      $data['jewelrydetails'] = $jewelrydetails;

      $data['watchesdetails'] = $watchesdetails;

      $data['keydetails'] = $keydetails;



      //var_dump($keydetails);



      $output = $this->load->view('engagement/searchresult' , $data , true);

      $this->output($output , $data);

      } */

    /*function searchresult() {

        $data = $this->getCommonData();

        $data['title'] = 'Search Result';

        $this->load->model('searchresultmodel');

        $this->load->model('diamondmodel');

        $this->load->model('watchesmodel');

        $getsearchresult = '';

        $inputvalue = '';

        $inputarray = array();

        $diamonddetails = '';

        $jewelrydetails = '';

        $watchesdetails = '';

        $keydetails = array();



        $inputvalue = $_POST['searchkeyword'];

        $inputarray = explode(' ', $inputvalue);

        for ($i = 0; $i < sizeof($inputarray); $i++) {



            if (is_numeric($inputarray[$i])) {

                $diamonddetails = $this->diamondmodel->getDetailsByLot($inputarray[$i]);
		//print_r($inputarray);
//die;
                $jewelrydetails = $this->jewelrymodel->getAllByStock($inputarray[$i]);
            }
            $qgdetail = $this->diamondmodel->getAllByQG($inputarray[$i]);
            $stullerdetail = $this->diamondmodel->getAllByStuller($inputarray[$i]);
            //$watchesdetails = $this->watchesmodel->getWatchBySKU($inputarray[$i]);

            $keydetails = $this->searchresultmodel->getAllSearchResultByKey($inputarray[$i]);
	
        }



        $data['inputvalue'] = $inputvalue;

        $data['diamonddetails'] = $diamonddetails;

        $data['jewelrydetails'] = $jewelrydetails;
        $data['qgdetail'] = $qgdetail;
        $data['stullerdetail'] = $stullerdetail;

        $data['watchesdetails'] = $watchesdetails;

        $data['keydetails'] = $keydetails;$this->searchresultmodel->

        //print_r($data);
        //var_dump($keydetails); 



        $output = $this->load->view('engagement/searchresult', $data, true);

        $this->output($output, $data, false);
    }*/

	function searchresult()
	{
        $this->load->model('searchresultmodel');		
		$data = $this->getCommonData();
		$this->load->library("pagination");
		$inputvalue = $_POST['searchkeyword'];
		$data['inputvalue'] = $inputvalue;
		
		$config["base_url"]=config_item('base_url')."engagement/searchresult/";
		$config["total_rows"]=$this->searchresultmodel->numofrowsquality($inputvalue);
		($_POST['pageper']!='') ? $config["per_page"]=$_POST['pageper'] : $config["per_page"]=25;
		$config["num_links"]=10;
		$config["uri_segment"] = 3;
		$pricerange = $_POST['pricerange'];
		$sort = $_POST['sortby'];

		//$config['num_tag_open'] = '<li>';
		//$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<a class="active" href="#">';
		$config['cur_tag_close'] = '</a>';

		//ezvalue
		$ezvalues = $this->searchresultmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue'];

		//$config['full_tag_open'] = '<div id="pagination" style="color:White">';
		//$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);

		$data['totalresult'] = $config["total_rows"];
		$data['numresults'] = $config["per_page"];
		$data['totalresult'] = $config["total_rows"];
		$data['results'] = $this->searchresultmodel->getSearchResult($config["per_page"], $this->uri->segment(3),$inputvalue, $pricerange, $sort);
		$output = $this->load->view('engagement/searchresultnew', $data, true);
		//$output = $this->load->view('engagement/searchresult', $data, true);
        $this->output($output, $data);
	}

    //new function added
    function products($l1, $l2) {
        $data = $this->getCommonData();
        $products = $this->jewelrymodel->GetProductsByLevels($l1, l2);
        $data['all_sub_category'] = $this->jewelrymodel->getstuller_cat_level();
        $data["products"] = $products;
        $data["page"] = "stuller";
        $output = $this->load->view('engagement/products', $data, true);
        $this->output($output, $data, false);
    }

    function newproducts($l1, $l2) {
        $data = $this->getCommonData();
        $products = $this->jewelrymodel->GetProductsByLevels_new($l1, l2);
        $data['all_sub_category'] = $this->jewelrymodel->getstuller_cat_level_new();
        $data["products"] = $products;
        $data["page"] = "stuller";
        $output = $this->load->view('engagement/new_products', $data, true);
        $this->output($output, $data, false);
    }

    function stullerinventory() {


        $data = $this->getCommonData();
        $data['title'] = 'Browse Stuller Jewellry';
        $data["page"] = "stuller";
        $data["all_category"] = $this->jewelrymodel->getstullerlevel1();
        $output = $this->load->view('engagement/stullerinventory', $data, true);
        $this->output($output, $data, false);
    }

    function newstullerinventory() {


        $data = $this->getCommonData();
        $data['title'] = 'Browse Stuller Jewellry';
        $data["page"] = "stuller";
        $data["all_category"] = $this->jewelrymodel->getstullerlevel1_new();
        $output = $this->load->view('engagement/new_stullerinventory', $data, true);
        $this->output($output, $data, false);
    }

    function qualityandgold($folder = 'Gold11', $page = '1') {


        $data = $this->getCommonData();
        $this->load->model('jewelrymodel');
        $data['page'] = 'home';
        $data['usetips'] = true;
        $rp = isset($_POST['rp']) ? $_POST['rp'] : 8;
        $sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'qg_id';
        $sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'asc';
        $query = isset($_POST['query']) ? $_POST['query'] : '';
        $qtype = isset($_POST['qtype']) ? $_POST['qtype'] : 'itemid';

        if (is_numeric($this->uri->segment(4)) && $this->uri->segment(4) != '')
            $page = $this->uri->segment(4);
        if ($this->uri->segment(4) == '' && is_numeric($this->uri->segment(3)) && $this->uri->segment(3) != '')
            $page = $this->uri->segment(3);

        $folder = $this->uri->segment(3);
        if ($folder == '' || is_numeric($folder))
            $folder = "";
        $result_array = $data['results'] = $this->jewelrymodel->getqualitygold($page, $rp, $sortname, $sortorder, $query, $qtype, $folder);
        $this->load->model('sitepaging');
        $data['paginlinks'] = $this->sitepaging->getPageing1($folder, $result_array['count'], 'dev_qg', $page, 'qg_id', $rp);
        //$data = explode("/",$folders[$l]['folder']);  
        //$data['returnhtml'] =  $returnhtml;  
        $output = $this->load->view('engagement/qualityandgold', $data, true);

        $this->output($output, $data, false);
        //$this->new_output($output , $data); 
    }

}
