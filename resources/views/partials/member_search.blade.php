<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2OJukM41NiEP_KnDGkx4mQ6HSucCuhwI"></script>
<script>
	(function() {
		"use strict";

		var mapOptions = {
			zoom: 10,
			center: {
				lat:  29.426791,
				lng: -98.489602
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		var map = new google.maps.Map(document.getElementById("map"), mapOptions);
		var geocoder = new google.maps.Geocoder();
		var address = "{{ $current_user_address }}";

		geocoder.geocode( {'address': address}, function(results, status) {
			if(status == google.maps.GeocoderStatus.OK) {
				new google.maps.Marker({
					position: results[0].geometry.location,
					map: map
				});
				map.setCenter(results[0].geometry.location);
			}
		});


		function getSearchResults(){
			$.ajax("{{ action('CompaniesController@getSearchedCompanies') }}", {
				type: "GET",
				data: {
					'searchField': $('#searchField').val(),
					'industry_id': $('#industry_id').val(),
					'organization': ($('#organization').prop('checked')) ? 1 : 0,
					'woman_owned': ($('#woman_owned').prop('checked')) ? 1 : 0,
					'family_owned': ($('#family_owned').prop('checked')) ? 1 : 0,
					'contractor':( $('#contractor').prop('checked')) ? 1 : 0,
				}
			}).done(function(data){
				// console.log(data);
				var search_results = data.results;
				var businesses = data.locations;
					businesses.forEach(function(business) {
						var address = business.address_line_1 + ' ' + business.city + ' ' + business.state + ' ' + business.zip;
						geocoder.geocode({ "address": address }, function (results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
								var marker = new google.maps.Marker({
									position: results[0].geometry.location, 
									map: map, 
									animation: google.maps.Animation.DROP,
									draggable: false
								});
								var infoWindow = new google.maps.InfoWindow({
									content: "<p>" + business.company_id + "</p>" + "<p>" + business.user_id + "</p>"
								});
								marker.addListener('click', function() {
									map.setCenter(results[0].geometry.location);
									infoWindow.open(map, marker);
								});
							} else {
								console.log(address);
								alert("Geocoding was not successful - STATUS: " + status);
							}
							
							$('#results').html("");
							search_results.forEach(function(result){
								$('#results').append("<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6\"><div class=\"row\"><div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3\"><a href=\"" + result.url + "><img class=\"img-circle center-block img-responsive\" src=\"/img/profile_photo_template.png\"></a></div><div class=\"col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8\"><p class=\"company_name\">" + result.name + "</p><p class=\"industry_name\">" + result.industry.industry + "</p><p class=\"company_desc\">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p></div></div></div>") + $("#results");
							});
						});	
					});
				});
		}		

		getSearchResults();

		$('#search_form').submit(function(e){
			alert("triggered");
			e.preventDefault();
			getSearchResults();
		})

	})();
</script>