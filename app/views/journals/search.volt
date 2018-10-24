{{ content()}}
<form action="" method="post">
日期：<input type="text" class="datepicker" name="visit_date" id="visit_date" value="{{request.getQuery("visitDate")}}"/>
催收员：<input type="text" name="journal_creator" id ="" value="{{request.getQuery("collector")}}"/>
合同号：<input type="text" name="contract_no" id ="" value="{{request.getQuery("srvID")}}"/>
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
            <input type="hidden" class="city" value="{{journal.city}}"/>
            <input type="hidden" class="addr_detail" value="{{journal.addr_detail}}"/>
            <input type="hidden" class="addr_sign_in" value="{{journal.addr_sign_in}}"/>
            <input type="hidden" class="journalID" value="{{journal.j_id}}"/>
            <input type="hidden" class="employee_code" value="{{journal.employee_code}}"/>
            <input type="hidden" class="negotiator_cn" value="{{journal.negotiator_cn}}"/>
            <td width="7%">{{ link_to("#", '评分', "class": "btn btn-default btn-xs","data-toggle":"modal","data-target":"#videoScoreBoard","data-backdrop":"static","data-id":journal.j_id,"data-action":"add") }}</td>
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

    {% endif %}
{% else %}
    No record
{% endfor %}


