<?php
  stream_context_set_default([
    'ssl' => [
      'verify_peer' => false,
      'verify_peer_name' => false,
    ]
    ]);
  $weather = "";
  $error = "";
  if(array_key_exists('city',$_GET))
  { 
    $k = ucwords($_GET['city']);
    if($k=="Madras")
      $k = "Chennai";
    $city = str_replace(" ","",$_GET['city']);
    $weather = "";
    $headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
    if($headers[0] == 'HTTP/1.1 404 Not Found') {
        $error = "City not found";
    }
    else
    {
        $forecastpage = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
        $pageArray = explode('.svg" /></div></div></div>'.$k.' Weather Forecast.', $forecastpage);
        if(sizeof($pageArray)>1)
        {
          $secondArrayPage = explode(' Local time in ',$pageArray[1]);
          if(sizeof($secondArrayPage)>1)
          {
            $weather =  $secondArrayPage[0];
          }
          else
          {
            $error = "City is not found";
          }
        }
        else
        {
          $error = "City is not found";
        }
    }
  }
  else
  {
    $error = "City is not found";
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WEATHER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style type="text/css">
        html { 
            background: url("https://images.unsplash.com/photo-1606663967575-8ca32425b97b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=774&q=80") no-repeat center center fixed; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        body{
            background :none;
        }
        .heading{
            padding : 30px 30px 10px 30px;
            color : white;
            font-size : 6vw;
            font-weight :bold;
            text-align : center;
        }
        form{
          text-align:center;
        }
        .sub{
          color : white;
          display:block; 
          font-size : 4vw;
        }
        .btn4{
            position: relative;
            z-index: 1;
            display: inline-block;
            font-size: 1.2rem;
            padding: 10px 20px;
            box-sizing: border-box;
            background-color: #e7eef1;
            border: solid 5px transparent;
            border-image: linear-gradient(45deg , blue , violet) 1;
            color: darkblue;
            transition: all 0.3s ease-in-out;
        }
        .btn4:hover{
            border-radius: 25%;
            font-size: 1.4rem;
            background-image: linear-gradient(45deg , blue , violet) ;
            color: white;
        }
        .done{
            /* color : white; */
            border-radius: 2vw;
            padding:20px;
            background-color: lightblue;
            box-shadow: inset -1px 1px 1px hsl(200,100%,50%),
                              -2px 2px 2px hsl(200,100%,20%),
                              -3px 3px 3px hsl(200,100%,18%),
                              -4px 4px 4px hsl(200,100%,16%),
                              -5px 5px 5px hsl(200,100%,14%),
                              -7px 7px 7px hsl(200,100%,12%),
                              -9px 9px 9px hsl(200,100%,10%);
        }
        .error{
          border-radius: 2vw;
            padding:20px;
            background-color: #FFC2C1;
            color: darkred;
            font-weight: bold;
            box-shadow: inset -1px 1px 1px hsl(40,100%,50%),
                              -2px 2px 2px hsl(40,100%,20%),
                              -3px 3px 3px hsl(40,100%,18%),
                              -4px 4px 4px hsl(40,100%,16%),
                              -5px 5px 5px hsl(40,100%,14%),
                              -7px 7px 7px hsl(40,100%,12%),
                              -9px 9px 9px hsl(40,100%,10%);
        }
    </style>
  </head>
  <body>
    <div class="heading"> Wanted to know Weather? </div>
    <form>
    <label for="city" class="sub">Enter the Name of the City</label>
      <div class="mb-3 mt-3 container">
        <div class="row">
          <div class="col-8 offset-2">
            <input type="text" class="form-control" name="city" id="city" placeholder="Eg. Hyderabad, Mumbai" value="<?php  if(array_key_exists('city',$_GET)) echo $_GET['city'];?>">
          </div>
        </div> 
      </div>
      <button type="submit" class="btn4"><b>Get Weather</b></button>
    </form>
    <div class="mb-3 mt-3 container">
        <div class="row">
          <div class="col-10 offset-1">
            
                <?php
                  if($weather)
                    echo "<div class='done'>".$weather."</div>";
                  else if($error)
                    echo "<div class='error'>".$error."</div>";
                ?>
            </div>
        </div> 
      </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>