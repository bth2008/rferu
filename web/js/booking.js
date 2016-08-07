/**
 * Created by BTH on 07.08.16.
 */
var toggled = [];
function showturnaround(id)
{
    if(toggled.indexOf(id) > -1){
        var index = toggled.indexOf(id);
        $('#turnaround_row_'+id).remove();
        delete(toggled[index]);
    }
    else {
        $.post('/site/gettrnflight', {id: id}, function (response) {
            var data = JSON.parse(response);
            var tr = '<tr class="alert alert-warning" id="turnaround_row_' + id + '">' +
                '<td><img src="https://ivaoru.org/images/airlines/' + data.airline + '.gif"></td>' +
                '<td>' + data.airline + data.flightnumber + '</td>' +
                '<td>' + data.gate + '</td>' +
                '<td>' + data.aircraft + '</td>' +
                '<td>' + data.icaofrom + '</td>' +
                '<td>' + data.icaoto + '</td>' +
                '<td>' + data.timefrom + '</td>' +
                '<td>' + data.timeto + '</td>' +
                '<td>' + '<button class="btn btn-success btn-sm">Book</button>' + '</td>' +
                '</tr>';
            $(tr).css('background-color','transparent');
            $('tr[data-key=' + id + ']').after(tr);
            toggled.push(id);
        });
    }
}