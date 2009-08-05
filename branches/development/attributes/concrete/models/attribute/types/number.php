<?
defined('C5_EXECUTE') or die(_("Access Denied."));

class NumberAttributeTypeController extends AttributeTypeController  {

	public function getValue() {
		$db = Loader::db();
		$value = $db->GetOne("select value from atNumber where avID = ?", array($this->getAttributeValueID()));
		$v = explode('.', $value);
		$p = 0;
		for ($i = 0; $i < strlen($v[1]); $i++) {
			if (substr($v[1], $i, 1) > 0) {
				$p = $i+1;
			}
		}
		return round($value, $p);	
	}

	public function form() {
		if (is_object($this->attributeValue)) {
			$value = $this->getAttributeValue()->getValue();
		}
		print Loader::helper('form')->text($this->field('value'), $value, array('style' => 'width:80px'));
	}

	// run when we call setAttribute(), instead of saving through the UI
	public function saveValue($value) {
		$db = Loader::db();
		$value = ($value == false || $value == '0') ? 0 : $value;
		$db->Replace('atNumber', array('avID' => $this->getAttributeValueID(), 'value' => $value), 'avID', true);
	}
	
	public function deleteKey() {
		$db = Loader::db();
		$arr = $this->attributeKey->getAttributeValueIDList();
		foreach($arr as $id) {
			$db->Execute('delete from atNumber where avID = ?', array($id));
		}
	}
	
	public function saveForm($data) {
		$db = Loader::db();
		$this->saveValue($data['value']);
	}
	
	public function deleteValue() {
		$db = Loader::db();
		$db->Execute('delete from atNumber where avID = ?', array($this->getAttributeValueID()));
	}
	
}