$(function(){
$(document).scroll(function(){
var x=$(document).scrollTop();
var y=Math.floor(x/1500);
if(y%2==0){
    // $('.bcg').css({
    //     "content":"url('http://backgroundcheckall.com/wp-content/uploads/2017/12/blur-background-photography-hd-3.jpg')"
    // });
//  $(".bcg").attr("src",'img_(web)_a.jpg');
$(".image_container").css({
    "background": "#1D976C",  /* fallback for old browsers */
    "background": "-webkit-linear-gradient(to right, #93F9B9, #1D976C)",  /* Chrome 10-25, Safari 5.1-6 */
    "background": "linear-gradient(to right, #93F9B9, #1D976C)" /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    
});
}
else{
    // $('.bcg').css({
    //     "content":"url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTokkaGIOsGxiF9TfGozs9UCyYmk3Urfz6b4mH9Vc2PmSHWaScu')"
    // });
    // $(".bcg").attr("src","img_(web)_b.jpg");
    $(".image_container").css({
"background": "#085078",  /* fallback for old browsers */
"background": "-webkit-linear-gradient(to right, #85D8CE, #085078)",  /* Chrome 10-25, Safari 5.1-6 */
"background": "linear-gradient(to right, #85D8CE, #085078)" /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        
    });
}
});
});