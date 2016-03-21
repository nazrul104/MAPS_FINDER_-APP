<!-- Content -->
<div style="font-size:15px; color: #999999; padding-bottom: 15px; float:left;">LOCATION LIST</div>
<div style="float:right;">
	<div class="menu">
		<a href="#view"><button id="btn-view">View</button></a> 
		<a href="#form"><button id="btn-insert">Insert</button></a> 
		<a href="#form"><button id="btn-update" disabled="disabled">Update</button></a>
		<button id="btn-remove" disabled="disabled">Remove</button>
		<button id="btn-filter" value="on">Filter</button>
		<button id="btn-add-image" disabled="disabled" onClick="openPages('images/index')">Images</button>
		<button id="btn-add-times" disabled="disabled" onClick="openPages('times/index')">Times</button>
	</div>
</div>

<div class="mainview view">
	<div id="map" style="display:none;">
	  	<div id="panel" style="margin-left: -260px">
      		<input id="searchTextField" type="text" size="50">
      		<input type="radio" name="type" id="changetype-all" checked="checked">
      		<label for="changetype-all">All</label>
      		<input type="radio" name="type" id="changetype-establishment">
      		<label for="changetype-establishment">Establishments</label>
      		<input type="radio" name="type" id="changetype-geocode">
      		<label for="changetype-geocode">Geocodes</lable>
			<a href="#form" id="btn-add-map"><button>Add</button></a>
			<div style="width: 630px; border-top: 1px #CCC dashed; margin-top: 5px; padding-top: 3px;">Address: <span id="show-address">none</span> | Lat: <span id="show-lat">none</span> | Lng: <span id="show-lng">none</span></div>
    	</div>
		<br>
    <div id="maps-canvas" style="height: 400px; width: 100%;"></div>
	
	</div>
	<div id="form" style="display:none; padding-bottom:45px;">
		<form method="post" id="submit-form" action="location_list/insert" enctype="multipart/form-data">
		<input type="hidden" name="markers_id" id="markers_id">
		<br /><br />
		<div class="innert-list">
    		<h1>Name</h1>
    		<div class="corner">
    			<input type="text" name="markers_name" id="markers_name">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Category</h1>
    		<div class="corner">
				<select id="markers_category_id" name="markers_category_id">
        		</select>
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Phone</h1>
    		<div class="corner">
    			<input type="text" name="markers_phone" id="markers_phone">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Url</h1>
    		<div class="corner">
    			<input type="text" name="markers_url" id="markers_url">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Logo</h1>
    		<div class="corner">
    			<input type="file" name="markers_logo" id="markers_logo">
    		</div>
    	</div>
		<!--<div class="innert-list">
    		<h1>Catalogue</h1>
    		<div class="corner">
    			<input type="file" name="markers_catalogue" id="markers_catalogue">
    		</div>
    	</div>-->
		<div class="innert-list">
    		<h1>Address</h1>
    		<div class="corner">
    			<input type="text" name="markers_address" id="markers_address" style="width: 320px;" placeholder="Click icon to search location!"> <a id="btn-map" href="#map"> <span aria-hidden="true" data-icon="&#xe03d;" style="font-size:16px;"></span></a>
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Latitude</h1>
    		<div class="corner">
    			<input type="text" name="markers_lat" id="markers_lat" style="width: 320px;">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Longitude</h1>
    		<div class="corner">
    			<input type="text" name="markers_lng" id="markers_lng" style="width: 320px;">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Description</h1>
    		<div class="corner">
    			<input type="text" name="markers_desc" id="markers_desc" style="width: 320px;">
    		</div>
    	</div>
		<div class="innert-list">
    		<h1>Aktif</h1>
    		<div class="corner">
				<select id="markers_aktif" name="markers_aktif">
					<option value="No">No</option>
					<option value="Yes">Yes</option>
        		</select>
    		</div>
    	</div>		
		<div class="innert-list">
    		<h1>Language</h1>
    		<div class="corner">
				<select id="markers_lan" name="markers_lan">
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
				<th width="20%">Name</th>
				<th width="15%">Category</th>
				<th width="15%">Phone</th>
				<th width="20%">Url</th>
				<th width="20%">Address</th>
				<th width="20%">Language</th>
				<th width="20%">Aktif</th>
			</tr>
		</thead>
		<tfoot id="form_filter" style="display:none">
			<tr align="center">
				<th>Name</th>
				<th>Category</th>
				<th>Phone</th>
				<th>Url</th>
				<th>Address</th>
				<th>Language</th>
				<th>Aktif</th>
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
			 		<form method="post" id="remove-form" action="location_list/remove">
                		<div class="action-area-right">
                  			<div class="button-strip">
				   				<input type="hidden" name="remove_location_list_id" id="remove_location_list_id">
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
	/** Get Maps **/
	$('#btn-map').click(function() {
		setTimeout("initialize()", 500);
	});

	/* Menu transition */
	$('#btn-map,#btn-add-map,.menu a').click(function(ev) {

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
		$('#markers_id').val('');
		$("#submit-form")[0].reset();		
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

	/** Get request data category  **/
	getRequest("location_list/get_category", function(data) {
         
        var data = JSON.parse(data.responseText);
    
        for (var i = 0; i < data.length; i++) {
			$("#markers_category_id").append("<option value="+data[i].category_id+">"+data[i].category_name+"</option>");
        }

    });

	/** Get request data language  **/
	getRequest("category/get_language", function(data) {
         
        var data = JSON.parse(data.responseText);
    
        for (var i = 0; i < data.length; i++) {
			$("#markers_lan").append("<option value="+data[i].language_code+">"+data[i].language_name+"</option>");
        }

    });
	
	function getRequest(url, callback) {
    	var request;
    	if (window.XMLHttpRequest) {
       		request = new XMLHttpRequest();
    	} else {
        	request = new ActiveXObject("Microsoft.XMLHTTP");
    	}
		
    	request.onreadystatechange = function() {
        	if (request.readyState == 4 && request.status == 200) {
            	callback(request);
				$('.loading').hide();
        	}
    	}
    	request.open("GET", url, true);
    	request.send();
	}

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
 		openPages('location_list');
		alert(query);
	}
	
	/** Set datatables **/

	var oTable = $('#tabels').dataTable({
		"bProcessing": false,
		"bServerSide": true,
		"sAjaxSource": "location_list/get",
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
				        { type: "text" }]
		});

	/** Show detail data datatables **/
	
	function fnFormatDetails ( nTr )
		{

	
		 var aData = oTable.fnGetData( nTr );
		 if(aData != null){
					
				if(aData[12] == null){ 
				  
				  rating = 0; 
				
				}else{ 
					
				  rating = aData[12];
				
				}
				
			var sOut = '<table width="100%" height="100" border="0" cellpadding="0" cellspacing="0">';
  				sOut += '<tr>';
    			sOut += '<td width="10%" rowspan="7"><div align="center"><img src="<?php echo base_url(); ?>upload/logo/'+aData[7]+'" width="100" height="100"></div></td>';
				sOut += '<td width="10%"><strong>Latitude</strong></td>';
				sOut += '<td width="2%"><strong>:</strong></td>';
				sOut += '<td width="56%">'+aData[8]+'</td>';
				sOut += '</tr>';
				sOut += '<tr>';
				sOut += '<td><strong>Longitude</strong></td>';
				sOut += '<td><strong>:</strong></td>';
				sOut += '<td>'+aData[9]+'</td>';
				sOut += '</tr>';
				sOut += '<tr>';
				sOut += '<td><strong>Rating</strong></td>';
				sOut += '<td><strong>:</strong></td>';
				sOut += '<td><img src="<?php echo base_url(); ?>images/star/star_'+rating+'.png"></div></td>';
				sOut += '</tr>';
				sOut += '<tr>';
				sOut += '<td><strong>User Rating</strong></td>';
				sOut += '<td><strong>:</strong></td>';
				sOut += '<td>'+aData[12]+'</td>';
				sOut += '</tr>';
				sOut += '<tr>';
				sOut += '<td><strong>Description</strong></td>';
				sOut += '<td><strong>:</strong></td>';
				sOut += '<td>'+aData[10]+'</td>';
				sOut += '</tr>';
				sOut += '<tr>';
				sOut += '<td><strong>Created</strong></td>';
				sOut += '<td><strong>:</strong></td>';
				sOut += '<td>'+aData[15]+'</td>';
				sOut += '</tr>';
				sOut += '<tr>';
				sOut += '<td><strong>Created Date</strong></td>';
				sOut += '<td><strong>:</strong></td>';
				sOut += '<td>'+aData[16]+'</td>';
				sOut += '</tr>';
				sOut += '</table>';

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
	 	$('#add_images_marker_id').val(aData[11]);
		$('#markers_id').val(aData[11]);
		$('#remove_location_list_id').val(aData[11]);
		$('#add_images_marker_name').val(aData[0]);
		$('#markers_category_id > option[value="'+aData[12]+'"]').prop("selected", "selected");
	 	$('#markers_name').val(aData[0]);
		$('#markers_phone').val(aData[2]);
	 	$('#markers_url').val(aData[3]);
		$('#markers_address').val(aData[4]);
	 	$('#markers_lat').val(aData[8]);
		$('#markers_lng').val(aData[9]);
		$('#markers_desc').val(aData[10]);
		//$('#markers_lan').val(aData[5]);
		$('#markers_lan > option[value="'+aData[5]+'"]').prop("selected", "selected");
		
 		if($(this).hasClass('row_selected')) {
            $(this).removeClass('row_selected');
			// clear data form
			$(':hidden','#remove-form').val('');
			$('#btn-update').attr("disabled","disabled");
			$('#btn-remove').attr("disabled","disabled");
			$('#btn-add-image').attr("disabled","disabled");
			$('#btn-add-times').attr("disabled","disabled");
			
        } else {
            oTable.$('tr.row_selected').removeClass('row_selected');
            $(this).addClass('row_selected');
			$('#btn-update').removeAttr("disabled");
			$('#btn-remove').removeAttr("disabled");
			$('#btn-add-image').removeAttr("disabled");
			$('#btn-add-times').removeAttr("disabled");
        }
	  }
	});
});
</script>