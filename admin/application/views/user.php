<!-- Content -->
<div style="font-size:15px; color: #999999; padding-bottom: 15px; float:left;">USER</div>
<div style="float:right;">
	<div class="menu">
		<a href="#view"><button id="btn-view">View</button></a> 
		<a href="#form"><button id="btn-insert">Insert</button></a> 
		<a href="#form"><button id="btn-update" disabled="disabled">Update</button></a>
		<button id="btn-remove" disabled="disabled">Remove</button>
		<button id="btn-filter" value="on">Filter</button>
	</div>
</div>
<div class="mainview view">
	<div id="form" style="display:none; padding-bottom:45px;">
		<form method="post" id="submit-form" action="user/insert">
		<input type="hidden" name="user_id" id="user_id">
		<br /><br />
		<div class="innert-list">
    		<h1>User Name</h1>
    		<div class="corner">
    			<input type="text" name="user_name" id="user_name">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Password</h1>
    		<div class="corner">
    			<input type="text" name="user_password" id="user_password">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Group</h1>
    		<div class="corner">
				<select name="user_group" id="user_group">
        		</select>
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Full Name</h1>
    		<div class="corner">
    			<input type="text" name="user_full_name" id="user_full_name">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Email</h1>
    		<div class="corner">
    			<input type="text" name="user_email" id="user_email">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Phone</h1>
    		<div class="corner">
    			<input type="text" name="user_phone" id="user_phone">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Address</h1>
    		<div class="corner">
    			<input type="text" name="user_address" id="user_address">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Status</h1>
    		<div class="corner">
				<select name="user_aktif" id="user_aktif">
					<option value="0">Non Active</option>
					<option value="1">Active</option>
        		</select>
    		</div>
    	</div>
		<div class="innert-list">
			<br />
			<div class="corner">
    		  <button type="reset">Reset</button>
              <button type="submit">Submit</button>
			</div>
		</div>
	</form>
</div>




<div id="view" style="padding-bottom:45px;">
<!-- Datatables -->
	<table class="table" id="tabels">
		<thead>
			<tr>
				<th>User Name</th>
				<th>Full Name</th>
				<th>Emai</th>
				<th>Phone</th>
				<th>Address</th>
				<th>Group</th>
				<th>Status</th>
			</tr>
		</thead>
		<tfoot id="form_filter" style="display:none">
			<tr align="center">
				<th>User Name</th>
				<th>Full Name</th>
				<th>Emai</th>
				<th>Phone</th>
				<th>Address</th>
				<th>Group</th>
				<th>Status</th>
			</tr>
		</tfoot>
		<tbody>
			<tr>
				<td colspan="5" class="dataTables_empty">Loading data from server</td>
			</tr>
		</tbody>
	</table>

<!-- Remove Modal -->


	<div class="overlay" style="display: none; padding-bottom:45px;">
    	<div class="page">
              <h1><b>Confirm</b></h1>
              	<div class="content-area">
               		Are you sure you want to remove this data? 
              	</div>
              	<div class="action-area">
			 		<form method="post" id="remove-form" action="user/remove">
                		<div class="action-area-right">
                  			<div class="button-strip">
				   				<input type="hidden" name="remove_user_id" id="remove_user_id">
                    			<button type="reset">Cancel</button>
                    			<button type="submit">Okay</button>
                  			</div>
                		</div>
					</form>
              	</div>
            </div>
		</div>
			 
</div>
<!-- End -->
		
<script type="text/javascript"> 

$(document).ready(function() {
	
	/** Action button menu **/
	
	/* Menu transition */
	$('.menu a').click(function(ev) {

        ev.preventDefault();
        var selected = 'selected';

        $('.mainview > *').removeClass(selected);
        $('.menu button').removeClass(selected);
		 setTimeout(function() {
          $('.mainview > *:not(.selected)').css('display', 'none');
        }, 100);
		$(ev.currentTarget).parent().addClass(selected);
        var currentView = $($(ev.currentTarget).attr('href'));
        currentView.css('display', 'block');
        setTimeout(function() {
          currentView.addClass(selected);
        }, 0);
      });

	/* View button */
	$('#btn-view').bind('click', function(){
		// Enable button insert
		$('#btn-insert').removeAttr("disabled");
		$('#btn-filter').removeAttr("disabled");
	});
		  
	/* Insert button */
	$('#btn-insert').bind('click', function(){
		// Reset submit form
		$('#user_id').val('');
		// Disabled button
		$('#btn-update').attr("disabled","disabled");
		$('#btn-remove').attr("disabled","disabled");
		$('#btn-filter').attr("disabled","disabled");
	});

	/* Update button */
	$('#btn-update').bind('click', function(){
		// Disabled button
		$('#btn-insert').attr("disabled","disabled");
		$('#btn-remove').attr("disabled","disabled");
		$('#btn-filter').attr("disabled","disabled");
	});
	
	/* Filter button */	
  	$('#btn-filter').bind('click', function(){
		
		if($('#btn-filter').attr("value") == "on"){
			$('#form_filter').show();
			$('#btn-filter').attr("value","off");
    	}else{
			$('#form_filter').hide();
			$('#btn-filter').attr("value","on");
		}
			
		});

	/* Remove button */
	  	$('#btn-remove').bind('click', function(){
			$('.overlay').show();
			$('.overlay').find('button').click(function() {
         		$('.overlay').hide();
        	});
			
			$('.overlay').click(function() {
        		$('.overlay').find('.page').addClass('pulse');
        		$('.overlay').find('.page').on('webkitAnimationEnd', function() {
            		$(this).removeClass('pulse');
          		});
        	});

		});

	/** Form submit action **/ 
	
	/* Set "submit-form" action */	 
	$('#submit-form').ajaxForm({
	   resetForm: true,
	   cache: false,
	   success: alertForm
    });
	
	/* Set "remove-form" action */
	$('#remove-form').ajaxForm({
	   resetForm: true,
	   cache: false,
	   success: alertForm
    });
	
	/* Alert form action */
	function alertForm(query){
		// Reload page
 		openPages('user');
		alert(query);
	}

	/** Get request data group  **/
	getRequest("user/get_group", function(data) {
         
        var data = JSON.parse(data.responseText);
    
        for (var i = 0; i < data.length; i++) {
			$("#user_group").append("<option value="+data[i].group_id+">"+data[i].group_name+"</option>");
        }

    });
	
		/** Set datatables **/

	var oTable = $('#tabels').dataTable({
		"bProcessing": false,
		"bServerSide": true,
		"sAjaxSource": "user/get",
		'sPaginationType': 'full_numbers',					
       	"fnServerData": function( sUrl, aoData, fnCallback ) {
            $.ajax( {
                "url": sUrl,
                "data": aoData,
                "success": fnCallback,
                "dataType": "jsonp",
                "cache": false
            } );
        }
         }).columnFilter({
		 	// Set filter type
	      	aoColumns: [{ type: "text" },
						{ type: "text" },
						{ type: "text" },
						{ type: "text" },
						{ type: "text" },
				        { type: "text" }]
		});
	
	/** Set edit value after click datatables **/	
	$('#tabels tbody').on('click','tr', function () {
	
	 var aData = oTable.fnGetData(this);
	  
	 if(aData != null){
	 	// Set value form after select table for update data
		$('#remove_user_id').val(aData[9]);
	 	$('#user_id').val(aData[9]);
	 	$('#user_name').val(aData[0]);
		$('#user_group > option[value="'+aData[8]+'"]').prop("selected", "selected");
	 	$('#user_full_name').val(aData[1]);
		$('#user_email').val(aData[2]);
		$('#user_phone').val(aData[3]);
		$('#user_address').val(aData[4]);
		$('#user_aktif > option[value="'+aData[7]+'"]').prop("selected", "selected");
	 
 			if ( $(this).hasClass('row_selected') ) {
            	$(this).removeClass('row_selected');
				// clear data form
				$(':hidden','#remove-form').val('');
				$(':hidden','#submit-form').val('');
				$('#btn-update').attr("disabled","disabled");
				$('#btn-remove').attr("disabled","disabled");
        	} else {
            	oTable.$('tr.row_selected').removeClass('row_selected');
            	$(this).addClass('row_selected');
				$('#btn-update').removeAttr("disabled");
				$('#btn-remove').removeAttr("disabled");
        	}
	  	}
		});
	});

</script>