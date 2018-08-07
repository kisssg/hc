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
            <input type="hidden" class="employeeID" value="{{vrdScore.employeeID}}"/>
            <input type="hidden" class="city" value="{{vrdScore.city}}"/>
            <input type="hidden" class="signInAddr" value="{{vrdScore.signInAddr}}"/>
            <input type="hidden" class="journalID" value="{{vrdScore.journalID}}"/>
            <input type="hidden" class="object" value="{{vrdScore.object}}"/>
            <input type="hidden" class="remark" value="{{vrdScore.remark}}"/>
            <input type="hidden" class="videoInfo" value="{{vrdScore.videoInfo}}"/>
            <input type="hidden" class="integrality" value="{{vrdScore.integrality}}"/>
            <input type="hidden" class="description" value="{{vrdScore.description}}"/>
            <input type="hidden" class="announcement" value="{{vrdScore.announcement}}"/>
            <input type="hidden" class="location" value="{{vrdScore.location}}"/>
            <input type="hidden" class="objectionHandling" value="{{vrdScore.objectionHandling}}"/>
            <input type="hidden" class="noHarassment" value="{{vrdScore.noHarassment}}"/>
            <input type="hidden" class="getPTP" value="{{vrdScore.getPTP}}"/>
            <input type="hidden" class="skipTrace" value="{{vrdScore.skipTrace}}"/>
            <input type="hidden" class="complaintIndicator" value="{{vrdScore.complaintIndicator}}"/>
            <input type="hidden" class="journalID" value="{{vrdScore.journalID}}"/>
            <td>
            {{ link_to("#", '修改', "class": "btn btn-default btn-xs","data-toggle":"modal","data-target":"#videoScoreBoard","data-backdrop":"static","data-id":vrdScore.id,"data-action":"edit") }}
            {{ tagHtml("input",["type":"button","value": "删除", "class":"btn btn-default btn-xs","onclick":"return VideoScore.delete("~vrdScore.id~");"],true) }}
            {{ link_to("#", '审核', "class": "btn btn-default btn-xs","data-toggle":"modal","data-target":"#videoScoreBoard","data-backdrop":"static","data-id":vrdScore.id,"data-action":"autit") }}
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
    No journals are recorded
{% endfor %}

<?php
echo $this->tag->javascriptInclude ( 'js/journals.js?t=0525' );

