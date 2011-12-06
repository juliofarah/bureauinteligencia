<?php
    require_once 'WeatherForecast.php';
    require_once 'WeatherDayInfo.php';
    $url = "http://jornaldotempo.uol.com.br/rss/cidades/rss_prev_".$_GET['id'].".xml";

    $reader = new RSSReader(simplexml_load_file($url));

    $rssItem = $reader->getRssWeahter();

    $wheaterForecast = new WeatherForecast($rssItem->title(), $rssItem->description());

    $daysInfo = $wheaterForecast->daysInfo();

?>
        <table class="weather-table" border="0">
            <tbody>
            <?$i = 0;?>
            <?while($daysInfo->valid() && $i < 4):?>
              <?$dayInfo = $daysInfo->current();?>
              <?if($i % 2 == 0):?>
              <tr>
              <?endif?>
                  <td>
                      <div class="td-weather">
                        <?echo $dayInfo->day()?> <!--(<?//echo $dayInfo->situation()?>)--> <br/>
                        <div class="weather-info">
                            <div class="img-weather">
                                <?echo str_replace("src='imgs", "src='".LinkController::getBaseURL()."/images/weather_imgs", $dayInfo->imageSituation())?>
                            </div>
                            <div class="weather-data">
                                <img alt="Mínima" src="<?echo LinkController::getBaseURL()?>/images/weather_imgs/cli_min.gif"/> Mín.: <?echo $dayInfo->min()?><br />
                                <img alt="Mínima" src="<?echo LinkController::getBaseURL()?>/images/weather_imgs/cli_max.gif"/> Max.: <?echo $dayInfo->max()?>
                            </div>
                        </div>
                      </div>
                  </td>
              <?$i++;?>
              <?if($i % 2 == 0):?>
              </tr>
              <?endif?>
              <?$daysInfo->next();?>
            <?endwhile?>
            </tbody>
        </table>
