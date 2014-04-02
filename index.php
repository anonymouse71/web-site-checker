<?php
function chkLive($url){
	$c= $url[0].$url[1].$url[2].$url[3];
	if($c!='http' && $c!='HTTP'){$url="http://".$url;}
	$data = @get_headers($url,1);
	if($data==false){ echo "Website Dead : Sorry Host Not Found!";}
	$pattern = '/b*[0-9]{3}/';
	preg_match($pattern, $data[0], $matches, PREG_OFFSET_CAPTURE, 3);
	$count = count($matches);
	if($count>0)
	{
		$state = $matches[0][0];
		if($state[0]=='2'){echo "Website live !<br> State : $state<br>url : $url";}
		elseif($state[0]=='3'){echo "Website live !<br> State : $state<br>url : $url";}
		elseif($state[0]=='4'){echo "Website live !<br> State : $state<br>url : $url";}
		elseif($state[0]=='5'){echo "Website Down !<br> State : $state<br>url : $url";}
		else{echo "Website Dead : Sorry Host Not Found!";}
	}
}

function chkLiveApi($url){
	$c= $url[0].$url[1].$url[2].$url[3];
	if($c!='http' && $c!='HTTP'){$url="http://".$url;}
	$data = @get_headers($url,1);
	if($data==false){ $s = 0; $code = 0;}
	$pattern = '/b*[0-9]{3}/';
	preg_match($pattern, $data[0], $matches, PREG_OFFSET_CAPTURE, 3);
	$count = count($matches);
	if($count>0)
	{
		$state = $matches[0][0];
		if(	   $state[0]=='2'){$s = 1; $code = $state;}
		elseif($state[0]=='3'){$s = 1; $code = $state;}
		elseif($state[0]=='4'){$s = 1; $code = $state;}
		elseif($state[0]=='5'){$s = 0; $code = $state;}
		else{$s = 0; $code = 0;}	
	}
	$response["success"] = $s;
    $response["code"] = $code;
	echo json_encode($response);
}


if(isset($_POST['url'])){
	chkLive($_POST['url']);
	exit();
}
if(isset($_REQUEST['api'])){
	chkLiveApi($_REQUEST['api']);
	exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check Site</title>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    #result{width:100%;top:20%;}
    #loading
    {
    width:100%; 
    height: 100px;
    margin-top: -100px; 
    background-image:url('http://s.sajib.im/loading.gif'); 
    background-repeat:no-repeat;
    background-position: center center;
    display: none;
    }
    #res{
    width:100%; 
    height: 100px;
    margin-top: -100px;
    font-size: 22px;
    }
    .center{
    width:100%;
    margin: auto;
    }
    .footer{
    position: fixed;
    bottom: 10px;
    text-align: center;
    width: 100%;
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="center" style="margin-top:10px;">
      <div align="center" style="text-align:center;">
      <div id="result">
        <div id="loading"></div>
      </div>
      <div id="res"></div>
      
      
        <form class="form-inline" role="form" id="myUrl">
          <div class="form-group">
            <input type="text" class="form-control" id="url" data-validation="url" style="width:450px;" required >
            <button type="submit" class="control-label btn btn-success" name="short">Check Site</button>
          </div>
        </form>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
	$("#myUrl").submit(function() {
    submitUrl();
    return false;
    });
    function submitUrl() {
       var url =document.getElementById("url").value;
       var params = "url="+url;
               var url = "<?php echo $_SERVER['PHP_SELF'];?>";
                    $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'html',
                            data: params,
                            beforeSend: function()
                            {
                            $("#loading").show();
                            document.getElementById("res").innerHTML='' ;
                            },
                            complete: function() {
                            },
                            success: function(html) {
                            document.getElementById("res").innerHTML= html ;
                            //document.getElementById("result").innerHTML="";
                            $("#loading").hide();
                            }
                           });
     
    }

//centering div 
    $(window).resize(adjustLayout);
    $(document).ready(function(){
    adjustLayout();
    })
    function adjustLayout(){
    $('.center').css({
        position:'absolute',
        left: ($(window).width() - $('.center').outerWidth())/2,
        top: ($(window).height() - $('.center').outerHeight())/2
    });
    }
    </script>
    <footer class="footer">
      &copy 2014 saiful.im
    </footer>
  </body>
</html>
