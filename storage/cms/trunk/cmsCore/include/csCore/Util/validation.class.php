<?PHP
/**
 * 
 * ClickSuccess, L.P.
 * March 24, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */

class csCore_Util_validation
{
	var $regExMap = array(
		"is_email" 			=> '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$',
		"is_numeric" 		=> '[^0-9]',
		"is_alphanumeric" 	=> '[^A-Za-z0-9]',						
	);
	function validate($data, $reg)
	{
		$regex = $this->regExMap[strtolower($reg)];
		return @ereg($regex, strtolower($data));
	}

}
?>