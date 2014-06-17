<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 16:13
 */

namespace fields;

class Checkbox extends AbstractField {

	public function script() {
		?>
		<script src="fields/Checkbox/js/checkbox.js"></script>
		<?php
	}


	public function render($data) {
		$value = $this->get_value($data);
		?>
		<p class="extra-field checkbox-field">
			<input class="input" type="checkbox" name="<?php echo $this->name; ?>" id="<?php echo $this->name; ?>" value="1"<?php echo ($value == '1') ? ' checked="checked"' : ''; ?>/>
			<?php $this->render_label($data); ?>
			<?php $this->render_errors($data); ?>
		</p>
	<?php
	}

	public function get_value_for_export($data) {
		$value = 'non';
		if($this->get_value($data) == 1) {
			$value = 'oui';
		}

		return $value;
	}
}