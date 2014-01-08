<style type="text/css">
#pagination{
    float: left;
    font:11px Tahoma, Verdana, Arial, "Trebuchet MS", Helvetica, sans-serif;
    color:#3d3d3d;
	text-align:center;
    width:100%;
}
#pagination a, #pagination strong{
    list-style-type: none;
    display: inline;
    padding: 5px 8px;
    text-decoration: none; 
    background-color: inherit;
    color: #5D78AE;
    font-weight: bold;
}
#pagination strong{
    color: #ffffff;
    background-color:#5D78AE;
    background-position: top center;
    background-repeat: no-repeat;
    text-decoration: none; 
}
#pagination a:hover{
    color: #ffffff;
    background-color:#5D78AE;
    background-position: top center;
    background-repeat: no-repeat;
    text-decoration: none; 
}
.maindiv{
float:left;
width:100%;
text-align:center;
margin-left:0px;
margin-top:40px;
}

.panels-1 {  
    padding: 0;  
    margin:0 6px 10px 50px;
    float: left; 
    position: relative;
    border: 7px solid #fff;

    width: 325px;  
    height: auto; 
    overflow: hidden;
  
} 
 
.panels-1 .panel-1, .panels-1 .panel-2 {  
    padding: 0;  
    margin:  0;
    height: 210px;
    width: 325px;
}

.panel-2 {
    	position:absolute; 
	display:none; 
	width:325px;
        height:260px;
        bottom: 0;
}

.panel-1 a img {
   width: 325px;
}

.panels-1 .panel-2 h4, .panels-1 .panel-2 h5 {
     font-family: "neuzon-1","neuzon-2", sans-serif;
     text-transform: uppercase;
     position: absolute;
     text-align: center;
     width: 325px;
     color: #f6f5f0;
}

.panels-1 .panel-2 h4 {
     font-size: 18px;
     bottom: 24px;
}

.panels-1 .panel-2 h5, p.soldout {
     font-size: 14px;
     bottom: 80px;
}

.panels-1 .panel-2 h5 span, p.soldout span {
     background-color: #d93645;
     padding: 3px 5px 5px 5px;
-moz-border-radius: 4px; border-radius: 4px; -webkit-border-radius: 4px; 
}
.jprice{
width:100%;
text-align:center;
color:#5D78AE;
font-weight:bold;
}
.jdetail{
width:100%;
text-align:center;
color:#5D78AE;
font-weight:bold;
}
.jtitle{
width:100%;
text-align:center;
color:#5D78AE;
font-weight:bold;
margin:2px 0px 2px 0px;
}
.sortby{
width:100%;
height:60px;
margin-top:40px;
float:left;
color:#00507C;
}
.sorttitle{
width:20%;
float:left;
}
.sorttext{
width:18%;
float:left;
}
.catclass{
width:200px;
float:left;
}
.cattype{
width:200px;
float:left;
}
.cinput{
width:200px;
float:left;
}

</style>
<script type="text/javascript">

function showdetail(id){
	urllink = base_url+'site/uniquedetail/'+id+'/';	
			$.ajax({
                 type: "POST",
                 url:urllink,
                 success: function(response) {
    				$.facebox('<div >' + response + '</div>');
                },
				error: function(){alert('Error ');}
             }) 
	
}

</script>

<form id="form1" name="form1" method="post" action="<?php echo config_item('base_url') ?>jewelleries/addtoshoppingcart">

<article class="container_12">
        <section id="sub">
        	<ul>
            	<li><a href="#">Home</a></li>
                <li>></li>
                <li><a href="#">view detail</a></li>
                
            </ul>
        </section>
        
        <section id="main" class="view">
        	<div id="containt">
                 <div class="share">
                    <span class="text-search">View Detail </span>  
                    <!--<div>
                        <span class='st_sharethis' displayText='Share'></span>
                        <span class='st_pinterest'></span>
                        <span class='st_facebook'></span>
                        <span class='st_twitter'></span>
                        <span class='st_linkedin'></span> 
                        <span class='st_email'></span>
                    </div>-->
                     
                 </div>
                  
		        <?php	if($details['data'][0]['Videos']!=""){
				$json_decoded = json_decode($details['data'][0]['Videos']);
				$imagemy = $json_decoded[0]->{'FullUrl'};
				$src= addslashes(str_replace('$standard$', 'hei=300&wid=300', $imagemy));
				//$src="http://".$details['data'][0]['ImageLink_500'];
				}
				else{
				$src="http://images3.wikia.nocookie.net/__cb20061129213453/muppet/images/7/7c/Noimage.png";				
				}?>      

                 <div class="content">
                 	 <div class="view-left">
                     	<div class="img-description">
                     		<div id="bigPic">
                                <img src="<?php echo $src; ?>" alt="" width="385" hight="396"/>
                                <!--<img src="<?php echo $this->config->item('base_url');?>images/prod02.jpg" alt="" />
                                <img src="<?php echo $this->config->item('base_url');?>images/prod03.jpg" alt="" /> -->
                            </div>
                             <!--<p class="tt">Roll over image to zoom detail. </p>
                            <ul id="thumbs">
                                <li class='active' rel='1'><img src="<?php echo $this->config->item('base_url');?>images/thum01.jpg" alt="" /></li>
                                <li rel='2'><img src="<?php echo $this->config->item('base_url');?>images/thum02.jpg" alt="" /></li>
                                <li rel='3'><img src="<?php echo $this->config->item('base_url');?>images/thum03.jpg" alt="" /></li> 
                            </ul>-->
                            
                            <!--<div class="note clearfix">
                            	<div class="note-left">
                                    <p class="text-h4">Extended Service Plan</p>
                                    <p>Once you've made your selection, you'll want to protect it for a lifetime. </p>
                                </div>
                                <div class="note-right">
                                	Learn more about our Extended Service Plan
                                </div>
                            </div>-->
                        </div>
                        <div class="text-description">
                        	<h4 class="title-description"><?php echo $details['data'][0]['Description']; ?></h4>
                            <p class="date-description">Stock number: <?php echo $details['data'][0]['stuller_id'];?></p>
                            <p><?php echo $details['data'][0]['Description']; ?></p>
                            
                            <p class="ring">
                                <select class="type">
                                    <option>6.75</option>
                                    <option>7.00</option>
                                    <option>7.75</option>
                                    <option>8.00</option>
                                </select> 
                                Ring size <b class="icon-note"></b>
                            </p>
                            
							<div class="desc-price">
                            	
								<?php 
								$cuprice=$org_price=$details['data'][0]['Price'];
								
								$cuprice= $cuprice*2.5;
								$cuprice1=$cuprice;
								$cuprice15=$cuprice*15/100;
								$cuprice=$cuprice-$cuprice15;
								?>
								
								Item Price : <?php echo number_format($cuprice1,0)	?>
								<br>
									<input type="radio" name="price" value="<?php echo intval(number_format($cuprice,0,'.',''))?>,normal">
									BEST VALUE - $<?php echo number_format($cuprice,0)?> Price after 15% discount when paid by Visa/MC. 
									<br/><?php if($details['data'][0]['ezstatus']){ ?>
									
								<input type="radio" name="price" value="<?php $ez3 = $org_price+(($org_price*$ez3value)/100);$fez3=$ez3;$ez3=$cuprice1-$ez3; echo intval(number_format($fez3,0,'.',''))?>,3EZ">
								3 EZ Pay - $<?php echo number_format($cuprice1,0); ?> Price $<?php echo number_format($fez3,0);?> payment then 2 EZ payments of $<?php $ez3s=$ez3/2;  echo number_format($ez3s,0); ?> monthly
								<br/>
								  
								<input type="radio" name="price" value="<?php $ez5=$org_price+(($ez5value*$org_price)/100);$fez5=$ez5; $ez5=$cuprice1-$ez5; echo intval(number_format($fez5,0,'.','')); ?>,5EZ">
								5 EZ Pay - $<?php echo number_format($cuprice1,0); ?> Price $<?=number_format($fez5,0)?> payment then 4 EZ payments of $<? $ez5s = $ez5/4; echo number_format($ez5s,0)?> monthly. 
								<?php } ?>
								<input type="hidden" name="3ez_price" value="<?php echo intval(number_format($ez3,0,'.','')); ?>">
								<input type="hidden" name="5ez_price" value="<?php echo intval(number_format($ez5,0,'.','')); ?>">
								<input type="hidden" name="main_price" value="<?php echo intval(number_format($cuprice1,0,'.','')); ?>">
								
								<!--
								<p class="price"><input type="radio" name="price" value="<?php echo number_format($details['data'][0]['Price'])?>,normal">$<?php echo number_format($details['data'][0]['Price'])?></p>
								
								<?php if($details['data'][0]['ezstatus'] == true){ ?>
								<input type="radio" name="price" value="<?php $ez3 = $details['data'][0]['Price']+(($ez3value*$details['data'][0]['Price'])/100); echo number_format($ez3,2)?>,3EZ">3EZ = $<?php $ez3s=$ez3/3; echo number_format($ez3s,2);?><br/>
								<input type="radio" name="price" value="<?php $ez5 =  $details['data'][0]['Price']+(($ez5value*$details['data'][0]['Price'])/100); echo number_format($ez5,2); ?>,5EZ">5EZ = $<?php $ez5s=$ez5/5; echo number_format($ez5s,2); }?><br/>
								
								-->
								<input type="hidden" name="vender" value="stuller">
								<input type="hidden" name="url" value="<?php echo $src ?>">
								<input type="hidden" name="prodname" value="<?php echo $details['data'][0]['Description']?>">
								<!--<input type="submit" name="submit" id="submit" value="Add to Basket" />-->
                                <p class="bt-add clearfix"><a href="#" onClick="addcartsubmit()">ADD TO SHOPPING BAG</a></p>
                            </div>
                            
							<input type="hidden" name="prid" value="<?php echo $details['data'][0]['stuller_id'];?>">

                           <!-- <b class="icon-note"></b>
                            <div class="desc-text">
                            	he standard size for this ring is 6.75 . If you choose a different size, ring sizing service will be required to adjust it and you will be charged a service fee of $15.99 . This will take up to 3 additional business days. If you ordered additional merchandise, your sized ring will ship separately from the rest of your order. 
                               --> 
                                <p><a href="#" onClick="addWishlist()">Save to Wish List</a></p>
                            </div>-->
                            
                            <div class="share-this clearfix">
                            	<!--<span class='st_pinterest_hcount'></span>
                                <span class='st_twitter_hcount'></span>
                                <span class='st_googleplus_hcount'></span>
                                <span class='st_fblike_hcount'></span>-->
                            </div>
                            
                            <!--<div class="start">
                                <b class="icon-start"><img src="<?php echo $this->config->item('base_url');?>images/start.png" alt=""/></b>
                                <b class="icon-start"><img src="<?php echo $this->config->item('base_url');?>images/start.png" alt=""/></b>
                                <b class="icon-start"><img src="<?php echo $this->config->item('base_url');?>images/start.png" alt=""/></b>
                                <b class="icon-start"><img src="<?php echo $this->config->item('base_url');?>images/start.png" alt=""/></b>
                                <b class="icon-start"><img src="<?php echo $this->config->item('base_url');?>images/start.png" alt=""/></b>
                            </div>-->
                            
                          <!--  <div class="payment">
                            	<h3 class="text-h3">LOW MONTHLY PAYMENT OPTIONS</h3>
                                <p>EZ Pay Payment Options 
CY Jewelers offers online customers a unique combination of flexibility and
affordability. Whichever payment option you choose, your purchase ships immediately
with three or five convenient payments:<br/>
EZ Pay 3<br/>
EZ Pay 5</p>
                                <!--<p class="month"><span class="price">$65</span><br/> per month</p>
                                <p class="t-text clearfix">Payment for this item only. Does not include any existing balance. Approximate payment does not include tax, shipping or other services. </p>
                                <p><a href="#">I have a Kay Credit  Account</a>|<a href="#">Apply for Kay Credit </a></p>
                            </div>
                            
                            <div class="additional"> 
                                <p><a href="#"><b class="icon-additional"></b>Additional Payment Options</a></p>
                            </div>
                             -->
                        
                            <div class="info clearfix">
                          <!--  <div id="tabs">
								
                                <ul>
                                    <!--<li>Overview </li>
                                    <li>EZ Pay Information</li>
                                    <!--<li>Ratings & Reviews  </li>
                                    <li>FAQ  </li>
                                </ul>
                                <!--<div>
									<p><strong><?php// echo $details['data'][0]['Description']; ?> <!--Diamond Engagement Ring 3/8 ct tw Round-cut 10K White Gold </strong></p>
                                    <!--<p>Sparklitng round diamonds form a heart in this romantic engagement ring for her. Additional round diamonds line the band on either side of the center. The ring has a total diamond weight of 3/8 carat and is fashioned in 10K white gold. Diamond Total Carat Weight may range from  .37 - .44 carats. </p>
                                </div><!-- end HTML tab content 
                                <div>
                                    <p><strong></strong></p>
									<p>EZ Pay Payment Options
CY Jewelers offers online customers a unique combination of flexibility and
affordability. Whichever payment option you choose, your purchase ships immediately
with three or five convenient payments:<br/>

EZ Pay 3 - Your purchase is divided into three payments no application or credit check
required. We will bill your credit card for the first installment plus sales tax if applicable.
The balance is then automatically billed to your credit card in two equal monthly
installments beginning 30 days after your order date.<br/>

EZ Pay 5 - Your purchase is divided into five payments no application or credit check required. We will bill your credit card for the first installment plus sales tax if applicable. The balance is then automatically billed to your credit card in four equal monthly installments beginning 30 days after your order
date.<br/>

CY Jewelers does not charge interest or fees on our EZ Pay plans. Using your credit
card for EZ Pay may result in interest or other charges in accordance with the terms and
conditions of your credit card agreement.</p>
                                </div><!-- end CSS tab content -->
                                <!--<div>
                                    <p>Sparklitng round diamonds form a heart in this romantic engagement ring for her. Additional round diamonds line the band on either side of the center. The ring has a total diamond weight of 3/8 carat and is fashioned in 10K white gold. Diamond Total Carat Weight may range from  .37 - .44 carats. </p>
                                </div><!-- end JQuery tab content -->
                                 <!--<div>
                                    <p>Sparklitng round diamonds form a heart in this romantic engagement ring for her. Additional round diamonds line the band on either side of the center. The ring has a total diamond weight of 3/8 carat and is fashioned in 10K white gold. Diamond Total Carat Weight may range from  .37 - .44 carats. </p>
                                </div><!-- end JQuery tab content 
                            </div><!-- end tabs panel -->
			
			
			</div>
                     </div>

                     
                     <div class="view-right">
                     	<h2 class="text-h2">More Jewelry to Love</h2>
                        
                        <div class="other-product">
							<?php foreach($radomprodects as $radomprodect) {
							if($radomprodect['Videos']!=""){
							$json_decoded = json_decode($radomprodect['Videos']);
							$imagemy = $json_decoded[0]->{'FullUrl'};
							$src= addslashes(str_replace('$standard$', 'hei=300&wid=300', $imagemy));
							//$src="http://".$details['data'][0]['ImageLink_500'];
							}
							else{
							$src="http://images3.wikia.nocookie.net/__cb20061129213453/muppet/images/7/7c/Noimage.png";				
							}?>
                        <div class="other-product">
                            <a href="<?php echo config_item('base_url') ?>site/qualitydetail/<?php echo $radomprodect['stuller_id']; ?>"><img src="<?php echo $src ?>" alt="" width="114" hight="113"/></a>
                            
                            <div class="name-product"><a href="<?php echo config_item('base_url') ?>site/qualitydetail/<?php echo $radomprodect['stuller_id']; ?>"><?php echo $radomprodect['Description'] ?></a></div>
                            <div class="price-product">
                                <span>Price : $<?php echo number_format($radomprodect['Price'],2);?></span><br>
								<?php if($radomprodect['ezstatus'] == true){ ?>
                                3EZ = $<?php $ez3 = ($radomprodect['Price']+(($ez3value*$radomprodect['Price'])/100))/3; echo number_format($ez3,2); ?><br>
                                5EZ = $<?php $ez5 = ($radomprodect['Price']+(($ez5value*$radomprodect['Price'])/100))/5; echo number_format($ez5,2); ?><br><?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        
                     </div>
                 </div>
				</div>
             
        
    </article>
		</section>
	</form>
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
<script type="text/javascript">
	
	var currentImage;
    var currentIndex = -1;
    var interval;
    function showImage(index){
        if(index < $('#bigPic img').length){
        	var indexImage = $('#bigPic img')[index]
            if(currentImage){   
            	if(currentImage != indexImage ){
                    $(currentImage).css('z-index',2);
                    clearTimeout(myTimer);
                    $(currentImage).fadeOut(250, function() {
					    myTimer = setTimeout("showNext()", 3000);
					    $(this).css({'display':'none','z-index':1})
					});
                }
            }
            $(indexImage).css({'display':'block', 'opacity':1});
            currentImage = indexImage;
            currentIndex = index;
            $('#thumbs li').removeClass('active');
            $($('#thumbs li')[index]).addClass('active');
        }
    }
    
    function showNext(){
        var len = $('#bigPic img').length;
        var next = currentIndex < (len-1) ? currentIndex + 1 : 0;
        showImage(next);
    }
    
    var myTimer;
    
    $(document).ready(function() {
	    myTimer = setTimeout("showNext()", 3000);
		showNext(); //loads first image
        $('#thumbs li').bind('click',function(e){
        	var count = $(this).attr('rel');
        	showImage(parseInt(count)-1);
        });
	});
</script>
    
<script type="text/javascript">
		$(document).ready( function() {
			$("#tabs ul li:first").addClass("active");
			$("#tabs div:gt(0)").hide();
			$("#tabs ul li").click(function(){
				$("#tabs ul li").removeClass('active');
				//var current_index = $(this).index(); // Sử dụng cho jQuery >= 1.4.x
				var current_index = $("#tabs ul li").index(this);
				$("#tabs ul li:eq("+current_index+")").addClass("active");
				$("#tabs div").hide();
				$("#tabs div:eq("+current_index+")").fadeIn(100);
			});
		});
	</script>

<script type="text/javascript">
function addcartsubmit()
{
var radios = document.getElementsByName('price');
	var selected;
	for (var i = 0, count = radios.length; i < count; i++) {
		if (radios[i].checked) {
		selected = radios[i].value;
		break;
		}
	}
	if (selected) {
		document.getElementById('form1').submit();
	}
	else { alert('Please select a payment option.'); }
}
function addWishlist()
{
	var radios = document.getElementsByName('price');
	var selected;
	for (var i = 0, count = radios.length; i < count; i++) {
		if (radios[i].checked) {
		selected = radios[i].value;
		break;
		}
	}
	if (selected) {
		document.getElementById('form1').action = "<?php echo config_item('base_url') ?>jewelleries/wishList";
		document.getElementById('form1').submit();
	}
	else { alert('Please select a payment option.'); }
}
</script>

<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "7a6efe38-c4d4-4f64-a105-5247ba606425", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
