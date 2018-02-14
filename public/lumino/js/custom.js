$('#calendar').datepicker({});

! function ($) {
	$(document).on("click", "ul.nav li.parent > a ", function () {
		$(this).find('em').toggleClass("fa-minus");
	});
	$(".sidebar span.icon").find('em:first').addClass("fa-plus");
}

(window.jQuery);
$(window).on('resize', function () {
	if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
})
$(window).on('resize', function () {
	if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
})

$(document).on('click', '.panel-heading span.clickable', function (e) {
	var $this = $(this);
	if (!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('em').removeClass('fa-toggle-up').addClass('fa-toggle-down');
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('em').removeClass('fa-toggle-down').addClass('fa-toggle-up');
	}
})

$(function(){
	$.fn.editable.defaults.ajaxOptions = { type: "PUT" };
	$('.editable').editable({
		params: function(params) {
			params._token = $('meta[name=csrf-token]').attr('content')
			return params;
		},
		error: function(response, val) {
			return response.responseJSON.message
		}
	})
})

$(function(){
	$('a.open-notification').click(function(){
		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '/admin/notification/read',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				$('span.notification-count').text(response.total)
			},
			error: function(response) {
				console.log(response)
			}
		})
	})
})