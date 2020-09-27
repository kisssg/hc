<?php

use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class CallBackController extends ControllerBase
{

    public function initialize()
    {
        
    }

    public function indexAction()
    {
        $this->dispatcher->forward([
            "controller" => 'callback',
            "action" => "delete"
        ]);
    }

    public function deleteAction()
    {
        
    }

    public function addAction()
    {
        try {
            $type = $this->request->getPost('type_add');
            $homer_id=trim($this->request->getPost('homer_id'));
            $contract_no = trim($this->request->getPost('contract_no_add'));

            $client_name = $this->request->getPost('client_name_add');
            $contact_info = $this->request->getPost('contact_info_add');
            $contact_info2 = $this->request->getPost('contact_info2_add');
            $city = $this->request->getPost('city_add');
            $visit_date = $this->request->getPost('visit_date_add');
            $responsible_person = $this->request->getPost('responsible_person_add');
            $remark_phone = $this->request->getPost('remark_phone_add');
            $remark_detail = $this->request->getPost('remark_detail_add');
            $actual_paid_amt = $this->request->getPost('actual_paid_amt_add');
            $team_leader = $this->request->getPost('team_leader_add');
            $manager = $this->request->getPost('manager_add');
            $contact_person = $this->request->getPost('contact_person_add');
            $is_connected = $this->request->getPost('is_connected_add');
            $is_meet = $this->request->getPost('is_meet_add');
            $paid_date = $this->request->getPost('paid_date_add');
            $paid_method_q3 = $this->request->getPost('paid_method_q3_add');
            $paid_amt_q4 = $this->request->getPost('paid_amt_q4_add');
            $is_contacted = $this->request->getPost('is_contacted_add');
            $contact_type = $this->request->getPost('contact_type_add');
            $contact_info_collector = $this->request->getPost('contact_info_collector_add');
            $is_harassed = $this->request->getPost('is_harassed_add');
            $harass_type = $this->request->getPost('harass_type_add');
            $issue_type = $this->request->getPost('issue_type_add');
            $complaint_obj = $this->request->getPost('complaint_obj_add');
            $harass_detail = $this->request->getPost('harass_detail_add');
            $issue_time = $this->request->getPost('issue_time_add');
            $sensitive_word = $this->request->getPost('sensitive_word_add');
            $has_evidence = $this->request->getPost('has_evidence_add');
            $evidence_channel = $this->request->getPost('evidence_channel_add');
            $has_paid = $this->request->getPost('has_paid_add');
            $paid_method = $this->request->getPost('paid_method_add');
            $paid_amount = $this->request->getPost('paid_amount_add');
            $got_understood = $this->request->getPost('got_understood_add');
            $remark = $this->request->getPost('remark_add');
            $qc_name = $this->session->get('auth') ['name']; // $this->request->getPost('qc_name_add');
            $check_time = date("Y-m-d H:i:s"); // $this->request->getPost('check_time_add');
            $delete_time = $this->request->getPost('delete_time_add');
            $actual_caller = $this->request->getPost('actual_caller_add');
            $data_uploader = $this->request->getPost('data_uploader_add');
            $upload_time = $this->request->getPost('upload_time_add');
            $upload_batch = date("Y-m-d");
            $create_type = "manual";

            if ($type == "" || $contract_no == "")
            {
                throw new exception("Type and contract No. are required");
            }
            if ($qc_name == "")
            {
                throw new exception("Login session expired");
            }

            $cb = new Callback ();
            $cb->type = $type;
            $cb->homer_id=$homer_id;
            $cb->contract_no = $contract_no;
            $cb->client_name = $client_name;
            $cb->contact_info = $contact_info;
            $cb->contact_info2 = $contact_info2;
            $cb->city = $city;
            $cb->visit_date = $visit_date;
            $cb->responsible_person = $responsible_person;
            $cb->remark_phone = $remark_phone;
            $cb->remark_detail = $remark_detail;
            $cb->actual_paid_amt = $actual_paid_amt;
            $cb->team_leader = $team_leader;
            $cb->manager = $manager;
            $cb->contact_person = $contact_person;
            $cb->is_connected = $is_connected;
            $cb->is_meet = $is_meet;
            $cb->paid_date = $paid_date;
            $cb->paid_method_q3 = $paid_method_q3;
            $cb->paid_amt_q4 = $paid_amt_q4;
            $cb->is_contacted = $is_contacted;
            $cb->contact_type = $contact_type;
            $cb->contact_info_collector = $contact_info_collector;
            $cb->is_harassed = $is_harassed;
            $cb->harass_type = $harass_type;
            $cb->issue_type = $issue_type;
            $cb->complaint_obj = $complaint_obj;
            $cb->harass_detail = $harass_detail;
            $cb->issue_time = $issue_time;
            $cb->sensitive_word = $sensitive_word;
            $cb->has_evidence = $has_evidence;
            $cb->evidence_channel = $evidence_channel;
            $cb->has_paid = $has_paid;
            $cb->paid_method = $paid_method;
            $cb->paid_amount = $paid_amount;
            $cb->got_understood = $got_understood;
            $cb->remark = $remark;
            $cb->qc_name = str_replace(".", " ", $qc_name);
            $cb->check_time = $check_time;
            // $cb->delete_time=$delete_time;
            $cb->actual_caller = $actual_caller;
            $cb->data_uploader = $qc_name;
            $cb->upload_batch = $upload_batch;
            $cb->create_type = $create_type;
            $cb->edit_log = $is_connected . " " . $qc_name . " " . date("ymd H:i:s");

            if ($cb->create() === false)
            {
                throw new exception("something wrong");
            }
            else
            {
                echo '{"result":"success","msg":"' . $cb->id . '","date":"' . $upload_batch . '"}';
            }
        } catch (exception $e) {
            echo '{"result":"failed","msg":"' . $e->getmessage() . '"}';
        }
        $this->view->disable();
    }

    public function updateAction()
    {
        try {
            $id = $this->request->getPost('id');
            $type = $this->request->getPost('type');
            $contract_no = $this->request->getPost('contract_no');
            $client_name = $this->request->getPost('client_name');
            $contact_info = $this->request->getPost('contact_info');
            $remark_detail = $this->request->getPost('remark_detail');
            $remark_phone = $this->request->getPost('remark_phone');

            $homer_id=$this->request->getPost('homer_id');
            $city = $this->request->getPost('city');
            $responsible_person = $this->request->getPost('responsible_person');
            $visit_date = $this->request->getPost('visit_date');

            $cb = Callback::findFirst($id);
            $cb->type = $type;
            $cb->contract_no = $contract_no;
            $cb->client_name = $client_name;
            $cb->contact_info = $contact_info;
            $cb->remark_detail = $remark_detail;
            $cb->remark_phone = $remark_phone;

            $cb->homer_id=$homer_id;
            $cb->city = $city;
            $cb->responsible_person = $responsible_person;
            $cb->visit_date = $visit_date;
            if ($cb->save() === false)
            {
                throw new Exception("Failed updating record");
            }

            echo '{"result":"success","msg":"更新成功！"}';
        } catch (Exception $e) {
            echo '{"result":"failed","msg":"' . $e->getMessage() . '"}';
        }
        $this->view->disable();
    }

    public function markDeletionAction()
    {
        try {
            $column_name = $this->request->getPost('column_name');
            $value = $this->request->getPost('value');
            // test variables
            if ($column_name == "qc")
            {
                $column_name = "qc_name";
            }
            elseif ($column_name == "agency")
            {
                $column_name = "responsible_person";
            }

            $items = Callback::find([
                        "conditions" => "$column_name = :value:  and is_connected='' and action_id is null",
                        "bind" => [
                            "value" => "$value"
                        ]
            ]);

            $action_id = date("YmdHis") . random_int();
            $count = 0;
            foreach ($items as $item)
            {
                $item->post_qc = $item->qc_name;
                $item->qc_name = '已删除';
                $item->delete_user = $this->session->get('auth') ['name'];
                $item->action_id = $action_id;
                $item->update();
                $count ++;
            }
            echo '{"result":"success","msg":"' . $count . '"}';
        } catch (Exception $e) {
            echo '{"result":"failed","msg":"' . $e->getMessage() . '"}';
        }
        $this->view->disable();
    }

    public function transferAction()
    {
        try {
            if ($this->session->get('auth')['level'] < 10)
            {
                throw new exception('您暂时无法执行此操作，请找资深帮忙。');
            }
            $ids = $this->request->getPost('ids');
            $receiver = $this->request->getPost('to');
            $receiver = str_replace(" ", ".", $receiver); // need to check if object user exists, so replace those input username separated by space with dot.
            if ($receiver !== "已删除")
            { // if need to delete data, transfer to '已删除'
                $exist_user = Users::count([
                            "username = :username:",
                            "bind" => [
                                "username" => "$receiver"
                            ]
                ]);
                if ($exist_user == 0)
                {
                    throw new exception("User not exist");
                }
            }
            $receiver = str_replace(".", " ", $receiver); // data owner in the call back table username separate with blank character

            $items = Callback::find([
                        "conditions" => "id in ({ids:array})  and action_id is null",
                        "bind" => [
                            "ids" => $ids
                        ]
            ]);
            //it can transfer only one record while there actually are multiple;
            $action_id = date("YmdHis") . rand(1, 999);
            $count = 0;
            foreach ($items as $item)
            {
                $item->post_qc = $item->qc_name;
                $item->qc_name = $receiver;
                $item->delete_user = $this->session->get('auth') ['name'];
                $item->action_id = $action_id;
                $item->update();
                $count ++;
            }
            echo '{"result":"success","msg":"' . $count . '"}';
        } catch (Exception $e) {
            echo '{"result":"failed","msg":"' . $e->getMessage() . '"}';
        }
        $this->view->disable();
    }

    public function restoreDeletionAction()
    {
        try {
            // check if user is allowed to do the grant action;
            $level = $this->session->auth ['level'];
            if ($level < 10)
            {
                throw new exception("Not authorized");
            }
            $action_id = $this->request->getPost('action_id', 'string');
            if ($action_id == "")
            {
                throw new exception("Action ID not valid");
            }
            $connection = $this->db;
            $sql = "update `callback` set qc_name=post_qc,post_qc=null, action_id=null where action_id='$action_id'";
            $result = $connection->query($sql);
            if ($result === false)
            {
                throw new Exception("Failed updating data in base");
            }
            else
            {
                echo '{"result":"success","msg":""}';
            }
        } catch (Exception $e) {
            echo '{"result":"failed","msg":"' . $e->getMessage() . '"}';
        }
        $this->view->disable();
    }

    public function recycleBinAction()
    {
        try {
            // check if user is allowed to do the grant action;
            $level = $this->session->auth ['level'];
            if ($level < 10)
            {
                throw new exception("Not authorized");
            }
            $list = Callback::find([
                        "columns" => "distinct(action_id) as action_id,count(action_id) as count,delete_user as operator,qc_name as currentQC",
                        "conditions" => "action_id is not null ",
                        "order" => "action_id desc",
                        "group" => "action_id",
                        "limit" => "100"
            ]);
            // Create a Model paginator, show 10 rows by page starting from $currentPage
            $currentPage = $this->request->getQuery("page", "int");

            $paginator = new PaginatorModel([
                "data" => $list,
                "limit" => 50,
                "page" => $currentPage
            ]);

            // Get the paginated results
            $page = $paginator->getPaginate();
            echo "<table class='contracts' style='width:auto;'>
		<tr>
		<th>No.</th>
		<th>Action ID</th>
		<th>Operator</th>
		<th>CurrentOwner</th>
		<th>Count</th>
		<th>Action</th>
		</tr>";
            $i = 0;
            foreach ($page->items as $item)
            {
                $i ++;
                echo "<tr>
        <td>" . $i . "</td>" . "
        <td>" . $item->action_id . "</td>
        <td>" . $item->operator . "</td>
        <td>" . $item->currentQC . "</td>
		<td>" . $item->count . "</td>
		<td><button class='btn btn-default btn-xs' onclick='return Callback.restore(\"" . $item->action_id . "\")'>restore</button></td>
    	</tr>";
            }
            echo "</table>";
            echo '<div class="clearfix pagination">
	<a class="number" href="?page=1">&laquo;</a>' . '
	<a class="number" href="?page=' . $page->before . '">&lsaquo;</a>
	<a class="number" href="?page=' . $page->next . '">&rsaquo;</a>
	<a class="number" href="?page=' . $page->last . '">&raquo;</a>
	</div>
	' . $page->current, "/", $page->total_pages;
            echo $this->tag->javascriptInclude('js/callback.js');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getRecAuditAction()
    {
        $this->view->disable();
        try {
            $logUser = $this->session->get('auth') ['name'];
            $cbId = $this->request->getPost('id');
            $result = CallRecAudits::findFirstByCbId($cbId);
            echo json_encode($result);
        } catch (Exception $e) {
            
        }
    }

    public function saveRecAuditAction()
    {
        $this->view->disable();
        try {
            $logUser = $this->session->get('auth') ['name'];
            $auditor = $logUser;
            $id = $this->request->getPost('id');
            $cbId = $this->request->getPost('cbId');
            $pattern_completed = $this->request->getPost('pattern_completed');
            $filling_right = $this->request->getPost('filling_right');
            $communication = $this->request->getPost('communication');
            $improve_tips = $this->request->getPost('improve_tips');
            $remark = $this->request->getPost('remark');

            $currentDate = date("Y-m-d");
            $currentTime = date("H:i:s");


            $recAudit = CallRecAudits::findFirstBycbId($cbId);
            if ($recAudit === FALSE)
            {
                $recAudit = new CallRecAudits ();
                $recAudit->addDate = $currentDate;
                $recAudit->addTime = $currentTime;
                $type = 'add';
                $recAudit->auditor = $auditor;
                $cb = Callback::findFirst($cbId);
                $cb->recAuditor2 = $auditor;
                if ($cb->save() === FALSE)
                {
                    throw new exception("Failed setting recAuditor2");
                }
            }
            else
            {

                $currentRole = $this->session->get('auth')['role'];
                $currentTeam = substr($currentRole, 0, 3);
                $currentPosition = substr($currentRole, -2);
                
                $old_user = Users::findFirstByUsername($recAudit->auditor);
                $old_team = substr($old_user->role, 0, 3);
                $theTl = ($currentTeam == $old_team && $currentPosition == 'TL');
                //how many days passed since last edit
                $diffDay=date_diff(date_create($currentDate), date_create($recAudit->addDate))->format("%a");
                
                if (!$theTl)
                {
                    if ($diffDay > 1)
                    {
                        throw new exception('超过修改时限。');
                    }
                    if ($logUser != $recAudit->auditor)
                    {
                        throw new exception("不能修改别人的记录，添加人：" . $recAudit->auditor);
                    }
                }else{
                    $recAudit->edit_log=$recAudit->edit_log.$auditor.' edit at '.$currentDate.$currentTime;
                }
                $recAudit->editDate = $currentDate;
                $recAudit->editTime = $currentTime;
                $type = 'update';
            }
            $recAudit->cbId = $cbId;
            $recAudit->pattern_completed = $pattern_completed;
            $recAudit->filling_right = $filling_right;
            $recAudit->communication = $communication;
            $recAudit->improve_tips = $improve_tips;
            $recAudit->remark = $remark;
            if ($recAudit->save() === FALSE)
            {
                throw new exception("Failed adding record");
            }
            else
            {
                echo '{"result":"success","id":"' . $recAudit->id . '","type":"' . $type . '","msg":""}';
            }
        } catch (Exception $e) {
            echo '{"result":"failed","id":"","type":"","msg":"' . $e->getMessage() . '"}';
        }
    }

}
