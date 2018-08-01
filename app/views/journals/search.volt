<?php
$visit_date=isset($_GET['visit_date'])?($_GET['visit_date']):"";
$collector=isset($_GET['collector'])?$_GET['collector']:"";
?>
{{ content()}}
<form action="" method="post">
日期：<input type="text" class="datepicker" name="visit_date" id="visit_date" value=""/>
催收员：<input type="text" name="journal_creator" id ="" value=""/>
合同号：<input type="text" name="contract_no" id ="" value=""/>
<input type="submit" class="btn btn-default btn-xs" value="搜索"/>
</form>
{% for journal in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>合同号</th>
            <th>外催员</th>
            <th>外访结果</th>
            <th>外访日期</th>
            <th>外访时间</th>
            <th>地址判定</th>
            <th>设备判定</th>
            <th colspan="2">质检</th>            
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr id="{{journal.j_id}}">
            <td class="contract_no">{{ journal.contract_no }}</td>
            <td class="journal_creator">{{ journal.journal_creator }}</td>
            <td class="visit_result_cn">{{ journal.visit_result_cn }}</td>
            <td class="visit_date">{{ journal.visit_date }}</td>
            <td class="visit_time">{{ journal.visit_time }}</td>
            <td class="validity">{{ journal.validity }}</td>
            <td class="equipment_id">{{ journal.equipment_id }}</td>
            <td class="qc_name">{{ journal.qc_name }}</td>
            <input type="hidden" class="employee_code" value="{{journal.employee_code}}"/>
            <td width="7%">{{ link_to("", '评分', "class": "btn btn-default btn-xs","data-toggle":"modal","data-target":"#videoScoreBoard","data-id":journal.j_id) }}</td>
        </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="9" align="right">
                <div class="btn-group">
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                    {{ link_to("journals/search", '&laquo; 首页', "class": "btn btn-default") }}
                    {{ link_to("journals/search?page=" ~ page.before, '&lsaquo; 上一页', "class": "btn btn-default") }}
                    {{ link_to("journals/search?page=" ~ page.next, '下一页 &rsaquo;', "class": "btn btn-default") }}
                    {{ link_to("journals/search?page=" ~ page.last, '末页 &raquo;', "class": "btn btn-default") }}
                </div>
            </td>
        </tr>
    </tbody>
</table>

<!-- Modal 评分卡-->
				<div class="modal fade" id="videoScoreBoard" tabindex="-1"
					role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog " role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"
									aria-label="Close">
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
									<td>签到地址：<span id="addr_detail"></span><span id="addr_sign_in"></span></td>
								</tr>
								<tr>
									<td>外访时间：<span id="visit_time"></span></td>
									<td>外访结果：<span id="visit_result"></span></td>
									<td>质检结果：<span id="validity"></span></td>
								</tr>								
									<tr>
										<td colspan="3">
											<div class="form-group">
												<label for="duration" class="col-sm-4 control-label">Duration：</label>
												<div class="col-sm-5">
													<input type="text" class="form-control input-sm"
														id="duration" value="">
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="form-group">
												<label for="object" class="col-sm-4 control-label">Object：</label>
												<div class="col-sm-5">
													<input type="text" class="form-control input-sm"
														id="object" value="">
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="form-group">
												<label for="videoName" class="col-sm-4 control-label">Video Name：</label>
												<div class="col-sm-5">
													<input type="text" class="form-control input-sm"
														id="videoName" value="">
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td colspan="3">
											<div class="row">
												<div class="col-md-7">1. Data integrality</div>
												<div class="col-xs-2">
													<select class="form-control input-sm ten-value mys-score-val" id="">
														<option>10</option>
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
													<select class="form-control input-sm ten-value mys-score-val" id="">
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
													<select class="form-control input-sm ten-value mys-score-val" id="">
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
													<select class="form-control input-sm ten-value mys-score-val" id="">
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
													<select class="form-control input-sm ten-value mys-score-val" id="">
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
													<select class="form-control input-sm ten-value mys-score-val" id="">
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
													<select class="form-control input-sm ten-value mys-score-val" id="">
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
													<select class="form-control input-sm ten-value mys-score-val" id="">
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
											<div class="form-group">
												<label for="remark" class="col-sm-2 control-label">备注：</label>
												<div class="col-sm-10">
													<textarea class="form-control" id="issue_detail" rows="5"
														onkeyup="wordStatic(this,'remark_num');" maxlength="500"
														placeholder="remark"></textarea>
													<span id="remark_num">0</span>/500
												</div>
											</div>
										</td>
									</tr>
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" onclick="return VideoScore.addScore();">提交</button>
								<button type="button" class="btn btn-default"
									data-dismiss="modal">关闭</button>
							</div>
						</div>
					</div>
				</div>
<!-- end of modal -->

    {% endif %}
{% else %}
    No journals are recorded
{% endfor %}

<?php
echo $this->tag->javascriptInclude ( 'js/journals.js?t=0525' );

