<?php
/**
* class used for displaying jewelleries entered by the sellers...
* @param string
* @return string
* @since 24, March 2013
* @Author Maninder Singh
*/
class Jewelleries extends Controller{
	function jewelleries(){
		
		parent::Controller();
        $this->load->library("pagination");
        $this->load->model("jewelleriesmodel");
        $this->load->helper("url");
        $this->load->helper("t_helper");
        $this->load->helper('directory');
	}
	function getmysubstullerfur($catname="")
	{
		$this->load->library("pagination");
		$data = $this->getCommonData();
		$config["base_url"]=config_item('base_url')."jewelleries/getmysubstullerfur/".$catname."/";
		$config["total_rows"]=$this->jewelleriesmodel->numofrowsmysubstullerfur($catname);
		$config["per_page"]=16;
		$config["num_links"]=5;
		$config["uri_segment"] = 5;
		$config['full_tag_open'] = '<div id="pagination" style="color:White">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		//echo $this->uri->segment(9);
		$data["records"] = $this->jewelleriesmodel->getminesubstuller($config["per_page"], $this->uri->segment(4),$catname);
		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		$output = $this->load->view('jewelleries/subsubmystuller', $data, true);
		$this->output($output, $data);
	}
	function allstullerandquantity($status='') {
		$this->load->library("pagination");
		$data = $this->getCommonData();
		$config["base_url"]=config_item('base_url')."jewelleries/allstullerandquantity/";
		$config["total_rows"]= $this->jewelleriesmodel->numofrowsallstullerandquantity();
		$config["per_page"]=9;
		$config["num_links"]=3;
		$config["uri_segment"] = 3;
		$seg = 3;
		if(!is_numeric($status)) {
			$seg = 4;
			$config["uri_segment"] = 4;
			$config["base_url"]=config_item('base_url')."jewelleries/allstullerandquantity/".$status."/";
		}

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="active" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		//ezvalues
		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue'];
		$this->pagination->initialize($config);
		$carat = $_POST['ctweight'];
		$price = $_POST['price'];
		$metal = $_POST['metal'];

		$data["records"] = $this->jewelleriesmodel->getallstullerandquantity($config["per_page"], $this->uri->segment($seg),$carat,$price,$status);
		
		$data['clearancelink'] = '<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/allstullerandquantity/Special_Order\';" value="Special Order"/>Special Order</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/allstullerandquantity/Made_To_Order\';" value="Made To Order"/>Made To Order</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/allstullerandquantity/Limited_Availability\';" value="Limited Availability"/>Limited Availability</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/allstullerandquantity/While_supplies_last\';" value="While supplies last"/>While supplies last</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/allstullerandquantity/CloseOut\';" value="CloseOut"/>Closeout</li>';
	
		/* the metalink and style is more related to categories so we need to have another kind of naming each link to do this
		$data['metallink'] .= "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Ring'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Ring'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Ring'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Rose_Gold/Ring'>14k Rose Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Ring'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Ring'>14k Two-tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k-Silver_Two-Tone/Ring'>14k Silver Two-Tone</a></li>";		
		$data['metallink'] .= "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Necklace'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Necklace'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Necklace'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Necklace'>14k_White_Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Necklace'>14k Two-tone</a></li>";
		$data['metallink'] .= "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Bracelet'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Bracelet'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Bracelet'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Bracelet'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Bracelet'>14k Two-tone</a></li>";
		$data['metallink'] .= "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Earring'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Earring'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Earring'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Rose_Gold/Earring'>14k Rose Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Earring'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Earring'>14k Silver Two-Tone</a></li>";		
		$data['metallink'] .= "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Mens'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/clearnace/Mens'>clearnace</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Rings/Mens'>Rings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Earrings/Mens'>Earrings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Pendants/Mens'>Pendants</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Necklaces/Mens'>Necklaces</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Braclets/Mens'>Braclets</a></li>";

	
		$data['stylelink'] .= "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Ring'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Wedding_Bands/Ring'>Wedding Bands</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Ring'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Ring'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Ring'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Engagement_And_Anniversary/Ring'>Engagement And Anniversary</a></li>";
		$data['stylelink'] .= "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Necklace'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Necklace'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Necklace'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Necklace'>Mountings</a></li>";
		$data['stylelink'] .= "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Bracelet'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Bracelet'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Bracelet'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Bracelet'>Diamond Fashion</a></li>";
		$data['stylelink'] .= "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Earring'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Earring'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Earring'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Earring'>Metal Fashion</a></li>";
*/
		$data['mainurl'] = config_item('base_url')."jewelleries/allstullerandquantity/";
		$output = $this->load->view('jewelleries/allstullerandquantity', $data, true);
		$this->output($output, $data);		
	}
	function getmystullerfurwithsub($catname="",$maincat="",$status="")
	{
		$this->load->library("pagination");
		$data = $this->getCommonData();
		$config["base_url"]=config_item('base_url')."jewelleries/getmystullerfurwithsub/".$catname."/".$maincat."/";
		//print_r($config["base_url"]);exit;
		$config["total_rows"]= $this->jewelleriesmodel->numofrowsmystullerfurwithsub($catname);
		$config["per_page"]=18;
		$config["num_links"]=5;
		$config["uri_segment"] = 5;
		$seg = 5;
		if(!is_numeric($status)) {
			$seg = 6;
			$config["uri_segment"] = 6;
			$config["base_url"]=config_item('base_url')."jewelleries/getmystullerfurwithsub/".$catname."/".$maincat."/".$status."/";
		}

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="active" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		//ezvalues
		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue'];

		//$config['full_tag_open'] = '<div id="pagination" style="color:White">';
		//$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		//echo $this->uri->segment(9);
		$carat = $_POST['ctweight'];
		$price = $_POST['price'];
		$metal = $_POST['metal'];

		$data["records"] = $this->jewelleriesmodel->getminestullerwithsub($config["per_page"], $this->uri->segment($seg),$catname,$maincat,$carat,$price,$status);
		
		//print_r($data["records"]);exit;
		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		//$output = $this->load->view('jewelleries/submystullerwithsub', $data, true);//old

		$data['clearancelink'] = '<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getmystullerfurwithsub/'.$catname.'/'.$maincat.'/Special_Order\';" value="Special Order"/>Special Order</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getmystullerfurwithsub/'.$catname.'/'.$maincat.'/Made_To_Order\';" value="Made To Order"/>Made To Order</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getmystullerfurwithsub/'.$catname.'/'.$maincat.'/Limited_Availability\';" value="Limited Availability"/>Limited Availability</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getmystullerfurwithsub/'.$catname.'/'.$maincat.'/While_supplies_last\';" value="While supplies last"/>While supplies last</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getstullerfur/'.$catname.'/'.$maincat.'/CloseOut\';" value="CloseOut"/>Closeout</li>';

		switch ($maincat){
			case 'Ring':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Ring'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Ring'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Ring'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Rose_Gold/Ring'>14k Rose Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Ring'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Ring'>14k Two-tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k-Silver_Two-Tone/Ring'>14k Silver Two-Tone</a></li>";
			break;
			case 'Necklace':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Necklace'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Necklace'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Necklace'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Necklace'>14k_White_Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Necklace'>14k Two-tone</a></li>";
			break;
			case 'Bracelet':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Bracelet'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Bracelet'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Bracelet'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Bracelet'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Bracelet'>14k Two-tone</a></li>";
			break;
			case 'Earring':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Earring'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Earring'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Earring'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Rose_Gold/Earring'>14k Rose Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Earring'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Earring'>14k Silver Two-Tone</a></li>";
			break;
			case 'Mens':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Mens'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/clearnace/Mens'>clearnace</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Rings/Mens'>Rings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Earrings/Mens'>Earrings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Pendants/Mens'>Pendants</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Necklaces/Mens'>Necklaces</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Braclets/Mens'>Braclets</a></li>";
			break;
		}

		switch ($maincat){
			case 'Ring':		
			$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Ring'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Wedding_Bands/Ring'>Wedding Bands</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Ring'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Ring'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Ring'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Engagement_And_Anniversary/Ring'>Engagement And Anniversary</a></li>";
			break;
			case 'Necklace':		
			$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Necklace'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Necklace'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Necklace'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Necklace'>Mountings</a></li>";
			break;
			case 'Bracelet':		
			$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Bracelet'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Bracelet'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Bracelet'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Bracelet'>Diamond Fashion</a></li>";
			break;
			case 'Earring':		
			$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Earring'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Earring'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Earring'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Earring'>Metal Fashion</a></li>";
			break;
			case 'Mens':		
			$data['stylelink'] = '';
			break;
			case 'watch':		
			$data['stylelink'] = '';
			break;
		}
		$filterp = $this->jewelleriesmodel->getfilterprice(); 
		$data['filterprice']=$filterp['0']['price'];
		//die($data['filterprice']);
		 
		$data['cataname'] = $maincat;
		$data['mainurl'] = config_item('base_url')."jewelleries/getmystullerfurwithsub/";
		$output = $this->load->view('jewelleries/submystullerwithsubnew', $data, true);
		$this->output($output, $data);
	}
	function getmystullerfur($catname="")
	{
		$this->load->library("pagination");
		$data = $this->getCommonData();
		$config["base_url"]=config_item('base_url')."jewelleries/getmystullerfur/".$catname."/";
		$config["total_rows"]=$this->jewelleriesmodel->numofrowsmystullerfur($catname);
		$config["per_page"]=18;
		$config["num_links"]=5;
		$config["uri_segment"] = 5;

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="active" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		//ezvalues
		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue'];

		//$config['full_tag_open'] = '<div id="pagination" style="color:White">';
		//$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		//echo $this->uri->segment(9);
		$carat = $_POST['ctweight'];
		$price = $_POST['price'];
		$metal = $_POST['metal'];
		$data["records"] = $this->jewelleriesmodel->getminestuller($config["per_page"], $this->uri->segment(4),$catname,$carat,$price);
		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		//$output = $this->load->view('jewelleries/submystuller', $data, true);//old

		$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfur/Gemstone_Fashion'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfur/Wedding_Bands'>Wedding Bands</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfur/Diamond_Fashion'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfur/Mountings'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfur/Metal_Fashion'>Metal_Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfur/Engagement_And_Anniversary'>Engagement And Anniversary</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfur/Findings'>Findings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfur/Fabricated_Metals'>Fabricated Metals</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfur/Functional_Drivers'>Functional Drivers</a></li>";

		$data['cataname'] = $maincat;
		$output = $this->load->view('jewelleries/submystullerwithsubnew', $data, true);
		$this->output($output, $data);
	}
	function getstullerfur($catname="",$maincat,$status="")
	{
		$this->load->library("pagination");
		$data = $this->getCommonData();
		$config["base_url"]=config_item('base_url')."jewelleries/getstullerfur/".$catname."/".$maincat."/";
		$config["total_rows"]=$this->jewelleriesmodel->numofrowsqualityfur($catname);
		$config["per_page"]=18;
		$config["num_links"]=5;
		$config["uri_segment"] = 5;
		$seg = 5;
		if(!is_numeric($status)) {
			$seg = 6;
			$config["uri_segment"] = 6;
			$config["base_url"]=config_item('base_url')."jewelleries/getstullerfur/".$catname."/".$maincat."/".$status."/";
		}

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="active" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		//old
		//$config['full_tag_open'] = '<div id="pagination" style="color:White">';
		//$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		//echo $this->uri->segment(9);
		$carat = $_POST['ctweight'];
		$price = $_POST['price'];
		$metal = $_POST['metal'];
		$data["records"] = $this->jewelleriesmodel->getAllqualityinfofur($config["per_page"], $this->uri->segment($seg),$catname,$maincat,$carat,$price,$status);

		$filterp = $this->jewelleriesmodel->getfilterprice(); 
		$data['filterprice']=$filterp['0']['price'];
		//die($data['filterprice']);
		//ezvalues
		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue'];

		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		//$output = $this->load->view('jewelleries/quality', $data, true);//old

		$data['clearancelink'] = '<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getmystullerfurwithsub/'.$catname.'/'.$maincat.'/Special_Order\';" value="Special Order"/>Special Order</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getmystullerfurwithsub/'.$catname.'/'.$maincat.'/Made_To_Order\';" value="Made To Order"/>Made To Order</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getmystullerfurwithsub/'.$catname.'/'.$maincat.'/Limited_Availability\';" value="Limited Availability"/>Limited Availability</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getmystullerfurwithsub/'.$catname.'/'.$maincat.'/While_supplies_last\';" value="While supplies last"/>While supplies last</li>'.
						'<li><input type="radio" name="status" onclick="window.location.href = \''.config_item('base_url').'jewelleries/getstullerfur/'.$catname.'/'.$maincat.'/CloseOut\';" value="CloseOut"/>Closeout</li>';

		switch ($maincat){
			case 'Ring':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Ring'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Ring'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Ring'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Rose_Gold/Ring'>14k Rose Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Ring'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Ring'>14k Two-tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k-Silver_Two-Tone/Ring'>14k Silver Two-Tone</a></li>";
			break;
			case 'Necklace':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Necklace'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Necklace'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Necklace'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Necklace'>14k_White_Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Necklace'>14k Two-tone</a></li>";
			break;
			case 'Bracelet':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Bracelet'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Bracelet'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Bracelet'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Bracelet'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Bracelet'>14k Two-tone</a></li>";
			break;
			case 'Earring':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Earring'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Earring'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Earring'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Rose_Gold/Earring'>14k Rose Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Earring'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Earring'>14k Silver Two-Tone</a></li>";
			break;
			case 'Mens':		
			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Mens'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/clearnace/Mens'>clearnace</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Rings/Mens'>Rings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Earrings/Mens'>Earrings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Pendants/Mens'>Pendants</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Necklaces/Mens'>Necklaces</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Braclets/Mens'>Braclets</a></li>";
			break;
		}

		switch ($maincat){
			case 'Ring':		
			$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Ring'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Wedding_Bands/Ring'>Wedding Bands</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Ring'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Ring'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Ring'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Engagement_And_Anniversary/Ring'>Engagement And Anniversary</a></li>";
			break;
			case 'Necklace':		
			$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Necklace'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Necklace'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Necklace'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Necklace'>Mountings</a></li>";
			break;
			case 'Bracelet':		
			$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Bracelet'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Bracelet'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Bracelet'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Bracelet'>Diamond Fashion</a></li>";
			break;
			case 'Earring':		
			$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Earring'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Earring'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Earring'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Earring'>Metal Fashion</a></li>";
			break;
			case 'Mens':		
			$data['stylelink'] = '';
			break;
			case 'watch':		
			$data['stylelink'] = '';
			break;
		}
		
		$data['cataname'] = $maincat;
		$output = $this->load->view('jewelleries/qualityview', $data, true);//new
		$this->output($output, $data);
	}
	function getjewleries($catname="")
	{
	
		$this->load->library("pagination");
		$data = $this->getCommonData();
		$config["base_url"]=config_item('base_url')."jewelleries/getjewleries/".$catname."/";
		$config["total_rows"]=$this->jewelleriesmodel->numofrowsquality($catname);
		$config["per_page"]=16;
		$config["num_links"]=5;
		$config["uri_segment"] = 4;
		  $config['full_tag_open'] = '<div id="pagination" style="color:White">';
		 $config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		//echo $this->uri->segment(9);
		$data["records"] = $this->jewelleriesmodel->getAllqualityinfo($config["per_page"], $this->uri->segment(4),$catname);
		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));

		//$output = $this->load->view('jewelleries/quality', $data, true);//old
	
		//New View Section
		$data['cataname'] = $catname;
		switch ($catname){
			case 'Ring':		
			$output = $this->load->view('jewelleries/ring-view', $data, true);//new
			break;
			case 'Necklace':		
			$output = $this->load->view('jewelleries/necklaces-view', $data, true);//new
			break;
			case 'Bracelet':		
			$output = $this->load->view('jewelleries/qualitycata', $data, true);//new
			break;
			case 'Earring':
			$output = $this->load->view('jewelleries/qualitycataearrings', $data, true);//new
			break;
			case 'Mens':		
			$output = $this->load->view('jewelleries/qualitycataearringsmen', $data, true);//new
			break;
			case 'watch':		
			$output = $this->load->view('jewelleries/qualitycata', $data, true);//new
			break;
		}
		$this->output($output, $data);
	}
	function getmystuller($catname="")
	{
		$this->load->library("pagination");
		$data = $this->getCommonData();
		$config["base_url"]=config_item('base_url')."jewelleries/getmystuller/".$catname."/";
		$config["total_rows"]=$this->jewelleriesmodel->numofrowsmystuller($catname);
		$config["per_page"]=16;
		$config["num_links"]=5;
		$config["uri_segment"] = 4;
		$config['full_tag_open'] = '<div id="pagination" style="color:White">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		//echo $this->uri->segment(9);
		$data["records"] = $this->jewelleriesmodel->getAllstullermyinfo($config["per_page"], $this->uri->segment(4),$catname);
		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		//$output = $this->load->view('jewelleries/mystuller', $data, true);//old
		
		$data['cataname'] = $catname;
		$output = $this->load->view('jewelleries/mystullernew', $data, true);
		$this->output($output, $data);
	}
	function getuniquecat()
	{
		//echo "mica";
		
		$data = $this->getCommonData();
	
		//$data["mytotal_rows"] = 0;
		$data["records"] = $this->jewelleriesmodel->getAlluniquecat2();
		$output = $this->load->view('jewelleries/unique1', $data, true);
		$this->output($output, $data);
	}
	
	function getsuboncat($id)
	{
		
		$data = $this->getCommonData();
		$data["mytotal_rows"]=$this->jewelleriesmodel->numofrowsunique2($id);
		$data["records"] = $this->jewelleriesmodel->build_child($id);
		if(count($records['result'])==0)
		{
			$this->load->library("pagination");
			$config["base_url"]=config_item('base_url')."jewelleries/getsuboncat/".$id."/";
			$config["total_rows"]=$this->jewelleriesmodel->numofrowsunique($id);
			$config["per_page"]=16;
			$config["num_links"]=5;
			$config["uri_segment"] = 5;
			$config['full_tag_open'] = '<div id="pagination" style="color:White">';
			$config['full_tag_close'] = '</div>';
			$this->pagination->initialize($config);
			//$data["records"] = $this->jewelleriesmodel->getAlluniquecat2();
			$data["records2"] = $this->jewelleriesmodel->getuniqueproduct($config["per_page"], $this->uri->segment(5),$id);
		}
		$output = $this->load->view('jewelleries/unique1', $data, true);
		$this->output($output, $data);
	}
	function getstuller($catname="")
	{
		$this->load->library("pagination");
		$data = $this->getCommonData();
		//$config["base_url"]=config_item('base_url')."jewelleries/getstuller/".$catname."/";
		//$config["total_rows"]=$this->jewelleriesmodel->numofrowsstuller($catname);
		//$config["per_page"]=16;
		///$config["num_links"]=10;
	//	$config["uri_segment"] = 4;
	//	$config['full_tag_open'] = '<div id="pagination" style="color:White">';
	//	$config['full_tag_close'] = '</div>';
	//	$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		//echo $this->uri->segment(9);
		$data["records"] = $this->jewelleriesmodel->getAllstullerinfo();
		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		$output = $this->load->view('jewelleries/stuller', $data, true);
		$this->output($output, $data);
	}
	function index($gender="none", $catid="none", $subcatid="none", $metaltype="none", $style="none", $price="none")
	{
		//$data = $this->getCommonData();
		//$data['title'] = 'Jewelleries';
		//$config["base_url"]=config_item('base_url')."jewelleries/index/".$gender."/".$catid."/".$subcatid."/".$metaltype."/".$style."/".$price."/";
		//$config["total_rows"]=$this->jewelleriesmodel->jewellery_count($gender, $catid, $subcatid, $metaltype, $style, $price);
		//$config["per_page"]=16;
		//$config["num_links"]=10;
		//$config["uri_segment"] = 9;
      //  $config['full_tag_open'] = '<div id="pagination">';
       /// $config['full_tag_close'] = '</div>';
		//$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		$data["records"] = $this->jewelleriesmodel->getAlluniquecat();
		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		$output = $this->load->view('jewelleries/index',$data, true);
        $this->output($output, $data);
	}
	function uniquesetting($gender="none", $catid="none", $subcatid="none", $metaltype="none", $style="none", $price="none")
	{
		//$data = $this->getCommonData();
		//$data['title'] = 'Jewelleries';
		//$config["base_url"]=config_item('base_url')."jewelleries/index/".$gender."/".$catid."/".$subcatid."/".$metaltype."/".$style."/".$price."/";
		//$config["total_rows"]=$this->jewelleriesmodel->jewellery_count($gender, $catid, $subcatid, $metaltype, $style, $price);
		//$config["per_page"]=16;
		//$config["num_links"]=10;
		//$config["uri_segment"] = 9;
		//  $config['full_tag_open'] = '<div id="pagination">';
		/// $config['full_tag_close'] = '</div>';
		//$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		$data["records"] = $this->jewelleriesmodel->getAlluniqueproducts();
		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		$output = $this->load->view('jewelleries/uniquesetting', $data, true);
		$this->output($output, $data);
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
	
    private function getCommonData($banner = '') {

        $data = array();
        $data = $this->commonmodel->getPageCommonData();
        return $data;
    }

    function output($layout = null, $data = array(), $isleft = true, $isright = true) {

        $data['loginlink'] = $this->user->loginhtml();
        $output = $this->load->view($this->config->item('template') . 'header', $data, true);
        $output .= $layout;
        if ($isright)
            $output .= $this->load->view($this->config->item('template') . 'right', $data, true);
        $output .= $this->load->view($this->config->item('template') . 'footer', $data, true);
        $this->output->set_output($output);
    }	

    function addtoshoppingcart()
	{
		$this->jewelleriesmodel->addtoshoppingcartmode($_POST);
		$_SESSION['5ez_price'] = $_POST['5ez_price'];
		$_SESSION['3ez_price'] = $_POST['3ez_price'];
		$_SESSION['main_price'] = $_POST['main_price'];
		header("Location: " . config_item('base_url')."shoppingbasket/mybasket");
	}
	
	/* 28-10-2013-sandeep*/
	function engagement()
	{
		//echo "mica";
		
		$data = $this->getCommonData();
	
		//$data["mytotal_rows"] = 0;
		$data["records"] = $this->jewelleriesmodel->getAlluniquecat2();
		$output = $this->load->view('jewelleries/engagement', $data, true);
		$this->output($output, $data);
	} 	
	function engagementView()
	{
		//echo "mica";
		
		$data = $this->getCommonData();
	
		//$data["mytotal_rows"] = 0;
		$data["records"] = $this->jewelleriesmodel->getAlluniquecat2();
		$output = $this->load->view('jewelleries/engagement_view', $data, true);
		$this->output($output, $data);
	} 

	function getuniqueproduct($id,$cataname)
	{
		$this->load->library("pagination");
		$data = $this->getCommonData();
		$config["base_url"]=config_item('base_url')."jewelleries/getuniqueproduct/".$id.'/'.$cataname.'/';
		$config["total_rows"]=$this->jewelleriesmodel->numofrowsunique2($id);
		$config["per_page"]=18;
		$config["num_links"]=5;
		$config["uri_segment"] = 4;

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="active" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		//old
		//$config['full_tag_open'] = '<div id="pagination" style="color:White">';
		//$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		//echo $this->uri->segment(9);
		$carat = $_POST['ctweight'];
		$metal = $_POST['metal'];
		$data["records"] = $this->jewelleriesmodel->getuniqueproduct($config["per_page"], $this->uri->segment(5),$id,$carat);

		//ezvalues
		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue'];

		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		//$output = $this->load->view('jewelleries/quality', $data, true);//old
		
		$data['cataname'] = $cataname;
		$output = $this->load->view('jewelleries/engagementnew', $data, true);//new
		$this->output($output, $data);
	}
	
	//Engagement Quality Friday, November 15 2013
	function engagementQuality($catname="")
	{
		$this->load->library("pagination");
		$data = $this->getCommonData();
		//echo $catname=$this->uri->segment(3);
		$config["base_url"]=config_item('base_url')."jewelleries/engagementQuality/".$catname.'/';
		$data["sub_ex"]=array();
		if(is_numeric($catname)){
			$Cat_id=$catname;
			$cat_namebyid=$this->jewelleriesmodel->cat_namebyid($catname);
			$catname=substr(str_replace(' ','_',trim($cat_namebyid['result']['0']['catname'])), 0,-1);
			//$catname=$cat_namebyid['result']['0']['catname'];
			$data["sub_ex"] = $this->jewelleriesmodel->build_child($Cat_id);
			/*echo '<pre>';
			print_r($data["sub_ex"]);
			die;
			$i=0;
			foreach($data['sub_ex']['result'] as $daa){
				$data['sub_ex']['result'][$i]['sub_categories']= $this->jewelleriesmodel->build_child($daa['id']);
				$i++;
			}*/
			if(count($sub_ex['result'])==0)
			{
					
			}else{
				
			}
		}
		
		
		if(is_numeric($this->uri->segment(3)))
		$config["total_rows"]=$this->jewelleriesmodel->numofrowsunique($this->uri->segment(3));
		else
		$config["total_rows"]=$this->jewelleriesmodel->getnumengagementQuality($catname);
		$config["per_page"]=18;
		$config["num_links"]=5;
		$config["uri_segment"] = 4;

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a class="active" href="#">';
		$config['cur_tag_close'] = '</a></li>';

		//old
		//$config['full_tag_open'] = '<div id="pagination" style="color:White">';
		//$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		//$config["base_url"]=config_item('base_url')."jewelleries/engagementQuality/".$catname.'/';
		//echo $catname;
		//if(isset($_REQUEST["sort"])){
		//echo "<pre>";
		//print_r($_REQUEST);
		//die;
		//}
		//$data["mtype"]=$metaltype;
		//$data["stype"]=$style;
		//$data["pricetype"]=$price;
		//echo $this->uri->segment(9);
		$carat = $_POST['ctweight'];
		$price = $_POST['price'];
		$metal = $_POST['metal'];
		if(is_numeric($this->uri->segment(3)))
		$data["records"] = $this->jewelleriesmodel->getuniqueproduct($config["per_page"], $this->uri->segment(4),$this->uri->segment(3));
		else
		$data["records"] = $this->jewelleriesmodel->getallengagementQuality($config["per_page"], $this->uri->segment(4),$catname,$carat);
		
		$new_record=array();
		if(count($data["records"]['result'])<1){
			if(isset($data['sub_ex']['result']) && count($data['sub_ex']['result'])>0){
				$i=$j=0;
				
				foreach($data['sub_ex']['result'] as $daa){
					$get_product=$this->jewelleriesmodel->getuniqueproduct($config["per_page"], $this->uri->segment(4),$daa['id']);
					if(count($get_product['result'])>0){
						foreach($get_product['result'] as $row){
							$new_record['result'][$j]=$row;
							$j++;
						}
					}else{
						
					}
					$i++;
				}
				
			}
		}
		if(count($new_record)>0){
			
			$config["total_rows"]=count($new_record['result']);
			$this->pagination->initialize($config);
		}
		
		$rr=0;
		$rr=$this->uri->segment(4);
		
		if(count($new_record)>0){
			
			$config["total_rows"]=count($new_record['result']);
			$i=0;
			$n=1;
			
			if(!empty($rr)){
				foreach($new_record['result'] as $record_){
					if($n>18){
						break;
					}
					if($i>$rr-1){
						$data["records"]['result'][$n]=$record_;
						$n++;
					}
					$i++;
				}
			}else{
				foreach($new_record['result'] as $recordq){
				
					if($i==18){
						break;
					}else{
						$data["records"]['result'][$i]=$recordq;
					}
					$i++;
				}		
			}
			$this->pagination->initialize($config);
		}
		/*echo '<pre>';
		print_r($data["records"]);
		echo $i.$n;
		die;*/
		//ezvalues
		$filterp = $this->jewelleriesmodel->getfilterprice(); 
		$data['filterprice']=$filterp['0']['price'];
		//die($data['filterprice']);
		$ezvalues = $this->jewelleriesmodel->getezvalue();
		$data['ez3value'] = $ezvalues[0]['ezvalue'];
		$data['ez5value'] = $ezvalues[1]['ezvalue'];

		//$data["records"]=$this->jewelleriesmodel->getAlljewelleries($config["per_page"], $this->uri->segment(9), $gender, $catid, $subcatid, $metaltype, $style, $price);
		//echo $this->uri->segment(3);
		///$data["metalpurity"]=$this->jewelleriesmodel->getmetalpurity($this->uri->segment(3));
		//$data["metalcolor"]=$this->jewelleriesmodel->getmetalcolor($this->uri->segment(3));
		//$output = $this->load->view('jewelleries/quality', $data, true);//old


			$data['metallink'] = "<li><a href='".config_item('base_url')."jewelleries/getstullerfur/Sterling_Silver/Ring'>Sterling Silver</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Yellow_Gold/Ring'>14k Yellow Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Silver_Two-Tone/Ring'>14k Silver Two-Tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Rose_Gold/Ring'>14k Rose Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_White_Gold/Ring'>14k White Gold</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k_Two-tone/Ring'>14k Two-tone</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getstullerfur/14k-Silver_Two-Tone/Ring'>14k Silver Two-Tone</a></li>";	
			$data['stylelink'] = "<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Gemstone_Fashion/Ring'>Gemstone Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Wedding_Bands/Ring'>Wedding Bands</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Diamond_Fashion/Ring'>Diamond Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Metal_Fashion/Ring'>Metal Fashion</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Mountings/Ring'>Mountings</a></li>"."<li><a href='".config_item('base_url')."jewelleries/getmystullerfurwithsub/Engagement_And_Anniversary/Ring'>Engagement And Anniversary</a></li>";
		
	//	echo '<pre>';
		$data['cataname'] = $maincat;
		
		//	print_r($data['records']);
		
		$data['main_cat']=$this->jewelleriesmodel->getAlluniquecat21();
		$i=0;
		foreach($data['main_cat']['result'] as $daa){
			if(substr(  str_replace(' ','_',trim($daa['catname'])), 0,-1)==$catname){
				$data['main_cat']['result'][$i]['sub_categories']= $this->jewelleriesmodel->build_child($daa['id']);
			}
			$i++;
		}
		$output = $this->load->view('jewelleries/qualityengagementview', $data, true);//new
		
		$this->output($output, $data);
	}
	
	
	//Add to wishlist Thursday, November 28 2013
    function wishList()
	{
		$result = $this->jewelleriesmodel->addWishList($_POST);
		if($result){
		header("Location: " . config_item('base_url')."wishlist");
		}
		else{
			header("Location: " . config_item('base_url')."account/membersignin");
		}
	}
}
?>
