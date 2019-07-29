<html>
    <head>
        <title>Load Messages</title>
    </head>
    <body>
        <h3>Messages</h3>
        <div id="message_box" style="height:400px;"></div>
        <button id="message_btn">Load Messages</button>
    </body>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#message_btn").click(function(){
                alert("DD");
                $.ajax({
                    type	: 'GET',
                    url     : "http://localhost/distress_connect/data_service.php?op=GET_NODE_CONCURRENT_MESSAGE_DATA",
                    //data	: {'op':'GET_DISASTER_DATA'},
                    dataType: 'json',
                    async	: true,
                    success	: function(response){
                        if(response.status == 1)
                        {
                            alert(response.msg);
                            $("#message_box").text(response.msg);
                        }
                        },
                        error: function(x,t,e){
                            console.log(t);
                        }
                });
            });
        });
    </script>
</html>