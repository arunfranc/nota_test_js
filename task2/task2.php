
<!DOCTYPE html>
<html>
<head>
    <title>Data Table</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <!-- New entry button-->
    <div class="container my-3 bg-light">
        <div class="col-md-12 text-center">
            <button id="addEntry">Add new entry</button>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data rows will be dynamically added here -->
        </tbody>
    </table>
    
    
</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

             // Mock data 
            $.ajax({    
                type: "POST",
                url: "backend.php",    //backend server file         
                dataType: "json",
                data: {"comes": "backend"},                  
                success: function(data){                    
                    // console.log(data); 
                   // Initial population of the table with mock data
                    populateTable(data);
                }
            });

            // Function to populate the table with data
            function populateTable(data) {
                var tbody = $("table tbody");
                tbody.empty();
                //Append data in the table
                data.forEach(function(item) {
                    var row = $("<tr>");
                    row.append("<td>" + item.id + "</td>");
                    var nameInput = $("<input type='text' readonly value='" + item.name + "'>");
                    row.append("<td><input type='text' readonly value='" + item.name + "'></td>");
                    row.append("<td>" + item.date_time + "</td>");
                    var actions = $("<td>");
                    actions.append("<button class='save' style='display:none;'>Save</button>");
                    actions.append("<button class='edit'>Edit</button>");
                    actions.append("<button class='delete'>Delete</button>");
                    row.append(actions);
                    tbody.append(row);
                });
            }
        });

        // Add new entry button click
            $("#addEntry").click(function() {
                var newRow = $("<tr>");
                newRow.append("<td>(New)</td>");
                newRow.append("<td><input type='text' name='new_name' id='new_name' placeholder='Name' value=''></td>");
                var currentTime = new Date().toISOString();
                newRow.append("<td>" + currentTime + "</td>");
                var actions = $("<td>");
                actions.append("<button id='send'>Send</button>");
                newRow.append(actions);
                $("table tbody").append(newRow);
            });

            //Add request goes to backend
            $(document).on('click', '#send' , function() {
                var new_name = $("#new_name").val();
                var date = "<?php echo date('Y-m-d H:i:s', time()); ?>";
                // console.log(date);
                // return false;
                $.ajax({    
                    type: "POST",
                    url: "backend.php",       //backend server file      
                    dataType: "json",
                    data: {"comes": "save_new","name":new_name,"date_time":date},                  
                    success: function(data){ 
                        if(data=="success"){
                            console.log("saved successfully");
                            location.reload(); 
                        }else{
                            console.log("Error"); 
                        }
                    }
                });
            });

            //Delete request
            $("table").on("click", ".delete", function() {
                var row = $(this).closest("tr");
                var id = row.find("td:eq(0)").text();
                $.ajax({    
                    type: "POST",
                    url: "backend.php",        //backend server file     
                    dataType: "json",
                    data: {"comes": "delete","id":id},                  
                    success: function(data){ 
                        if(data=="success"){
                            console.log("Deleted successfully");
                            location.reload(); 
                        }else{
                            console.log("Error"); 
                        }
                    }
                });
            });

            //Edit request
            $("table").on("click", ".edit", function() {
                var row = $(this).closest("tr");
                row.find("input").prop("readonly", false);
                row.find(".edit").hide();
                row.find(".save").show();
            });

            //Save record in the backend
            $("table").on("click", ".save", function() {
                var row = $(this).closest("tr");
                var id = row.find("td:eq(0)").text();
                var name = row.find("input").val();
                var date = "<?php echo date('Y-m-d H:i:s', time()); ?>";
                // console.log(name);
                $.ajax({    
                    type: "POST",
                    url: "backend.php",             //backend server file
                    dataType: "json",
                    data: {"comes": "update","id":id,"name":name,"date_time":date},                  
                    success: function(data){ 
                        if(data=="success"){
                            console.log("Updated successfully");
                            location.reload(); 
                        }else{
                            console.log("Error"); 
                        }
                    }
                });
            });

    </script>
