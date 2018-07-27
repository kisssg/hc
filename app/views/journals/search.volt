<?php
$visit_date=isset($_GET['visit_date'])?($_GET['visit_date']):"";
$collector=isset($_GET['collector'])?$_GET['collector']:"";
?>
{{ content()}}
<form action="" method="post">
日期：<input type="text" class="datepicker" name="visit_date" id="visit_date" value="{{visit_date}}"/>
催收员：<input type="text" name="journal_creator" id ="" value="{{collector}}"/>
<input type="submit" class="btn btn-default btn-xs" value="搜索"/>
</form>
{% for journal in page.items %}
    {% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>journal Type</th>
            <th>Name</th>
            <th>Price</th>
            <th>Active</th>
        </tr>
    </thead>
    <tbody>
    {% endif %}
        <tr>
            <td>{{ journal.j_id }}</td>
            <td>{{ journal.journal_creator }}</td>
            <td>{{ journal.visit_result_cn }}</td>
            <td>${{ "%.2f"|format(journal.checking_time) }}</td>
            <td>{{ journal.validity }}</td>
            <td width="7%">{{ link_to("journals/edit/" ~ journal.j_id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-default") }}</td>
            <td width="7%">{{ link_to("journals/delete/" ~ journal.j_id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-default") }}</td>
        </tr>
    {% if loop.last %}
    </tbody>
    <tbody>
        <tr>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("journals/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("journals/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn") }}
                    {{ link_to("journals/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("journals/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }} of {{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    </tbody>
</table>
    {% endif %}
{% else %}
    No journals are recorded
{% endfor %}
