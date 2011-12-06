<?php
/**
 * Description of WeatherForecast
 *
 * @author RAMONox
 */
class WeatherForecast {

    private $city;

    /**
     * @var ArrayIterator
     */
    private $days;


    /**
     * array de WeatherDayInfo
     * @var ArrayIterator
     */
    private $daysInfo;

    public function WeatherForecast($city, $days){
       $this->city = $city;
       $this->setDays($days);
    }

    private function setDays($days){
        $days_array = explode("<br />", $days);        
        array_pop($days_array);
        $this->days = new ArrayIterator($days_array);
        $this->dayInfo();        
    }

    private function dayInfo(){
        $this->daysInfo = new ArrayIterator();
        while($this->days->valid()){
            $day = explode(") - ", $this->days->current());
            $infos = explode("/", $day[1]);
            $this->daysInfo->append($this->buildWeatherDayInfo($day[0], $infos));
            $this->days->next();
        }
    }

    private function buildWeatherDayInfo($day, $infos){
        $day = str_replace("(", "", $day);
        $min = explode(":", $infos[0]);
        $max = explode(":", $infos[1]);
        $prec = explode(":", $infos[2]);
        $situation = explode(":", $infos[3]);

        $wheaterInfo = new WeatherDayInfo($day, $min[1], $max[1], $prec[1], $situation[1]);
        return $wheaterInfo;
    }

    /**     
     * @return ArrayIterator
     */
    public function daysInfo(){
        return $this->daysInfo;
    }

    /**
     * @return ArrayIterator
     */
    public function days(){
        return $this->days;
    }

    public function city(){
        return $this->city;
    }
}
?>
