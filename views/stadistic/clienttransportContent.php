<table id="tablaTransporteCliente" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>N°</th>
        <th>Asegurado</th>
        <th>Mes</th>
        <th>Fecha Solicitud</th>
        <th>Monto Asegurado</th>
        <th>Prima Seguro</th>
        <th>Prima Cliente</th>
        <th>Profit Cliente</th>
        <th>Medio</th>
        <th>Póliza</th>
        <th>N° Certificado</th>
        <th>Transbordo</th>
        <th>Tipo Mercadería</th>
        <th>Ejecutivo</th>
        <th>Certificado</th>
        <th>Factura</th>
        <th></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>N°</th>
        <th>Asegurado</th>
        <th>Mes</th>
        <th>Fecha Solicitud</th>
        <th>Monto Asegurado</th>
        <th>Prima Seguro</th>
        <th>Prima Cliente</th>
        <th>Profit Cliente</th>
        <th>Medio</th>
        <th>Póliza</th>
        <th>N° Certificado</th>
        <th>Transbordo</th>
        <th>Tipo Mercadería</th>
        <th>Ejecutivo</th>
        <th>Certificado</th>
        <th>Factura</th>
        <th></th>
    </tr>
    </tfoot>
    <tbody>
    <?php $n = 1; ?>
    <?php foreach ($transportesVM as $transporteVM): ?>
        <tr data-id="<?php echo $transporteVM['ID_CERTIFICADO'] ?>">
            <th><?php echo $n ?></th>
            <td><?php echo $transporteVM['ASEGURADO'] ?></td>
            <td><?php echo $transporteVM['MES'] ?></td>
            <td><?php echo $transporteVM['FECHA_SOLICITUD'] ?></td>
            <td><?php echo $transporteVM['MONTO_ASEGURADO'] ?></td>
            <td><?php echo $transporteVM['PRIMA_SEGURO'] ?></td>
            <td><?php echo $transporteVM['PRIMA_CLIENTE'] ?></td>
            <td><?php echo $transporteVM['PROFIT_CLIENTE'] ?></td>
            <td><?php echo $transporteVM['MEDIO'] ?></td>
            <td><?php echo $transporteVM['POLIZA'] ?></td>
            <td><?php echo $transporteVM['NUMERO_CERTIFICADO'] ?></td>
            <td><?php echo $transporteVM['TRANSBORDO'] ?></td>
            <td><?php echo $transporteVM['TIPO_MERCADERIA'] ?></td>
            <td><?php echo $transporteVM['EJECUTIVO'] ?></td>
            <td class="text-center text-uppercase"><?php echo $transporteVM['CERTIFICADO'] ?></td>
            <td><?php echo $transporteVM['FACTURA'] ?></td>

            <td class="text-center" style="width: 70px;">
                <!--<button data-original-title="Editar" class="btn btn-xs btn-default editSinister">
                    <i class="fa fa-pencil"></i>
                </button>-->
            </td>
        </tr>
        <?php $n++; ?>
    <?php endforeach; ?>
    </tbody>

</table>

<script>

    $(function () {
        var table = $('#tablaTransporteCliente').DataTable({
            "scrollX": true
        });
    });

</script>