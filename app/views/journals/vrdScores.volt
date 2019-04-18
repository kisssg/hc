{{ content()}}
<form action="" method="post">
日期：<input type="text" class="datepicker" name="visit_date" id="visit_date" value=""/>
催收员：<input type="text" name="journal_creator" id ="" value=""/>
质检：<input type="text" name="QC" id ="" value=""/>
内审结果：<input type="text" name="auditResult" id ="" value=""/>
合同号：<input type="text" name="contract_no" id ="" value=""/>
对象：<select name="object" >
		<option></option>
		<option>RPC</option>													
		<option>Non_RPC</option>
		<option>-</option>
	</select>
<input type="submit" class="btn btn-default btn-xs" value="搜索"/>
</form>
{% for vrdScore in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>合同号</th>
            <th>外催员</th>
            <th>外访结果</th>
            <th>对象</th>
            <th>外访日期</th>
            <th>外访时间</th>
            <th>评分</th>
            <th colspan="2">质检</th>            
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr id="{{vrdScore.id}}">
            <td class="contractNo">{{ vrdScore.contractNo }}</td>
            <td class="LLI">{{ vrdScore.LLI }}</td>
            <td class="visitResult">{{ vrdScore.visitResult }}</td>
            <td>{{ vrdScore.object }}</td>
            <td class="visitDate">{{ vrdScore.visitDate }}</td>
            <td class="visitTime">{{ vrdScore.visitTime }}</td>
            <td class="score">{{ vrdScore.score }}</td>
            <td class="QC">{{ vrdScore.QC }}</td>
			<input type='hidden' class='videoInfo' value='{{vrdScore.videoInfo}}'/>
			<input type='hidden' class='city' value='{{vrdScore.city}}'/>
			<input type='hidden' class='employeeID' value='{{vrdScore.employeeID}}'/>
			<input type='hidden' class='signInAddr' value='{{vrdScore.signInAddr}}'/>
			<input type='hidden' class='negotiator_cn' value='{{vrdScore.negotiator}}'/>
			<input type='hidden' class='object' value='{{vrdScore.object}}'/>
			
			<input type='hidden' class='cheating' value='{{vrdScore.cheating}}'/>
			<input type='hidden' class='recSurrounding' value='{{vrdScore.recSurrounding}}'/>
			<input type='hidden' class='announceContract' value='{{vrdScore.announceContract}}'/>
			<input type='hidden' class='selfIntro' value='{{vrdScore.selfIntro}}'/>
			<input type='hidden' class='RPCEndRec' value='{{vrdScore.RPCEndRec}}'/>
			<input type='hidden' class='askOthers' value='{{vrdScore.askOthers}}'/>
			<input type='hidden' class='leaveMsg' value='{{vrdScore.leaveMsg}}'/>
			<input type='hidden' class='askForDebt' value='{{vrdScore.askForDebt}}'/>
			<input type='hidden' class='tellConsequence' value='{{vrdScore.tellConsequence}}'/>
			<input type='hidden' class='negotiatePay' value='{{vrdScore.negotiatePay}}'/>
			<input type='hidden' class='provideSolution' value='{{vrdScore.provideSolution}}'/>
			<input type='hidden' class='specificCollect' value='{{vrdScore.specificCollect}}'/>
			<input type='hidden' class='payHierarchy' value='{{vrdScore.payHierarchy}}'/>
			<input type='hidden' class='updateDT' value='{{vrdScore.updateDT}}'/>
			<input type='hidden' class='cashCollect' value='{{vrdScore.cashCollect}}'/>						
			
			<input type='hidden' class='remark' value='{{vrdScore.remark}}'/>
			<input type='hidden' class='score' value='{{vrdScore.score}}'/>
			<input type='hidden' class='journalID' value='{{vrdScore.journalID}}'/>
			
			<input type='hidden' class='auditResult' value='{{vrdScore.auditResult}}'/>
            <td>
            {{ link_to("#", '修改', "class": "btn btn-default btn-xs","data-toggle":"modal","data-target":"#videoScoreBoard","data-backdrop":"static","data-id":vrdScore.id,"data-action":"edit") }}
            {{ tagHtml("input",["type":"button","value": "删除", "class":"btn btn-default btn-xs","onclick":"return VideoScore.delete("~vrdScore.id~");"],true) }}
            {% if vrdScore.auditResult=="blank" %}
            {{ link_to("#", '审核', "class": "btn btn-default btn-xs","data-toggle":"modal","data-target":"#videoScoreBoard","data-backdrop":"static","data-id":vrdScore.id,"data-action":"audit") }}
            {% else %}
            {{ link_to("#", '审核'~vrdScore.auditResult, "class": "btn btn-primary btn-xs","data-toggle":"modal","data-target":"#videoScoreBoard","data-backdrop":"static","data-id":vrdScore.id,"data-action":"audit") }}
            {% endif %}
            </td>
        </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="9" align="right">
                    <span class="in-line">{{ page.current }}/{{ page.total_pages }}</span>
                <div class="btn-group">
                    {{ link_to("journals/vrdScores", '&laquo; 首页', "class": "btn btn-default") }}
                    {{ link_to("journals/vrdScores?page=" ~ page.before, '&lsaquo; 上一页', "class": "btn btn-default") }}
                    {{ link_to("journals/vrdScores?page=" ~ page.next, '下一页 &rsaquo;', "class": "btn btn-default") }}
                    {{ link_to("journals/vrdScores?page=" ~ page.last, '末页 &raquo;', "class": "btn btn-default") }}
                </div>
            </td>
        </tr>
    </tbody>
</table>


    {% endif %}
{% else %}
    No record
{% endfor %}


