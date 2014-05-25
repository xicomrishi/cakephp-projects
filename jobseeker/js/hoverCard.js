var hc = null;
function hoverCard(link, cont, _mode){
	var mode = "top";
	if(_mode){
		mode = _mode;
	}
	this.link = $(link);
	this.cont = $(cont);
	this.status = 0;
	var t = this;
	var contentHeight = this.cont.height();
	var contentWidth = this.cont.width();
	
	this.init = function(){
		hover_scan(this.cont);
		this.link.addClass('k-hover-trigger');
		this.reg();
	}
	this.reg = function(){
		this.link.click(function(){
		//alert("in");
			//return false;
			//alert("in");
			var l =$(this).position().left;
			var w = $(this).width();
			var tp = $(this).position().top;
			if(t.cont.css('display') == 'block'){
				if(mode == 'top'){
					t.cont.animate({'height':0, 'opacity':0},500, 'linear', function(){ $(this).hide(); $(this).css({'height':'auto'}); });
				}
				else if(mode=='right'){
					t.cont.animate({'width':0, 'opacity':0},500, 'linear', function(){ $(this).hide(); $(this).css({'width':'auto'}); });
				}
			}
			else{
				$('.hover_card').hide();
				t.cont.fadeTo(0);
				if(mode == 'top'){
					t.cont.show().css({'height':0});
					t.cont.animate({'height':contentHeight, 'opacity':1},500, 'linear', function(){  $(this).css({'height':'auto'}); });
				}
				else if(mode=='right'){
					t.cont.show().css({'width':0, 'opacity':0});
					t.cont.animate({'width':contentWidth, 'opacity':1},500, 'linear', function(){   });
				}
			}
			
			//t.cont.css({'left':(l+w)+"px", 'top':tp+"px"});
			return false;
		});
	}
	
	$(document).click(function(e){
		if( $(e.target).is('.k-hover-card') || $(e.target).is('.k-hover-trigger')){
		//console.
			return;	
			
		}
			$('.hover_card').hide();
		/*document.getElementById("ProfessionalIndexForm").reset();*/
		$('#ProfessionalIndexForm #ProfessionalEmail,#ProfessionalIndexForm #ProfessionalPassword').val('');
		$('#ProfessionalIndexForm #ProfessionalEmail').attr("placeholder", 'Enter Email');
		$('#ProfessionalIndexForm #ProfessionalPassword').attr("placeholder", 'Password');
		$('#ProfessionalIndexForm').validationEngine('hide');
		$('#ProfessionalIndexForm #ProfessionalEmail,#ProfessionalIndexForm #ProfessionalPassword').validationEngine().css({border : "1px solid #D5D0D0"});
		
		
	});
	
}
	function hover_scan(ctrl){
		$(ctrl).children().each(function(){
			if($(this).children().size()>0){
				hover_scan(this);
			}
			$(this).addClass('k-hover-card');
			
		});
	}