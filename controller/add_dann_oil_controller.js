$(document).ready(function () {
    $('.user_btn_oil').click(function () {
            user_milage_day = $('.user_milage_day').val();
            user_milage_night = $('.user_milage_night').val();
            user_rashod_oil = $('.user_rashod_oil').val();
            user_day_oil = $('.user_day_oil').val();
            user_get_oil = $('.user_get_oil').val();
            auto = $('#i_auto').val();
            $.ajax({
                url: 'model/dann_oildb.php',
                type: 'POST',
                data: ({
                    user_milage_day: user_milage_day,
                    user_milage_night: user_milage_night,
                    user_rashod_oil: user_rashod_oil,
                    user_day_oil: user_day_oil,
                    user_get_oil: user_get_oil,
                    auto: auto
                }),
                success: function (data) {
                    if (data) {
                        $('.dann #error').html(data);
                    } else {
                        $.oil_raschet(user_milage_day,user_milage_night,user_rashod_oil,user_day_oil,user_get_oil);
                    }
                }
            })
        })
		    $('#i_auto').change(function () {
				enter_input = $('#i_auto').val();
				$.ajax ({
					url: 'model/dann_oildb.php',
					type: 'POST',
					data: ({enter_input: enter_input}),
					success: function(data) {
					    if(data) {
                            var obj = jQuery.parseJSON(data);
                            $('.user_milage_day').val(obj.probeg_night);
                            $('.user_day_oil').val(obj.ost_oil);
                            $('.user_rashod_oil').val(obj.rashod_oil);
                        } else {
                            $('.user_milage_day').val('');
                            $('.user_day_oil').val('');
                            $('.user_rashod_oil').val('');
                        }
					}
				        })
			})

});