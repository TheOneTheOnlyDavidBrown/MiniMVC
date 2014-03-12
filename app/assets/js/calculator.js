// inherited "class" from base
base.calculator = $.inherit(base,/** @lends B.prototype */{
	init : function(){
		
	},
	
	ready : function(){
		this.eventListeners();
		//alert(this.site_name);
	},
	
	eventListeners : function(){
		$('input').bind('click',function(){
			$sum = $('#sum');
			$numone = $('#numone');
			$numtwo = $('#numtwo');
			if($sum.text()!==''){
				$numone.text('');
				$numtwo.text('');
				$sum.text('');
			}
			
			if($numone.text()===''){
				$numone.text($(this).val());
			}
			else if($numtwo.text()===''){
				$numtwo.text($(this).val());
				//var sum = parseInt($('#numtwo').text())+parseInt($('#numone').text());
				
				//$sum.text(parseInt($numone.text(),null)+parseInt($numtwo.text(),null));
				$.ajax({
					url: "?c=calculatorsample&m=add",
					data: {
						a:$numone.text(),
						b:$numtwo.text()
					},
					dataType: 'json',
  					method: 'post',
					success: function(response){
						console.log(response);
						if(response.error){
							console.log(response.error);
							$sum.text(response.error);
							return;
						}
						$sum.text(response.sum);
						
					},
					error: function(e){
						console.log('error');
						console.log(e.statusText);
					}
				});
			}
		});
	}
});
