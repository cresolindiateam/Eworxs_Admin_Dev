
$(document).ready(function() {
    $("#lat_area").hide();
    $("#long_area").hide(); 
   
});
/* $(document).ready(function() {*/
/* google.maps.event.addDomListener(window, 'load', initAutocomplete);*/
 window.addEventListener('load', (event) => { initAutocomplete(); });
function initAutocomplete() {
var input = document.getElementById('autocomplete');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.addListener('place_changed', function() {
var place = autocomplete.getPlace();
$('#latitude').val(place.geometry['location'].lat());
$('#longitude').val(place.geometry['location'].lng());
// --------- show lat and long ---------------
$("#lat_area").removeClass("d-none");
$("#long_area").removeClass("d-none");
$("#lat_area").show(); 
$("#long_area").show();
});
} 


/*});*/