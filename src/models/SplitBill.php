<?php
class SplitBill {

    private $jsonData;

    public function splitBillAmount($jsonData)
    {
        $this->jsonData = $jsonData;

        return array(
            'noOfDays' => $this->getNoOfDays(),
            'totalAmountSpent' => $this->getTotalAmountSpent(),
            'eachUserSpentAmounts' => $this->getEachUserSpentAmounts(),
            'eachUserOwesAmount' => $this->getEachUserOwesAmount(),
            'userSettlementData' => $this->userDifferenceSettlement()
        );
    }

    /**
     * Number of days
     *
     * @return int
     */
    private function getNoOfDays()
    {
        return count(json_decode($this->jsonData[0])->data);
    }

    /**
     * Total amount spent
     *
     * @return double
     */
    private function getTotalAmountSpent()
    {
        $totalAmount = 0;

        foreach(json_decode($this->jsonData[0])->data as $eachDayData){
            $totalAmount += $eachDayData->amount;
        }

        return $totalAmount;
    }

    /**
     * Each user spent amounts
     *
     * @return array
     */
    private function getEachUserSpentAmounts()
    {
        $eachUserSpent = [];

        foreach(json_decode($this->jsonData[0])->data as $eachDayData){

            $eachUserToSpent = $this->getUserPaidAmountInOneDay($eachDayData);

            foreach($eachDayData->friends as $friend){
                $eachUserSpent[$friend] = array_key_exists($friend, $eachUserSpent) ? round ($eachUserSpent[$friend] + $eachUserToSpent, 2) : $eachUserToSpent;
            }
        }

        return $eachUserSpent;
    }

    /**
     * Amount spent by user in one day
     *
     * @param $eachDayData
     * @return float
     */
    private function getUserPaidAmountInOneDay($eachDayData)
    {
        return (($eachDayData->amount) / count($eachDayData->friends));
    }

    /**
     * Amounts owe by each user
     *
     * @return array
     */
    private function getEachUserOwesAmount()
    {
        $eachUserOwes = [];

        foreach(json_decode($this->jsonData[0])->data as $eachDayData){
            $paidByUser = $eachDayData->paid_by;

            $eachUserToSpent = $this->getUserPaidAmountInOneDay($eachDayData);

            foreach($eachDayData->friends as $friend){

                if($paidByUser != $friend) {
                    $eachUserOwes[$friend] = array_key_exists($friend, $eachUserOwes) ?  round($eachUserOwes[$friend] + $eachUserToSpent, 2) : round($eachUserToSpent, 2);
                }
            }

        }

        return $eachUserOwes;
    }

    /**User settlement data
     *
     * @return array
     */
    private function getUserSettlements()
    {
        $eachUserSettlements = [];

        foreach(json_decode($this->jsonData[0])->data as $eachDayData){
            $paidByUser = $eachDayData->paid_by;
            $eachUserToSpent = $this->getUserPaidAmountInOneDay($eachDayData);

            foreach($eachDayData->friends as $friend){
                if($paidByUser != $friend) {
                    $eachUserSettlements[$friend][$paidByUser] = $eachUserToSpent;
                }
            }
        }

        return $eachUserSettlements;
    }

    /**Generate user difference settlement
     *
     * @return array
     */
    private function userDifferenceSettlement()
    {
        $userDifferenceSettlement = [];

        $userSettlements = $this->getUserSettlements();

        foreach($userSettlements as $key => $settlement){

            $arrayKeyGot = 0;
            $settleKey = null;

            foreach ($userSettlements as $keySecond => $settle){
                if (array_key_exists($key, $settle ) && (array_key_exists($keySecond, $settlement))) {

                    $arrayKeyGot  ++;

                    $settleKey = $keySecond;

                    if (($settlement[$keySecond] - $settle[$key]) < 0) {
                        $userDifferenceSettlement[$keySecond][$key] = round($settlement[$keySecond] - $settle[$key], 2);
                    } else {
                        $userDifferenceSettlement[$key][$keySecond] = round($settlement[$keySecond] - $settle[$key], 2);
                    }
                }
            }

            if($arrayKeyGot == 1){
                foreach ($settlement as $keyThird => $item){
                    if ($keyThird != $settleKey )
                    $userDifferenceSettlement[$key][$keyThird] = round($item, 2);
                }

            } else {
                foreach ($settlement as $keyThird => $item){
                    $userDifferenceSettlement[$key][$keyThird] = round($item, 2);
                }
            }
        }

        return $userDifferenceSettlement;
    }
}