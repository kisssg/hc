
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
													<option>Non_RPC</option>
													<option>-</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr id="videoBottom" class="both">
										<td colspan="1">1. Did LLI announce contract# at the beginning of video?</td><td>
										<span class="vintage4 judgeResults" id="announceContract" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('announceContract',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('announceContract',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="both">
										<td colspan="1">2. Did LLI record on video surrounding of the client’s address?</td><td>
										<span class="vintage4 judgeResults" id="recSurrounding" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('recSurrounding',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('recSurrounding',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="rpc_only">
										<td colspan="1">3. Did LLI introduce himself, company and announced recording to client? (any failure=0)</td><td>
										<span class="vintage4 judgeResults" id="selfIntro" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('selfIntro',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('selfIntro',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="rpc_only">
										<td colspan="1">4. If recording finished earlier, was disagreement of RPC with both video and audio recorded on video?</td><td>
										<span class="vintage4 judgeResults" id="RPCEndRec" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('RPCEndRec',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('RPCEndRec',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="both">
										<td colspan="1">5. Did LLI update the DT with correct result of visit,?</td><td>
										<span class="vintage4 judgeResults" id="updateDT" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('updateDT',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('updateDT',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="both">
										<td colspan="1">6. Did LLI record fake collection video？</td><td>
										<span class="vintage4 judgeResults" id="cheating" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('cheating',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="non_rpc_only">
										<td colspan="1">7. Did LLI ask neighbor when/how to catch client?</td><td>
										<span class="vintage4 judgeResults" id="askOthers" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('askOthers',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('askOthers',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="non_rpc_only">
										<td colspan="1">8. Did LLI leave letter with message?</td><td>
										<span class="vintage4 judgeResults" id="leaveMsg" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('leaveMsg',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('leaveMsg',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="rpc_only">
										<td colspan="1">9. Did LLI ask for debt amount?</td><td>
										<span class="vintage4 judgeResults" id="askForDebt" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('askForDebt',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('askForDebt',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="rpc_only">
										<td colspan="1">10. Did LLI argue with consequences if not paid?</td><td>
										<span class="vintage4 judgeResults" id="tellConsequence" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('tellConsequence',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('tellConsequence',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="rpc_only">
										<td colspan="1">11. Did LLI negotiate for payment?</td><td>
										<span class="vintage4 judgeResults" id="negotiatePay" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('negotiatePay',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('negotiatePay',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="rpc_only">
										<td colspan="1">12. Did LLI provide/investigate possible solutions?</td><td>
										<span class="vintage4 judgeResults" id="provideSolution" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('provideSolution',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('provideSolution',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="rpc_only">
										<td colspan="1">13. Did LLI ask for payment immediately, if later did he asked for specific date?</td><td>
										<span class="vintage4 judgeResults" id="specificCollect" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('specificCollect',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('specificCollect',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="rpc_only">
										<td colspan="1">14. Did LLI follow payment hierarchy (1. on-line payment directly to Home Credit, 2. Cash payment by client to bank?, 3. Direct debit)?</td><td>
										<span class="vintage4 judgeResults" id="payHierarchy" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('payHierarchy',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('payHierarchy',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>
									<tr class="rpc_only">
										<td colspan="1">15. If agreed mode was payment in cash to LLI, did LLI ask for approval in advance?</td><td>
										<span class="vintage4 judgeResults" id="cashCollect" ></span></td>
										<td colspan="1" class="coverShow">
										<button onclick="return VideoScoreCard.judge('cashCollect',this.innerHTML);" class='vintage4'>0</button>
										<button onclick="return VideoScoreCard.judge('cashCollect',this.innerHTML);" class='vintage4'>1</button>
										</td>
									</tr>							
									<tr>
										<td colspan="3">
										<div class="row">
												<div class="col-md-7">Total score 总分：</div>
												<div class="col-xs-2">
													<div id="score" class='vintage4'>100</div>
												</div>
										</div>
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
echo $this->tag->javascriptInclude ( 'js/vrd.js?t=122802' );

