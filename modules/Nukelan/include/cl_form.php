<?php
class form {
	var $_elements;
	var $_crutch;
	function form($crutch="") {
		$this->_elements = array();
		$this->_crutch = $crutch;
	}
	function startform($form_action, $method) { ?>
		<form action="<?=$form_action?>" method="<?=$method?>">
		<?php
	}
	function add_text		($name,$req,$mod,$crutch,$desc,$errors=array(),$max_length,$unclean=0) {
		$this->_elements[$name] = new form_element("text",$name,$req,$mod,$crutch,$desc,$errors,$max_length,$unclean);
	}
	function add_select		($name,$req,$mod,$crutch,$desc,$errors=array(),$array_choices) {
		$this->_elements[$name] = new form_element("select",$name,$req,$mod,$crutch,$desc,$errors,$array_choices,0);
	}
	function add_selectlist	($name,$req,$mod,$crutch,$desc,$errors=array(),$query,$id_field,$display_field,$empty_entry=1) {
		$this->_elements[$name] = new form_element("selectlist",$name,$req,$mod,$crutch,$desc,$errors,array($query,$id_field,$display_field),0,$empty_entry);
	}
	function add_radio		($name,$req,$mod,$crutch,$desc,$errors=array(),$array_choices) {
		$this->_elements[$name] = new form_element("radio",$name,$req,$mod,$crutch,$desc,$errors,$array_choices,0);	
	}
	function add_radiolist	($name,$req,$mod,$crutch,$desc,$errors=array(),$query,$id_field,$display_field) {
		$this->_elements[$name] = new form_element("radiolist",$name,$req,$mod,$crutch,$desc,$errors,array($query,$id_field,$display_field),0);	
	}
	function add_textarea	($name,$req,$mod,$crutch,$desc,$errors=array(),$rows,$unclean=0) {
		$this->_elements[$name] = new form_element("textarea",$name,$req,$mod,$crutch,$desc,$errors,$rows,$unclean);
	}
	function add_datetime	($name,$req,$mod,$crutch,$desc,$errors=array(),$array_comparison) {
		$this->_elements[$name] = new form_element("datetime",$name,$req,$mod,$crutch,$desc,$errors,$array_comparison,0);
	}
	function add_checkbox	($name,$req,$mod,$crutch,$desc,$errors=array(),$highlander=0) {
		// highlander is whether there can be only one in the database with a 'true' value.
		$this->_elements[$name] = new form_element("checkbox",$name,$req,$mod,$crutch,$desc,$errors,$highlander,0);
	}
	function add_hidden		($name,$value) { ?>
		<input type="hidden" name="<?=$name?>" value="<?=$value?>">
		<?php
	}
	function add_hidden_dos	($name,$value) {
		$this->_elements[$name] = new form_element("hidden",$name,0,1,0,"",array(),$value);
	}

	function endform($submit_button) { 
		global $colors; ?>
		<br>
		<div align="right"><input type="submit" value="<?=$submit_button?>" style="width: 160px; background-color: <?=$colors["text"]?>; color: <?=$colors["background"]?>"></div>
		</form>
		<?php
	}
	function get_elements() {
		return $this->_elements;
	}
	function display_element($name,$mysql_fetch_assoc="",$id="") {
		$element = $this->_elements[$name];
		if((func_num_args()==0)||($element->get_is_modifiable()&&!$element->get_is_dep_crutch())||($element->get_is_modifiable()&&$element->get_is_dep_crutch()&&!$mysql_fetch_assoc[$this->_crutch])) {
			$element->display($mysql_fetch_assoc[$element->get_name()],$id);
		}
	}
	function display_elements($mysql_fetch_assoc="", $id="") {
		foreach($this->_elements as $val) {
			if((func_num_args()==0)||($val->get_is_modifiable()&&!$val->get_is_dep_crutch())||($val->get_is_modifiable()&&$val->get_is_dep_crutch()&&!$mysql_fetch_assoc[$this->_crutch])) {
				$val->display($mysql_fetch_assoc[$val->get_name()],$id);
			}
		}
	}
	function element_exists($name) {
		// if element with the name exists, return true.
		if(!empty($this->_elements[$name])) {
			return true;
		} else {
			return false;
		}
	}
	function element_is_modifiable($name) {
		return $this->_elements[$name]->get_is_modifiable();
	}
	function element_description($name) {
		return $this->_elements[$name]->get_description();
	}
}

class form_element {
	var $_type, $_name, $_is_required, $_description, $_is_modifiable, $_is_dep_crutch, $_unclean, $_empty_entry;
	var $_error;
	var $_specific;
	function form_element($type, $name, $req=0, $mod=0, $crutch=0, $desc="", $errors=array(), $extra="", $unclean=0, $empty_entry=1) {
		$this->_type = $type;
		$this->_name = $name;
		$this->_is_required = $req;
		$this->_is_modifiable = $mod;
		$this->_is_dep_crutch = $crutch;
		$this->_description = $desc;
		$this->_error = array();
		if(sizeof($errors)>0) {
			foreach($errors as $key => $val) {
				if(!empty($val)) $this->_error[$key] = $val;
			}
		}
		$this->_specific = $extra;
		$this->_unclean = $unclean;
		$this->_empty_entry = $empty_entry;
	}
	function display($value="",$id="") {
		global $colors, $start, $end;
		if($this->_type=="text") { 
			if(!empty($this->_description)) { ?>
				<font size=1><b><?=$this->_description?></b> <?=($this->_is_required?" <font color=".$colors["primary"].">(required)</font>":"")?><br></font>
				<?php
			} ?>
			<input type="text" name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>" maxlength="<?=$this->_specific?>" style="width: 95%"<?=(!empty($value)?" value=\"".$value."\"":"")?>><br>
			<?php
		} elseif($this->_type=="select") {
			if(!empty($this->_description)) { ?>
				<font size=1><b><?=$this->_description?></b> <?=($this->_is_required?" <font color=".$colors["primary"].">(required)</font>":"")?><br></font>
				<?php
			} ?>
			<select name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>" style="width: 99%"><?php if($this->_empty_entry) { ?><option value=""></option><?php } ?>
			<?php
			foreach($this->_specific as $key => $val) { ?>
				<option value="<?=$key?>"<?=($value==$key?" selected":"")?>><?=$val?></option>
				<?php
			} ?>
			</select>
			<?php
		} elseif($this->_type=="selectlist") {
			if(!empty($this->_description)) { ?>
				<font size=1><b><?=$this->_description?></b> <?=($this->_is_required?" <font color=".$colors["primary"].">(required)</font>":"")?><br></font>
				<?php
			} ?>
			<select name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>" style="width: 99%"><?php if($this->_empty_entry) { ?><option value=""></option><?php } ?>
			<?php
			$data = @mysql_query($this->_specific[0]);
			while($row = @mysql_fetch_assoc($data)) { ?>
				<option value="<?=$row[$this->_specific[1]]?>"<?=($value==$row[$this->_specific[1]]?" selected":"")?>><?=$row[$this->_specific[2]]?></option>
				<?php
			} ?>
			</select>
			<?php
		} elseif($this->_type=="radio") { ?>
			<table width="100%" cellpadding=3 cellspacing=0><tr>
				<?php
				if(!empty($this->_description)) { ?>
					<td><font size=1><b><?=$this->_description?></b> <?=($this->_is_required?" <font color=".$colors["primary"].">(required)</font>":"")?></font></td>
					<?php
			} ?>
				<td align=right><nobr><font size=1>
					<?php
					foreach($this->_specific as $key => $val) { ?>
						<input type="radio" name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>" value="<?=$key?>" class="radio"<?=($value==$key?" checked":"")?>> <?=$val?>&nbsp;&nbsp;
						<?php
					} ?><br></font>
				</td>
			</tr></table>
			<?php
		} elseif($this->_type=="radiolist") {
			if(!empty($this->_description)) { ?>
				<font size=1><b><?=$this->_description?></b> <?=($this->_is_required?" <font color=".$colors["primary"].">(required)</font>":"")?><br></font>
				<?php
			}
			$data = @mysql_query($this->_specific[0]);
			while($row = @mysql_fetch_assoc($data)) { ?>
				&nbsp;&nbsp;<input type="radio" name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>" value="<?=$row[$this->_specific[1]]?>" class="radio"<?=($value==$row[$this->_specific[1]]?" checked":"")?>> <?=$row[$this->_specific[2]]?><br>
				<?php
			} 
		} elseif($this->_type=="textarea") {
			if(!empty($this->_description)) { ?>
				<font size=1><b><?=$this->_description?></b> <?=($this->_is_required?" <font color=".$colors["primary"].">(required)</font>":"")?><br></font>
				<?php
			} ?>
			<textarea cols="" rows="<?=$this->_specific?>" name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>" style="width: 99%"><?=nl2br($value)?></textarea><br>
			<?php
		} elseif($this->_type=="checkbox") { ?>
			<img src="img/pxt.gif" width="1" height="6" border="0" alt=""><br>
			<input name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>" type="checkbox" value="1" class="radio"<?=($value?" checked":"")?>> <b><?=$this->_description?></b> <?=($this->_is_required?" <font color=".$colors["primary"].">(required)</font>":"")?><br>
			<img src="img/pxt.gif" width="1" height="6" border="0" alt=""><br>
			<?php
		} elseif($this->_type=="datetime") {
			if(!empty($this->_description)) { ?>
				<font size=1><b><?=$this->_description?></b> (year - month - day hour : minute : second) <?=($this->_is_required?" <font color=".$colors["primary"].">(required)</font>":"")?><br></font>
				<?php
			}
			$i = 0;
			while($i<sizeof($this->_specific)&&!empty($this->_specific[$i])) {
				$holder = $this->_specific[$i];
				$i++;
			}
			if(!empty($value)) {
				$holder = strtotime($value);
			} ?>
			&nbsp;&nbsp;<select name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>_year"><?php
				for($i=0;$i<(date("Y",$end)-date("Y",$start)+1);$i++) {
					echo "<option value=".(date("Y",$start)+$i)."".((date("Y",$start)+$i)==date("Y",$holder)?" selected":"").">".(date("Y",$start)+$i)."</option>";
				} ?>
			</select>&nbsp;-&nbsp;<select name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>_month"><?php
				$months = array("","jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec");
				if((date("n",$end)-date("n",$start))<0) {
					for($i=1;$i<sizeof($months);$i++) {
						echo "<option value=".$i."".($i==date("n",$holder)?" selected":"").">".$months[$i]."</option>";
					}
				} else { 
					for($i=0;$i<(date("n",$end)-date("n",$start)+1);$i++) {
						echo "<option value=".(date("n",$start)+$i)."".((date("n",$start)+$i)==date("n",$holder)?" selected":"").">".$months[date("n",$start)+$i]."</option>";
					}
				} ?>
			</select>&nbsp;-&nbsp;<select name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>_day"><?php
				if((date("j",$end)-date("j",$start))<0||(date("n",$start)!=date("n",$end))||(date("Y",$start)!=date("Y",$end))) {
					for($i=1;$i<32;$i++) {
						echo "<option value=".$i."".($i==date("j",$holder)?" selected":"").">".($i<10?"0":"").$i."</option>";
					}
				} else {
					for($i=0;$i<(date("j",$end)-date("j",$start)+1);$i++) {
						echo "<option value=".(date("j",$start)+$i)."".((date("j",$start)+$i)==date("j",$holder)?" selected":"").">".((date("j",$start)+$i)<10?"0":"").(date("j",$start)+$i)."</option>";
					}
				} ?>
			</select>&nbsp;&nbsp;&nbsp;<select name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>_hour"><?php
				if((date("G",$end)-date("G",$start))<0||(date("j",$start)!=date("j",$end))||(date("n",$start)!=date("n",$end))||(date("Y",$start)!=date("Y",$end))) {
					for($i=0;$i<24;$i++) {
						echo "<option value=".$i."".($i==date("G",$holder)?" selected":"").">".($i<10?"0":"").$i."</option>";
					}
				} else { 
					for($i=0;$i<(date("G",$end)-date("G",$start)+1);$i++) {
						echo "<option value=".(date("G",$start)+$i)."".((date("G",$start)+$i)==date("G",$holder)?" selected":"").">".(date("G",$start)+$i)."</option>";
					}
				} ?>
			</select>&nbsp;:&nbsp;<select name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>_minute"><?php
				if((date("i",$end)-date("i",$start))<0||(date("G",$start)!=date("G",$end))||(date("j",$start)!=date("j",$end))||(date("n",$start)!=date("n",$end))||(date("Y",$start)!=date("Y",$end))) {
					for($i=0;$i<60;$i++) {
						echo "<option value=".$i."".($i==date("i",$holder)?" selected":"").">".($i<10?"0":"").$i."</option>";
					}
				} else { 
					for($i=0;$i<(date("i",$end)-date("i",$start)+1);$i++) {
						echo "<option value=".(date("i",$start)+$i)."".((date("i",$start)+$i)==date("i",$holder)?" selected":"").">".($i<10?"0":"").(date("i",$start)+$i)."</option>";
					}
				} ?>
			</select>&nbsp;:&nbsp;<select name="<?=(!empty($id)?$id."_":"")?><?=$this->_name?>_second"><?php
				if((date("s",$end)-date("s",$start))<0||(date("i",$start)!=date("i",$end))||(date("G",$start)!=date("G",$end))||(date("j",$start)!=date("j",$end))||(date("n",$start)!=date("n",$end))||(date("Y",$start)!=date("Y",$end))) {
					for($i=0;$i<60;$i++) {
						echo "<option value=".$i."".($i==date("s",$holder)?" selected":"").">".($i<10?"0":"").$i."</option>";
					}
				} else { 
					for($i=0;$i<(date("s",$end)-date("s",$start)+1);$i++) {
						echo "<option value=".(date("s",$start)+$i)."".((date("s",$start)+$i)==date("s",$holder)?" selected":"").">".($i<10?"0":"").(date("s",$start)+$i)."</option>";
					}
				} ?>
			</select><br>
			<?php
		}
	}
	function get_type() {
		// return string
		return $this->_type;
	}
	function get_name() {
		// return string
		return $this->_name;
	}
	function get_is_required() {
		// return boolean
		return $this->_is_required;
	}
	function get_is_unclean() {
		return $this->_unclean;
	}
	function get_is_modifiable() {
		// return boolean
		return $this->_is_modifiable;
	}
	function get_is_dep_crutch() {
		// return boolean
		return $this->_is_dep_crutch;
	}
	function get_description() {
		// return string
		return $this->_description;
	}
	function get_error($type) {
		// return string
		return $this->_error[$type];
	}
	function get_specific() {
		// text: maxlength integer
		// select: choices array
		// selectlist: array(mysql query, id, display)
		// textarea: rows integer
		// datearea: comparison array for selection
		// checkbox: highlander (only one true)
		return $this->_specific;
	}
}
?>