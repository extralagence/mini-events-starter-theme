$(document).ready(function(){
	/**************************
	 *
	 *
	 *
	 *  TIMEPICKER
	 *
	 *
	 **************************/
	$('.field-time').each(function () {
		var $fieldTime = $(this),
			fieldTimeHourSeparator = $fieldTime.data('time-hour-separator'),
			fieldTimeMin = $fieldTime.data('time-min'),
			fieldTimeMax = $fieldTime.data('time-max')
			;

		var options = {
			slide: function( event, ui ) {
				$fieldTime.val(ui.value+fieldTimeHourSeparator+'00');
				resetErrors($fieldTime);
			}
		};

		if ($(this).val() != '') {
			var value = $(this).val(),
				hourArray = value.split(fieldTimeHourSeparator);

			if (hourArray.length > 0) {
				var intValue = parseInt(hourArray[0]);
				if (!isNaN(intValue)) {
					options.value = intValue;
				}
			}
		}

		if (fieldTimeMin != '') {
			var minHourArray = fieldTimeMin.split(fieldTimeHourSeparator);
			options.min = parseInt(minHourArray[0]);
		}
		if (fieldTimeMax != '') {
			var maxHourArray = fieldTimeMax.split(fieldTimeHourSeparator);
			options.max = parseInt(maxHourArray[0]);
		}

		var slider = $('<div class="slider-inner-wrapper"><div class="slider"></div></div>').insertBefore($fieldTime).find('.slider').slider(options);
		$fieldTime.change(function() {
			var value = $(this).val(),
				hourArray = value.split(fieldTimeHourSeparator);

			slider.slider('value', parseInt(hourArray[0]));
			resetErrors($(this));
		});

		function resetErrors($fieldTime) {
			var $field = $fieldTime.closest('.extra-field'),
				$error = $field.find('.error');
			$error.hide();
		}
	});
});