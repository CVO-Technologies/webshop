//$(function () {
//	var closestForm = $('form')/*.closest('form')*/;
//	closestForm.on('change keydown keyup', function () {
//		var timerFunction = function (form) {
//			form.find('label').before('<i class="fa fa-refresh fa-spin load-icon"></i>');
//			$.ajax({
//				url: Croogo.basePath + 'webshop/address_details/check/' + 'Customer' + '.json?' + form.serialize(),
//				success: function (json) {
//					var fields = json.fields;
//
//					for (var fieldName in fields) {
//						var fieldOptions = fields[fieldName];
//
//						var field = $('[name="' + fieldOptions.name + '"]');
//						if (fieldOptions.disabled !== null) {
//							field.prop('disabled', fieldOptions.disabled);
//						}
//						if (fieldOptions.changed) {
//							field.val(fieldOptions.value);
//						}
//
//						field.closest('.form-group').removeClass('has-error')
//						for (var errorIndex in fieldOptions.errors) {
//							var error = fieldOptions.errors[errorIndex];
//
//							field.closest('.form-group').addClass('has-error');
//
//							alert(error);
//						}
//					}
//
//					form.find('.fa-refresh').removeClass('fa-spin');
//					form.find('.load-icon').remove();
//				}
//			});
//		};
//
//		if ($(this).data('change-lookup-timeout') !== null) {
//			clearTimeout($(this).data('change-lookup-timeout'));
//		}
//
//		$(this).data('change-lookup-timeout', setTimeout(timerFunction, 250, $(this)));
//	});
//	$(document).on('change', '#CustomerType', function () {
//		$('#CustomerVatNumber').toggle($(this).val() !== 'individual');
//		$('[for=CustomerVatNumber]').toggle($(this).val() !== 'individual');
//
//		$('#CustomerContactName').prop('disabled', $(this).val() === 'individual');
//	});
//	$(document).on('change keyup keydown', '#CustomerName', function () {
//		if ($('#CustomerType').val() !== 'individual') {
//			return;
//		}
//		$('#CustomerContactName').val($(this).val());
//	});
//	$('#CustomerType').change();
//})

$(function () {
	var reloadAddressDetailLists = function () {
		var wasDisabled = $('[data-model="AddressDetail"]').attr('disabled');
		if (!wasDisabled) {
			$('[data-model="AddressDetail"]').attr('disabled', true);
		}

		$.ajax({
			url: Croogo.basePath + 'panel/webshop/address_details.json',
			success: function (json) {
				var addressDetailInput = $('[data-model="AddressDetail"]');
				addressDetailInput.empty();
				$.each(json.addressDetails, function(index, addressDetail) {
					addressDetailInput
						.append($("<option></option>").attr('value', addressDetail.AddressDetail.id).text(addressDetail.AddressDetail.name));
				});

				if (!wasDisabled) {
					$('[data-model="AddressDetail"]').attr('disabled', false);
				}
			}
		});
	};
	var hookAddressDetailModalEvents = function () {
		$('.modal-overall .modal-content').find('form').on('submit', function (event) {
			var data = {};
			$.each($(this).serializeArray(), function (index, value) {
				data[value.name] = value.value;
			});

			$('.modal-overall .modal-content').load($(this).attr('action'), data, function (html) {
				hookAddressDetailModalEvents();

				console.log(html.indexOf('<form'));
				if (html.indexOf('<form') !== -1) {
					return;
				}

				reloadAddressDetailLists();
				$('.modal-overall').modal('hide');
			});

			event.preventDefault();
		});
	};
	$(document).on('click', '.add-address-detail', function () {
		$('.modal-overall .modal-content').load(Croogo.basePath + 'panel/webshop/address_details/add?modal=true', function () {
			hookAddressDetailModalEvents();
		});
		$('.modal-overall').modal();
	});
});
