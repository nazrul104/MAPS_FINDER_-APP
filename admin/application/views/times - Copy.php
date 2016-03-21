<!-- Content -->
<div style="font-size:15px; color: #999999; padding-bottom: 15px; float:left;">Times Open or Close | <span id="images-location-name"></span></div>
<div style="float:right;">
	<div class="menu">
		<a href="#view"><button id="btn-view">View</button></a> 
		<a href="#form"><button id="btn-insert">Insert</button></a> 
		<a href="#form"><button id="btn-update" disabled="disabled">Update</button></a>
		<button id="btn-remove" disabled="disabled">Remove</button>
		<button id="btn-filter" value="on">Filter</button>
		<button onClick="openPages('location_list')">Back</button>
	</div>
</div>

<div class="mainview view">
	<div id="form" style="display:none; padding-bottom:45px;">
		<form method="post" id="submit-form" action="times/insert" enctype="multipart/form-data">
		<input type="hidden" name="times_id" id="times_id">
		<input type="hidden" name="times_markers_id" id="times_markers_id">
		<br /><br />
	<div class="innert-list">
    		<h1>Sunday</h1>
    		<div class="corner">
				<input type="hidden" name="times_day[]" id="times_day" value="Sunday">
    			<input type="text" name="times_open[]" id="times_open" style="width: 80px;" placeholder="Open"> -
				<input type="text" name="times_close[]" id="times_close" style="width: 80px;" placeholder="Close">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Monday</h1>
    		<div class="corner">
			<input type="hidden" name="times_day[]" id="times_day" value="Monday">
    			<input type="text" name="times_open[]" id="times_open" style="width: 80px;" placeholder="Open"> -
				<input type="text" name="times_close[]" id="times_close" style="width: 80px;" placeholder="Close">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Tuesday</h1>
    		<div class="corner">
				<input type="hidden" name="times_day[]" id="times_day" value="Tuesday">
    			<input type="text" name="times_open[]" id="times_open" style="width: 80px;" placeholder="Open"> -
				<input type="text" name="times_close[]" id="times_close" style="width: 80px;" placeholder="Close">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Wednesday</h1>
    		<div class="corner">
				<input type="hidden" name="times_day[]" id="times_day" value="Wednesday">
    			<input type="text" name="times_open[]" id="times_open" style="width: 80px;" placeholder="Open"> -
				<input type="text" name="times_close[]" id="times_close" style="width: 80px;" placeholder="Close">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Thursday</h1>
    		<div class="corner">
				<input type="hidden" name="times_day[]" id="times_day" value="Thursday">
    			<input type="text" name="times_open[]" id="times_open" style="width: 80px;" placeholder="Open"> -
				<input type="text" name="times_close[]" id="times_close" style="width: 80px;" placeholder="Close">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Friday</h1>
    		<div class="corner">
				<input type="hidden" name="times_day[]" id="times_day" value="Friday">
    			<input type="text" name="times_open[]" id="times_open" style="width: 80px;" placeholder="Open"> -
				<input type="text" name="times_close[]" id="times_close" style="width: 80px;" placeholder="Close">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Saturday</h1>
    		<div class="corner">
				<input type="hidden" name="times_day[]" id="times_day" value="Saturday">
    			<input type="text" name="times_open[]" id="times_open" style="width: 80px;" placeholder="Open"> -
				<input type="text" name="times_close[]" id="times_close" style="width: 80px;" placeholder="Close">
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
				<th>Days</th>
				<th>Open</th>
				<th>Close</th>
			</tr>
		</thead>
		<tfoot id="form_filter" style="display:none">
			<tr align="center">
				<th>Days</th>
				<th>Open</th>
				<th>Close</th>
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
			 		<form method="post" id="remove-form" action="times/remove">
                		<div class="action-area-right">
                  			<div class="button-strip">
				   				<input type="hidden" name="remove_times_id" id="remove_times_id">
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

	var timesMarkerId =  $('#add_images_marker_id').val();
	var timesMarkerName = $('#add_images_marker_name').val();
	
	$('#images-location-name').html(timesMarkerName);
	
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
		// Enable button
		$('#btn-insert').removeAttr("disabled");
		$('#btn-filter').removeAttr("disabled");
	});
		  
	/* Insert button */
	$('#btn-insert').bind('click', function(){
		// Reset submit form
		//$(':hidden','#submit-form').val('');
		$('#times_id','#times_markers_id','#submit-form').val('');
		// Set Marker id
		$('#times_markers_id').val(timesMarkerId);
		// Disabled button
		$('#btn-update').attr("disabled","disabled");
		$('#btn-remove').attr("disabled","disabled");
		$('#btn-filter').attr("disabled","disabled");
		$('#btn-add-image').attr("disabled","disabled");
		$('#btn-add-times').attr("disabled","disabled");
	});

	/* Update button */
	$('#btn-update').bind('click', function(){
		// Disabled button
		$('#btn-insert').attr("disabled","disabled");
		$('#btn-remove').attr("disabled","disabled");
		$('#btn-filter').attr("disabled","disabled");
		$('#btn-add-image').attr("disabled","disabled");
		$('#btn-add-times').attr("disabled","disabled");
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
 		openPages('images');
		alert(query);
	}
	
		/** Set datatables **/

	var oTable = $('#tabels').dataTable({
		"bProcessing": false,
		"bServerSide": true,
		"sAjaxSource": "times/get?id="+timesMarkerId,
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
				        { type: "text" }]
		});


	/** Show detail data datatables **/
	
	function fnFormatDetails ( nTr )
		{
			
		 var aData = oTable.fnGetData( nTr );
		 if(aData != null){
			
			var sOut = '<div align="center" ><img border="3" src="<?php echo base_url(); ?>upload/images/'+aData[3]+'"></div>';
			
				return sOut;
			}
				}
			
				$('#tabels tbody').on( 'dblclick','td', function () {
					var nTr = $(this).parents('tr')[0];
					if ( oTable.fnIsOpen(nTr) )
					{
						oTable.fnClose( nTr );
					}
					else
					{
						oTable.fnOpen( nTr, fnFormatDetails(nTr), 'details' );
					}
				} );
	
	/** Set form edit value after click datatables **/	
	$('#tabels tbody').on('click','tr', function () {
	 var aData = oTable.fnGetData(this);
	 if(aData != null){
	 	// Set value form after select table for update data
	 	$('#images_id').val(aData[5]);
		$('#remove_images_id').val(aData[5]);
		$('#images_markers_id').val(aData[4]);
		
	 	$('#images_name').val(aData[0]);
	 	$('#images_desc').val(aData[1]);

		
 		if($(this).hasClass('row_selected')) {
            $(this).removeClass('row_selected');
			// clear data form
			$(':hidden','#remove-form').val('');
			$(':hidden','#submit-form').val('');
			$('#btn-update').attr("disabled","disabled");
			$('#btn-remove').attr("disabled","disabled");
			$('#btn-add-image').attr("disabled","disabled");
        } else {
            oTable.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
			$('#btn-update').removeAttr("disabled");
			$('#btn-remove').removeAttr("disabled");
			$('#btn-add-image').removeAttr("disabled");
        }
	  }
	});
});
</script>