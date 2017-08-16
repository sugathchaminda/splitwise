<?php
namespace Tests\Unit;
require_once('src/models/SplitBill.php');

Use PHPUnit\Framework\TestCase;

class SplitBillTest extends TestCase
{
    protected $dataSet = [
            '{"data":[
                {
                    "day":1,
                    "amount":50,
                    "paid_by":"tanu",
                    "friends":["kasun","tanu"]
                },
                {
                    "day":2,
                    "amount":100,
                    "paid_by":"kasun",
                    "friends":["kasun","tanu","liam"]
                },
                {
                    "day":3,
                    "amount":100,
                    "paid_by":"liam",
                    "friends":["liam","tanu","liam"]
                }
            ]}'
    ];


    /**
     * @test
     */
    public function it_should_calculate_no_of_days()
    {
        $result =  (new \SplitBill())->splitBillAmount($this->dataSet);

        $this->assertEquals(3, $result['noOfDays']);
    }


    /**
     * @test
     */
    public function it_should_calculate_total_amount_spent()
    {
        $result =  (new \SplitBill())->splitBillAmount($this->dataSet);

        $this->assertEquals(250, $result['totalAmountSpent']);
    }

    /**
     * @test
     */
    public function it_should_calculate_amount_spent_by_each()
    {
        $result =  (new \SplitBill())->splitBillAmount($this->dataSet);

        $expected = [
            'kasun' => 58.33,
            'tanu' => 91.66,
            'liam' => 100.00
        ];

        $this->assertEquals($expected , $result['eachUserSpentAmounts']);
    }

    /**
     * @test
     */
    public function it_should_calculate_amount_owe_by_each()
    {
        $result =  (new \SplitBill())->splitBillAmount($this->dataSet);

        $expected = [
            'kasun' => 25,
            'tanu' => 66.66,
            'liam' => 33.33
        ];

        $this->assertEquals($expected , $result['eachUserOwesAmount']);
    }

    /**
     * @test
     */
    public function it_should_calculate_amount_need_to_settle_by_each()
    {
        $result =  (new \SplitBill())->splitBillAmount($this->dataSet);

        $expected = [
            'tanu' => [
                'kasun' => 8.33,
                'liam' => 33.33,
            ],
            'liam' => [
                'kasun' => 33.33
            ]
        ];

        $this->assertEquals($expected , $result['userSettlementData']);
    }
}