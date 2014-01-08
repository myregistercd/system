
<div class="slider">
  <div class="slide-top"></div>
  <div class="slide-images">
      <div class="slide-text">
	      <h1>Welcome to <? echo $this->config->item('full_site_name'); ?></h1>
	  <p>A Trusted Leader and your Friend in the Diamond Business...</p>
	  <a href="#">See Details</a>
      </div>
      <a href="#">
      <img src="images/slideimages1.jpg" alt="slide images 1" title="slide images 1"/>
      </a>
  </div>
  <div class="slide-bottom"></div>
</div>
  <div class="dimond">
  	<img src="images/diamond.jpg" alt="Diamond" title="Diamond"/> 
  </div>
  <div class="radiosearch">
<div class="middle_nav">
<script>
function setAction() {

loc = jQuery('input[name=ds]:checked', '#diamond_search').val();
 $('#diamond_search').attr('action', loc);

}

</script>	
		<style type="text/css">
		.tooltip {
			border-bottom: 0px dotted #000000; color: #000000; outline: none;
			 text-decoration: none;
			position: relative;
		}
		.tooltip span {
			margin-left: -999em;
			position: absolute;
		}
		.tooltip:hover span {
			border-radius: 5px 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; 
			box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); -webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); -moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1);
			font-family: Calibri, Tahoma, Geneva, sans-serif;
			position: absolute; left: 1em; top: 2em; z-index: 99;
			margin-left: 0; width: 150px;
		}
		.tooltip:hover img {
			
		}
		.tooltip:hover em {
			font-family: Candara, Tahoma, Geneva, sans-serif; font-size: 1.2em; font-weight: bold;
			display: block; padding: 0.2em 0 0.6em 0;
		}
		.classic { padding: 0.8em 1em; }
		.classic {background: #FFFFAA; border: 1px solid #FFAD33; }
		</style>
		
			
 <form id="diamond_search" name="diamond_search" method="post" action="<?php echo $this->config->item('base_url');?>watches/watches_settings/false/false/false/false/solitaire" onsubmit="setAction();">
 	<table border="0" bordercolor="#FFCC00" cellpadding="0" cellspacing="5">
	<tr>
	  <td><img src="<?php echo $this->config->item('base_url');?>images/ds.png" height="80;" width="90px;" data-ot=""></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds1.png" height="50;" width="50px;"/>
		<span class="classic">Round</span>
		</a>
		
		</td>
		<td><input type="radio" name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/B"  /></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds2.png" height="50;" width="50px;">
		<span class="classic">Pear</span>
		</a>
		
		</td>
		<td><input type="radio"  name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/P"  /></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds3.png" height="50;" width="50px;">
		<span class="classic">Princess</span>
		</a>
		</td>
		
		<td><input type="radio"  name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/PR"  /></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds4.png" height="50;" width="50px;">
		<span class="classic">Marquise</span>
		</a>
		</td>
		<td><input type="radio"  name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/M"  /></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds5.png" height="50;" width="50px;">
		<span class="classic">oval</span>
		</a>
		</td>
		<td><input type="radio"  name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/O"  /></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds6.png" height="50;" width="50px;">
		<span class="classic">Emerald</span>
		</a>
		</td>
		<td><input type="radio"  name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/E"  /></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds7.png" height="50;" width="50px;">
		<span class="classic">Asscher</span>
		</a>
		</td>
		<td><input type="radio"  name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/AS"  /></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds8.png" height="50;" width="50px;">
		<span class="classic">Heart</span>
		</a>
		</td>
		<td><input type="radio"  name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/H"  /></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds9.png" height="50;" width="50px;">
		<span class="classic">Radiant</span>
		</a>
		</td>
		<td><input type="radio"  name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/R"  /></td>
		<td>
		<a href="#"  class="tooltip">
		<img src="<?php echo $this->config->item('base_url');?>images/ds10.png" height="50;" width="50px;">
		<span class="classic">Cushion</span>
		</a>
		</td>
		<td><input type="radio"  name="ds" value="<?php echo $this->config->item('base_url');?>diamonds/search/true/C"  /></td>
		<td>
		<input type="image" src="<?php echo $this->config->item('base_url');?>images/srch2.png" />
		</td>
	</tr>
	<tr>
		
	</tr>

</table></form>
   </div>
  </div>
  <div id="main-dody">
  	<div class="body-left">
        <div class="rows">
        	<div class="col">
            	<h2>Necklaces</h2>
			  <ul>
                	<li><a href="<?php echo $this->config->item('base_url');?>engagementQuality/Engagement_Rings/">Semi Mounts</a></li>
                </ul>
                <img src="images/ring1.jpg"  alt="Ring 2"/>
<div class="clear"></div>
          </div>
          <div class="col">
            	<h2>Sterling Silver</h2>
			  <ul>
                	<li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/Sterling_Silver/Necklace/">14k Sliver Two Tone</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/14k_Yellow_Gold/Necklace/">14k Yellow Gold</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getmystullerfurwithsub/Diamond_Fashion/Necklace/">Diamond Fashion</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getmystullerfurwithsub/Gemstone_Fashion/Necklace/">Gemstone Fashion</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getmystullerfurwithsub/Metal_Fashion/Bracelet/">Metal Fashion</a></li>
                </ul>
                <img src="images/ring2.jpg"  alt="Ring 3"/>
<div class="clear"></div>
          </div>
          <div class="col">
            	<h2>Bracelet</h2>
			  <ul>
                	<li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/14k_Silver_Two-Tone/Bracelet/">14k Silver Two Tone</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/14k_Yellow_Gold/Bracelet/">14k Yellow Gold</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/Sterling_Silver/Bracelet/">Sterling Silver</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/14k_White_Gold/Bracelet/">14k White Gold</a></li>
                </ul>
                <img src="images/ring3.jpg"  alt="Ring 4"/>
<div class="clear"></div>
          </div>
          <div class="col">
            	<h2>Earrings</h2>
			  <ul>
                	<li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/Sterling_Silver/Earring/">Sterling Silver</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/14k_Yellow_Gold/Earring/">Yellow Gold</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/14k_White_Gold/Earring/">White Gold</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/14k_Silver_Two-Tone/Earring/">Silver Two Tone</a></li>
                </ul>
                <img src="images/ring5.jpg"  alt="Ring 5"/>
<div class="clear"></div>
          </div>
          <div class="col">
            	<h2>Mens Rings</h2>
			  <ul>
                	<li><a href="<?php echo $this->config->item('base_url');?>getstullerfur/Sterling_Silver/Mens/">Mens Rings</a></li>
                </ul>
                <img src="images/ring6.jpg"  alt="Ring 6"/>
<div class="clear"></div>
          </div>
          <div class="col">
            	<h2>Clearance</h2>
			  <ul>
                	<li><a href="<?php echo $this->config->item('base_url');?>allstullerandquantity/Special_Order">Special Order</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>allstullerandquantity/Made_To_Order">Made to Order</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>allstullerandquantity/Limited_Availability">Limited Availability</a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>allstullerandquantity/While_supplies_last">While Supplies Last </a></li>
                    <li><a href="<?php echo $this->config->item('base_url');?>allstullerandquantity/CloseOut">Close Out</a></li>
                </ul>
                <img src="images/ring7.jpg"  alt="Ring 7"/>
<div class="clear"></div>
          </div>
          <div class="col">
            	<h2>Loose Diamonds</h2>
			  <ul>
                	<li><a href="http://atlasdiamond.com/diamonds/search/true/B">Round Diamonds</a></li>
                    <li><a href="http://atlasdiamond.com/diamonds/search/true/PR">Princess Diamonds</a></li>
                    <li><a href="http://atlasdiamond.com/diamonds/search/true/C">Cushion Diamonds</a></li>
                    <li><a href="http://atlasdiamond.com/diamonds/search/true/R">Radiant Diamonds</a></li>
                </ul>
                <img src="images/ring8.jpg"  alt="Ring 8"/>
			<div class="clear"></div>
          </div>
          <div class="col">
            	<h2>3D Engagement Rings</h2>
				<ul>
                	<li><a href="http://atlasdiamond.com/engagement/engagement_ring_settings/">Solitaire Rings</a></li>
                    <li><a href="http://atlasdiamond.com/engagement/engagement_ring_settings/">Halo Rings</a></li>
                    <li><a href="http://atlasdiamond.com/engagement/engagement_ring_settings/">Wedding Bands</a></li>
                    <li><a href="http://atlasdiamond.com/engagement/engagement_ring_settings/">Three Stone Rings</a></li>
                </ul>
                <img src="images/ring1.jpg"  alt="Ring 1"/>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="row-2">
        <h2>
        BUILD YOUR OWN
        <img src="images/mid-border.png" alt="Border" title="Border" /> 
        </h2>
        <div class="items">
        	<h3>BUILD YOUR <br />DIAMOND STUDS</h3>
            <img src="images/item1.png"  alt=""/>
        </div>
        <div class="items">
        	<h3>BUILD YOUR <br />DREAM RING</h3>
            <img src="images/item2.png"  alt=""/>
        </div>
        <div class="items">
        	<h3>BUILD YOUR <br />DIAMOND PENDANT</h3>
          	<img src="images/item3.png"  alt=""/>
          </div>
        <div class="items">
        	<h3>BUILD YOUR <br />3 STONE RING</h3>
            <img src="images/item4.png"  alt=""/>
        </div>
        <div class="clear"></div>
        </div>
      <div class="row-3">
        <h3>NEW 3D RING TECHNOLOGY!</h3>
        <p>Start Designing the ring ring of your dreams now using our 3D Ring Builder technology...</p>
        <a href="<?php echo $this->config->item('base_url');?>engagement/engagement_ring_settings/">More Info</a>
        <img src="images/ring5.png" alt=""/>
      </div>
    </div>
    <div class="body-right">
    	<div class="right-row1">
        	<h2>Customer Service</h2>
        	<ul>
            	<li><img src="images/livechat.jpg"  alt="Live Chat" title="Live Chat"/>Live Chat</li>
                <li><img src="images/contact.jpg" alt="Contact" title="Contact"/>Contact Us</li>
                <li><img src="images/call.jpg" alt="Call" title="Call"/>Request Call</li>
            </ul>
          <h3>Call Us Now! <br /><? echo $this->config->item("site_owner_number"); ?></h3>
        <img src="images/chatimage.jpg" alt="Chat Image" title="Chat Image" />
        </div>
        <div class="clear"></div>
        <div class="right-row2">
        	<h2>Sign up For Best Discounts &amp; Offers</h2>
        	<form action="#" method="post">
            	<input type="text" placeholder="Name"><br />
                <input type="text" placeholder="Email"><br />
                <input type="submit" value="Send">
            </form>
        </div>
        <div class="clear"></div>
        <div class="right-row3">
        	<h2>Featured Product</h2>
            <div class="clear"></div>
        	<img src="images/dimondview.jpg" alt="View Image" title="View Image" />
            <div class="clear"></div>
            <a href="#">View</a>
        </div>
        <div class="clear"></div>
        <div class="right-row4">
        	<img src="images/ebay2.png" alt="View Image" title="View Image" />
        </div>
        <div class="clear"></div>
       <!-- <div class="right-row4">
        	<img src="images/facebook.jpg" alt="View Image" title="View Image" />
        </div> -->
        <div class="clear"></div>
        <div class="right-row4">
        	<img src="images/ama.jpg" alt="View Image" title="View Image" />
        </div>
    </div>
  </div>
  <div class="clear"></div>
     <div id="logo">
        <ul>
            <li><a  href="#"><img src="images/accr.jpg" alt=""/></a></li>
            <li><a  href="#"><img src="images/jewe.jpg" alt=""/></a></li>
            <li><a  href="#"><img src="images/auth.jpg" alt=""/></a></li>
            <li><a  href="#"><img src="images/jv.jpg" alt=""/></a></li>
            <li><a  href="#"><img src="images/vidpa.jpg" alt=""/></a></li>
            <li><a  href="#"><img src="images/priv.jpg" alt=""/></a></li>
            <li><a  href="#"><img src="images/ups.jpg" alt=""/></a></li>
        </ul>
     </div>