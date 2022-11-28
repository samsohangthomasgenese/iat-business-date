<?php

// use Carbon\Carbon;
/**
 * Class for IAT_Business_Date_Generator
 *
 * @copyright  IAT
 * @version    1.0.0
 * @since      1.0.0
 */ 
class IAT_Business_Date_Generator {

	public static $instance = null;
	private $next_business_date = null;
	private $current_input_date = null;

	/**
	* Class Constructor
	*
	* @return null
	*/
	function __construct() {}


	/**
	* Instantiate the singelton pattern
	*
	* @return IAT_Business_Date_Generators A single instance of this class.
	*/
	public static function get_instance() {
		if(!self::$instance || self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * [getBufferDate description]
	 * @param  [type] $date [description]
	 * @return [type]       [description]
	 */
	public  function getBufferDate($date)
	{
		$this->current_input_date = $date;
		return $this->getNextBusinessBufferDate();
	}

	/**
	 * [getNextBusinessBufferDate description]
	 * @return [type] [description]
	 */
	public function getNextBusinessBufferDate()
	{
		//If the next business date is in the same month, update it. 
		$this->update_next_business_date();

		// check whether the next date is less than equal to first thrusday of the month
 		$first_day_of_the_month = date('Y-m-d', strtotime("{$this->next_business_date} first Thu of this month"));

 		if($this->next_business_date<=$first_day_of_the_month){
 			return $this->next_business_date;
 		}

 		// skip month and search for next month
 		$this->out_of_bound_handling();

 		return $this->next_business_date;

	}
	/**
	 * [out_of_bound_handling description]
	 * @return [type] [description]
	 */
	public function out_of_bound_handling(){
		$this->current_input_date = $this->next_business_date;
		$this->update_next_business_date();
	}

	/**
	 * [update_next_business_date description]
	 * @return [type] [description]
	 */
	public function update_next_business_date(){
		$two_weeks_buffer_date = date('Y-m-d',strtotime("{$this->current_input_date} +2 weeks"));
		$this->next_business_date = date('Y-m-d',strtotime($two_weeks_buffer_date));

		$temp_current_date = date('Y-m',strtotime("{$this->current_input_date}"));
		$temp_next_date = date('Y-m',strtotime("{$this->next_business_date}"));

		if($temp_current_date==$temp_next_date){
			$next_month = date('Y-m-d',strtotime("{$temp_current_date} next month")); 
			$next_month_thu = date('Y-m-d',strtotime("{$next_month} first Thu of this month"));
			$this->next_business_date = $next_month_thu;
		}
		
	}

	/**
	 * [check_next_business_day_is_thrusday_of_the_week description]
	 * @return [type] [description]
	 */
	public function check_next_business_day_is_thrusday_of_the_week()
	{
		// code...
		$temp_next_business_day = date('D',strtotime($this->next_business_date));
		return (in_array($temp_next_business_day,['Mon','Tue','Wed']));
	}

	/**
	 * [find_next_business_date description]
	 * @return [type] [description]
	 */
	public function find_next_business_date(){
		$new_business_date = "{$this->next_business_date}";
	}
}
IAT_Business_Date_Generator::get_instance();
