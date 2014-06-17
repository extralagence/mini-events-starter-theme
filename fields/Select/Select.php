<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 16:13
 */

namespace fields;

class Select extends AbstractField {

	protected $options;

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
			<?php $this->render_label($data); ?>
			<select class="input" name="<?php echo $this->name; ?>" id="<?php echo $this->name; ?>">
				<?php foreach ($this->options as $option) : ?>
					<option value="<?php echo $option['value'] ?>"<?php echo ($value == $option['value']) ? ' selected="selected"' : ''; ?>><?php echo $option['label'] ?></option>
				<?php endforeach; ?>
			</select>
			<?php $this->render_errors($data); ?>
		</p>
	<?php
	}
}