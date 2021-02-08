$(function() {

    // add input listeners
    google.maps.event.addDomListener(window, 'load', function () {
        var from_places = new google.maps.places.Autocomplete(document.getElementById('address'));
        google.maps.event.addListener(from_places, 'place_changed', function () {
            var from_place = from_places.getPlace();
            var from_address = from_place.formatted_address;
            $('#origin').val(from_address);
        });

    });
        // alert("hello");
        
    // calculate distance
    // $('[type="text"]').focusin(function(){
       
    //     $(this).css({
    //         "border":"3px solid blue"
    //     });
    // });
    // $('[type="text"]').focusout(function(){
    //     $(this).css({
    //         "border":""
    //     });
    // });
});