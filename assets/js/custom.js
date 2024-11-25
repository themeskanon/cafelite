(function( $ ) {
    "use strict";

    function theme_sidebar() {
	    document.getElementById("openbtn").onclick = function() {
	        openNav();
	    };

	    function openNav() {
	        document.getElementById("mySidebar").style.width = "250px";
	        document.getElementById("main").style.marginLeft = "250px";
	        // $("#closebtn").fadeIn(1000); 
	    }

	    document.getElementById("closebtn").onclick = function() {
	        closeNav();
	    };

	    function closeNav() {
	        document.getElementById("mySidebar").style.width = "0";
	        document.getElementById("main").style.marginLeft = "0";
	        // $("#closebtn").fadeOut(500); 
	    }
	}	

    //Document ready function
    $(document).ready(function(){
        theme_sidebar();
    });

})(jQuery);