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
            <th colspan="2">质检</th>            
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr id="{{journal.id}}">
            <td class="contract_no">{{ journal.contractNo }}</td>
            <td class="journal_creator">{{ journal.LLI }}</td>
            <td class="visit_result_cn">{{ journal.visitResult }}</td>
            <td class="visit_date">{{ journal.visitDate }}</td>
            <td class="visit_time">{{ journal.visitTime }}</td>
            <td class="QC">{{ journal.QC }}</td>
            <input type="hidden" class="employeeID" value="{{journal.employeeID}}"/>
            <input type="hidden" class="city" value="{{journal.city}}"/>
            <input type="hidden" class="addr_detail" value="{{journal.addr_detail}}"/>
            <input type="hidden" class="addr_sign_in" value="{{journal.addr_sign_in}}"/>
            <input type="hidden" class="journalID" value="{{journal.j_id}}"/>
            <input type="hidden" class="employee_code" value="{{journal.employee_code}}"/>
            <td width="7%">{{ link_to("#", '修改', "class": "btn btn-default btn-xs","data-toggle":"modal","data-target":"#videoScoreBoard","data-backdrop":"static","data-id":journal.id) }}</td>
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

