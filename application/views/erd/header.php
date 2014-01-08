<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo (isset($meta_tags)) ? $meta_tags : '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />';?>
<title>Welcome to <? echo $this->config->item('full_site_name'); ?></title>
<link type="text/css" href="<?php echo config_item('base_url') ?>css/style.css" rel="stylesheet" />
<link type="text/css" href="<?php echo config_item('base_url') ?>css/site-style.css" rel="stylesheet" />
<link type="text/css" href="<?php echo config_item('base_url') ?>css/main.css" rel="stylesheet" />
<link type="text/css" href="<?php echo config_item('base_url') ?>css/js-image-slider.css" rel="stylesheet" />
<link type="text/css" href="<?php echo config_item('base_url') ?>css/tamal.css" rel="stylesheet" />
<link type="text/css" href="<?php echo config_item('base_url')?>css/tabs.css" rel="stylesheet" /> 
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo config_item('base_url')?>css/IE7styles.css" /><![endif]--> 
<link type="text/css" href="<?php echo config_item('base_url') ?>css/style1.css" rel="stylesheet" />
<link type="text/css" href="<?php echo config_item('base_url') ?>css/reset1.css" rel="stylesheet" />
<link type="text/css" href="<?php echo config_item('base_url') ?>css/ruman.css" rel="stylesheet" />
<!-- <link type="text/css" href="<?php echo config_item('base_url') ?>css/header_menu.css" rel="stylesheet" /> -->
<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" />
<!--[if  IE 8]>
<link rel="stylesheet" type="text/css"  href=<?php echo config_item('base_url')?>IE8styles.css"" />
<![endif]-->
<script>var base_url = '<?php echo config_item('base_url');?>';</script>
<script src="<?php echo config_item('base_url');?>js/jquery.js" type="text/javascript"></script>
<script src="<?php echo config_item('base_url');?>slider/js-image-slider.js" type="text/javascript"></script>
<script src="<?php echo config_item('base_url') ?>js/facebox.js" type="text/javascript"></script>
<script src="<?php echo config_item('base_url')?>js/jquery.corner.js" type="text/javascript"></script>
<script src="<?php echo config_item('base_url')?>js/function.js" type="text/javascript"></script>
<script src="<?php echo config_item('base_url')?>js/t.js" type="text/javascript"></script>
<script src="<?php echo config_item('base_url')?>js/r.js" type="text/javascript"></script>
<script type="text/javascript">
var item_type ='<?php echo $itemtype;?>';


    $(document).ready(function() { console.log('item_type=>'+item_type);
        $('td#body').removeClass("content");
		if(item_type.trim()!='' && !(item_type.trim()=='Rings' || item_type.trim()=='Ring')){
			$('p.ring').hide();
		}
    });
</script>
<style type="text/css">
@import "css/reset1.css";
@import "css/style1.css";
</style>
<!--
<link type="text/css" href="<?php echo config_item('base_url');?>css/diamondsearch.css" rel="stylesheet" />
<link type="text/css" href="<?php echo config_item('base_url');?>css/papillon.css" rel="stylesheet" />
<script language="javascript" type="text/javascript" src="<?php echo config_item('base_url');?>js/papillon.js"></script>
-->
<?php echo isset($extraheader) ? $extraheader : '';?> 
<!--
<script type="text/javascript" language="javascript">
	jQuery(document).ready(function() {
		<?php echo isset($onloadextraheader) ? $onloadextraheader : '';?>
		/*jQuery(".roundcorner").corner("round 3px");*/
		closetimer = 0;
		if(jQuery("#mainmenu")) {
			jQuery("#mainmenu b").mouseover(function() {
				clearTimeout(closetimer);
				if(this.className.indexOf("clicked") != -1) {
					jQuery(this).parent().next().slideUp(300);
					jQuery(this).removeClass("clicked");
				}
				else {
					jQuery("#mainmenu b").removeClass();
					jQuery(this).addClass("clicked");
					jQuery("#mainmenu ul:visible").slideUp(300);
					jQuery(this).parent().next().slideDown(300);
				}
				return false;
			});
			jQuery("#mainmenu").mouseover(function() {
				clearTimeout(closetimer);
			});
			jQuery("#mainmenu").mouseout(function() {
				closetimer = window.setTimeout(function(){
					jQuery("#mainmenu ul:visible").slideUp(300);
					jQuery("#mainmenu b").removeClass("clicked");
				}, 500);
			}); 
		}
		
		//menuleft js
		jQuery("ul.lst-menu-left").mouseover(function(){
			jQuery(this).find("div.categoryPopout").css("display","block");
		});
		jQuery("ul.lst-menu-left div.categoryPopout").mouseover(function(){
			jQuery(this).parent().addClass("active");
		});
		jQuery("#ul.lst-menu-left").mouseout(function() {
			jQuery(this).find("div.categoryPopout").css("display","none");
		});	
		jQuery("ul.lst-menu-left div.categoryPopout").mouseout(function(){
			jQuery(this).parent().removeClass("active");
		});
		
	});
</script>-->
<script type="text/javascript" language="javascript">
	jQuery(document).ready(function() {
		<?php echo isset($onloadextraheader) ? $onloadextraheader : '';?>
		/*jQuery(".roundcorner").corner("round 3px");*/
		closetimer = 0;
		if(jQuery("#mainmenu")) {
			jQuery("#mainmenu b").mouseover(function() {
				clearTimeout(closetimer);
				if(this.className.indexOf("clicked") != -1) {
					jQuery(this).parent().next().slideUp(300);
					jQuery(this).removeClass("clicked");
				}
				else {
					jQuery("#mainmenu b").removeClass();
					jQuery(this).addClass("clicked");
					jQuery("#mainmenu ul:visible").slideUp(300);
					jQuery(this).parent().next().slideDown(300);
				}
				return false;
			});
			jQuery("#mainmenu").mouseover(function() {
				clearTimeout(closetimer);
			});
			jQuery("#mainmenu").mouseout(function() {
				closetimer = window.setTimeout(function(){
					jQuery("#mainmenu ul:visible").slideUp(300);
					jQuery("#mainmenu b").removeClass("clicked");
				}, 500);
			}); 
		}
		
		//menuleft js
		jQuery("ul.lst-menu-left").mouseover(function(){
			jQuery(this).find("div.categoryPopout").css("display","block");
		});
		jQuery("ul.lst-menu-left div.categoryPopout").mouseover(function(){
			jQuery(this).parent().addClass("active");
		});
		jQuery("#ul.lst-menu-left").mouseout(function() {
			jQuery(this).find("div.categoryPopout").css("display","none");
		});	
		jQuery("ul.lst-menu-left div.categoryPopout").mouseout(function(){
			jQuery(this).parent().removeClass("active");
		});
		
	});
	//vnr
	function submit_search_form(){//alert('searchkeyword');
		var searchkeyword = $.trim($('#searchkeyword').val());	
		if(searchkeyword == ''){		
			//alert('Please enter some keyword');
			return false;
		}
		if(searchkeyword!=''){						
			document.f_search.submit();			
			//$('f_search').submit();
		}	
		
	}
</script>


<link rel="stylesheet" type="text/css" href="<?php echo config_item('base_url')."css/leftmenu.css"; ?>" >
	   
</head>
<body> 
<script type="text/javascript" src="<?php echo config_item('base_url')?>third_party/dhtmltooltips/wz_tooltip.js"></script>
<script type="text/javascript" src="<?php echo config_item('base_url')?>third_party/dhtmltooltips/tip_balloon.js"></script>
<script type="text/javascript" src="<?php echo config_item('base_url')?>third_party/dhtmltooltips/tip_centerwindow.js"></script>
<script type="text/javascript" src="<?php echo config_item('base_url')?>third_party/dhtmltooltips/tip_followscroll.js"></script>

<div id="wrapper">
	<div class="header">
     <nav>
        <div class="top-nav-left">
        	<ul>
            <li><a href="/">Home</a></li>
            <li><a href="<?php echo config_item('base_url') ?>site/page/aboutus">About us</a></li>
            <li><a href="<?php echo config_item('base_url') ?>site/page/contactus">Contact us</a></li>
            </ul>
        </div>
        <div class="top-nav-right">
        	<ul>
            <li><a href="<?php echo config_item('base_url') ?>account/membersignin">My Account</a></li>
            <li><a href="<?php echo config_item('base_url') ?>account/trackorder">Order Status</a></li>
            <li><a href="<?php echo config_item('base_url') ?>shoppingbasket/mybasket">View Cart &nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo config_item('base_url') ?>images/cart.png" width="14" height="12"  alt="cart" title="cart"/></a></li>
            </ul>
        </div>
     </nav>
    </div>
  	<div class="clear"></div>  
  	<div class="second-header">
      <div class="logo">
        <a href="/"><img src="<?php echo config_item('base_url') ?>images/logo.png"  alt="logo" title="logo"/></a>
        <a href="/"><img src="<?php echo config_item('base_url') ?>images/ebay.png"  alt="ebay" title="ebay"/></a>
            <div class="search-menu">
              <!--  <ul>
                    <li><a href="#">Live Chat</a></li>
                    <li><a href="#">Account</a></li>
                </ul> -->
                <h3>Call us: <? echo $this->config->item("site_owner_number"); ?></h3>
                <form autocomplete="on" action="<?php echo config_item('base_url') ?>engagement/searchresult" name="f_search" method="Post">
                    <input type="text" value="Stock # or keyword" onblur="myBlur(this)" onfocus="myFocus(this)" id="searchkeyword" name="searchkeyword" class="txt_s">
                    <input type="submit" value="" />
                </form>
            </div>
        </div>
        <div class="clear"></div>
        <nav class="main-nav">
       	  <ul>
            	<li><a class="activ" href="<?php echo config_item('base_url') ?>jewelleries/engagementQuality/Engagement_Rings/">ENGAGEMENT</a></li>
                <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Ring">RINGS</a></li>
                <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Necklace">NECKLACES</a></li>
                <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Bracelet">BRACELETS</a></li>
                <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Earring">EARRINGS</a></li>
                <li><a href="<?php echo config_item('base_url') ?>jewelleries/getjewleries/Mens">MENS</a></li>
                <li><a href="<?php echo config_item('base_url') ?>jewelleries/getstullerfur/Sterling_Silver/Bracelet">SILVER</a></li>
                <li><a href="<?php echo config_item('base_url') ?>jewelleries/allstullerandquantity">CLEARANCE</a></li>
            </ul>
        </nav>
	</div>
    <div class="clear"></div><!--End #Header-->
