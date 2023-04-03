

$(document).ready(function () {

  $("#toggle").click(function () {
    $("#toggleDiv").slideToggle("500");
  });

  $("#statement").click(function () {
    $("#statementDiv").slideToggle("500");
  });



  // Enable pusher logging - don't include this in production
  // Pusher.logToConsole = true;

  // var pusher = new Pusher('355a2039e6e477c07f84', {
  //   cluster: 'eu'
  // });

  // var channel = pusher.subscribe('bellbank');
  // channel.bind('notifier', function(data) {
  //   let notification_data = data;
  //   $.ajaxSetup({
  //     headers: {
  //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     }
  // });
  //   $.post('/notification', {

  //     data: notification_data,

  //   }, function () { }).done(function (response) {
  //   })
  // });



  $(document).on("click", '.read', function (e) {
    e.preventDefault();
    let id = $(this).attr("id");
    var data = $(this).closest('.read').find("#data").val();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $.ajax({
      method: "POST",
      url: "read_notifications",
      data: {
        'data': data,
        'id': id,
      },

      success: function (response) {

        let message = JSON.parse(response)
        $('#content' + id).text(message.messages);
        $(".test").load(" .test");
      }

    })

  });



  $(document).on("click", '.account_modal', function (e) {
    e.preventDefault();
    let id = $(this).attr("id");



    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $.ajax({
      method: "POST",
      url: "account",
      data: {

        'id': id,
      },

      success: function (response) {

        let message = JSON.parse(response)


        //console.log(message.id)
        $("#account_id").text(message.id);
        $("#name").text(message.account.name);
        $("#number").text(message.account.number);
        $("#balance").text(message.account.balance);
        $("#created_at").text(message.account.created_at);

      }

    })

  });


  $(document).on("click", '.statement', function (e) {
    e.preventDefault();
    let account_number = $('#account_number').val();
    let start = $('#start').val();
    let end = $('#end').val();



    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $.ajax({
      method: "POST",
      url: "view",
      data: {

        'account_number': account_number,
        'start': start,
        'end': end,
      },

      success: function (response) {
      }

    })

  });

  $(document).on("click", '.edit-user', function (e) {
    e.preventDefault();
    let id = $(this).attr("id");

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $.ajax({
      method: "POST",
      url: "edit",
      data: {

        'id': id,
      
      },

      success: function (response) {
        
        let message = JSON.parse(response)
        $("#name").val(message.name);
        $("#email").val(message.email);
        $("#phone").val(message.phone);
        $("#address").val(message.address);
        $("#id").val(message.id);
         $("#edit_id").val(message.id);
      }

    })

  });

  $(document).on("click", '.delete-user', function (e) {
    e.preventDefault();
    let id = $(this).attr("id");
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $.ajax({
      method: "POST",
      url: "delete",
      data: {

        'id': id,
      
      },

      success: function (response) {
        
        let message = JSON.parse(response)
        $("#id").val(message.id);
      
      

      }

    })

  });

  $(document).on("click", '.delete-currency', function (e) {
    e.preventDefault();
    let id = $(this).attr("id");

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $.ajax({
      method: "POST",
      url: "operations",
      data: {

        'id': id,
      
      },

      success: function (response) {
        
        let message = JSON.parse(response)
        $("#id").val(message.id);
      
      

      }

    })

  });

  $(document).on("click", '.edit-currency', function (e) {
    e.preventDefault();
    let id = $(this).attr("id");

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    $.ajax({
      method: "POST",
      url: "operations",
      data: {

        'id': id,
      
      },

      success: function (response) {
        
        let message = JSON.parse(response)
        $("#name").val(message.name);
        $("#email").val(message.email);
        $("#phone").val(message.phone);
        $("#address").val(message.address);
        $("#id").val(message.id);
         $("#edit_id").val(message.id);
      }

    })

  });


})