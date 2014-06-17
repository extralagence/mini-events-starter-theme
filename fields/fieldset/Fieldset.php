<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 12/06/2014
 * Time: 10:15
 */

namespace fields;

class Fieldset extends AbstractGroup {

	public function __construct($data) {
		parent::__construct($data);
		$this->persisted = false;
	}

	public function get_value($data) {
		return null;
	}

	/**
	 * @param $data
	 */
	public function render($data) {
		$this->render_errors($data);
		?>
		<fieldset id="<?php echo $this->name; ?>">
			<legend><?php echo $this->label; ?></legend>
			<?php
			/** @var AbstractField $field */
			foreach ($this->subfields as $field) {
				$field->render($data);
			}
			?>
		</fieldset>
	<?php
	}
}