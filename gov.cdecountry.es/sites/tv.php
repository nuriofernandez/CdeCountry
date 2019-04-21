<?php 
/************************ Variable area ************************/
$head['title'] = "TV";
$site['active-tab'] = "tab-tv";
?>
<div id="dynamicDiv">
    <main class="container">
        <iframe id="tvframe" src="https://new.cdecountry.es/frames/TVFrame/" class="nofullScreen"></iframe>
        <button class="btn btn-secondary btn-block my-2 my-sm-0 btn-lg" onclick="makeFullScreenTV()">Fullscreen</button>
    </main>
</div>