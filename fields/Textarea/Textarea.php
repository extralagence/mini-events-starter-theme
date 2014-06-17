<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 10:15
 */

namespace fields;

class Textarea extends Text {
	/**
	 * @param $data
	 */
	public function render($data) {
		$value = $this->get_value($data);
		?>
		<p class="extra-field">
			<?php $this->render_label($data); ?>
			<textarea class="input" name="<?php echo $this->name; ?>" id="<?php echo $this->name; ?>"><?php if($value !== null) echo $value; ?></textarea>
			<?php $this->render_errors($data); ?>
		</p>
	<?php
	}
}