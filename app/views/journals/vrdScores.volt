{{ content()}}
<form action="" method="post">
日期：<input type="text" class="datepicker" name="visit_date" id="visit_date" value="{{request.getQuery("visitDate")}}"/>
催收员：<input type="text" name="journal_creator" id ="" value=""/>
质检：<input type="text" name="QC" id ="" value=""/>
内审结果：<input type="text" name="auditResult" id ="" value=""/>
合同号：<input type="text" name="contract_no" id ="" value="{{request.getQuery("srvID")}}"/>
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
			<input type="hidden" class="announceRec" value="{{vrdScore.announceRec}}"/>
			<input type="hidden" class="visitLocation" value="{{vrdScore.visitLocation}}"/>
			<input type="hidden" class="objectionHandling" value="{{vrdScore.objectionHandling}}"/>
			<input type="hidden" class="InfoInvestigation" value="{{vrdScore.InfoInvestigation}}"/>
			<input type="hidden" class="matchedVisitResult" value="{{vrdScore.matchedVisitResult}}"/>
			<input type="hidden" class="uploadOntime" value="{{vrdScore.uploadOntime}}"/>
			<input type="hidden" class="IDVerification" value="{{vrdScore.IDVerification}}"/>
			<input type="hidden" class="selfIntroduction" value="{{vrdScore.selfIntroduction}}"/>
			<input type="hidden" class="infoProviding" value="{{vrdScore.infoProviding}}"/>
			<input type="hidden" class="paymentChannel" value="{{vrdScore.paymentChannel}}"/>
			<input type="hidden" class="approvedCashCollect" value="{{vrdScore.approvedCashCollect}}"/>
			<input type="hidden" class="dataIntegrality" value="{{vrdScore.dataIntegrality}}"/>
			<input type="hidden" class="wrongInfo" value="{{vrdScore.wrongInfo}}"/>
			<input type="hidden" class="attitude" value="{{vrdScore.attitude}}"/>
			<input type="hidden" class="cheating" value="{{vrdScore.cheating}}"/>
			<input type="hidden" class="informationLeakage" value="{{vrdScore.informationLeakage}}"/>
			<input type="hidden" class="urgentNoReport" value="{{vrdScore.urgentNoReport}}"/>
			<input type="hidden" class="acceptWaiving" value="{{vrdScore.acceptWaiving}}"/>
			<input type="hidden" class="sensitiveWording" value="{{vrdScore.sensitiveWording}}"/>
			<input type="hidden" class="description" value="{{vrdScore.description}}"/>
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
                <div class="btn-group">
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
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


