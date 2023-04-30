<!DOCTYPE html>
<html>
<head>
 <title>Survey</title>
<link rel="stylesheet"href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<scriptsrc="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">
</script>
</head>
<body>
<div align="center">

 <h1 style="font-family:verdan;">Survey Form</h1>
 <p style="color:red; font-family:Courier; font-size:500%;">Select your favourite Fruit</p>
 </div>
</div>
 <div align="left">
 <form action="survey.php" method="post">
 <p style="font-family: sans-serif;"><b><i> Please Select your choice:</i></b></p><br>
 <input type="radio" name="fruit" id="Kiwi" value="1">
<label for="Kiwi">Kiwi</label><br><br>
 <input type="radio" name="fruit" id="Mango" value="2">
 <label for="Mango"> Mango</label><br><br>
 <input type="radio" name="fruit" id="Apple" value="3">
 <label for="Apple">Apple</label><br><br>
 <input type="radio" name="fruit" id="Grapes" value="4">
 <label for="Grapes">Grapes</label><br><br>
 <input type="radio" name="fruit" id="Chiku" value="5">
 <label for="Chiku">Chiku</label><br><br>
 <input type="radio" name="fruit" id="Pineapple" value="6">
 <label for="Pineapple">Pineapple</label><br><br>
 <input type="radio" name="fruit" id="Banana" value="7">
 <label for="Banana">Banana</label><br><br>
 <input type="radio" name="fruit" id="Watermelon" value="8">
 <label for="Watermelon"> Watermelon</label><br><br>
 <input type="radio" name="fruit" id="Jackfruit" value="9">
 <label for="Jackfruit">Jackfruit</label><br><br>
 <input type="radio" name="fruit" id="Orange" value="10">
 <label for="Orange">Orange</label><br><br>
 <input type="radio" name="fruit" id="Peach" value="11">
 <label for="Peach">Peach</label><br><br>
 <input type="radio" name="fruit" id="Pomegranate" value="12">
 <label for="Pomegranate">Pomegranate</label><br><br>
 <button type="submit" class="btn btn-primary">Submit</button>
 </form>
 </div>
 <script type="text/javascript">
 if ($('input[type=radio]:checked').length <= 0) {
 alert("No option selected!")
}</script> 
</body>
</html> 