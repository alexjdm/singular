<table id="tablaSiniestros" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>N°</th>
        <th>Cliente</th>
        <th>Asegurado</th>
        <th>Mes</th>
        <th>Fecha Solicitud</th>
        <th>Monto Asegurado</th>
        <th>Prima Compañía</th>
        <th>Póliza</th>
        <th>N° Certificado</th>
        <th>Ejecutivo</th>
        <th>Siniestro</th>
        <th>Motivo</th>
        <th>Monto Provisión</th>
        <th>Fecha Denuncia</th>
        <th>Indemnización</th>
        <th></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>N°</th>
        <th>Cliente</th>
        <th>Asegurado</th>
        <th>Mes</th>
        <th>Fecha Solicitud</th>
        <th>Monto Asegurado</th>
        <th>Prima Compañía</th>
        <th>Póliza</th>
        <th>N° Certificado</th>
        <th>Ejecutivo</th>
        <th>Siniestro</th>
        <th>Motivo</th>
        <th>Monto Provisión</th>
        <th>Fecha Denuncia</th>
        <th>Indemnización</th>
        <th></th>
    </tr>
    </tfoot>
    <tbody>
    <?php $n = 1; ?>
    <?php foreach ($siniestrosVM as $siniestro): ?>
        <tr data-id="<?php echo $siniestro['ID_SINIESTRO'] ?>">
            <th><?php echo $n ?></th>
            <td><?php echo $siniestro['CLIENTE'] ?></td>
            <td><?php echo $siniestro['ASEGURADO'] ?></td>
            <td><?php echo $siniestro['MES'] ?></td>
            <td><?php echo $siniestro['FECHA_SOLICITUD'] ?></td>
            <td><?php echo $siniestro['MONTO_ASEGURADO'] ?></td>
            <td><?php echo $siniestro['PRIMA'] ?></td>
            <td><?php echo $siniestro['POLIZA'] ?></td>
            <td><?php echo $siniestro['NUMERO_CERTIFICADO'] ?></td>
            <td><?php echo $siniestro['EJECUTIVO'] ?></td>
            <td><?php echo $siniestro['SINIESTRO'] ?></td>
            <td><?php echo $siniestro['MOTIVO'] ?></td>
            <td><?php echo $siniestro['MONTO_PROVISION'] ?></td>
            <td><?php echo $siniestro['FECHA_DENUNCIA'] ?></td>
            <td><?php echo $siniestro['INDEMNIZACION'] ?></td>
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
        var table = $('#tablaSiniestros').DataTable({
            "scrollX": true
        });
    });

</script>