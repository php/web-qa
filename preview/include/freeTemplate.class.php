<?
class freeTemplate {
	
	var $templateContent = "";
	var $templateLoop = array();

	function queryDB ($querystring){
		global $db_host, $db_port, $db_user, $db_pass, $db_name;
		
		$db =  @mysql_connect($db_host.":".$db_port, $db_user, $db_pass) or die();
		if ($db) {
			@mysql_select_db($db_name,$db);
			$result = @mysql_query($querystring);
			@mysql_close($db);
			return $result;
		}
		return false;
	} //queryDB
	
	function assignTemplate($filename, $type = 0) {
		$buffer = "";
		if ($type==0 || empty($type)) {
			if (!@is_file($filename)) {
				return false;
			}
			
			$this->templateContent = @fread(fopen($filename, "r"), filesize($filename));
			return true;
		} elseif ($type==1 && !empty($filename)) {
			$result = $this->queryDB("SELECT * FROM $template_table WHERE template_name='$templatename' LIMIT 0,1");
			
			if (mysql_num_rows($result) != NULL) {
				$buffer_ar = @mysql_fetch_array($result, MYSQL_ASSOC);
				$buffer = $buffer_ar["template_content"];
				
				mysql_free_result($result);
				
				return $buffer;
			}
		}
		return false;
	} //assignTemplate
	
	function printTemplate() {
		echo $this -> templateContent;
		return true;
	} // printTemplate
	
	function findLoop($loopname) {
		if (is_array($loopname)) {
			for ($x=0; $x<count($loopname); $x++) {
				eregi("\<!--".strtolower($loopname[$x])."--\>(.*)\<!--\/".strtolower($loopname[$x])."--\>", $this->templateContent, $hits);
				if (count($hits)==0) {
					return false;
				} else {
					$this->templateLoop[strtolower($loopname[$x])][0] = $hits[0];
					$this->templateLoop[strtolower($loopname[$x])][1] = $hits[1];
					$this->templateLoop[strtolower($loopname[$x])][2] = "";
				}
			}
		} else {
			eregi("\<!--".strtolower($loopname)."--\>(.*)\<!--\/".strtolower($loopname)."--\>", $this->templateContent, $hits);
			if (count($hits)==0) {
				return false;
			} else {
				$this->templateLoop[strtolower($loopname)][0] = $hits[0];
				$this->templateLoop[strtolower($loopname)][1] = $hits[1];
				$this->templateLoop[strtolower($loopname)][2] = "";
			}
		}
		return true;
	} // findLoop
	
	function replaceLoop($loopname) {
		if (is_array($loopname)) {
			for ($x=0; $x<count($loopname); $x++) {
				$this->templateContent = str_replace($this->templateLoop[strtolower($loopname[$x])][0], $this->templateLoop[strtolower($loopname[$x])][2] , $this->templateContent);
			} 
		} else {
			$this->templateContent = str_replace($this->templateLoop[strtolower($loopname)][0], $this->templateLoop[strtolower($loopname)][2] , $this->templateContent);	
		}
		return true;
	} // replaceLoop
	
	function addLoop($loopname) {
		$this->templateLoop[strtolower($loopname)][2] .= $this->templateLoop[strtolower($loopname)][1];
		return true;
	} // addLoop

	function parseLoop($oldstring, $newstring = "", $loopname) {
		$this->templateLoop[strtolower($loopname)][2] = str_replace($oldstring, $newstring, $this->templateLoop[strtolower($loopname)][2]);
		return true;
	} // parseLoop
	
	function replaceVar($oldstring, $newstring = "") {
		$this->templateContent = str_replace($oldstring, $newstring, $this->templateContent);
		return true;
	}
}
?>
