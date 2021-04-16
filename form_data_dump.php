<html>
<head>
<title>
Displaying All Form Data
</title>
</head>
<body>

<h1>Displaying All Form Data</h1>
Here is the form's data I got:
<br><br><br />
<?php
    foreach($_REQUEST as $index => $value){
        if(is_array($value)){
            foreach($value as $number => $item){
                echo "${index}[${number}] => $item <br>";
            }
        }
        else {
        echo $index, " => ", $value, "<br>";
        }
    }
?>

</body>
</html>