<script type="text/javascript">
function submitform()
{
	document.getElementById('form1').submit();
}
</script>
    
    <article class="container_12">
        <section id="sub">
        	 
        </section>
        
        <section id="main" class="engagement">
        	<div id="containt">
                 <div class="share">
                    <span class="text-search"><?php echo $cataname ?></span>  
                    <!--<div>
                        <span class='st_sharethis' displayText='Share'></span>
                        <span class='st_pinterest'></span>
                        <span class='st_facebook'></span>
                        <span class='st_twitter'></span>
                        <span class='st_linkedin'></span> 
                        <span class='st_email'></span>
                    </div> -->
                 </div> 
                 
                 <div class="content">
                 	<div class="engagement-left">
                    	<p class="tt-engagement">REFINE SEARCH</p>
                        <form id="form1" name="form1" method="post" action="<?php echo current_url()?>">
                        <ul class="carat">
                        	<li><strong>Carat Weight</strong></li>
                            <li><input type="radio" name="ctweight" onclick="submitform()" value="0.24"/> 0 - 0.24</li>
                            <li><input type="radio" name="ctweight" onclick="submitform()" value="0.49"/> 0.25 - 0.49</li>
                            <li><input type="radio" name="ctweight" onclick="submitform()" value="0.99"/> 0.50 - 0.99</li>
                            <li><input type="radio" name="ctweight" onclick="submitform()" value="1.49"/> 1.00 - 1.49</li>
                            <li><input type="radio" name="ctweight" onclick="submitform()" value="1.99"/> 1.50 - 1.99</li>
                            <li><input type="radio" name="ctweight" onclick="submitform()" value="2.00"/> 2.00+</li>
                        </ul>
                        
                        <ul class="carat">
                        	<li><strong>Price Range</strong></li>
                            <li><input type="radio" name="price" onclick="submitform()" value="999"/> $0 - $999</li>
                            <li><input type="radio" name="price" onclick="submitform()" value="1999"/> $1,000 - $1,999</li>
                            <li><input type="radio" name="price" onclick="submitform()" value="2999"/> $2,000 - $2,999</li>
                            <li><input type="radio" name="price" onclick="submitform()" value="3999"/> $3,000 - $4,999</li>
                            <li><input type="radio" name="price" onclick="submitform()" value="4999"/> $5,000 +</li> 
                        </ul>

                        <ul class="carat">
                        	<li><strong>Clearance</strong></li><?php echo $clearancelink ?>
                        </ul>
                        
                        <ul class="style">
                        	<li class="style-title">Engagement Rings</li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/engagementQuality/Engagement_Rings/">Engagement Rings</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/engagementQuality/Three_Stone_Rings/">Three Stone Rings</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/engagementQuality/Wedding_Bands/">Wedding Bands</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/engagementQuality/Bridal_Ring/">Bridal Ring</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/engagementQuality/Color_Stone_Ring/">Color Stone Rings</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/engagementQuality/Fancy_Ring/">Fancy Ring</a></li> 
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/engagementQuality/Pendant/">Pendant</a></li> 
                        </ul>

						<hr />
                        
                        <ul class="style">
                        	<li class="style-title"><strong>Metal</strong></li><?php echo $metallink ?>
                        </ul>
                        </form>


                        <hr />
                        
                        <ul class="style">
                        	<li class="style-title">Style</li><?php echo $stylelink ?>
                        </ul>
                        
                        <ul class="category">
                        	<li class="style-title">CATEGORIES</li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/getuniquecat">Engagement</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Ring">Rings</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Necklace">Necklaes</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Bracelet">Bracelets</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Earring">Earrings</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Mens">Mens</a></li> 
                            <li><a href="<?php echo config_item('base_url') ?>watches">Watches</a></li> 
                            <li><a href="<?php echo config_item('base_url') ?>jewelleries/getmystuller">Clearance</a></li> 
                        </ul>
                        
                        <ul class="style">
                        	<li class="style-title">Designers</li>
                            <li><a href="<?php echo config_item('base_url') ?>engagement/search">Build Your Own Ring</a></li>
                            <li><a href="#">Build  Your Own Earrings</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>jewelry/search">Build Three Stone Ring</a></li>
                            <li><a href="<?php echo config_item('base_url') ?>engagement/search">Build  Your Own Pendant</a></li>
                            <li><a href="#">Loose Diamond Search</a></li> 
                        </ul>
                        
                      <!--  <div class="bn-ads01">
                        	 <img src="<?php echo config_item('base_url') ?>images/sp01.png" alt="banner"/>
                        </div>
                        
                        <div class="bn-ads02">
                        	 <img src="<?php echo config_item('base_url') ?>images/sp02.png" alt="banner"/>
                        </div>
                        
                        <div class="bn-ads02">
                        	 <img src="<?php echo config_item('base_url') ?>images/sp03.png" alt="banner"/>
                        </div> -->
                    </div>
                    
                    <div class="engagement-right">
                    	<div class="ads01"><a href="#"><img src="<?php echo config_item('base_url') ?>images/ads1.png" alt=""/></a></div>
                        <div class="engagement-paging">
                        	<ul><li>
									<a href="#">0</a>                                    
                                </li><?php echo $this->pagination->create_links();?>
                                <!--<li>
									<a class="active" href="#">1</a>                                    
                                </li>
                                <li>
									<a href="#">2</a>                                    
                                </li>
                                <li>
									<a href="#">></a>                                    
                                </li>
                                <li>
									<a href="#">>|</a>                                    
                                </li>-->
                            </ul>
                            
                             <!--<span class="total-page">1 to 33 of 52 (2 Page)</span>-->
                        </div>
						<?php
						if(count($records['result'])>0){
							for($i=0;$i<count($records['result']);$i++)
							{
							 	if($records['result'][$i]['ImageLink_100']!=""){
								$src="http://".$records['result'][$i]['ImageLink_500'];
								}
								else{
								$src="http://images3.wikia.nocookie.net/__cb20061129213453/muppet/images/7/7c/Noimage.png";				
								}
							 ?>
                        <div class="engagement-product">
                            
                            <div class="image-engagement"><a href="<?php echo config_item('base_url') ?>site/qualitydetail/<?php echo $records['result'][$i]['qg_id']; ?>"><img src="<?php echo $src;?>" alt="<?php echo $records['result'][$i]['Metal_Desc'];?>" width="155" hight="144"></a></div>  
                            <div class="price-product">
                            	<p class="ring-engagement"><?php echo $records['result'][$i]['Description'];?><?php //echo $cataname?><?php //echo $records['result'][$i]['qg_id']; ?></p>
								<?php 
								 if(isset($records['result'][$i]['MSRP'])) { 
									$cuprice=$org_price=$records['result'][$i]['MSRP'];
									$cuprice= $cuprice*2.5;
									$cuprice1=$cuprice;
									$cuprice15=$cuprice*15/100;
									$cuprice=$cuprice-$cuprice15; 
									if($cuprice>=$filterprice){
								?> 
								
                                <span>Price : $<?php echo  number_format($cuprice,0); ?></span><br>
								<?php if($records['result'][$i]['ezstatus']) { ?>
								3EZ : $<?php $ez3 = $org_price+(($org_price*$ez3value)/100); $fez3=$ez3; $ez3=$cuprice1-$ez3; echo number_format($ez3/2,0); ?><br>
								5EZ : $<?php  $ez5= $org_price+(($ez5value*$org_price)/100); $fez5=$ez5; $ez5=$cuprice1-$ez5; echo number_format($ez5/4,0); ?><br><?php } 
								}
									} ?>
								<!--These are semimount only <br>diamonds are sold seperately-->
                                <p class="view"><a href="<?php echo config_item('base_url') ?>site/qualitydetail/<?php echo $records['result'][$i]['qg_id']; ?>">View Details</a></p>
                            </div>
                            
                        </div><?php } }?>
                         
                    </div>
                 </div> 
            </div>
             
             
        </section>
        
    </article><!--End #Content-->
	 
</body>

<script type="text/javascript">
window.onload = function() {
var radios = document.getElementsByName('ctweight');
};
</script>

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
