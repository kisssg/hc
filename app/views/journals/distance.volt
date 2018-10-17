Visit Date:<input type='text' class='datepicker' id='visitDate' value='' placeholder='Visit Date' />
		<input type='button' class='btn btn-primary btn' onclick='return Distance.createHomeLog();' value='Go PikaChu!'/>
		<input type='button' class='btn btn-primary btn-xs' onclick='return Distance.fetchStartPoints();' value='Fetch Start Points'/>
		<input type='button' class='btn btn-default btn-xs' onclick='return Distance.clearStartPoints();' value='Clear Start Points'/>
		<input type='button' class='btn btn-primary btn-xs' onclick='return Distance.calc();' value='Calculate Distance'/>
		<input type='button' class='btn btn-default btn-xs' onclick='return Distance.clearCalc();' value='Clear Distance'/>
		<input type='button' class='btn btn-default btn-xs' onclick='return Distance.delHomeLog();' value='Delete Home Log'/>
		<input type='button' value='Clear info' onclick='return Distance.clearInfo();'/><br/>
		Info:<br/>		
		<pre id='info'></pre>
<?php
echo $this->tag->javascriptInclude ( 'js/distance.js?t=1' );