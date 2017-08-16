
    $( document ).ready(function() {

        $("#jsonUpload").click(function(e) {

            e.preventDefault();

            resetElements();

            $("#errorLabel").text('');

            var jsonTextInput =  $("#jsonInput").val().trim();

            if (isJson(jsonTextInput)){
                submitJsonData (JSON.stringify(jsonTextInput));
            }else{
                invalidJsonErrorMessage();
            }
        });

        function invalidJsonErrorMessage() {
            return $("#errorLabel").text('Please enter valid json.');
        }

        function isJson(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }

        function submitJsonData(jsonData) {
            $.ajax({
                type: "POST",
                url: "routes.php",
                data: {myData: jsonData},
                cache: false,
                success: function(result){
                    var resultJson = JSON.parse(result);

                    setNoOfDays(resultJson);
                    setTotalAmountSpent(resultJson);
                    setEachUsersSpentAmount(resultJson);
                    setEachUsersOweAmount(resultJson);
                    userSettlementData(resultJson);
                }
            });
        }

        function setNoOfDays(resultJson) {
            return $("#noOfDaysLbl").text(resultJson['noOfDays']);
        }

        function setTotalAmountSpent(resultJson) {
            return $("#totalAmountLbl").text(resultJson['totalAmountSpent']);
        }

        function setEachUsersSpentAmount(resultJson) {
            $.map(resultJson['eachUserSpentAmounts'], function(value, index) {
                $(".user-spent-ul").append($("<li class='alert-success'>").text(index + ' Spent ' + roundNumber(2,value)));
            });
        }

        function setEachUsersOweAmount(resultJson) {
            $.map(resultJson['eachUserOwesAmount'], function(value, index) {
                $(".user-owe-ul").append($("<li class='alert-success'>").text(index + ' Owe ' + roundNumber(2,value)));
            });
        }

        function roundNumber(decimalPlaces, number) {
            return parseFloat(number).toFixed(decimalPlaces)
        }

        function userSettlementData(resultJson) {
            $.map(resultJson['userSettlementData'], function(index, value) {
                $.map(index, function(indexInner, valueInner) {
                    $(".user-settlement-ul").append($("<li class='alert-success'>").text(value + ' Must pay to ' + valueInner + ' Amount ' + roundNumber(2, indexInner)));
                });
            });
        }

        function resetElements() {
            $("#noOfDaysLbl").text('');
            $("#totalAmountLbl").text('');
            $(".user-spent-ul").empty();
            $(".user-owe-ul").empty();
            $(".user-settlement-ul").empty();
        }
    });
