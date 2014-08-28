
<?php 	
		echo $this->Html->css(array('tablet/reset', 'tablet/bootstrap','tablet/style','tablet/responsive','tablet/font-awesome'));
	//	echo $this->Html->script(array('html5','jquery-2.0.2', 'bootstrap.min','modernizr.custom.79639'));
		//echo $this->Html->script(array('jquery.ba-cond.min'));		
		echo $this->Html->script(array('jquery.bxslider.js'));
		
?>
<style>
    .choose-deals{ color: #<?php if(!empty($font_color)) echo $font_color; else echo 'fff'; ?> !important; }	
</style>
<script type="text/javascript">



    $(function() {

        var quotes = $(".choose-deals");
        var quoteIndex = -1;

        function showNextQuote() {
            ++quoteIndex;
            quotes.eq(quoteIndex % quotes.length)
                    .fadeIn(1000)
                    .delay(1500)
                    .fadeOut(1000, showNextQuote);
        }

        showNextQuote();
    });


    $(document).ready(function() {
        setTimeout(function() {

            if ($(window).width() > 767) {
                $('.bxslider').bxSlider({
                    minSlides: 2,
                    maxSlides: 2,
                    slideWidth: 337,
                    slideMargin: 10
                            //pager: false
                });
            }
            else {
                $('.bxslider').bxSlider({
                    minSlides: 1,
                    maxSlides: 1,
                    slideWidth: 337,
                    slideMargin: 10,
                    //pager: false
                });
            }

        }, 1000);




    });
</script>

<style>
    .deal-logo{ height:auto;}
</style>

<?php $bg = !empty($bg_color)?$bg_color:''; ?>
<?php $bg_texture = !empty($bg_texture)?$bg_texture:1; ?>
<?php $fore_color = !empty($color)?$color:''; ?>


<div class="" style="background-color:#<?php echo $bg; ?>; min-height: 100%;">
    <div class="pattern" style="background: url('<?php echo $this->webroot.'img/textures/texture_'.$bg_texture.'.png'; ?>') repeat-x !important; min-height: 100%; position: relative;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 dls" style="word-wrap: break-word;">
                            <figure class="deal-logo">
                                <img id="comp_logo" src=""  alt="" style="max-height:143px;" />
                            </figure>
                            <h1 id="unique_main_page_text_1" class="choose-deals mtext1" style="height:215px;"<?php if(!empty($font_color)) echo 'style="color:#'.$font_color.'"'; ?>>

                            </h1>
                            <h1 id="unique_main_page_text_2" class="choose-deals mtext2" style="height: 215px; display: none;" <?php if(!empty($font_color)) echo 'style="color:#'.$font_color.'"'; ?>>

                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=" landing-page-slider">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">                        
                        <div class="slider-wrap">
                            <ul class="bxslider">

                                <li>

                                    <a href="javascript://">
                                        <figure>
													<?php echo $this->Html->image('take-a-peek.png',array('escape'=>false,'style' => 'max-height: 96px; max-width: 58px;'));?>
                                        </figure>
                                        <article>
                                            <span id="">Company</span><br>
                                            <span id="">Deal</span><br>
                                            <span id="">Get 10% of deals


                                            </span>
                                        </article>
                                    </a>
                                </li>
                                <li>

                                    <a href="javascript://">
                                        <figure>
													<?php echo $this->Html->image('take-a-peek.png',array('escape'=>false,'style' => 'max-height: 96px; max-width: 58px;'));?>
                                        </figure>
                                        <article>
                                            <span id="">Company</span><br>
                                            <span id="">Deal</span><br>
                                            <span id="">Get 10% of deals


                                            </span>
                                        </article>
                                    </a>
                                </li>


                            </ul>
                        </div>                                         
                    </div>                
                </div>  
            </div>  
        </div>  
        <div class="footer-wrap landing-page">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <footer class="footer col-sm-12">
                            <a href="#" class="text-center" ><img src="<?php echo $this->webroot.'img/powered-by.png'; ?>" alt="" /></a>
                        </footer>  
                    </div>                   
                </div>    
            </div>
        </div>  
        <div class="clear"></div>
    </div> 
    <div class="clear"></div>
</div>	
