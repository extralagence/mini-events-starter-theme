<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 16:13
 */

namespace fields;

class RadioGroup extends AbstractField {

	protected $options;

	public function script() {
		?>
		<script src="fields/Radiogroup/js/radiogroup.js"></script>
		<?php
	}

	public function __construct($data) {
		parent::__construct($data);
		$options = (isset($data['options'])) ? $data['options'] : array();

		$this->options = array();
		foreach ($options as $current) {
			if (is_array($current)) {
				$this->options[] = $current;
			} else {
				$this->options[] = array(
					'value' => $current,
					'label' => $current
				);
			}
		}

		if (empty($this->options)) {
			throw new \Exception('Missing options for "'.$this->name.'"');
		}
	}

	public function render($data) {
		$value = $this->get_value($data);
		?>
		<p class="extra-field">
			<label><?php echo $this->label; ?><?php echo ($this->required !== null) ? '<span class="form-required">*</span>' : ''; ?></label>
			<?php foreach ($this->options as $option) : ?>
				<input class="input-radiogroup input" type="radio" name="<?php echo $this->name; ?>" id="<?php echo $this->name.'_'.$option['value']; ?>" value="<?php echo $option['value'] ?>"<?php echo ($value == $option['value']) ? ' checked="checked"' : ''; ?>> <label class="radio-label" for="<?php echo $this->name.'_'.$option['value']; ?>"><?php echo $option['label']; ?></label> <br>
			<?php endforeach; ?>
			<?php $this->render_errors($data); ?>
		</p>
	<?php
	}
}