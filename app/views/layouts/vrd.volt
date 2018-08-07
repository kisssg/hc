
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
				<a class="navbar-brand" href="#">VRD Scoring</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
			
			<ul class="nav navbar-nav">
				<li><a href="/qm" target="_blank">Home</a></li>				
      </ul>
      
          <ul class="nav navbar-nav navbar-right">

            {%- set menus = [
              'Journals': 'journals/search',
              'Scores': 'journals/vrdScores'
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

{{content()}}
<!-- Modal 评分卡-->
				<div class="modal fade" id="videoScoreBoard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog " role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="videoScoreBoardTitle">Video Score</h4>
							</div>
							<div class="modal-body" style="width: 100%">
							<table class="questions ">
								<tr>
									<td>催收员：<span id="journal_creator"></span></td>
									<td>员工编号：<span id="employee_code"></span></td>
									<td>城市：<span id="city"></span></td>
								</tr>
								<tr>
									<td>合同号：<span id="contract_no"></span></td>
									<td>外访日期：<span id="visit_date_card"></span></td>
									<td>签到地址：<span id="signInAddr"><span id="addr_detail"></span><span id="addr_sign_in"></span></span></td>
								</tr>
								<tr>
									<td>外访时间：<span id="visit_time"></span></td>
									<td>外访结果：<span id="visit_result"></span></td>
									<td>质检结果：<span id="validity"></span></td>
								</tr>									
									<tr>
										<td colspan="3">
											<div class="form-group">
												<label for="object" class="col-sm-4 control-label">Object：</label>
												<div class="col-sm-5">
													<input type="text" class="form-control input-sm" id="object" value="">
												</div>
											</div>
										</td>
									</tr>
									<tr id="videoBottom">
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">1. Data integrality</div>
												<div class="col-xs-2">
													<select class="form-control input-sm fif-value videoScore" id="integrality">
														<option>15</option>
														<option>0</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">2. Description of the visit</div>
												<div class="col-xs-2">
													<select class="form-control input-sm fif-value videoScore" id="description">
														<option>15</option>
														<option>0</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">3. Announcing of the recording</div>
												<div class="col-xs-2">
													<select class="form-control input-sm fif-value videoScore" id="announcement">
														<option>15</option>
														<option>0</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">4. Start location/end location</div>
												<div class="col-xs-2">
													<select class="form-control input-sm fif-value videoScore" id="location">
														<option>15</option>
														<option>0</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">5. Objection handling</div>
												<div class="col-xs-2">
													<select class="form-control input-sm fif-value videoScore" id="objectionHandling">
														<option>15</option>
														<option>0</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">6. no harassment visit</div>
												<div class="col-xs-2">
													<select class="form-control input-sm fif-value videoScore" id="noHarassment">
														<option>15</option>
														<option>0</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">7. Compliant PTP</div>
												<div class="col-xs-2">
													<select class="form-control input-sm five-value videoScore" id="getPTP">
														<option>5</option>
														<option>0</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">8. skip trace</div>
												<div class="col-xs-2">
													<select class="form-control input-sm five-value videoScore" id="skipTrace">
														<option>5</option>
														<option>0</option>
													</select>
												</div>
											</div>
										</td>
									</tr>								
									<tr>
										<td colspan="3"><div class="row">
												<div class="col-md-7">Total score 总分：</div>
												<div class="col-xs-2">
													<div id="score">100</div>
												</div>
											</div></td>
									</tr>
									
									<tr>
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">Complaint Indicator:</div>
												<div class="col-xs-2">
													<select class="form-control input-sm" id="complaintIndicator">
														<option>N</option>
														<option>Y</option>
													</select>
												</div>
											</div>
										</td>
									</tr>	
									<tr>
										<td colspan="3">
											<div class="form-group">
												<label for="remark" class="col-sm-2 control-label">备注：</label>
												<div class="col-sm-10">
													<textarea class="form-control" id="remark" rows="5" onkeyup="" maxlength="500" placeholder="remark"></textarea>
												</div>
											</div>
										</td>
									</tr>
								</table>
							</div>
							<div class="modal-footer">
								<input type="hidden" id="journalID" value=""/>
								<span id="tips"></span>
								<button type="button" class="btn btn-primary" onclick="return VideoScore.add();" id="scoreSubmitBtn">提交</button>
								<button type="button" class="btn btn-default"
									data-dismiss="modal">关闭</button>
							</div>
						</div>
					</div>
				</div>
<!-- end of modal -->
<?php
echo $this->tag->javascriptInclude ( 'js/journals.js?t=0525' );

