<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('js/app.js') }}" rel="stylesheet" type="text/css"/>
<style type="text/css">
    body{
        background: #3097d1;
    }
</style>

</head>
<body>
    <div class="container">
        <div class="row" style="padding-top: 200px;">
            <div class="col-lg-offset-4">
                <form action="/test1" method="post">
                    <button type="submit" name="btn" value="1" onclick="document.getElementById('myImage').src='images/pic_bulbon.gif'">Turn on the light</button>

                     <img id="myImage" src="{{$img}}" style="width:100px">

                    <button type="submit" name="btn" value="0"  onclick="document.getElementById('myImage').src='images/pic_bulboff.gif'">Turn off the light</button>
                </form>
            </div>
        </div>
   </div>
</body>
</html>