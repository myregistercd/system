<? $this->load->helper('url'); ?>
<link type="text/css" href="<?php echo config_item('base_url') ?>css/infostyle.css" rel="stylesheet" />

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<style>
    .menu_info p{line-height: 0.3;}
    
</style>

<div class="">
    <div class="">


        <!-- Middle Section Start Here -->
        <div class="">

            <!-- Shipping Policy Page Start Here -->
            <div class="shippingPageContentOuter" style="float: none!important; margin:0 auto;">
                <div class="leftMenueBoxOuter">
                    <h2 style="color: #000;"></h2>
                    <div class="menu_info">



                        <style>

                            .ac{
                                font-size:11px;
                                color: #517B9B;    	

                                font-family:arial;	
                                text-decoration:none;
                            }
                        </style>
                        <?
                        if(!isset ($topicid)) {
                            $topicid = "";
                        }
                        if ($topicid == 'careers' || $topicid == 'aboutus' || $topicid == 'qualityandvalue' || $topicid == 'investors' || $topicid == 'news' || $topicid == 'conflictfreediamonds' || $topicid == 'freefedexshipping' || $topicid == 'freegift' || $topicid == '30dayreturns' || $topicid == 'jewelryapprisals' || $topicid == 'financingandinsurance' || $topicid == 'subscription' || $topicid == 'aboutgemnile' || $topicid == 'gemnileadvantage'
                                || $topicid == 'referfriend' || $topicid == 'shippingpolicy' || $topicid == 'privacypolicy' || $topicid == 'terms'
                                || $topicid == 'security' || $topicid == 'shipping' || $topicid == 'ethicalsourcing' || $topicid == 'gemnileadvantage'
                                || $topicid == 'affiliateprogram' || $topicid == 'affiliatereward' || $topicid == 'employment' || $topicid == 'benefit'
                                || $topicid == 'testimonial' || $topicid == 'freefedexshipping' || $topicid == 'services' || $topicid == 'giftpackaging'
                                || $topicid == 'specialorder' || $topicid == 'financingandinsurance' || $topicid == 'financing' || $topicid == 'insurance'
                        ) {

                            if ($topicid == 'careers') {
                                $active = 5;
                            }
                            if ($topicid == 'news' || $topicid == 'aboutus' || $topicid == 'aboutgemnile' || $topicid == 'gemnileadvantage' || $topicid == 'referfriend' || $topicid == 'awards') {
                                $active = 0;
                            }
                            if ($topicid == '30dayreturns' || $topicid == 'shippingpolicy' || $topicid == 'privacypolicy' || $topicid == 'terms' || $topicid == 'security' || $topicid == 'shipping' || $topicid == 'ethicalsourcing') {
                                $active = 2;
                            }
                            if ($topicid == 'freegift' || $topicid == 'subscription' || $topicid == 'contact') {
                                $active = 3;
                            }
                            if ($topicid == 'affiliateprogram' || $topicid == 'affiliatereward') {
                                $active = 4;
                            }
                            if ($topicid == 'employment' || $topicid == 'benefit' || $topicid == 'testimonial') {
                                $active = 5;
                            }
                            if ($topicid == 'freefedexshipping' || $topicid == 'services' || $topicid == 'giftpackaging' || $topicid == 'specialorder') {
                                $active = 1;
                            }
                            if ($topicid == 'financingandinsurance' || $topicid == 'financing' || $topicid == 'insurance') {
                                $active = 6;
                            }
                            ?>

                            <script>
                                $(document).ready(function() {
                                    $("#accordion").accordion({
                                        active: <? echo $active; ?>;
                                    });
                                });
                            </script>

                            <div id="accordion"> 
                                <h3  style="width:186px;background:white;height:20px;line-height:0.8px;color:#00328A;font-size:13px;"><a href="#" style="color:#00328A;font-family:arial;background;white;"><span>About Tyson</span></a></h3>
                                <div class="menu_info">

                                    <p><a href="<?php echo config_item('base_url') ?>site/page/aboutus" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background;white;"><span>About us</span></a></p>

                                    <p><a href="<?php echo config_item('base_url') ?>site/page/referfriend" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background;white;"><span>Refer a friend</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/awards"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background;white;"><span>Awards</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/news" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background;white;"><span>In The News</span></a></p>
                                </div>
                                <h3  style="width:186px;background:white;height:20px;line-height:0.8px;color:#00328A;font-size:13px;"><a href="#" style="color:#00328A;font-family:arial;background;white;">Services</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/services" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background;white;">Services</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/freefedexshipping" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background;white;">Free Shipping</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/giftpackaging" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background;white;">Gift Packaging</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/specialorder" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background;white;">Special Orders</a></p>
                                </div>
                                <h3  style="width:186px;background:white;height:20px;line-height:0.8px;color:#00328A;font-size:13px;"><a href="#" style="color:#00328A;font-family:arial;background;white;">Policies</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/shippingpolicy" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Shipping Policy</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/30dayreturns" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Return Policy</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/privacypolicy" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Privacy Policy</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/terms" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Terms & Conditions</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/security" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Security</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/shipping" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Shipping Information</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/ethicalsourcing" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Ethical Sourcing</a></p>
                                </div>
                                <h3  style="width:186px;background:white;height:20px;line-height:0.8px;color:#00328A;font-size:13px;"><a href="#" style="color:#00328A;font-family:arial;">Contact Us</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/contact" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Contact Tyson</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/freegift" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Gift Certificate Status</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/subscription" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Subscription Status</a></p>

                                </div>
                                <h3  style="width:186px;background:white;height:20px;line-height:0.8px;color:#00328A;font-size:13px;"><a href="#" style="color:#00328A;font-family:arial;">Affiliates</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/affiliateprogram" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Affiliate Program</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/affiliatereward" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Affiliate Rewards</span></a></p>

                                </div>
                                <h3  style="width:186px;background:white;height:20px;line-height:0.8px;color:#00328A;font-size:13px;"><a href="#" style="color:#00328A;font-family:arial;text-decoration:none;">Careers</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/employment" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Employment</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/benefit" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Benefits</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/testimonial" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;">Testimonials</span></a></p>

                                </div>
                                <h3  style="width:186px;background:white;height:20px;line-height:0.8px;color:#00328A;font-size:13px;font-family:arial;"><a href="#" style="color:#00328A;font-family:arial;">Financing & Insurance</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/financing" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;"><span>Financing Overview</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/insurance" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;"><span>Insurance</span></a></p>

                                </div>


                            </div>

                        <?
                        } else {

                            $active = 0;
                            if ($topicid == 'diamondedu') {
                                $active = 0;
                            }
                            if ($topicid == 'jwelryedu') {
                                $active = 1;
                            }
                            if ($topicid == 'ringedu') {
                                $active = 2;
                            }
                            if ($topicid == 'metaleducation') {
                                $active = 3;
                            }
                            if ($topicid == 'gemstoneedu') {
                                $active = 4;
                            }
                            if ($topicid == 'pearledu') {
                                $active = 5;
                            }
                            ?>

                            <script>
                                $(document).ready(function() {
                                    $("#accordion").accordion({

                                        active: <? echo $active; ?>
                                    });
                                });
    	
                            </script>


                            <div id="accordion"> 
                                <!--<h3  style="width:186px;background:white;height:20px;line-height:0.8px;color:#00328A;font-size:13px;">
                                    <a href="#" style="color:#00328A;margin-top:2px;background-color:white;"><span>Diamond Education</span></a></h3>
                                <div class="menu_info">
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/certification" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Certication</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/edushape"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Shape</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/educlarity"style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Clarity</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/educut"style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Cut</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/educarat"style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;background-color:white;">Carat</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/educolor"style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Color</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/fancydiamond"style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Fancy diamonds</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/signaturediamond"style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Tyson Signature Diamonds</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/signatureround"style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Premium Round</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/signatureprincess"style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Premium Princess</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/signatureemerald" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Premium Emerald</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/signatureasscher" style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Premium Asscher</a></p>

                                </div>
                                <h3 style="width:186px;background:white;;height:20px;line-height:0.8px;color:#00328A;background-color:white;
                                    font-size:13px;"><a href="#" style="color:#00328A;margin-top:2px;margin-top:2px;background-color:white;">Education</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/earrings"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Earrings</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/necklaces"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Necklaces</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/bracelets"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Bracelets</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/watches"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Watches</a></p>
                                </div>
                                <h3 style="width:186px;background:white;;height:20px;line-height:0.8px;color:#00328A;
                                    font-size:13px;background-color:white;"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><a href="#" style="color:#00328A;margin-top:2px;background-color:white;">Rings Education</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/engagementringguid"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Engagement Ring Guide</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/weddingringguide"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;e;">Wedding Ring Guide</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/findringsize"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Find Your Ring Size</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/choosejeweler"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Choose Your Jeweler</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/choosering"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Choose Your Ring</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/choosediamond"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Choose Your Diamond</a></p>
                                </div>
                                <h3 style="width:186px;background:white;;height:20px;line-height:0.8px;color:#00328A;
                                    font-size:13px;"><a href="#" style="color:#00328A;margin-top:2px;background-color:white;">Metal education</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/platinumeducation"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Platinum education</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/goldeducation"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Gold education</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/silvereducation"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Silver education</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/palladiumeducation"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Palladium education</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/tungsteneducation"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Tungsten education</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/tintaniumeducation"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Titanium education</a></p>

                                </div>
                                <h3 style="width:186px;background:white;;height:20px;line-height:0.8px;color:#00328A;
                                    font-size:13px;"><a href="#" style="color:#00328A;margin-top:2px;background-color:white;">Gemstone education</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/gemnileeducationcolor"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Color</a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/gemnileeducationclarity"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Clarity</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/gemnileeducationcut"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Cut</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/gemnileeducationsize"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Size</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/gemnileeducationenhancements"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;">Enhancements</span></a></p>
                                </div>
                                <h3 style="width:186px;background:white;;height:20px;line-height:0.8px;color:#00328A;
                                    font-size:13px;"><a href="#" style="color:#00328A;margin-top:2px;background-color:white;">Pearl Education</a></h3>
                                <div>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/akoya"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Akoya</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/freshwater"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Fresh water</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/southsea"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>South sea</span></a></p>
                                </div>	-->
                                <h3 style="width:186px;background:white;;height:20px;line-height:0.8px;color:#00328A;
                                    font-size:13px;"><a href="#" style="color:#00328A;margin-top:2px;background-color:white;">Information</a></h3>
                                <div>
                                 <!--   <p><a href="<?php echo config_item('base_url') ?>site/page/plans/"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>EZ Pay Plans</span></a></p> -->
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/aboutus"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>About Us</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/CopyrightAndTrademarkNotice"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Copyright and TM</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/CreditCards"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Credit Cards</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/EffectofTermsandConditions"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Effect of T&C</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/ExchangeonlyNoReturns"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>No Returns Policy</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/Links"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Links</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/MoneyOrders"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Money Orders,Checks</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/MultipleProductOrders"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Multiple Orders</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/OrderAcceptancePolicy"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Acceptance Policy</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/Out-of-StockProducts"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Out-of-Stock Products</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/PricingErrors"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Pricing Errors</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/Privacy"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Privacy</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/PrivacyonOtherWebSites"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Privacy-Other Sites</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/ShippingPolicy"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Shipping Policy </span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/Taxes"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>Taxes</span></a></p>
                                    <p><a href="<?php echo config_item('base_url') ?>site/page/15percentoff"  style="font-size:11px;color:#517B9B;font-family:arial;text-decoration:none;background-color:white;"><span>15 % off</span></a></p>
                                </div>

                            </div>
<? } ?>						
                    </div>
                    <div style="clear:both;"></div>
                </div>

                <div class="rightContentBoxOuter">
                    <div class="rightContentBoxInner">
                        <div class="shippingPoliciesOuter" style="min-height: 600px; padding-bottom: 20px;">
                            <div class="shippingPoliciesInnerLeft shippingPoliciesBox2">
								<?php echo ($content); ?>
                            </div>
                        </div>

                    </div>	
                </div>
                <div style="clear:both">&nbsp;</div>
            </div>	
            <!-- Shipping Policy Page End Here -->
        </div>			
        <!-- Middle Section End Here -->

    </div>
</div>

<?
//echo(uri_string());
/*
  if(uri_string()=="/site/page/contactus")
  {
  ?>

  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/base/jquery-ui.css" type="text/css" media="all" />
  <link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" type="text/javascript"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js" type="text/javascript"></script>
  <script src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>


  <style>

  label, input {  display:block; }
  input.text { font-size:12px; margin-bottom:12px; width:81%; padding: .4em; }
  fieldset {  font-size:12px;padding:0; border:0; margin-top:25px; }
  h1 { font-size: 1.2em; margin: .6em 0; }
  div#users-contain { width: 350px; margin: 20px 0; }
  div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
  div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
  .ui-dialog .ui-state-error { padding: .3em; }
  .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
  <script>
  $(function() {
  // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
  $( "#dialog:ui-dialog" ).dialog( "destroy" );

  var name = $( "#name" ),
  email = $( "#email" ),
  subject = $( "#subject" ),
  question = $( "#question" ),
  allFields = $( [] ).add( name ).add( email ).add( subject ).add( question ),
  tips = $( ".validateTips" );

  function updateTips( t ) {
  tips
  .text( t )
  .addClass( "ui-state-highlight" );
  setTimeout(function() {
  tips.removeClass( "ui-state-highlight", 1500 );
  }, 500 );
  }

  function checkLength( o, n, min, max ) {
  if ( o.val().length > max || o.val().length < min ) {
  o.addClass( "ui-state-error" );
  updateTips( "Length of " + n + " must be between " +
  min + " and " + max + "." );
  return false;
  } else {
  return true;
  }
  }

  function checkRegexp( o, regexp, n ) {
  if ( !( regexp.test( o.val() ) ) ) {
  o.addClass( "ui-state-error" );
  updateTips( n );
  return false;
  } else {
  return true;
  }
  }

  $( "#dialog-form" ).dialog({
  autoOpen: false,
  height: 300,
  width: 350,
  modal: true,
  buttons: {
  "Send Email": function() {
  var bValid = true;
  allFields.removeClass( "ui-state-error" );

  // From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
  bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );


  if ( bValid ) {
  /*	$( "#users tbody" ).append( "<tr>" +
  "<td>" + name.val() + "</td>" +
  "<td>" + email.val() + "</td>" +
  "<td>" + password.val() + "</td>" +
  "</tr>" );
 */
/*
  alert("we have received your email will contact your shortly");
  $.ajax({
  type: "POST",
  url: "http://diamondsforengagementrings.com/site/sendmail",
  data: "name="+$("#name").val()+"&email="+$("#email").val()+"&subject="+$("#subject").val()+"&question="+$("#question").val()+"",
  success: function(msg){
  //alert( "Data Saved: " + msg );
  alert("Email send Successfully");


  }
  });


  $( this ).dialog( "close" );
  }
  },
  Cancel: function() {
  $( this ).dialog( "close" );
  }
  },
  close: function() {
  allFields.val( "" ).removeClass( "ui-state-error" );
  }
  });

  $( ".email_link" )
  .button()
  .click(function() {
  $( "#dialog-form" ).dialog( "open" );
  });
  });
  </script>



  <div class="demo">

  <div id="dialog-form" title="Contact us">
  <p class="validateTips">All form fields are required.</p>

  <form>
  <fieldset>
  <label for="name">Your Name</label>
  <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
  <label for="email">Your Email Address</label>
  <input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" />
  <label for="password">Subject</label>
  <input type="text" name="subject" id="subject" value="" class="text ui-widget-content ui-corner-all" />
  <label for="password">Question</label>
  <textarea name="question" id="question" cols="36" rows="5" class="ui-widget-content ui-corner-all" ></textarea>
  </fieldset>
  </form>
  </div>

  </div>
  -->
  <!--
  <div class="col_2">
  <img align="middle" alt="Email" src="http://pics.bluenile.com/assets/chrome/icons/icon_mail_lrg_36x36.gif"><h2 class="content_hdr">Email</h2>
  <span class="info"><a href="mailto:sales@diamondsforengagementrings.com" class="email_link">sales@diamondsforengagementrings.com</a></span>
  <span class="details"><div class="email_text">Send us your questions in an email. We will respond to you promptly.</div></span>
  </div>

  -->
  <?
 */
// }
?>
<script>
    jQuery(document).ready(function(){
     jQuery('#accordion div').css('height','auto');
});
   
</script>    
	
