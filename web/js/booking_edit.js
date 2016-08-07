/**
 * Created by BTH on 07.08.16.
 */
function linkturnaround(id)
{
    $('#turnarounds').html(null);
    $('#ownid').val(id);
    $.post('/site/get-turnaround-candidates',{id:id},function(response){
        var candidates = JSON.parse(response);
        for(i in candidates)
        {
            $('#turnarounds').append('<OPTION value="'+candidates[i].id+'">'+candidates[i].airline+candidates[i].flightnumber+'</OPTION>');
        }
        $('#linkturnaroundmodal').modal('show');
    });

}
function unlinkturnaround(id)
{
    $.post('/site/unlinkturnaround',{id:id},function(response){
        location.reload();
    });
}