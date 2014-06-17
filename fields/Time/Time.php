<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 10:15
 */

namespace fields;

class Time extends AbstractField {

	public $format;
	public $min;
	public $max;

	public function __construct($data) {
		parent::__construct($data);

		$this->format = (isset($data['format'])) ? $data['format'] : null;
		$this->min = (isset($data['min'])) ? $data['min'] : null;
		$this->max = (isset($data['max'])) ? $data['max'] : null;

		if ($this->format == null) {
			throw new \Exception('Missing format for "'.$this->name.'"');
		}
		if (count($this->format) != 3) {
			throw new \Exception('Missing format detail for "'.$this->name.'"');
		}
	}

	public function script() {
		?>
		<script src="fields/Time/js/time.js"></script>
		<?php
	}

	/**
	 * @param $data
	 */
	public function render($data) {
		$value = $this->get_value($data);
		?>
		<p class="extra-field input-slider">
			<?php $this->render_label($data); ?>
			<span class="slider-wrapper">
				<input class="field-time input" data-time-hour-separator="<?php echo $this->format[2]; ?>"<?php echo ($this->min != null) ? ' data-time-min="'.$this->min[0].'"' : ''; ?><?php echo ($this->max != null) ? ' data-time-max="'.$this->max[0].'"' : ''; ?> type="text" name="<?php echo $this->name; ?>" id="<?php echo $this->name; ?>" value="<?php if($value !== null) echo $value; ?>">
			</span>
			<?php $this->render_errors($data); ?>
		</p>
		<?php
	}

	public function is_valid($data) {
		$valid = parent::is_valid($data);

		$value = $this->get_value($data);
		if ($valid && !empty($value) && $this->format != null) {
			$format = $this->format[0];
			$date = \DateTime::createFromFormat($format, $value);
			if ($date == false) {
				$this->errors[] = array(
					'field_name' => $this->name,
					'label' => $this->format[1]
				);
				$valid = false;
			}

			if ($valid && $this->min != null) {
				$min = \DateTime::createFromFormat($format, $this->min[0]);
				if ($min->getTimestamp() > $date->getTimestamp()) {
					$this->errors[] = array(
						'field_name' => $this->name,
						'label' => $this->min[1]
					);
					$valid = false;
				}
			}

			if ($valid && $this->max != null) {
				$min = \DateTime::createFromFormat($format, $this->max[0]);
				if ($min->getTimestamp() < $date->getTimestamp()) {
					$this->errors[] = array(
						'field_name' => $this->name,
						'label' => $this->max[1]
					);
					$valid = false;
				}
			}
		}

		return $valid;
	}

	public function get_value_for_database($data) {
		$value = parent::get_value($data);
		if ($value != null) {
			$format = $this->format[0];
			$date = \DateTime::createFromFormat($format, $value);
			$value = date('H:i:s', $date->getTimestamp());
		}

		return $value;
	}
} 