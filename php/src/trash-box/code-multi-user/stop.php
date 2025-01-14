<?php
// Run the Docker exec command
$command = 'pkill -f video_user_video';
//$command = 'pkill --version';


// outputs the username that owns the running php/httpd process
// (on a system with the "whoami" executable in the path)
$output=null;
$retval=null;
exec($command, $output, $retval);
echo "Returned with status $retval and output:\n";
print_r($output);
?>
