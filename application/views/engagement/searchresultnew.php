<script type="text/javascript">
function submitform()
{
//alert('dsfsdf');
document.getElementById('form1').submit();
}
</script>    

    <article class="container_12">
        <section id="sub">
        	<ul>
            	<li><a href="#">Home</a></li>
                <li>></li>
                <li><a href="#">Search Results</a></li>
                <li>></li>
                <li><a href="#">Ring </a></li>
            </ul>
        </section>
        
        <section id="main">
        	<div id="containt">
                 <div class="share">
                    <span class="text-search">Search Results</span>  
                    <div>
                        <span class='st_sharethis' displayText='Share'></span>
                        <span class='st_pinterest'></span>
                        <span class='st_facebook'></span>
                        <span class='st_twitter'></span>
                        <span class='st_linkedin'></span> 
                        <span class='st_email'></span>
                    </div>
                    
                    <p class="results">We found <?php echo $totalresult?> results for <?php echo $inputvalue ?></p>
                 </div>
                 
                 <div class="search-narrow">
                 	<!--&nbsp;&nbsp;&nbsp;&nbsp;Narrow Your Search: 
                  	<select class="type">
                    	<option>Price</option>
                        <option>Price 1</option>
                        <option>Price 2</option>
                        <option>Price 3</option>
                    </select> 
                    <select class="type">
                    	<option>Metal Type</option>
                        <option>Metal Type 1</option>
                        <option>Metal Type 2</option>
                        <option>Metal Type 3</option>
                    </select> 
                    <select class="type">
                    	<option>Style</option>
                        <option>Style 1</option>
                        <option>Style 2</option>
                        <option>Style 3</option>
                    </select> 
                    <select class="type">
                    	<option>Ring Type</option>
                        <option>Ring Type 1</option>
                        <option>Ring Type 2</option>
                        <option>Ring Type 3</option>
                    </select> 
                    
                    <input type="reset" value="Reset" class="reset"/>-->
                        <form id="form1" name="form1" method="post" action="<?php echo current_url()?>/">
                 	<span class="sort-by-01">SORT BY: 
                        <select name="sortby" class="type">
                    	<option value="">--------------</option>
                            <option value="qg_id">ID</option>
                            <option value="Item">Item No.</option>
                            <option value="Weight">Weight</option>
                            <option value="CT_Weight">Carat</option>
                            <option value="Size">Size</option>
                            <option value="MSRP">Price</option>
                        </select>  
                    </span>
                    <span class="sort-by-02">RESULTS PER PAGE:
                        <select name="pageper" class="type">
                    	<option value="">--------------</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="300">300</option>
                        </select>  
                    <span class="sort-by-02">Price Range:
                  	<select name="pricerange" class="type">
                    	<option value="">--------------</option>
                    	<option value="999">$0 - $999</option>
                        <option value="1999">$1,000 - $1,999</option>
                        <option value="2999">$2,000 - $2,999</option>
                        <option value="4999">$3,000 - $4,999</option>
                        <option value="5000">$5,000 +</option>
                    </select> 
                    </span><input type="hidden" name="searchkeyword" value="<?php echo $inputvalue ?>">
                    <input type="reset" value="submit" onclick="submitform()" class="reset"/>
                 </div></form>
                 
                 <div class="paging">
                    
                    <span class="sort-by-03">
                    Displaying  <strong><?php echo $numresults?></strong>  of  <?php echo $totalresult?> <!--&nbsp;&nbsp;&nbsp;&nbsp; 
                    <strong>1</strong> of  800 -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $this->pagination->create_links();?>
                    </span>
                 </div>
                 
                 <div class="content">
					<?php foreach($results as $result) {

							if($result['ImageLink_100']!=""){
								$src="http://".$result['ImageLink_500'];
								}
								else{
								$src="http://images3.wikia.nocookie.net/__cb20061129213453/muppet/images/7/7c/Noimage.png";				
								}?>
                 	<div class="item-product">
			  <div class="image-product"><a href="<?php echo config_item('base_url') ?>site/qualitydetail/<?php echo $result['qg_id']?>"><img src="<?php echo $src ?>" width="146" hight="136" alt="diamond"/></a></div>
			  <div class="name-product"><a href="<?php echo config_item('base_url') ?>site/qualitydetail/<?php echo $result['qg_id']?>"><?php echo $result['Description'] ?></a></div>
			  <div class="price-product">
				  Price : $<?php echo $result['MSRP']; if($result['ezstatus'] == true){ ?><br />
							  3EZ = $ <?php $ez3 = ($result['MSRP']+(($ez3value*$result['MSRP'])/100))/3; echo number_format($ez3,2); ?><br/>
							  5EZ = $ <?php $ez5 =  ($result['MSRP']+(($ez5value*$result['MSRP'])/100))/5; echo number_format($ez5,2); ?><br/> <? } ?>
			  </div>
                    </div>
                    
                    <?php } ?>
                    
                 </div>
                 
                 <div class="paging clearfix">
                 	<!--<span class="sort-by-01">SORT BY: 
                        <select class="type">
                            <option>New</option>
                            <option>Price 1</option>
                            <option>Price 2</option>
                            <option>Price 3</option>
                        </select>  
                    </span>
                    <span class="sort-by-02">RESULTS PER PAGE:
                        <select class="type">
                            <option>New</option>
                            <option>New 1</option>
                            <option>New 2</option>
                            <option>New 3</option>
                        </select>  
                    </span>-->
                    
                    <span class="sort-by-03">
                    Displaying  <strong><?php echo $numresults?></strong>  of  <?php echo $totalresult?> &nbsp;&nbsp;&nbsp;&nbsp; 
                    <!--<strong>1</strong> of  800 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                    <?php echo $this->pagination->create_links();?></span>
                 </div>
            </div>
             
             
        </section>
        
    </article><!--End #Content-->
	 
</body>

<script type="text/javascript">
// ON BLUR , ON FOCUS	
function myFocus(element) 
   {
     if (element.value == element.defaultValue) {
       element.value = '';
     }
   }
function myBlur(element) 
{
 if (element.value == '') {
   element.value = element.defaultValue;
 }
 
}

</script>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "7a6efe38-c4d4-4f64-a105-5247ba606425", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</html>
