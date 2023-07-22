<?php
    // Your PHP code that has to be executed every 5 minutes comes here
?>
<script>
setTimeout(function () { window.location.reload(); }, 5*60*1000);
// just show current time stamp to see time of last refresh.
document.write(new Date());
</script>