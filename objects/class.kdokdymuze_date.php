<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `kdokdymuze_date` (
	`kdokdymuze_dateid` int(11) NOT NULL auto_increment,
	`kdokdymuze_userid` int(11) NOT NULL,
	`date` DATE NOT NULL, INDEX(`kdokdymuze_userid`), PRIMARY KEY  (`kdokdymuze_dateid`)) ENGINE=MyISAM;
*/

/**
* <b>kdokdymuze_date</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5&wrapper=pog&objectName=kdokdymuze_date&attributeList=array+%28%0A++0+%3D%3E+%27kdokdymuze_user%27%2C%0A++1+%3D%3E+%27date%27%2C%0A%29&typeList=array+%28%0A++0+%3D%3E+%27BELONGSTO%27%2C%0A++1+%3D%3E+%27DATE%27%2C%0A%29
*/
include_once('class.pog_base.php');
class kdokdymuze_date extends POG_Base
{
	public $kdokdymuze_dateId = '';

	/**
	 * @var INT(11)
	 */
	public $kdokdymuze_userId;
	
	/**
	 * @var DATE
	 */
	public $date;
	
	public $pog_attribute_type = array(
		"kdokdymuze_dateId" => array('db_attributes' => array("NUMERIC", "INT")),
		"kdokdymuze_user" => array('db_attributes' => array("OBJECT", "BELONGSTO")),
		"date" => array('db_attributes' => array("NUMERIC", "DATE")),
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
	
	function kdokdymuze_date($date='')
	{
		$this->date = $date;
	}
	
	
	/**
	* Gets object from database
	* @param integer $kdokdymuze_dateId 
	* @return object $kdokdymuze_date
	*/
	function Get($kdokdymuze_dateId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `kdokdymuze_date` where `kdokdymuze_dateid`='".intval($kdokdymuze_dateId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->kdokdymuze_dateId = $row['kdokdymuze_dateid'];
			$this->kdokdymuze_userId = $row['kdokdymuze_userid'];
			$this->date = $row['date'];
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $kdokdymuze_dateList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `kdokdymuze_date` ";
		$kdokdymuze_dateList = Array();
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
			$sortBy = "kdokdymuze_dateid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$kdokdymuze_date = new $thisObjectName();
			$kdokdymuze_date->kdokdymuze_dateId = $row['kdokdymuze_dateid'];
			$kdokdymuze_date->kdokdymuze_userId = $row['kdokdymuze_userid'];
			$kdokdymuze_date->date = $row['date'];
			$kdokdymuze_dateList[] = $kdokdymuze_date;
		}
		return $kdokdymuze_dateList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $kdokdymuze_dateId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `kdokdymuze_dateid` from `kdokdymuze_date` where `kdokdymuze_dateid`='".$this->kdokdymuze_dateId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `kdokdymuze_date` set 
			`kdokdymuze_userid`='".$this->kdokdymuze_userId."', 
			`date`='".$this->date."' where `kdokdymuze_dateid`='".$this->kdokdymuze_dateId."'";
		}
		else
		{
			$this->pog_query = "insert into `kdokdymuze_date` (`kdokdymuze_userid`, `date` ) values (
			'".$this->kdokdymuze_userId."', 
			'".$this->date."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->kdokdymuze_dateId == "")
		{
			$this->kdokdymuze_dateId = $insertId;
		}
		return $this->kdokdymuze_dateId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $kdokdymuze_dateId
	*/
	function SaveNew()
	{
		$this->kdokdymuze_dateId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `kdokdymuze_date` where `kdokdymuze_dateid`='".$this->kdokdymuze_dateId."'";
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
			$pog_query = "delete from `kdokdymuze_date` where ";
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
	
	
	/**
	* Associates the kdokdymuze_user object to this one
	* @return boolean
	*/
	function GetKdokdymuze_user()
	{
		$kdokdymuze_user = new kdokdymuze_user();
		return $kdokdymuze_user->Get($this->kdokdymuze_userId);
	}
	
	
	/**
	* Associates the kdokdymuze_user object to this one
	* @return 
	*/
	function SetKdokdymuze_user(&$kdokdymuze_user)
	{
		$this->kdokdymuze_userId = $kdokdymuze_user->kdokdymuze_userId;
	}
}
?>