
<body>
<?php
    $command = escapeshellcmd("python python.py");
    $output = shell_exec($command);
    echo $output;
?>
<h1>hello</h1>
</body>