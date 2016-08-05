
function editApt(id)
{
    $.post('/site/get-apt-data',{id:id},function(response){
        response = JSON.parse(response);
        $('#airports-name').val(response.name);
        $('#airports-icao').val(response.icao);
        $('#airports-id').val(response.id);
        $('#admin_airport_edit_modal').modal('show');
    });
}
function removeApt(id)
{
    $.post('/site/remove-apt',{id:id},function(response){
        location.reload();
    });
}
function addApt()
{
    $('#airports-name').val('');
    $('#airports-icao').val('');
    $('#airports-id').val(null);
    $('#admin_airport_edit_modal').modal('show');
}