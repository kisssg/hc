
<!-- Fixed navbar -->
<div>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Data Charts</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
			
			<ul class="nav navbar-nav">
				<li><a href="/qm" target="_blank">Home</a></li>				
      </ul>
      
          <ul class="nav navbar-nav navbar-right">

            {%- set menus = [
              'DingCheck': 'charts/visitCheck',
              'OSV monitor': 'charts/#',
              'Call back':'charts/index',
              'Issues':'charts/issues'
            ] -%}

            {%- for key, value in menus %}
              {% if value == dispatcher.getControllerName()~"/"~dispatcher.getActionName() %}
              <li class="active">{{ link_to(value, key) }}</li>
              {% else %}
              <li>{{ link_to(value, key) }}</li>
              {% endif %}
            {%- endfor -%}

          </ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>
</div>

<div class="container main-container">
  {{ content() }}
</div>