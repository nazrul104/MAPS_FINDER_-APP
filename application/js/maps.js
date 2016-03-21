// Set url service app
var urlRequest = "http://celebeslab.pusku.com/";
var urlService  = urlRequest+"index.php/";
// Set maps variabel
var map,
	myLat,
	myLong,
	myRadius,
	userLocation,
	address,
	panorama,
	streetPlace,
	propertys,
	catalogue,
	ratingCek = 0,
	listClear = 0,
	listStart = 0,
	nearbyClear = 0,
	nearbyStart = 0,
	indexID = 0,
	lang = 'en';

var geocoder = new google.maps.Geocoder();
var infowindow = new google.maps.InfoWindow();
var bounds = new google.maps.LatLngBounds();
var directionsService = new google.maps.DirectionsService();
var directionsDisplay = new google.maps.DirectionsRenderer();
var markers = [];

	getSettings = localStorage.getItem("lang-form");
	if(getSettings != null){
		$.MultiLanguage('language.json',getSettings);
		var lang = getSettings;
	}else{
		$.MultiLanguage('language.json','en');
		
	}

//First Run
myGeoloc();
getDash();
getLang();

var slider = $('.bxslider').bxSlider({
				auto : true,
				mode: 'fade',
				infiniteLoop : true,
				touchEnabled : true,
				controls : false,
				pager : false,
				captions: true
			});
			
// Get detection user location  
function myGeoloc(){

	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(myGeolocSuccess, myGeolocError,{enableHighAccuracy:true});
	} else {
		error('Geolocation not supported');
	}

}

// Get user location 
function myGeolocSuccess(position) {

	myLat   = position.coords.latitude;
    myLong  = position.coords.longitude;
	myRadius  = position.coords.accuracy;

 	userLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
    geocoder.geocode( { 'latLng': userLocation}, function(results, status) {
    	if (status == google.maps.GeocoderStatus.OK) {

			address =  results[0].formatted_address;
			
    	}
	
	var pw 	= $(window).width(); 
	
	//Generate location images
	$("#page_home .slider ul").empty();
	$("#page_home .slider ul").append('<li><img src="http://maps.googleapis.com/maps/api/staticmap?center='+myLat+','+myLong+'&markers=color:blue|label:S|'+myLat+','+myLong+'&zoom=15&size='+pw+'x260&sensor=false"></li>');
	$("#page_home .slider ul").append('<li><img src="http://maps.googleapis.com/maps/api/streetview?size='+pw+'x260&location='+myLat+','+myLong+'&fov=90&heading=235&pitch=10&sensor=false"></li>');
    });
	
	// Set marker location user
   	var marker = new google.maps.Marker({
            map: map,
			icon: "img/pin/pin2.png",
            position: userLocation,
			animation: google.maps.Animation.DROP,
            title: location.nama
        });
	
	// Set accuracy location user
	var circle = new google.maps.Circle({
  		center: userLocation,
  		radius: position.coords.accuracy,
  		map: map,
  		fillColor: '#FF3300',
  		fillOpacity: 0.2,
  		strokeColor: '#FF3300',
  		strokeOpacity: 0.4
	});

	markers.push(marker);
		
}

// Get user location not found
function myGeolocError() {
	 log('Location Not Found!');
}

// Set maps properties
function init(req,status,street) {
	
	if(!req){
     	var req = '';
	}

	if(!category){
     	var category = '';
	}
	
	var mapOptions = {
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
     
	// Set id to display maps
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
	// Request result directions maps
    if(status == 1){

		directionsDisplay.setMap(map);
   		directionsDisplay.setPanel(document.getElementById('directions-route'));

	}else{

    	directionsDisplay.setMap(null);
		$('#directions_panel').empty();
		
	}		
	
	if($('#toggle-traffic-layer').prop('checked')){
		// Display traffic layer maps
  		var trafficLayer = new google.maps.TrafficLayer();
 		trafficLayer.setMap(map);
	}
	
	if($('#toggle-weather-layer').prop('checked')){
		// Display weather layer maps
		var weatherLayer = new google.maps.weather.WeatherLayer({temperatureUnits: google.maps.weather.TemperatureUnit.celsius});
  		weatherLayer.setMap(map);
	}

  	if($('#toggle-panoramio-layer').prop('checked')){
  		// Display panoramio layer maps
  		var panoramioLayer = new google.maps.panoramio.PanoramioLayer();
  		panoramioLayer.setMap(map);
  	}
	
	if($('#toggle-transit-layer').prop('checked')){
		// Display transit layer maps
    	var transitLayer = new google.maps.TransitLayer();
  		transitLayer.setMap(map);
  	}
	
	if($('#toggle-bike-layer').prop('checked')){
		// Display bike layer maps
    	var bikeLayer = new google.maps.BicyclingLayer();
  		bikeLayer.setMap(map);
  	}
	
  	panorama = map.getStreetView();
  	panorama.setPosition(streetPlace);
  	panorama.setPov(({
    	heading: 265,
    	pitch: 0
  	}));
  	
	if (street == "true") {
    	panorama.setVisible(true);
  	} else {
    	panorama.setVisible(false);
  	}
	
  	// Set url requst maps data
		var url = urlService+'service/get_maps?clear='+req+'&lang='+lang;

	// Get request data
    getRequest(url, function(data) {
         
        var data = JSON.parse(data.responseText);
    
        for (var i = 0; i < data.length; i++) {
            displayLocation(data[i]);
        }
		if(!req){
			map.fitBounds(bounds);
    		map.panToBounds(bounds);
		}
    });
}

// Display maps markers 
function displayLocation(location) {

    var content =   '<div class="infoWindow"><strong>'  + location.markers_name + '</strong> <a class="btn-detail" transition="side" href="#page_show_location" onClick="detailShowLocation('+location.markers_id+')">[Detail]</a>'
                    + '<br/>('     + location.category_name
                    + ')<br/>'     + location.markers_address + '</div>';
     
    if (parseInt(location.markers_lat) == 0) {
        geocoder.geocode( { 'address': location.markers_address }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                 
                var marker = new google.maps.Marker({
                    map: map,
					icon: urlRequest+"upload/marker/"+location.category_marker,
                    position: results[0].geometry.location,
                    title: location.markers_name
                });
				
                bounds.extend(marker.position); 
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.setContent(content);
                    infowindow.open(map,marker);
                });
				markers.push(marker);
            }
        });
    } else {
         
        var position = new google.maps.LatLng(parseFloat(location.markers_lat), parseFloat(location.markers_lng));
        var marker = new google.maps.Marker({
            map: map,
			icon: urlRequest+"upload/marker/"+location.category_marker,
            position: position,
            title: location.markers_name
        });
        bounds.extend(marker.position); 
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(content);
            infowindow.open(map,marker);
        });
		markers.push(marker);
    }
}
 
// Get calculate route maps
function calculateRoute(lng,lat) {
	
	var destination = new google.maps.LatLng(lat,lng);
	
    var request = {
        origin: userLocation,
        destination: destination,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
	
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}
 
function getRequest(url, callback) {
	$('.loading').show();
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

function getCalculateRoute(lng,lat){
	window.location.href = "#page_location_map";
	setTimeout('init("false","1")',2500);
	calculateRoute(lng,lat)
}

function getLocationRoute(lng,lat){
	window.location.href = "#page_location_route";
	init("false","1");
	setTimeout('init("false","1")',2500);
	calculateRoute(lng,lat);
}
	
function getDash(){
	$('#menu-dash').empty();
	var url = urlService+'service/get_dash?lang='+lang;
	getRequest(url, function(data) {
        var data = JSON.parse(data.responseText);         
        for (var i = 0; i < data.length; i++) {
            $('#menu-dash').append('<div class="grids" onClick="getLocationList('+data[i]["category_id"]+',0)"><a transition="side" href="#page_detail"><div class="fs2" aria-hidden="true" data-icon="'+data[i]["category_icon"]+'"></div><span>'+data[i]["category_name"]+'</span></div></div>');
		}

	});
}

function getLang(){
	var url = urlService+'service/get_lang';
	getRequest(url, function(data) {
        var data = JSON.parse(data.responseText);         
        for (var i = 0; i < data.length; i++) {
            $('#lang-form').append('<option value="'+data[i]["language_code"]+'">'+data[i]["language_name"]+'</option>');
		}
		getSettings = localStorage.getItem("lang-form");
		$('#lang-form option[value="'+getSettings+'"]').attr('selected','selected');
	});
}

function getLocationCategory(){
	$('#list-category').empty();
	var url = urlService+'service/get_category?lang='+lang;
	getRequest(url, function(data) {
        var data = JSON.parse(data.responseText);         
        for (var i = 0; i < data.length; i++) {
            $('#list-category').append("<li onClick='getLocationList("+data[i]['category_id']+",0)'><a transition='side' href='#page_detail'><div class='fs1' aria-hidden='true' data-icon='"+data[i]['category_icon']+"'></div><strong>"+data[i]['category_name']+"</strong><span class='chevron'></span><span class='count'>"+data[i]['count']+"</span></a></li>");
		}

	});
}

function getLocationCategoryMap(){
	$('#location_category_map').empty();
	var url = urlService+'service/get_category?lang='+lang;
	getRequest(url, function(data) {
        var data = JSON.parse(data.responseText);         
        for (var i = 0; i < data.length; i++) {
            $('#location_category_map').append("<li onClick='loadLocationCategoryMap("+data[i]['category_id']+")'><a transition='side' href='#page_location_map'><div class='fs1' aria-hidden='true' data-icon='"+data[i]['category_icon']+"'></div><strong>"+data[i]['category_name']+"</strong><span class='chevron'></span><span class='count'>"+data[i]['count']+"</span></a></li>");
		}

	});
}

function loadLocationCategoryMap(category_id){
	
	setTimeout('init("false")',1500);
	
	// Set url requst maps data
	var url = urlService+'service/get_maps?category='+category_id+'&lang='+lang;

	// Get request data
   getRequest(url, function(data) {
         
        var data = JSON.parse(data.responseText);
    
        for (var i = 0; i < data.length; i++) {
        	
        	var lon  		= data[i]['markers_lng'];
			var lat  		= data[i]['markers_lat'];
			var icon 		= data[i]['category_marker'];
			var name 		= data[i]['markers_name'];
			var category 	= data[i]['category_name'];
			var address 	= data[i]['markers_address'];
			var id			= data[i]['markers_id'];

         setTimeout('addMarkers('+lon+','+lat+',"'+icon+'","'+name+'","'+category+'","'+address+'","'+id+'")',1500);

        }

    });
	
 }
 
// Get geolocation list
function getLocationList(categoryId,listClear){
if(listClear == 0){
	listStart = 0;
	$('#list-detail').empty();
	}
	$('#search-list').val('');
	$('#category-id').val(categoryId);
	var limit = 10;

	if($('#toggle-nearby-distances').prop('checked')){
		var distances = "km";
	}else{
		var distances = "m";
	}
	
	var url = urlService+'service/get_list?id='+categoryId+'&limit='+limit+'&start='+listStart+'&lang='+lang+'&lon='+myLong+'&lat='+myLat+'&option='+distances;
	getRequest(url, function(data) {
        var data = JSON.parse(data.responseText); 
        for (var i = 0; i < data.length; i++) {
			var logo = urlRequest+"/upload/logo/"+data[i]['markers_logo'];
			$('#list-detail').append("<li class='btn-detail' onClick='detailShowLocation("+data[i]['markers_id']+")'><a transition='side' href='#page_show_location'><strong>"+data[i]['markers_name']+"</strong><p>"+data[i]['markers_address']+"</p><span class='distance'>"+data[i]['distance']+" "+ distances +"</span><div class='img-box'><img src='"+logo+"' width='60' height='60'></div></a></li>");
		}
	});
}

$('.wrapper-bar').scroll(function(){
	if($('.wrapper-bar').scrollTop() + $('.wrapper-bar').height()>=$(this)[0].scrollHeight){
			listStart++;
			getLocationList($('#category-id').val(),1);	
	}
});

// Get filter list
function getFilterList(categoryId){
	listStart = 0;
	var categoryId = $('#category-id').val();
	
	
	var limit = 10;
	if($('#toggle-nearby-distances').prop('checked')){
		var distances = "km";
	}else{
		var distances = "m";
	}
	
	if($('#search-dashboard').val() == ''){
		$('#list-detail').empty();
		var filter     = $('#search-list').val();
		var url = urlService+'service/get_list?id='+categoryId+'&limit='+limit+'&start='+listStart+'&lang='+lang+'&long='+myLong+'&lat='+myLat+'&option='+distances+'&q='+filter;
	}else{
		var filter     = $('#search-dashboard').val();
		$('#list-dashboard').empty();
		var url = urlService+'service/get_list?limit='+limit+'&start='+listStart+'&lang='+lang+'&long='+myLong+'&lat='+myLat+'&option='+distances+'&q='+filter;
	}
	
	getRequest(url, function(data) {
        var data = JSON.parse(data.responseText);        
	
        for (var i = 0; i < data.length; i++) {
		var logo = urlRequest+"/upload/logo/"+data[i]['markers_logo'];
		if($('#search-dashboard').val() == ''){
	       		$('#list-detail').append("<li class='btn-detail' onClick='detailShowLocation("+data[i]['markers_id']+")'><a transition='side' href='#page_show_location'><strong>"+data[i]['markers_name']+"</strong><p>"+data[i]['markers_address']+"</p><span class='distance'>"+data[i]['distance']+" "+ distances +"</span><div class='img-box'><img src='"+logo+"' width='60' height='60'></div></a></li>");
		}else{
			$('#list-dashboard').append("<li class='btn-detail' onClick='detailShowLocation("+data[i]['markers_id']+")'><a transition='side' href='#page_show_location'><strong>"+data[i]['markers_name']+"</strong><p>"+data[i]['markers_address']+"</p><span class='distance'>"+data[i]['distance']+" "+ distances +"</span><div class='img-box'><img src='"+logo+"' width='60' height='60'></div></a></li>");
		}
		}

	});
}


// Get nearby location
function getNearby(nearbyClear){

	var limit = 10;
	if($('#toggle-nearby-distances').prop('checked')){
		var distances = "km";
	}else{
		var distances = "m";
	}
	var url = urlService+'service/get_nearby?lat='+myLat+"&long="+myLong+"&option="+distances+'&limit='+limit+'&start='+nearbyStart+'&lang='+lang;

	getRequest(url, function(data) {
         var data = JSON.parse(data.responseText);
		   if(nearbyClear == 0){
				$('#list-nearby').empty();
				$('#list-nearby').append("<li class='list-dividers'>Near "+address+"</li>");
				nearbyStart = 0;

			} 

        for (var i = 0; i < data.length; i++) {
			var logo = urlRequest+"/upload/logo/"+data[i]['markers_logo'];
        	$('#list-nearby').append("<li class='btn-detail' onClick='detailShowLocation("+data[i]['markers_id']+")'><a transition='side' href='#page_show_location'><strong>"+data[i]['markers_name']+"</strong><p>"+data[i]['markers_address']+"</p><span class='distance'>"+data[i]['distance']+" "+ distances +"</span><div class='img-box'><img src='"+logo+"' width='60' height='60'></div></a></li>");
		}

	});
}

$('.wrapper').scroll(function(){
	if($('#wrapper-nearby').scrollTop() + $('#wrapper-nearby').height()>=$(this)[0].scrollHeight){
			nearbyStart++;
			getNearby(1);	
	}
});
   
	var now = Math.round(new Date().getTime() / 1000);
	
	var selected_index = -1;

	var tbSaveLocation = localStorage.getItem("tbSaveLocation");

	tbSaveLocation = JSON.parse(tbSaveLocation); 

	if(tbSaveLocation == null)
		tbSaveLocation = [];

	function addMyLocation(){
		var client = JSON.stringify({
			Title : $("#form-title").val(),
			Desc : $("#form-desc").val(),
			Lon : myLong,
			Lat : myLat,
			Location : address,
			Dates : now
		});
		
		tbSaveLocation.push(client);
		localStorage.setItem("tbSaveLocation", JSON.stringify(tbSaveLocation)); 
		alert("The data was saved.");
		return true;
	}


	function listMyLocation(){
	
		$('#list-save-location').empty();
		$('.loading').hide();
		$('#show-location-address').html("Near : "+address);
		for(var i in tbSaveLocation){
			var cli = JSON.parse(tbSaveLocation[i]);
			
			var date = new Date(cli.Dates * 1000);
			
			$('#list-save-location').append("<li><span onClick='detailListMyLocation("+i+")'><strong>"+cli.Title+"</strong><p>"+date.toLocaleString()+"</p></span><a onClick='deleteMyLocation("+i+");' class='button-negative'>Delete</a></li>");

		}
	}

	function detailListMyLocation(selected_index){
		
		window.location.href = "#page_detail_save_location";
		
		var cli 	= JSON.parse(tbSaveLocation[selected_index]);
		var date 	= new Date(cli.Dates * 1000);
		var pw 		= $(window).width(); 
		
		$("#page_detail_save_location .slider ul").empty();
		$("#page_detail_save_location .slider ul").append('<li><img src="http://maps.googleapis.com/maps/api/staticmap?center='+cli.Lat+','+cli.Lon+'&markers=color:blue|label:S|'+cli.Lat+','+cli.Lon+'&zoom=15&size='+pw+'x220&sensor=false"></li>');
		$("#page_detail_save_location .slider ul").append('<li><img src="http://maps.googleapis.com/maps/api/streetview?size='+pw+'x230&location='+myLat+','+myLong+'&fov=90&heading=235&pitch=10&sensor=false"></li>');
		
		$("#date-save-location").html(date);
		$("#title-save-location").html(cli.Title);
		$("#address-save-location").html(cli.Location);
		$("#desc-save-location").html(cli.Desc);
		$("#button-save-location").html('<a onClick="getMyLocationMap('+cli.Lon+','+cli.Lat+')" class="button-positive button-block" href="#page_location_map">Map View</a>');
	}
	
	function catalogueDownload(){
			window.open(urlRequest+'upload/catalogue/'+catalogue,'_blank');
	}
	
	function detailShowLocation(id){
		$('.bxslider').empty();
		$('#comment').empty();
		
		var url = urlService+'service/get_detail?id='+id+'&lang='+lang;

				var urlGetImages = urlService+'service/get_images?id='+id;
				
				getRequest(urlGetImages, function(dataImages) {

        			var dataImages = JSON.parse(dataImages.responseText);    
						
        				for (var i = 0; i < dataImages.length; i++) {
							$('.bxslider').append('<li><img src="'+urlRequest+'upload/images/'+dataImages[i]['images_url']+'" title="'+dataImages[i]['images_desc']+'" /></li>');
						}
						slider.reloadSlider();
				});
				
		getRequest(url, function(data) {
        	var data = JSON.parse(data.responseText);        
        	for (var i = 0; i < data.length; i++) {

        		var lon  		= data[i]['markers_lng'];
				var lat  		= data[i]['markers_lat'];
				var icon 		= data[i]['category_marker'];

				var name 		= data[i]['markers_name'];
				var category 	= data[i]['category_name'];
				var address 	= data[i]['markers_address'];
				var id 			= data[i]['markers_id'];
				var total 	    = data[i]['total'];
					catalogue 	= data[i]['markers_catalogue'];
				
				$('#add_comment').attr('rel',data[i]['markers_id']);
				$('#rating-now').attr('rel',data[i]['markers_id']);
				
				if(catalogue == ''){
					$('#download').hide();
				}else{
					$('#download').show();
				}
				
				
				$('#rating-now').html('<div onClick="rateitSelected()" class="rateit bigstars" data-rateit-starwidth="32" data-rateit-starheight="32" data-rateit-value="'+total+'" data-rateit-ispreset="true" data-rateit-readonly="false" data-rateit-backingfld="#backing2"></div>');
				$('#backing2').val(total);
				$('#rating-now').find('.rateit').rateit();
			
				var urlGetComment = urlService+'service/get_comment?id='+data[i]['markers_id'];
				
				getRequest(urlGetComment, function(dataComment) {
											   
        			var data_comment = JSON.parse(dataComment.responseText);
						if(data_comment != ''){
							for (var i = 0; i < data.length; i++) {
							
								$('#comment').append('<blockquote class="bq1"><p>'+data_comment[i]['comment_value']+'</p></blockquote><p class="after">'+data_comment[i]['date']+' - '+data_comment[i]['comment_name']+'</p>');
							}
						}
				});
				
				$('#btn-show-map').attr('onClick','getShowLocation('+lon+','+lat+',"'+icon+'","'+name+'","'+category+'","'+address+'",'+id+')');
				$('#btn-show-street').attr('onClick','getStreetView('+data[i]['markers_lng']+','+data[i]['markers_lat']+')');
				$('#btn-show-directions').attr('onClick','getCalculateRoute('+data[i]['markers_lng']+','+data[i]['markers_lat']+')');
				$('#btn-show-route').attr('onClick','getLocationRoute('+data[i]['markers_lng']+','+data[i]['markers_lat']+')');
				
				$("#title-show-category").html(data[i]['category_name']);
				$("#title-show-name").html(data[i]['markers_name']);
				$("#title-show-phone").html("<a href='tel:"+data[i]['markers_phone']+"'>"+data[i]['markers_phone']+"</a>");
				$("#title-show-url").html('<span onClick="loadURL(\'http://'+data[i]['markers_url']+'\')">'+data[i]['markers_url']+'</span>');
				$("#title-show-address").html(data[i]['markers_address']);
				$("#title-show-desc").html(data[i]['markers_desc']);
				$("#title-show-open").html(data[i]['OPEN']);
				$("#title-show-close").html(data[i]['CLOSE']);

			}
			
			
		});
		
		$('.loading').hide();
	}
	
	function deleteMyLocation(selected_index){
		if (confirm('Are you sure you want to remove entry?')) {
			tbSaveLocation.splice(selected_index, 1);
			localStorage.setItem("tbSaveLocation", JSON.stringify(tbSaveLocation));
			listMyLocation();
		}
	}

	function addMarkers(lon,lat,icon,name,category,address,id){

    	var content =   '<div class="infoWindow"><strong>'  + name + '</strong> <a class="btn-detail" transition="side" href="#page_show_location" onClick="detailShowLocation('+id+')">[Detail]</a>'
                    	+ '<br/>('     + category
                    	+ ')<br/>'     + address + '</div>';
					
		if(icon){
			icon = urlRequest+"images/pin/"+icon;
		}else{
			icon = "img/pin/pin2.png";
		}
		var getLocation = new google.maps.LatLng(lat,lon);
		map.setCenter(new google.maps.LatLng(lat, lon));
		map.setZoom(15);
		
		var marker = new google.maps.Marker({
			map: map,
			icon: icon,
			position: getLocation,
			animation: google.maps.Animation.DROP,
			title: "Location"
		});
		   
		   google.maps.event.addListener(marker, 'click', function() {
           infowindow.setContent(content);
           infowindow.open(map,marker);
           });
						
		markers.push(marker);
  
	}
	
	function getMyLocationMap(lon,lat){
		
		setTimeout('init("false")',2500);
		setTimeout('addMarkers('+lon+','+lat+')',2500);
		
	}
	
	function getShowLocation(lon,lat,icon,name,category,address,id){
		
		window.location.href = "#page_location_map";
		setTimeout('init("false")',2500);
		setTimeout('addMarkers('+lon+','+lat+',"'+icon+'","'+name+'","'+category+'","'+address+'","'+id+'")',2500);
	}

	function getShowLocationCategoryMap(category_id){
		
		setTimeout('init("false")',2500);
		setTimeout('init("false","","",1)',2500);
	}

	function getStreetView(lon,lat){
		
		window.location.href = "#page_location_map";
		setTimeout('init("false","","true")',2500);
		streetPlace = new google.maps.LatLng(lat, lon);
	
	}

	function sendComment(){
		
		detailShowLocation($('#add_comment').attr('rel'));
	    
		var url = urlService+'service/send_comment?form-comment-name='+$("#form-comment-name").val()+'&form-comment='+$("#form-comment").val()+'&id='+$('#add_comment').attr('rel');
		$.get(url, function(data) {

        alert(data);

		});
	}
	
	function rateitSelected(){
		
		if(ratingCek == 0){
			
			ratingCek = 1;
			
			var url = urlService+'service/rating?score='+$('#backing2').val()+'&id='+$('#rating-now').attr('rel');
		
			$.get(url, function(data) {

				alert(data);

			});
		
			$(".rateit").rateit('readonly', true);
		}
	}
