/* Copyright JQUERY4U 2011 */
(function($)
{
    JQFUNCTIONS =
    {
       // settings:
//        {
//			ajaxImage: 'loading.gif'
//        },

        sel: function()
        {
			//button events
			$('select').live('change', function(e) {
				e.preventDefault();
				eval('JQFUNCTIONS.runFunc["'+$(this).attr("id")+'"]();');
			});
        },
		 cli: function()
        {
			//button events
			$('a').live('click', function(e) {
				e.preventDefault();
				eval('JQFUNCTIONS.runFunc["'+$(this).attr("id")+'"]();');
			});
        },
		
		 inp: function()
        {
			//button events
			$('input').live('keyup', function(e) {
				e.preventDefault();
				eval('JQFUNCTIONS.runFunc["'+$(this).attr("id")+'"]();');
			});
        },
		
		

        runFunc:
        {

            "tel1": function()
            {
				//console.log('running ajaxphp...');
				//$('#telverif').html('<img src="loading.gif" />');
				$.ajax({
				  url: 'repPhpAjax_verifTel.php',
				  type: 'POST',
				   data:'val_sel='+document.getElementById( 'tel1' ).value,
				 
				
				  success: function(data) {
					//called when successful
					$('#telverif').html(data);
				  },
				  error: function(e) {
					//called when there is an error
					$('#telverif').html(e.message);
				  }
				});	
				
				
				
            },
			
			
			
			 "tel2": function()
            {
				//console.log('running ajaxphp...');
				//$('#telverif2').html('<img src="loading.gif" />');
				$.ajax({
				  url: 'repPhpAjax_verifTel.php',
				  type: 'POST',
				   data:'val_sel='+document.getElementById( 'tel2' ).value,
				 
				
				  success: function(data) {
					//called when successful
					$('#telverif2').html(data);
				  },
				  error: function(e) {
					//called when there is an error
					$('#telverif2').html(e.message);
				  }
				});	
				
				
				
            },
			
			
			 "telcontact1": function()
            {
				//console.log('running ajaxphp...');
				//$('#telverif2').html('<img src="loading.gif" />');
				$.ajax({
				  url: 'repPhpAjax_verifContactTel.php',
				  type: 'POST',
				   data:'val_sel='+document.getElementById( 'telcontact1' ).value,
				 
				
				  success: function(data) {
					//called when successful
					$('#veriftelcontact').html(data);
				  },
				  error: function(e) {
					//called when there is an error
					$('#veriftelcontact').html(e.message);
				  }
				});	
				
				
				
            },
			
			
			
			"emailcontact1": function()
            {
				//console.log('running ajaxphp...');
				//$('#telverif2').html('<img src="loading.gif" />');
				$.ajax({
				  url: 'repPhpAjax_verifContactEmail.php',
				  type: 'POST',
				   data:'val_sel='+document.getElementById( 'emailcontact1' ).value,
				 
				
				  success: function(data) {
					//called when successful
					$('#verifemailcontact').html(data);
				  },
				  error: function(e) {
					//called when there is an error
					$('#verifemailcontact').html(e.message);
				  }
				});	
				
				
				
            }
			
			
		
			
			
		
        }

    }

})(jQuery);