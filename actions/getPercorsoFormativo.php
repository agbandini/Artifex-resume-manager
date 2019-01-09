<?php
require('../common.php');
$cv_id = filter_input(INPUT_POST, 'cv_id', FILTER_SANITIZE_NUMBER_INT);
$per_form = $curriculum->getItemsByCvId($cv_id,'formazione');
?>
    <li class="time-label">
        <span class="bg-red">
            Studi e formazione
        </span>
    </li>
<?php foreach ($per_form as $ff) { ?>
    <li id="">
        <i class="fa fa-book bg-yellow"></i>
        <div class="timeline-item">
            <div class="timeline-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4><span class="text-light-blue" id=""><?= $ff['titolo_conseguito'] ?></span></h4>
                    </div>
                    <div class="col-md-6">
                        <h4><span class="text-light-blue text-bold" >Dal: </span><span id="F_dal_-ID-"><?= date("d/m/Y", strtotime($ff['data_inizio_form'])) ?></span><span class="text-light-blue text-bold" > Al: </span><span id="F_al_-ID-"><?= date("d/m/Y", strtotime($ff['data_fine_form'])) ?></span></h4>
                    </div>
                </div>

            </div>
            <div class="timeline-body">
                <div class="row">
                    <div class="col-md-4">
                        <span class="text-light-blue"><b>Presso: </b></span> <span id="F_presso_-ID-"><?= $ff['conseguito_presso'] ?></span>
                    </div>
                    <div class="col-md-4">
                        <span class="text-light-blue"><b>Citta: </b></span> <span id="F_citta_-ID-"><?= $ff['citta_titolo'] ?></span>
                    </div>
                    <div class="col-md-4">
                        <span class="text-light-blue"><b>Provincia: </b></span> <span id="F_prov_-ID-"><?= $ff['provincia_titolo'] ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <p id="F_descr_-ID-"><?= $ff['attivita_svolte'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </li>                                       
<?php }
//$res = ob_get_contents();
//ob_end_clean();