
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
										<button onclick="return VideoScoreCard.judge('dataIntegrality',this.innerHTML);">10101无录音或录像</button>
										<button onclick="return VideoScoreCard.judge('dataIntegrality',this.innerHTML);">10102未拍摄拜访对象</button>
										<button onclick="return VideoScoreCard.judge('dataIntegrality',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td colspan="1">Critical:Wrong info 不实信息:</td><td>
										<span class="judgeResults" id="wrongInfo" style="color:red;"></span></td>
										<td colspan="1">
										<button onclick="return VideoScoreCard.judge('wrongInfo',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('wrongInfo',this.innerHTML);">10201不实承诺</button>
										<button onclick="return VideoScoreCard.judge('wrongInfo',this.innerHTML);">10202诱导下P</button>
										<button onclick="return VideoScoreCard.judge('wrongInfo',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td colspan="1">Critical:Attitude 态度问题:</td><td>
										<span class="judgeResults" id="attitude" style="color:red;"></span></td>
										<td colspan="1">
										<button onclick="return VideoScoreCard.judge('attitude',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('attitude',this.innerHTML);">10301态度恶劣</button>
										<button onclick="return VideoScoreCard.judge('attitude',this.innerHTML);">10302威胁恐吓</button>
										<button onclick="return VideoScoreCard.judge('attitude',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td colspan="1">Critical:Cheating 虚假行为:</td><td>
										<span class="judgeResults" id="cheating" style="color:red;"></span></td>
										<td colspan="1">
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);">10401虚假外访（有人扮演RPC）</button>
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);">10402外访时间与录像时间差别较大</button>
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>Critical:Information leakage 信息泄露:</td><td>
										<span class="judgeResults" id="informationLeakage" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('informationLeakage',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('informationLeakage',this.innerHTML);">10501未核实身份但透露贷款信息</button>
										<button onclick="return VideoScoreCard.judge('informationLeakage',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>Critical:Failing to report urgent complaints/other fraud 未上报紧急投诉/其他欺诈:</td><td>
										<span class="judgeResults" id="urgentNoReport" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('urgentNoReport',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('urgentNoReport',this.innerHTML);">10601未上报紧急投诉</button>
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
										<button onclick="return VideoScoreCard.judge('description',this.innerHTML);">20101日期和时间</button>
										<button onclick="return VideoScoreCard.judge('description',this.innerHTML);">20102客户姓名</button>
										<button onclick="return VideoScoreCard.judge('description',this.innerHTML);">20103合同号码</button>
										<button onclick="return VideoScoreCard.judge('description',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>Visit location 外访地址:</td><td>
										<span class="judgeResults" id="visitLocation" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('visitLocation',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('visitLocation',this.innerHTML);">20201未拍摄实际外访地址</button>
										<button onclick="return VideoScoreCard.judge('visitLocation',this.innerHTML);">20202外访地址错误</button>
										<button onclick="return VideoScoreCard.judge('visitLocation',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>Visit result 拜访结果:</td><td>
										<span class="judgeResults" id="matchedVisitResult" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('matchedVisitResult',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('matchedVisitResult',this.innerHTML);">20301外访结果填写错误</button>
										<button onclick="return VideoScoreCard.judge('matchedVisitResult',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr>
										<td>On time uploading 是否准时上传:</td><td>
										<span class="judgeResults" id="uploadOntime" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('uploadOntime',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('uploadOntime',this.innerHTML);">20401未准时上传</button>
										<button onclick="return VideoScoreCard.judge('uploadOntime',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr class="NONPC">
										<td>ID verification 身份核实:</td><td>
										<span class="judgeResults" id="IDVerification" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('IDVerification',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('IDVerification',this.innerHTML);">30101未核实身份</button>
										<button onclick="return VideoScoreCard.judge('IDVerification',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr class="NOWPC NONPC">
										<td>Self introduction 自我介绍:</td><td>
										<span class="judgeResults" id="selfIntroduction" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('selfIntroduction',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('selfIntroduction',this.innerHTML);">30201未自我介绍</button>
										<button onclick="return VideoScoreCard.judge('selfIntroduction',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr class="NOWPC NONPC">
										<td>Objection Handling 争议处理:</td><td>
										<span class="judgeResults" id="objectionHandling" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('objectionHandling',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('objectionHandling',this.innerHTML);">30301忽视不及时还款争议</button>
										<button onclick="return VideoScoreCard.judge('objectionHandling',this.innerHTML);">30302使用规定外的方案</button>
										<button onclick="return VideoScoreCard.judge('objectionHandling',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr class="NOWPC NONPC">
										<td>Providing info 提供信息:</td><td>
										<span class="judgeResults" id="infoProviding" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30401提供其他错误信息(RPC/TPC)</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30402忽视问题(RPC/TPC)</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30403未留言(TPC)</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30404未告知减免方案内容(Waving)</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">30405未告知减免方案失效政策(Waving)</button>
										<button onclick="return VideoScoreCard.judge('infoProviding',this.innerHTML);">清除</button>
										</td>
									</tr>
									<tr class="NOWPC NONPC">
										<td>Information Investigation 信息调查:</td><td>
										<span class="judgeResults" id="InfoInvestigation" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30501未询问住址(RPC)</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30502未询问联系方式(RPC)</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30503未询问工作(RPC)</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30504未询问违约原因(RPC)</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">30505未寻求RPC的联系信息(TPC)</button>
										<button onclick="return VideoScoreCard.judge('InfoInvestigation',this.innerHTML);">清除</button>
										</td>
									</tr>	
									<tr class="NOTPC NOWPC NONPC">
										<td>Announcing of the recording 提示录音录像:</td><td>
										<span class="judgeResults" id="announceRec" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">30601未提示录像</button>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">30602未二次提示录像</button>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">30603未提示录音</button>
										<button onclick="return VideoScoreCard.judge('announceRec',this.innerHTML);">清除</button>
										</td>
									</tr>	
									<tr class="NOTPC NOWPC NONPC">
										<td>Payment channel 还款渠道:</td><td>
										<span class="judgeResults" id="paymentChannel" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('paymentChannel',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('paymentChannel',this.innerHTML);">30701未推荐线上还款渠道</button>
										<button onclick="return VideoScoreCard.judge('paymentChannel',this.innerHTML);">清除</button>
										</td>
									</tr>	
									<tr class="NOTPC NOWPC NONPC">
										<td>Cash payment with approval 现金代收审批:</td><td>
										<span class="judgeResults" id="approvedCashCollect" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('approvedCashCollect',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('approvedCashCollect',this.innerHTML);">30801未有现金代收审批</button>
										<button onclick="return VideoScoreCard.judge('approvedCashCollect',this.innerHTML);">30802现金代收金额与审批金额不一致</button>
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
										<button onclick="return VideoScoreCard.judge('acceptWaiving',this.innerHTML);">40101接受</button>
										<button onclick="return VideoScoreCard.judge('acceptWaiving',this.innerHTML);">40102未接受</button>
										<button onclick="return VideoScoreCard.judge('acceptWaiving',this.innerHTML);">清除</button>
										</td>
									</tr>	
									<tr>
										<td>Sensitive wording 敏感字眼:</td><td>
										<span class="judgeResults" id="sensitiveWording" style="color:red;"></span></td>
										<td>
										<button onclick="return VideoScoreCard.judge('sensitiveWording',this.innerHTML);">0</button>
										<button onclick="return VideoScoreCard.judge('sensitiveWording',this.innerHTML);">40201敏感字眼</button>
										<button onclick="return VideoScoreCard.judge('sensitiveWording',this.innerHTML);">40202身份欺诈</button>
										<button onclick="return VideoScoreCard.judge('sensitiveWording',this.innerHTML);">40203其他欺诈</button>
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
echo $this->tag->javascriptInclude ( 'js/vrd.js?t=1026' );

