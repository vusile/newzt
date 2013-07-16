
function captchaRefreshBL() {

		var btn = this;


		$.ajax({
			type:"POST",
			dataType: "json",
			url:"http://localhost/zoomtanzania/generateCaptcha/1",
			success: function(data) {

				$(".captcha-imageBL").html(data.image);
			},

			error: function (data)
			{
				alert(data.image);
			}
		});	
	}

$(document).ready(function() {
	
		$('.ELLink').click(function() {
			
				// captchaRefresh();
				$("#EmailForm").show("slow");
			  	$(".container").hide("slow");
			  	$(".addthis_toolbox").hide("slow");
			  	$(".listlogo").hide("slow");
			  	$(".list").hide("slow");
			
		});
		
		$("#CancelEmailForm").click(function() {
			$("#EmailForm").hide("slow");
		  	$(".container").show("slow");
		  	$(".addthis_toolbox").show("slow");
		  	$(".listlogo").show("slow");	

		});
		$("#CancelLoginToApplyForm").click(function() {
			$("#LoginToApplyForm").hide("slow");
		  	$(".listings").show("slow");
		});
		$("#CancelJobLimitPerDayReached").click(function() {
			$("#JobLimitPerDayReached").hide("slow");
		  	$(".listings").show("slow");
		});
		$("#CancelCodeOfConductForm").click(function() {
			$("#CodeOfConductForm").hide("slow");
		  	$(".listings").show("slow");
		});
		
	$('.BLLink').click(function() {
		captchaRefreshBL();
		$("#BadListingForm").show("slow");
		$("#BadListingDiv").hide("slow");
	  	$(".listings").hide("slow");
	});
	$("#CancelBadListingForm").click(function() {
		$("#BadListingForm").hide("slow");
	  	$(".listings").show("slow");	
		$("#BadListingDiv").show("slow");		
	});

	$('#ELForm').submit(function(){
            var files = $('#ELForm input:file');
            var count=1;
            files.attr('name',function(){return this.name+''+(count++);});
            $('#fileCount').val(count-2);
        });


	$(".captcha-refresh").click(captchaRefreshBL);

	$('.ListingIDs').click(function() {	
					if ($("input[type=checkbox][name=ListingIDs]:checked").length > 6) {
						alert('Choose up to 6 businesses only.');
						return false;
					}
				});
			


});


