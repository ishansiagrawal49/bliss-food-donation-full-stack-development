$(function(){
    function myFunction(x) {
        if (x.matches) { // If media query matches
           width_animate="20%";
           $('.hide_mobile').hide();
        } else {
            width_animate="5%";
        }
    }
    
    var x = window.matchMedia("(max-width: 600px)")
    myFunction(x) // Call listener function at run time
    x.addListener(myFunction) // Attach listener function on state changes
    $(".link_page,#get_started").click(function(event){
    if($(this).hash!=="")
    {
      event.preventDefault();
  
    var hash=this.hash;
    $('html,body').animate({
      scrollTop: $(hash).offset().top
    },800,function(){
      window.location.hash=hash;
    }
  
    );
    }
    }
    );
    $(window).scroll(function(){
  if($(document).scrollTop()>=2300){
 
      $("body").css({
          "background-image":"url('https://ak2.picdn.net/shutterstock/videos/15772012/thumb/1.jpg')"
      });


  }
  else
  {
      $("body").css({
          "background-image":"url('back3.jpg')"
      });
  }
    });
  //   $(window).scroll(function(){
  // if($(".nav").offset().top==0){
  //     $(".nav").css({
  //         "background-color":"transparent"
  //     });
  // }
  // else{
  //     $(".nav").css({
  //         "background-color":"rgba(240,128,128,0.95)"
  //     });
  
  // }
  //   });
    // $(window).scroll(function(){
    //   var x=$(document).scrollTop();
    //   var y=$("#about").offset().top;
    //   if(x>=y||y>=x+10){
    //     $(".side_nav").show();
    //   }
    //   else{
    //     $(".side_nav").hide();
    //   }
    // });
    function restore_hover(){
      $(".link_page").hover(function(){
          $(this).css({
              "border-bottom":"4px solid yellow"
          }) ;      
      },
  function(){
      $(this).css({
          "border-bottom":""
      }) ;  
  }
  
  );
    }
    $("#icon_center2").hide();
    $("[name='icon']").each(
      function(){
      $(this).hide();
    }
    );
    function gun(){
      $("#icon_center").hide();
      $("#icon_center2").show();
    $(".side_nav").animate(
      {
        height:"50vh",
        width:width_animate
      },1000,function(){
        $("[name='icon']").fadeIn();
      }
    );
    
  }
  function fun(){
    $("[name='icon']").hide();
    $(".side_nav").animate(
      {
        height:"7vh",
        width:width_animate
      },1000,function(){
          $("#icon_center").show();
          $("#icon_center2").hide();
      }
    );
  }
  var count=0;
  $(".side_nav").click(
  function(){
    count++;
    if(count%2==1)
    gun();
    else
    fun();
  }
  );


  //////////////////////////////////////////
  function gun2(){
  
  $(".side_nav_menu").animate(
    {
      height:"50vh",
      width:"100%"
    },1000,function(){
      $(".side_nav_list").fadeIn();
    }
  );
  
}
function fun2(){

  $(".side_nav_menu").animate(
    {
      height:"8vh",
      width:"100%"
    },1000,function(){
        $(".side_nav_list").hide();
    }
  );
}
var count2=0;
$(".side_nav_menu").click(
function(){
  count2++;
  if(count2%2==1)
  gun2();
  else
  fun2();
}
); 
 
  //////////////////////////////////////////
  $(".side_nav").hover(function(){
      $("#icon_center").addClass("hoverme");
      $("#icon_center2").addClass("hoverme");
  },
  function(){
      $("#icon_center").removeClass("hoverme");
      $("#icon_center2").removeClass("hoverme");
  });
  
  $(window).scroll(function(){
  
     
  for(var k=0;k<6;k++)
  {
      
  var k1=$("[name='nav_element']").eq(k).offset().top;
  var k2=$(document).scrollTop();
  
  if(k2>k1-200&&k2<k1+600){
      $(".link_page").eq(k).css({
          "border-bottom":"4px solid yellow"
      });
   
  
  }
  else{
      $(".link_page").eq(k).css({
          "border-bottom":"none"
      });
      counter=0;
      restore_hover();
      // $(".link_page").eq(k).hover(
      //     function(){
      //         $(".link_page").eq(k).css({
      //             "border-bottom":"4px solid yellow"
      //         });
      //     },function(){
      //         $(".link_page").eq(k).css({
      //             "border-bottom":"4px solid yellow"
      //         });
      //     }
      // );
  }
  }
  });
  $(".tab-button_tabs").hover(function(){
  $(".fa-sign-in-alt").addClass('hoverme');
  
  },
  function(){
      $(".fa-sign-in-alt").removeClass('hoverme');   
    
  });
  $(".tab-button").hover(function(){
      $(".fa-angle-double-right").addClass('hoverme');
      
      },
      function(){
          $(".fa-angle-double-right").removeClass('hoverme');   
        
      });
      $(".container_black,.container_black2").hide();
      $(".show_video").click(function(){
          // alert('hey');
          $(".container_black,iframe,.close_video").slideDown();
          $(".container_black").click(function(event2){
              // $("[name='if1']").stopVideo();
              $("[name='if1']")[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
          
              if((!$(this).hasClass("show_video"))&&(!$(event2.target).is("iframe")))
              $(".container_black,iframe,.close_video").slideUp();
          });
      });

      $(".show_team").click(function(){
        // alert('hey');
        $(".container_black2,.team_member").slideDown();
        $(".container_black2").click(function(event2){
            // $("[name='if1']").stopVideo();
           
        
            if((!$(this).hasClass("show_team"))&&(!$(event2.target).hasClass('team_member')))
            $(".container_black2,.team_member").slideUp();
        });
    });
  });