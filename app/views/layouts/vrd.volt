
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
					<div class="modal-dialog  modal-lg" role="document">
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
									<td>质检结果：<span id="validity"></span></td>
								</tr>
								<tr>
									<td colspan="2">外访结果：<span id="visit_result"></span></td>
									<td>交涉对象：<span id="negotiator_cn"></span></td>
								</tr>								
								<tr>
									<td colspan="2">签到地址：<span id="signInAddr"><span id="addr_detail"></span><span id="addr_sign_in"></span></span></td>
									<td>外访时间：<span id="visit_time"></span></td>
								</tr>									
									<tr id="objectTr">
										<td colspan="3">
											<div class="form-group">
												<label for="object" class="col-sm-4 control-label">Object：</label>
												<div class="col-sm-5">
													<select class="form-control input-sm" id="object" onchange="return VideoScoreCard.onObjectChange(this.value);">
													<option>RPC</option>
													<option>TPC</option>
													<option>WPC</option>
													<option>NPC</option>
													<option>-</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr id="videoBottom">
										<td colspan="1">Critical:Data integrality 数据完整性:</td><td>
										<span class="judgeResults" id="dataIntegrality" style="color:red;"></span></td>
										<td colspan="1">
										<button onclick="return VideoScoreCard.judge('dataIntegrality',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('dataIntegrality',this.innerHTML);">10101 No matched video/voice</button>
										<button onclick="return VideoScoreCard.judge('dataIntegrality',this.innerHTML);">10102 Not record visit</button>
										<button onclick="return VideoScoreCard.judge('dataIntegrality',this.innerHTML);">10103 Provide voice but no video</button>
										<button onclick="return VideoScoreCard.judge('dataIntegrality',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td colspan="1">Critical:Wrong info 不实信息:</td><td>
										<span class="judgeResults" id="wrongInfo" style="color:red;"></span></td>
										<td colspan="1">
										<button onclick="return VideoScoreCard.judge('wrongInfo',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('wrongInfo',this.innerHTML);">10201 Untrue  promises</button>
										<button onclick="return VideoScoreCard.judge('wrongInfo',this.innerHTML);">10202 Inducement</button>
										<button onclick="return VideoScoreCard.judge('wrongInfo',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td colspan="1">Critical:Attitude 态度问题:</td><td>
										<span class="judgeResults" id="attitude" style="color:red;"></span></td>
										<td colspan="1">
										<button onclick="return VideoScoreCard.judge('attitude',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('attitude',this.innerHTML);">10301 Bad attitude</button>
										<button onclick="return VideoScoreCard.judge('attitude',this.innerHTML);">10302 Threat or intimidation</button>
										<button onclick="return VideoScoreCard.judge('attitude',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td colspan="1">Critical:Cheating 虚假行为:</td><td>
										<span class="judgeResults" id="cheating" style="color:red;"></span></td>
										<td colspan="1">
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);">10401 False visit(someone plays RPC)</button>
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);">10402 big difference between visiting time and video time</button>
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>Critical:Information leakage 信息泄露:</td><td>
										<span class="judgeResults" id="informationLeakage" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('informationLeakage',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('informationLeakage',this.innerHTML);">10501 NO ID verification but leaked information</button>
										<button onclick="return VideoScoreCard.judge('informationLeakage',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>Critical:Failing to report urgent complaints/other fraud 未上报紧急投诉/其他欺诈:</td><td>
										<span class="judgeResults" id="urgentNoReport" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('urgentNoReport',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('urgentNoReport',this.innerHTML);">10601 Didn't report urgent case</button>
										<button onclick="return VideoScoreCard.judge('urgentNoReport',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
									<td colspan="3"></td>
									</tr>
									<tr>
										<td>Contract description 合同要素描述:</td><td>
										<span class="judgeResults" id="description" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('description',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('description',this.innerHTML);">20101 Contract number</button>
										<button onclick="return VideoScoreCard.judge('description',this.innerHTML);">20102 Customer name</button>
										<button onclick="return VideoScoreCard.judge('description',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>Visit location 外访地址:</td><td>
										<span class="judgeResults" id="visitLocation" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('visitLocation',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('visitLocation',this.innerHTML);">20201 Didn't record visit location</button>
										<button onclick="return VideoScoreCard.judge('visitLocation',this.innerHTML);">20202 Visit wrong location</button>
										<button onclick="return VideoScoreCard.judge('visitLocation',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>Visit result 拜访结果:</td><td>
										<span class="judgeResults" id="matchedVisitResult" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('matchedVisitResult',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('matchedVisitResult',this.innerHTML);">20301 Wrong Visit result</button>
										<button onclick="return VideoScoreCard.judge('matchedVisitResult',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>On time uploading 是否准时上传:</td><td>
										<span class="judgeResults" id="uploadOntime" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('uploadOntime',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('uploadOntime',this.innerHTML);">20401 Didn't upload on time</button>
										<button onclick="return VideoScoreCard.judge('uploadOntime',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr class="NONPC">
										<td>ID verification 身份核实:</td><td>
										<span class="judgeResults" id="IDVerification" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('IDVerification',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('IDVerification',this.innerHTML);">30101 No ID verification</button>
										<button onclick="return VideoScoreCard.judge('IDVerification',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr class="NONPC">
										<td>Self introduction 自我介绍:</td><td>
										<span class="judgeResults" id="selfIntroduction" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('selfIntroduction',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('selfIntroduction',this.innerHTML);">30201 Using not allowed self-introduction</button>
										<button class="NOTPC NOWPC" onclick="return VideoScoreCard.judge('selfIntroduction',this.innerHTML);">30202 No Self-introduction</button>
										<button onclick="return VideoScoreCard.judge('selfIntroduction',this.innerHTML);">清除</button>										
										</td>
									</tr>
									<tr class="NOWPC NONPC">
										<td>Objection Handling 争议处理:</td><td>
										<span class="judgeResults" id="objectionHandling" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('objectionHandling',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('objectionHandling',this.innerHTML);">30301 Didn't handle objections</button>
										<button onclick="return VideoScoreCard.judge('objectionHandling',this.innerHTML);">30302 Didn't use suggested way</button>
										<button onclick="return VideoScoreCard.judge('objectionHandling',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr class="NOWPC NONPC">
										<td>Providing info 提供信息:</td><td>
										<span class="judgeResults" id="infoProviding" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30401 Provide mistake information</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30402 Ignore  RPC's questions</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30403 No message</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30404 Did’t mention waving amount</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30405 Did’t mention waving time limit</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr class="NOWPC NONPC">
										<td>Information Investigation 信息调查:</td><td>
										<span class="judgeResults" id="InfoInvestigation" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30501 Didn't ask address</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30502 Didn't ask contact information</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30503 Didn't ask Job</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30504 Didn't ask the reason of defaulting</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30505 Didn't ask RPC‘s contact information</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">清除</button>
										</td>
									</tr>	
									<tr class="NOTPC NOWPC NONPC">
										<td>Announcing of the recording 提示录音录像:</td><td>
										<span class="judgeResults" id="announceRec" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">30601 No 1st  announcement of the video recording</button>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">30602 No 2nd announcement of the video recording</button>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">30603 No announcement of the voice recording</button>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">清除</button>
										</td>
									</tr>	
									<tr class="NOTPC NOWPC NONPC">
										<td>Payment channel 还款渠道:</td><td>
										<span class="judgeResults" id="paymentChannel" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('paymentChannel',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('paymentChannel',this.innerHTML);">30701 Didn't suggest on-line payment</button>
										<button onclick="return VideoScoreCard.judge('paymentChannel',this.innerHTML);">清除</button>
										</td>
									</tr>	
									<tr class="NOTPC NOWPC NONPC">
										<td>Cash payment with approval 现金代收审批:</td><td>
										<span class="judgeResults" id="approvedCashCollect" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('approvedCashCollect',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('approvedCashCollect',this.innerHTML);">30801 Cash collect without approval</button>
										<button onclick="return VideoScoreCard.judge('approvedCashCollect',this.innerHTML);">30802 Cash collect without transferring to HCC</button>
										<button onclick="return VideoScoreCard.judge('approvedCashCollect',this.innerHTML);">清除</button>
										</td>
									</tr>							
									<tr>
										<td colspan="3">
										<div class="row">
												<div class="col-md-7">Total score 总分：</div>
												<div class="col-xs-2">
													<div id="score">100</div>
												</div>
										</div>
										</td>
									</tr>	
									<tr>
										<td>Client accept waving 客户接受减免:</td><td>
										<span class="judgeResults" id="acceptWaiving" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('acceptWaiving',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('acceptWaiving',this.innerHTML);">40101 Accept</button>
										<button onclick="return VideoScoreCard.judge('acceptWaiving',this.innerHTML);">40102 Didn't accept</button>
										<button onclick="return VideoScoreCard.judge('acceptWaiving',this.innerHTML);">清除</button>
										</td>
									</tr>	
									<tr>
										<td>Sensitive wording 敏感字眼:</td><td>
										<span class="judgeResults" id="sensitiveWording" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('sensitiveWording',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('sensitiveWording',this.innerHTML);">40201 Sensitive wording</button>
										<button onclick="return VideoScoreCard.judge('sensitiveWording',this.innerHTML);">40202 Identity fraud</button>
										<button onclick="return VideoScoreCard.judge('sensitiveWording',this.innerHTML);">40203 Other frauds</button>
										<button onclick="return VideoScoreCard.judge('sensitiveWording',this.innerHTML);">清除</button>
										</td>
									</tr>	
									<tr id="tableBottom">
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
echo $this->tag->javascriptInclude ( 'js/vrd.js?t=1120' );

