<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `kdokdymuze_user` (
	`kdokdymuze_userid` int(11) NOT NULL auto_increment,
	`jmeno` VARCHAR(255) NOT NULL,
	`email` VARCHAR(255) NOT NULL, PRIMARY KEY  (`kdokdymuze_userid`)) ENGINE=MyISAM;
*/

/**
* <b>kdokdymuze_user</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=kdokdymuze_user&attributeList=array+%28%0A++0+%3D%3E+%27jmeno%27%2C%0A++1+%3D%3E+%27email%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27VARCHAR%28255%29%27%2C%0A++1+%3D%3E+%27VARCHAR%28255%29%27%2C%0A%29
*/
include_once('class.pog_base.php');
class kdokdymuze_user extends POG_Base
{
	public $kdokdymuze_userId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $jmeno;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $email;
	
	public $pog_attribute_type = array(
		"kdokdymuze_userId" => array('db_attributes' => array("NUMERIC", "INT")),
		"jmeno" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"email" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		);
	public $pog_query;
	
	
	/**
	* Getter for some private attributes
	* @return mixed $attribute
	*/
	public function __get($attribute)
	{
		if (isset($this->{"_".$attribute}))
		{
			return $this->{"_".$attribute};
		}
		else
		{
			return false;
		}
	}
	
	function kdokdymuze_user($jmeno='', $email='')
	{
		$this->jmeno = $jmeno;
		$this->email = $email;
	}
	
	
	/**
	* Gets object from database
	* @param integer $kdokdymuze_userId 
	* @return object $kdokdymuze_user
	*/
	function Get($kdokdymuze_userId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `kdokdymuze_user` where `kdokdymuze_userid`='".intval($kdokdymuze_userId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->kdokdymuze_userId = $row['kdokdymuze_userid'];
			$this->jmeno = $this->Unescape($row['jmeno']);
			$this->email = $this->Unescape($row['email']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $kdokdymuze_userList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `kdokdymuze_user` ";
		$kdokdymuze_userList = Array();
		if (sizeof($fcv_array) > 0)
		{
			$this->pog_query .= " where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$this->pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) != 1)
					{
						$this->pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						if ($GLOBALS['configuration']['db_encoding'] == 1)
						{
							$value = POG_Base::IsColumn($fcv_array[$i][2]) ? "BASE64_DECODE(".$fcv_array[$i][2].")" : "'".$fcv_array[$i][2]."'";
							$this->pog_query .= "BASE64_DECODE(`".$fcv_array[$i][0]."`) ".$fcv_array[$i][1]." ".$value;
						}
						else
						{
							$value =  POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$this->Escape($fcv_array[$i][2])."'";
							$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
						}
					}
					else
					{
						$value = POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$fcv_array[$i][2]."'";
						$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
					}
				}
			}
		}
		if ($sortBy != '')
		{
			if (isset($this->pog_attribute_type[$sortBy]['db_attributes']) && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'SET')
			{
				if ($GLOBALS['configuration']['db_encoding'] == 1)
				{
					$sortBy = "BASE64_DECODE($sortBy) ";
				}
				else
				{
					$sortBy = "$sortBy ";
				}
			}
			else
			{
				$sortBy = "$sortBy ";
			}
		}
		else
		{
			$sortBy = "kdokdymuze_userid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$kdokdymuze_user = new $thisObjectName();
			$kdokdymuze_user->kdokdymuze_userId = $row['kdokdymuze_userid'];
			$kdokdymuze_user->jmeno = $this->Unescape($row['jmeno']);
			$kdokdymuze_user->email = $this->Unescape($row['email']);
			$kdokdymuze_userList[] = $kdokdymuze_user;
		}
		return $kdokdymuze_userList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $kdokdymuze_userId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `kdokdymuze_userid` from `kdokdymuze_user` where `kdokdymuze_userid`='".$this->kdokdymuze_userId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `kdokdymuze_user` set 
			`jmeno`='".$this->Escape($this->jmeno)."', 
			`email`='".$this->Escape($this->email)."' where `kdokdymuze_userid`='".$this->kdokdymuze_userId."'";
		}
		else
		{
			$this->pog_query = "insert into `kdokdymuze_user` (`jmeno`, `email` ) values (
			'".$this->Escape($this->jmeno)."', 
			'".$this->Escape($this->email)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->kdokdymuze_userId == "")
		{
			$this->kdokdymuze_userId = $insertId;
		}
		return $this->kdokdymuze_userId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $kdokdymuze_userId
	*/
	function SaveNew()
	{
		$this->kdokdymuze_userId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `kdokdymuze_user` where `kdokdymuze_userid`='".$this->kdokdymuze_userId."'";
		return Database::NonQuery($this->pog_query, $connection);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array)
	{
		if (sizeof($fcv_array) > 0)
		{
			$connection = Database::Connect();
			$pog_query = "delete from `kdokdymuze_user` where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) !== 1)
					{
						$pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$this->Escape($fcv_array[$i][2])."'";
					}
					else
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$fcv_array[$i][2]."'";
					}
				}
			}
			return Database::NonQuery($pog_query, $connection);
		}
	}
}
?>