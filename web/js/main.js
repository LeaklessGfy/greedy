$(document).ready(function() {
    $('#needsForm_codePostal').keyup(function(){
        if($(this).val().length === 5) {
            $.ajax({
                type: "GET",
                url: Routing.generate('app_ajax_findcities', { cp: $(this).val(), option: "cityCodePostal" }, true),
                success: function(data) {
                    $('#needsForm_city').html('');
                    for(var i = 0; i < data.cities.length; i++) {
                        $('#needsForm_city').append('<option value="' + data.cities[i][1] +  '">'+data.cities[i][0]+'</option>');
                    }
                    $("#needsForm_city").prop('disabled', false);
                }
            });
        }
        else if($(this).val().length === 2) {
            $.ajax({
                type: "GET",
                url: Routing.generate('app_ajax_findcities', { cp: $(this).val(), option: "cityDepartement" }, true),
                success: function(data) {
                    $('#needsForm_city').html('');
                    for(var i = 0; i < data.cities.length; i++) {
                        $('#needsForm_city').append('<option value="' + data.cities[i][1] +  '">'+data.cities[i][0]+'</option>');
                    }
                    $("#needsForm_city").prop('disabled', false);
                }
            });
        }
        else {
            $("#needsForm_city").prop('disabled', true);
            $('#needsForm_city').html('<option>Veuillez indiquer un département ou code postal</option>');
        }
    });

    $('#favoritCityForm_codePostal').keyup(function(){
        if($(this).val().length === 5) {
            $.ajax({
                type: "GET",
                url: Routing.generate('app_ajax_findcities', { cp: $(this).val(), option: "cityCodePostal" }, true),
                success: function(data) {
                    $('#favoritCityForm_city').html('');
                    for(var i = 0; i < data.cities.length; i++) {
                        $('#favoritCityForm_city').append('<option value="' + data.cities[i][1] +  '">'+data.cities[i][0]+'</option>');
                    }
                    $("#favoritCityForm_city").prop('disabled', false);
                }
            });
        }
        else if($(this).val().length === 2) {
            $.ajax({
                type: "GET",
                url: Routing.generate('app_ajax_findcities', { cp: $(this).val(), option: "cityDepartement" }, true),
                success: function(data) {
                    $('#favoritCityForm_city').html('');
                    for(var i = 0; i < data.cities.length; i++) {
                        $('#favoritCityForm_city').append('<option value="' + data.cities[i][1] +  '">'+data.cities[i][0]+'</option>');
                    }
                    $("#favoritCityForm_city").prop('disabled', false);
                }
            });
        }
        else {
            $("#favoritCityForm_city").prop('disabled', true);
            $('#favoritCityForm_city').html('<option>Veuillez indiquer un département ou code postal</option>');
        }
    });

    $('.btn-need-delete').click(function() {
        var id = $(this).data('id');
        var title = $(this).data('name');

        $('#deleteConfirm').attr('href', Routing.generate('app_ajax_deleteneed', { id: id }, true));
        $('#needName').text(title);
    });

    $('.btn-reportMSG').click(function() {
        var user = $(this).data('username');
        var userid = $(this).data('userid');
        var title = $(this).data('name');

        $('#reportUsername').text(user);
        $('#reportNeed').text(title);
        $('#reportForm_reportUser').val(userid);
    });

    $('.need-answer-historic a').click(function(e) {
        e.preventDefault();
        var historic = $(this).closest('.need-answer').find('.need-historic');
        historic.toggleClass('hidden');

        if(historic.hasClass('hidden')) {
            $(this).text('Afficher l\'historique');
        } else {
            $(this).text('Cacher l\'historique');
        }
    });


    $('.chat-room-dropdown').click(function(e) {
        e.preventDefault();
        var dropdown = $(this).next('.list-group');
        if(dropdown.hasClass('hidden')) {
            $(this).find('.fa.fa-caret-right').addClass('fa-caret-down');
            $(this).find('.fa.fa-caret-right').removeClass('fa-caret-right');
        } else {
            $(this).find('.fa.fa-caret-down').addClass('fa-caret-right');
            $(this).find('.fa.fa-caret-down').removeClass('fa-caret-down');
        }
        $(this).toggleClass('active');
        dropdown.toggleClass('hidden');
    });

    var height = $('.need-historic')[0].scrollHeight;
    $('.need-historic').parent().scrollTop(height);
});