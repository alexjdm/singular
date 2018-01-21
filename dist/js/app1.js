function ajax_loadModal(object, url, method, data, message, backdrop) {
    //console.debug(data);
    if(backdrop == 'static')
    {
        object.modal({backdrop: 'static', keyboard: false});
    }
    else
    {
        object.modal('show');
    }

    $.ajax({
        type: method,
        data: data,
        url: url,
        beforeSend: function () {
            object.html(code_Cargando());
            //console.debug("Antes de abrir el modal");
        },
        success: function (data) {
            //console.debug("llego al success");
            //console.debug(data);
            object.html(data);
            var modalWidth = object.find(".modal-dialog").width();
            var windowWidth = $(window).width();
            if (modalWidth > windowWidth)
                var modalWidth = object.find(".modal-dialog").width($(window).width() - 50);
        },
        error: function (x, status, error) {
            object.find(".modal-body").html(error);
        }

    });

}

function code_Cargando() {
    return $("#htmlCargando").html();
}

function getCleanID(stringvalue) {
    var splitchar = "_";
    if (stringvalue != null)
        return stringvalue.split(splitchar)[1];
    else
        return 0;
}

//This function displays a modal in the object element
// Example: showConfirmation($('#modalPrincipal'),
//{title:"Are you sure",message:"This action will delete a punch definetely.",ok:"Ok",cancel:"Cancel"}
//, function() {});
function showConfirmation(element, strings, okFunction) {

    var modalContent="";
    modalContent += "<div class=\"modal-dialog\" style=\"width: 450px\">";
    modalContent += "            <div class=\"modal-content\">";
    modalContent += "                <div id=\"confirmDelete_data\">";
    modalContent += "                    <div class=\"modal-header\">";
    modalContent += "                        <button type=\"button\" class=\"btn btn-default close closeModalConfirmacion\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;<\/button>";
    var title = strings.title;
    modalContent += "                        <h4>" +title +"<\/h4>";
    modalContent += "                    <\/div>";
    modalContent += "                    <div id=\"contenidomodal\" class=\"modal-body\">";
    var message = strings.message;
    modalContent += message;
    modalContent += "                    <\/div>";
    modalContent += "                    <div class=\"modal-footer\">";
    var cancelar = strings.cancel;
    modalContent += "                        <a href=\"#\" class=\"btn btn-default closeModalConfirmacion\" >" +cancelar + "<\/a>";
    var sure = strings.ok;
    modalContent += "                        <a id=\"confirmButton\" href=\"#\" class=\"btn btn-primary\" data-dismiss=\"modal\">" +sure +"<\/a>";
    modalContent += "                    <\/div>";
    modalContent += "                <\/div>";
    modalContent += "            <\/div>";
    modalContent += "        <\/div>";
    element.html(modalContent);
    $('.closeModalConfirmacion').click(function() {
        element.modal('hide');
        return false;
    });
    $('#confirmButton').click(function () {
        element.modal('hide');
        okFunction();
        return false;
    });
    element.modal('show');
}
function showConfirmationWithLoading(element, strings, ajaxParams,params) {
    var modalContent = "";
    modalContent += "<div class=\"modal-dialog\" style=\"width: 450px\">";
    modalContent += "            <div class=\"modal-content\">";
    modalContent += "                <div id=\"confirmDelete_data\">";
    modalContent += "                    <div class=\"modal-header\">";
    modalContent += "                        <button type=\"button\" class=\"btn btn-default close closeModalConfirmacion\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;<\/button>";
    var title = strings.title;
    modalContent += "                        <h4>" + title + "<\/h4>";
    modalContent += "                    <\/div>";
    modalContent += "                    <div id=\"contenidomodal\" class=\"modal-body\">";
    var message = strings.message;
    modalContent += message;
    modalContent += "                    <\/div>";
    modalContent += "                    <div class=\"modal-footer\">";
    var cancelar = strings.cancel;
    modalContent += "                        <a href=\"#\" class=\"btn btn-default closeModalConfirmacion\" >" +cancelar + "<\/a>";
    var sure = strings.ok;
    modalContent += "                        <a id=\"confirmButton\" href=\"#\" class=\"btn btn-primary\">" + sure + "<\/a>";
    modalContent += "                    <\/div>";
    modalContent += "                <\/div>";
    modalContent += "            <\/div>";
    modalContent += "        <\/div>";
    element.html(modalContent);
    $('.closeModalConfirmacion').click(function () {
        element.modal('hide');
        return false;
    });
    element.off('hidden.bs.modal');
    element.on('hidden.bs.modal', function () {

        if (params&&params.cancelFunction) {
            params.cancelFunction();
            element.off('hidden.bs.modal');
        }
    });
    var beforeSend = ajaxParams.beforeSend;
    ajaxParams.beforeSend = function () {
        reemplazaCargando($('#confirmButton'));
        if (beforeSend) beforeSend();
    }
    var success = ajaxParams.success;
    ajaxParams.success = function (data) {
        element.modal('hide');
        if (success) success(data);
    }
    var error = ajaxParams.error;
    ajaxParams.error = function (data) {
        quitarCargando();
        if (error) error(data);
    }
    $('#confirmButton').click(function () {
        $.ajax(ajaxParams);
        return false;
    });
    element.modal('show');
}

var defaultMessage = {
    tituloCorrecto: 'Exito',
    cuerpoCorrecto: 'Operación exitosa.',
    tituloError: 'Error',
    cuerpoError: 'Operación fallida.'
};