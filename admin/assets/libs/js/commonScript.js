function comm_script() { }

comm_script.fill_table_data = function(tbl_struct, response, tableID, lblCtID) {
    try {
        var data = response;
        var total_rows = response.length
        $('#' + tableID).empty();
        if (total_rows > 0) {
            $('#' + lblCtID).text(total_rows + " Record(s) Found.")
        }
        else {
            $('#' + lblCtID).text("No Record Found.")
            return;
        }

        // Clear previous table content


        // Create table header
        var thead = $('<thead class="bg-light">');
        var headerRowHtml = '<tr class="border-0">';
        tbl_struct.forEach(function (header) {
            var thClass = header.hidden === "Y" ? ' class="col_hide"' : '';
            headerRowHtml += '<th' + thClass + '>' + header.label + '</th>';
        });
        headerRowHtml += '</tr>';
        thead.html(headerRowHtml);
        $('#' + tableID).append(thead);

        // Create table body
        var tbody = $('<tbody>');
        var rowsHtml = '';
        data.forEach(function (item) {
            var rowHtml = '<tr>';
            tbl_struct.forEach(function (header) {
                var tdClass = header.hidden === "Y" ? ' class="col_hide"' : '';
                var cellContent = header.render ? header.render(item) : item[header.field] == null ? "" : item[header.field];;
                rowHtml += '<td' + tdClass + '>' + cellContent + '</td>';
            });
            rowHtml += '</tr>';
            rowsHtml += rowHtml;
            //console.log(rowsHtml)
        });
        tbody.html(rowsHtml);
        $('#' + tableID).append(tbody);
    } catch (err) {
        $(".loader").hide()
        msgbox_C2(err.message, 'error');

    }
}


comm_script.populateDropdown =function (dropdownId, data, selectedValue = null) {
    var $dropdown = $('#' + dropdownId);
    $dropdown.empty(); // Clear existing options

    if (data.length > 0) {
        $dropdown.append($('<option>', {
            value: '',
            text: 'Select option'
        }));
        data.forEach(function(item) {
            
            if (item[0] == selectedValue) {
                var isSelected = (item[0] === selectedValue) ? 'selected' : '';
                $dropdown.append($('<option>', {
                    value: item[0],
                    text: item[1],
                    selected: isSelected
                }));
            } else {
                $dropdown.append($('<option>', {
                    value: item[0],
                    text: item[1],
                }));
            }
           
        });
    } else {
        $dropdown.append($('<option>', {
            value: '',
            text: 'No options available'
        }));
    }
}
