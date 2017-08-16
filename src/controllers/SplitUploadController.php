<?php
class SplitUploadController {

    private $model;

    /**
     * SplitUploadController constructor.
     * @param SplitBill $model
     */
    public function __construct(SplitBill $model)
    {
        $this->model = $model;
    }

    /**
     *Index action, that encode json data for front end
     *
     */
    public function index()
    {
        $jsonData = (array)(json_decode($_POST['myData']));

        $returnData = $this->model->splitBillAmount($jsonData);

        echo json_encode($returnData);
    }
}