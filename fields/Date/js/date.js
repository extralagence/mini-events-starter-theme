$(document).ready(function(){
	/**************************
	 *
	 *
	 *
	 *  DATEPICKER
	 *
	 *
	 **************************/
	$('.field-date').each(function () {
		var $fieldDate = $(this),
			fieldDateFormat = $fieldDate.data('date-format'),
			fieldDateMin = $fieldDate.data('date-min'),
			fieldDateMax = $fieldDate.data('date-max')
			;

		var options = {
			dateFormat : fieldDateFormat //'dd/mm/yy',
		};
		if (fieldDateMin != '') {
			options.minDate = fieldDateMin;
		}
		if (fieldDateMax != '') {
			options.maxDate = fieldDateMax;
		}

		$fieldDate.datepicker(options);
	});
});