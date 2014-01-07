<?php
/**
* model class used for displaying jewelleries entered by the sellers...
* @param string
* @return string
* @since 24, March 2013
* @Author Maninder Singh
*/
class Jewelleriesmodel extends Model{
	
	function __construct(){
	
		parent::Model();
	}
	/**
	* model class used for displaying jewelleries entered by the sellers...
	* @param string
	* @return string
	* @since 24, March 2013
	* @Author Maninder Singh
	*/
	function getAlluniquecat()
	{
		$sql = 'SELECT  * FROM  dev_us_catagories';
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function  cat_namebyid($id){
		$sql = 'SELECT DISTINCT catname,pid,id FROM  dev_us_catagories where id='.$id;
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function getAlluniquecat21()
	{
		
		$sql = 'SELECT DISTINCT catname,pid,id FROM dev_us_catagories WHERE id NOT IN (230,119,466) AND pid=0 LIMIT 7';
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function build_child($oldID)			// Recursive function to get all of the children...unlimited depth
	{
		$sql = 'SELECT * FROM dev_us_catagories WHERE pid='.$oldID;
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function numofrowsunique2($catname)
	{
		 $sql = 'SELECT  COUNT(*) as records FROM dev_us WHERE catid='.$catname.'';
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function getnumberofus($catname)
	{
		echo $sql = 'SELECT  COUNT(*) as records FROM dev_us WHERE catid='.$catname.'';
		
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function numofrowsunique($catname)
	{
		$sql = 'SELECT  COUNT(*) as records FROM dev_us WHERE catid='.$catname.'';
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function getuniqueproduct($per_pg,$offset,$catname,$carat='')
	{
		if($carat=='') { $caratsql='';}
		else{
			$caratfrom = $carat - 0.24;
			$caratsql = " AND metal_weight BETWEEN $caratfrom AND $carat ";
		}
		
		if($offset==""){
			$offset=0;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
		$sql = 'SELECT  * FROM dev_us WHERE catid='.$catname.''.$caratsql.$limit;
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	
	function getAlluniquecat2()
	{
		
		$sql = 'SELECT DISTINCT catname,pid,id FROM dev_us_catagories WHERE id NOT IN (230,119,466) AND pid=0 LIMIT 7';
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function getAllstullermyinfo($per_pg, $offset,$catname)
	{
		if($offset==""){
			$offset=0;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
		
		$sql = 'SELECT  * FROM dev_stuller WHERE Videos != "" '.$limit;
		
		
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function getminestuller($per_pg, $offset,$catname,$carat='',$price='')
	{
		if($carat=='') { $caratsql='';}
		else{
			$caratfrom = $carat - 0.24;
			$caratsql = " AND Weight BETWEEN $caratfrom AND $carat ";
		}
		if($price=='') { $pricesql=''; }
		else{
			$pricefrom = $price - 999;
			$pricesql = " AND Price BETWEEN $pricefrom AND $price ";
		}

		if($offset==""){
			$offset=0;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
		
			$sql = 'SELECT  * FROM dev_stuller WHERE MerchandisingCategory1 = "'.str_replace('_', ' ', $catname).'" '.$caratsql.$pricesql.$limit;
		
		
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function getallstullerandquantity($per_pg, $offset,$carat='',$price='',$status='')
	{	

		if($status=='' || is_numeric($status)) 
		{ 
			$sstatussql="WHERE Status = 'Special Order' OR Status = 'Made To Order' OR Status = 'Limited Availability' OR Status = 'While supplies last' "; 
			$qstatussql="WHERE Status = 'CloseOut' "; 
			$con = "WHERE";
		}
		else{
			$con = "AND";
			$status = str_replace('_', ' ', $status);
			$sstatussql = " WHERE Status = '$status' ";
			$qstatussql = " WHERE Status = '$status' ";
		}

		if($carat=='') { $caratsql='';}
		else{
			$caratfrom = $carat - 0.24;
			$caratsql = " $con Weight BETWEEN $caratfrom AND $carat ";
		}
		if($price=='') { $pricesql=''; }
		else{
			$pricefrom = $price - 999;
			$pricesql = " $con Price BETWEEN $pricefrom AND $price ";
		}		

		if($offset==""){
			$offset=0;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
	
		$sql = 'SELECT  * FROM dev_stuller '.$sstatussql.$caratsql.$pricesql.$limit;
	 	$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		$j = count($results['result']);
		$sql = 'SELECT  * FROM dev_qg '.$qstatussql.$caratsql.$pricesql.$limit;
		$result2 = $this->db->query($sql);
		
		$result2 = $result2->result_array();
		for($i = 0; $i < count($result2); $i++) {
			$results['result'][$i + $j] = $result2[$i];
		}
		return $results;
	}
	function getminestullerwithsub($per_pg, $offset,$catname,$maincat,$carat='',$price='',$status='')
	{
		if($carat=='') { $caratsql='';}
		else{
			$caratfrom = $carat - 0.24;
			$caratsql = " AND Weight BETWEEN $caratfrom AND $carat ";
		}
		if($price=='') { $pricesql=''; }
		else{
			$pricefrom = $price - 999;
			$pricesql = " AND Price BETWEEN $pricefrom AND $price ";
		}

		if($status=='' || is_numeric($status)) { $statussql=''; }
		else{
			$status = str_replace('_', ' ', $status);
			$statussql = " AND Status = '$status' ";
		}

		if($offset==""){
			$offset=0;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
	
		 $sql = 'SELECT  * FROM dev_stuller WHERE MerchandisingCategory1 = "'.str_replace('_', ' ', $catname).'" AND Description!="" AND MerchandisingCategory2="'.$maincat.'s"'.$caratsql.$statussql.$pricesql.' group by Description '.$limit;
/*
		echo $sql;
		die;*/
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function getminesubstuller($per_pg, $offset,$catname)
	{
		if($offset==""){
			$offset=0;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
	
		 $sql = 'SELECT  * FROM dev_stuller WHERE MerchandisingCategory2="'.str_replace('_', ' ', $catname).'" '.$limit;
	
	
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function getAllqualityinfofur($per_pg, $offset,$catname,$maincat,$carat='',$price='',$status='')
	{
		if($carat=='') { $caratsql='';}
		else{
			$caratfrom = $carat - 0.24;
			$caratsql = " AND CT_Weight BETWEEN $caratfrom AND $carat ";
		}
		if($price=='') { $pricesql=''; }
		else{
			$pricefrom = $price - 999;
			$pricesql = " AND MSRP BETWEEN $pricefrom AND $price ";
		}

		if($status=='' || is_numeric($status)) { $statussql=''; }
		else{
			$status = str_replace('_', ' ', $status);
			$statussql = " AND Status = '$status' ";
		}
		
		if($offset==""){
			$offset=0;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
		if($maincat=="Ring"){
			$sql = 'SELECT  * FROM dev_qg WHERE Metal_Desc = "'.str_replace('_', ' ', $catname).'" AND Description LIKE "%'.$maincat.'%" AND Description NOT LIKE "%Earrings%" '.$caratsql.$pricesql.$statussql.$limit;
		}else{
			$sql = 'SELECT  * FROM dev_qg WHERE Metal_Desc = "'.str_replace('_', ' ', $catname).'" AND Description LIKE "%'.$maincat.'%"'.$caratsql.$pricesql.$statussql.$limit;
		}
		
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function getAllmystullerinfo($per_pg, $offset,$catname)
	{
		if($offset==""){
			$offset=0;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
		$sql = 'SELECT  * FROM dev_stuller '.$limit;
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function getAllqualityinfo($per_pg, $offset,$catname)
	{
		if($offset==""){
			$offset=0;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
		 $sql = 'SELECT  * FROM dev_qg WHERE Description LIKE "%'.$catname.'%" AND Description NOT LIKE "%Earrings%" '.$limit;
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function getAllstullerinfo()
	{
		
		$sql = 'SELECT  DISTINCT `MerchandisingCategory1` FROM dev_stuller';
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	function numofrowsallstullerandquantity()
	{
	
		$sql = 'SELECT  COUNT(*) as records FROM dev_stuller';
		$result = $this->db->query($sql);
		$result = $result->result_array();
		$r = $result[0]['records'];
		$sql = 'SELECT  COUNT(*) as records FROM dev_qg';
		$result = $this->db->query($sql);
		$result = $result->result_array();		
		$t = $result[0]['records'];
		return $r + $t;
	}
	function numofrowsstuller($catname)
	{
		$sql = 'SELECT  COUNT(*) as records FROM dev_stuller WHERE MerchandisingCategory1 LIKE "%Wedding Bands%"';
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function numofrowsmystullerfur($catname)
	{
		
		$sql = 'SELECT  COUNT(*) as records FROM dev_stuller WHERE MerchandisingCategory1 ="'.str_replace('_', ' ', $catname).'"';
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function numofrowsmystullerfurwithsub($catname,$main)
	{
	
		$sql = 'SELECT  COUNT(*) as records FROM dev_stuller WHERE MerchandisingCategory1 ="'.str_replace('_', ' ', $catname).'" AND MerchandisingCategory2="'.str_replace('_', ' ', $main).'"';
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function numofrowsmysubstullerfur($catname)
	{
	
		 $sql = 'SELECT  COUNT(*) as records FROM dev_stuller WHERE MerchandisingCategory2 ="'.str_replace('_', ' ', $catname).'"';
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function numofrowsqualityfur($catname,$maincat)
	{
		if($maincat=="Ring")
		{
			$sql = 'SELECT  COUNT(*) as records FROM dev_qg WHERE Metal_Desc ="'.str_replace('_', ' ', $catname).'" AND Description LIKE "%'.$maincat.'%" AND Description NOT LIKE "%Earrings%"';
		}else
		{
			$sql = 'SELECT  COUNT(*) as records FROM dev_qg WHERE Metal_Desc ="'.str_replace('_', ' ', $catname).'" AND Description LIKE "%'.$maincat.'%"';
		}
		
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function numofrowsmystuller($catname)
	{
		$sql = 'SELECT  COUNT(*) as records FROM dev_stuller';
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function numofrowsquality($catname)
	{
		$sql = 'SELECT  COUNT(*) as records FROM dev_qg WHERE Description LIKE "%'.$catname.'%"';
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	public function getstullerdetail($id){
		$sql = 'SELECT * FROM dev_stuller where stuller_id='.$id;
		$result = $this->db->query($sql);
		$results['data']=$result->result_array();
		return $results;
	}
	public function getqualitydetail($id){
		 $sql = 'SELECT * FROM dev_qg where qg_id='.$id;
		$result = $this->db->query($sql);
		$results['data']=$result->result_array();
		return $results;
	}
	public function getuniquedetail($id){
		$sql = 'SELECT * FROM dev_us where id='.$id;
		$result = $this->db->query($sql);
		$results['data']=$result->result_array();
		return $results;
	}
	function getAlluniqueproducts()
	{
		$sql = 'SELECT  * FROM  dev_us ORDER BY RAND() LIMIT 20';
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	public function getAlljewelleries($per_pg, $offset, $gender, $catid, $subcatid, $metaltype, $style, $price)
    {
	$qwhere="";
	$metaltype=str_replace("%20"," ",$metaltype);
	$style=str_replace("%20"," ",$style);
	if($gender!="none" && $gender!=""){
	$qwhere.=" AND gender='".$gender."'";
	}
	if($catid!="none" && $catid!=""){
	$qwhere.=" AND category='".$catid."'";
	}
	if($subcatid!="none" && $subcatid!=""){
	$qwhere.=" AND subcategory='".$subcatid."'";
	}
	if($metaltype!="none" && $metaltype!=""){
	$qwhere.=" AND metal_purity='".$metaltype."'";
	}
	if($style!="none" && $style!=""){
	$qwhere.=" AND metal_color='".$style."'";
	}
	if($price=="none"){
	$orderby="stock_number";
	$ordertype="desc";
	$sort=" ORDER BY ".$orderby." ".$ordertype;
//	$price=" AND price_website='".$price."'";
	}
	else{
	$orderby="price";
	$ordertype=$price;
	$sort=" ORDER BY ".$orderby." ".$ordertype;
	}
	if($offset==""){
	$offset=0;
	}
	$limit=" LIMIT ".$offset.",".$per_pg;
 		/* $this->db->order_by($orderby,$ordertype);
		$tablename=$this->config->item('table_perfix') . "jewelries ";
		$this->db->where('metal_type',$metaltype);
		$this->db->where('style',$style);
        $query=$this->db->get($tablename,$per_pg,$offset);
        return $query->result(); */
		$sql = 'SELECT  * FROM  ' . $this->config->item('table_perfix') . 'jewelries where 1=1 ' . $qwhere . ' ' . $sort . ' ' . $limit;
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
		
    }
    public function jewellery_count($gender, $catid, $subcatid, $metaltype, $style, $price)
    {
		
		$qwhere="";
		$metaltype=str_replace("%20"," ",$metaltype);
	$style=str_replace("%20"," ",$style);
	if($gender!="none" && $gender!=""){
	$qwhere.=" AND gender='".$gender."'";
	}
	if($catid!="none" && $catid!=""){
	$qwhere.=" AND category='".$catid."'";
	}
	if($subcatid!="none" && $subcatid!=""){
	$qwhere.=" AND subcategory='".$subcatid."'";
	}
		if($metaltype!="none" && $metaltype!=""){
			$qwhere.=" AND metal_purity='".$metaltype."'";
		}
		if($style!="none" && $style!=""){
			$qwhere.=" AND metal_color='".$style."'";
		}
		$sql = 'SELECT  count(*) as records FROM  ' . $this->config->item('table_perfix') . 'jewelries where 1=1 ' . $qwhere;
        $result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];		
    }	
	public function getJewellerydetailByID($id){
		$sql = 'SELECT  * FROM  ' . $this->config->item('table_perfix') . 'jewelries where stock_number='. $id;
		$result = $this->db->query($sql);
		$results['data']=$result->result_array();
		return $results;
	}
	public function getUserdetailByID($id){
		$sql = 'SELECT  * FROM  ' . $this->config->item('table_perfix') . 'customerinfo where id='. $id;
		$result = $this->db->query($sql);
		$results['data']=$result->result_array();
		return $results;
	}
	public function getmetalpurity($id){
		$sql = "SELECT  DISTINCT metal_purity FROM  " . $this->config->item('table_perfix') . "jewelries where gender='".$id."'";
		$result = $this->db->query($sql);
		$results['data']=$result->result_array();
		return $results;
	}
	public function getmetalcolor($id){
		$sql = "SELECT  DISTINCT metal_color FROM  " . $this->config->item('table_perfix') . "jewelries where gender='".$id."'";
		$result = $this->db->query($sql);
		$results['data']=$result->result_array();
		return $results;
	}
	public function addtoshoppingcartmode($post)
	{
		$sessionid = $this->session->session_data['session_id'];
		$pos = strpos($post['price'],',');
		$strlength = strlen( $post['price'] );
		$price = substr($post['price'],0,$pos);
		$ezpay = substr($post['price'],++$pos,$strlength);
		$sql = "INSERT INTO " . $this->config->item('table_perfix') . "cart (sessionid, lot, ezpay, venderinfo, price, quantity, addoption, totalprice, dsize, name) VALUES ('$sessionid', '{$post['prid']}', '$ezpay', '{$post['vender']}', '$price', '1', 'addjewelry', '{$post['price']}','0', '{$post['prodname']}')";
		$this->db->query($sql);
	}

	public function getrandomproduct($id)
	{
		//$sql = "SELECT * FROM dev_qg where qg_id=".$id." ORDER BY RAND() LIMIT 3";
		$sql = "SELECT * FROM dev_qg ORDER BY RAND() LIMIT 3";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getrandomproductstuller($id)
	{
		$sql = "SELECT * FROM dev_stuller ORDER BY RAND() LIMIT 3";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	function getezvalue()
	{
		$sql = "SELECT * FROM ezpayvalue";
		$result = $this->db->query($sql);
		return $result->result_array();
	}
	function getfilterprice()
	{ 
		$sql = "SELECT * FROM dev_price_filter";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	function getnumengagementQuality($catname)
	{
		$sql = "SELECT  COUNT(*) as records FROM dev_us WHERE name like '%".str_replace('_', ' ', $catname)."%'";
		$result = $this->db->query($sql);
		$result = $result->result_array();
		return $result[0]['records'];
	}
	function getallengagementQuality($per_pg, $offset,$catname,$carat='')
	{
		if($carat=='') { $caratsql='';}
		else{
			$caratfrom = $carat - 0.24;
			$caratsql = " AND metal_weight BETWEEN '$caratfrom gr.' AND '$carat gr.' ";
		}
		
		if($offset==""){
			$offset=198;
		}
		$limit=" LIMIT ".$offset.",".$per_pg;
		$sql = 'SELECT  * FROM dev_us WHERE name like "%'.str_replace('_', ' ', $catname).'%"'.$caratsql.$limit;
		$result = $this->db->query($sql);
		$results['result'] = $result->result_array();
		return $results;
	}
	
	function getuniquedetail2($id){
		 $sql = "SELECT * FROM dev_us where id = '$id'";
		$result = $this->db->query($sql);
		$results['data']=$result->result_array();
		return $results;
	}
	
	function getUniquePrice($id){
		$sql = "SELECT distinct matalType FROM dev_us_prices where productid = '$id'";
		$result = $this->db->query($sql);
		$results=$result->result_array();
		return $results;
	}
	
	function uniqeDetailMetalAjax($metal,$id)
	{
		$sql = "SELECT ringSize FROM dev_us_prices where productid = '$id' and matalType = '$metal'";
		$result = $this->db->query($sql);
		$results=$result->result_array();
		return $results;
	}
	
	function getUniquePriceAjax($metal, $ring,$id){
		$sql = "SELECT price FROM dev_us_prices where productid = '$id' and matalType = '$metal' and ringSize = '$ring' limit 1";
		$result = $this->db->query($sql);
		$results=$result->result_array();
		return $results[0];
	}
	
	function getPricesUnique($id){
		$sql = "SELECT price FROM dev_us_prices where productid = '$id' and matalType = '18K White' and ringSize = '6' limit 1";
		$result = $this->db->query($sql);
		$results=$result->result_array();
		return $results[0];
	}
	
	//Add to wishlist Thursday, November 28 2013
	function addWishList($post)
	{
		if($this->session->isLoggedin()){
			$userid = $this->session->userdata("userid");
			$pos = strpos($post['price'],',');
			$strlength = strlen( $post['price'] );
			$price = substr($post['price'],0,$pos);
			$ezpay = substr($post['price'],++$pos,$strlength);
			$isChekout = false;
			$sql = "INSERT INTO " . $this->config->item('table_perfix') . "wishlist (userid, lot, ezpay, venderinfo, price, quantity, addoption, totalprice, dsize, name, url,isChekout) VALUES ('$userid', '{$post['prid']}', '$ezpay', '{$post['vender']}', '$price', '1', 'addjewelry', '{$post['price']}','0', '{$post['prodname']}','{$post['url']}','$isChekout')";
			$this->db->query($sql);
			$result = true;
		}
		else{
			$result = false;
		}
		return $result;
	}
}
?>
