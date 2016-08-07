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
            var tr = '<tr style="font-weight: bold;" class="alert alert-warning" id="turnaround_row_' + id + '">' +
                '<td><img src="https://ivaoru.org/images/airlines/' + data.airline + '.gif"></td>' +
                '<td>' + data.airline + data.flightnumber + '(TURNAROUND)</td>' +
                '<td>' + data.gate + '</td>' +
                '<td>' + data.aircraft + '</td>' +
                '<td>' + data.icaofrom + '</td>' +
                '<td>' + data.icaoto + '</td>' +
                '<td>' + data.timefrom + '</td>' +
                '<td>' + data.timeto + '</td>' +
                '<td>' + ((data.vid)?'<a class="btn btn-warning btn-sm" href="/booking/show/'+data.id+'">Booked: '+data.vid+'</a>':'<a class="btn btn-success btn-sm" href="/booking/book/'+data.id+'">Book</a>') + '</td>' +
                '</tr>';
            $(tr).css('background-color','transparent');
            $('tr[data-key=' + id + ']').after(tr);
            toggled.push(id);
        });
    }
}