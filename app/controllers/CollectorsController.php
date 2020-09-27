<?php

class CollectorsController extends ControllerBase
{

    public function initialize()
    {
        
    }

    public function indexAction()
    {
        echo "index of collectors";
    }

    public function isearchAction()
    {
        $this->view->disable();
        if ($this->request->isPost())
        {
            $keyword = $this->request->getPost('search');
            $suggestion = Collectors::find([
                        "columns" => "id,name_en as value,city as city,area as region, employee_id as employeeID, name_cn as name,cfc_hm_id",
                        "conditions" => "name_en = :keyword: or name_cn = :keyword: or cfc_hm_id = :keyword:",
                        "limit" => "10",
                        "bind" => [
                            "keyword" => "$keyword"
                        ]
            ]);
            echo json_encode($suggestion);
        }
    }
    
    public function searchAction()
    {
        $this->view->disable();
        if ($this->request->isPost())
        {
            $keyword = $this->request->getPost('search');
            $suggestion = Collectors::find([
                        "columns" => "id,name_en as value,city as city,area as region, employee_id as employeeID, name_cn as name,cfc_hm_id",
                        "conditions" => "name_en like :keyword: or name_cn like :keyword: or cfc_hm_id = :homer_id:",
                        "limit" => "10",
                        "bind" => [
                            "keyword" => "$keyword%",
                            "homer_id" => "$keyword"
                        ]
            ]);
            echo json_encode($suggestion);
        }
    }

}
