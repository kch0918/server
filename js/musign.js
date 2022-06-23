$(function(){
	fix()
	$(window).scroll(function(){
		fix()
	})
	function fix(){
		var chk = $(window).scrollTop();
		if(chk > 100){
			$("#header").addClass("fixed");
		}else{
			$("#header").removeClass("fixed");
		}
	}
})
$(function(){
	$(".tab-wr").each(function(){
		var btn = $(this).find(".tab-ul > li");
		var cont = $(this).find(".tab-cont > div");
		
		btn.mouseenter(function(){
			var ind = $(this).index();
			btn.removeClass("active");
			$(this).addClass("active");
			cont.removeClass("active");
			cont.eq(ind).addClass("active");
		})
	})
})



$(window).ready(function(){
	var wh = $(window).innerHeight();
	$("#header_left ul").width(wh);
});

$(window).ready(function(){
	$(".step-mo .tab- div > .sp").click(function(){
		var idx = $(this).index();
		$(".step-mo .tab- .sp").removeClass("on");
		$(this).addClass("on");
		$(".tab-view > div > .spv").hide();
		$(".tab-view > div > .spv").eq(idx).show();
	});
});

$(window).ready(function(){
	$(".nav-big-menu").click(function(){
		$("html").toggleClass("menu-all-open")
	})
});





$(function(){
	classAdd();

	$(window).on("scroll", function(){
		
		if($(".main-sec").is(":animated")){
			return false;
		}else{

			$(".main-sec").each(function(i){
				var object =  $(this).offset().top ;
				var top =  $(window).scrollTop() + $(window).height();
				
				if (  top > object+400)
				{
					$("#wrap > .main-sec").removeClass("fix-active");
					$(this).addClass("fix-active");
					$(this).addClass("fix-text-active");
				}
			});
		
			var act = $("#wrap ").children(".fix-active").index();
			$("html").removeClass("fix-active-"+(act-1));
			$("html").removeClass("fix-active-"+(act-2));
			$("html").removeClass("fix-active-"+(act-3));
			$("html").removeClass("fix-active-"+(act-4));
			$("html").removeClass("fix-active-"+(act+1));
			$("html").removeClass("fix-active-"+(act+2));
			$("html").removeClass("fix-active-"+(act+3));
			$("html").removeClass("fix-active-"+(act+4));
			$("html").addClass("fix-active-"+act);
			$("html body #header_left .left_table li").eq(act-1).removeClass("on");
			$("html body #header_left .left_table li").eq(act+1).removeClass("on");
			$("html body #header_left .left_table li").eq(act).addClass("on");


		}
		if ($(window).scrollTop() == ($(document).height() - $(window).height()))
		{
			$(".left_table").hide();
		}else{
			$(".left_table").show();
		}
		
	});
	function classAdd(){
		$(".main-sec").each(function(i){
			var ind = $(this).index();
			setTimeout(function(){
				$(this).addClass("fix-section" + (i +1) );			
			},100);
		});


	}
})

















$(window).load(function(){
				
	var windowWidth = $(window).width();
	if(windowWidth < 767){
		
	$(".main-sec06 .part-wr").addClass("owl-carousel");
		var owl = $(".main-sec06 .owl-carousel");
		owl.owlCarousel({
			rtl:false,
			loop:true,
			mouseDrag: true,
			items:2,
			nav:true,
			margin:10,
			slideSpeed: 5000,
			paginationSpeed: 2000,	
			responsive:{
				0:{
					items:1
				},
				767:{				
					items:2
				}
			}
		})

	}
});