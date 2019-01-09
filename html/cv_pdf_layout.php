<table style="width: 100%;" cellpadding="6px">
<tbody>
<tr>
    <td style="width: 30%; text-align: left;" valign="middle" colspan="2">
<h1><span style="font-family: arial, helvetica, sans-serif;">Curriculum vitae</span></h1>
</td>
<td style="width: 30%; text-align: center;">
<p style="text-align: right;"><span style="font-family: arial, helvetica, sans-serif;"><img src="<?=$url?>uploads/images/logo-griffe.jpeg" alt="" width="100" height="54" style="float: right;" /></span></p>
</td>
</tr>
<tr>
<td style="width: 30%; text-align: center;" valign="top"><span style="font-family: arial, helvetica, sans-serif;">
        <img src="<?=$url?>uploads/images/<?=$userCv['cv_file_foto']?>" alt="" style="max-width: 200px; display: block; margin-left: auto; margin-right: auto; " /> 
    </span></td>
<td style="width: 35%; vertical-align: top;">
<h1><span style="font-size: 14pt; font-family: arial, helvetica, sans-serif;"><span style="font-size: 12pt;"><?=$userCv['cv_nome']?> <?=$userCv['cv_cognome']?></span><br /></span></h1>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong><br />Data di nascita<br /></strong><?=date("d/m/Y", strtotime($userCv['cv_data_nascita']))?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Luogo di nascita<br /></strong><?=$userCv['cv_luogo_nascita']?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Codice fiscale<br /></strong><?=$userCv['cv_codice_fiscale']?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Telefono<br /></strong><?=$userCv['cv_telefono']?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Email<br /></strong><?=$userCv['cv_email']?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Indirizzo<br /></strong><?=$userCv['cv_indirizzo']?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Localit&agrave;<br /></strong><?=$userCv['cv_cap']?> - <?=$userCv['cv_citta']?> (<?=$userCv['cv_provincia']?>)</span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Sesso<br /></strong><?=$userCv['cv_sesso']?></span></p>
</td>
<td style="vertical-align: top;">
<h1><span style="font-size: 12pt; font-family: arial, helvetica, sans-serif;">Competenze</span></h1>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong><br />Automunito<br /></strong><?=($userCv['cv_patente'] == 0 ? 'No': 'Si')?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Lingua madre<br /></strong><?=$userCv['cv_lingua_madre']?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Altre lingue<br /><?php echo '&nbsp;'.$curriculum::Utf8_ansi(implode(',', $cvLingue)) ?></strong>
<?php foreach ($cvLingue as $lin){
        echo '<span class="">'.$lin.'</span> '; 
} ?>
    </span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Competenze Email<br /></strong><?=($userCv['cv_mail_client'] == 0 ? 'No': 'Si')?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Competenze social network<br /></strong><?=($userCv['cv_social_network'] == 0 ? 'No': 'Si')?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Comptenze sw grafici<br /></strong><?=($userCv['cv_sw_grafica'] == 0 ? 'No': 'Si')?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Competenze commerciali<br /></strong><?=($userCv['cv_comp_commerciali'] == 0 ? 'No': 'Si')?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Comptenze profumeria<br /></strong><?=($userCv['cv_exp_profumeria'] == 0 ? 'No': 'Si')?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Comptenze estetica<br /></strong><?=($userCv['cv_exp_estetica'] == 0 ? 'No': 'Si')?></span></p>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Attestato di qualifica estetista<br /></strong><?=($userCv['cv_qualifica_estetista'] == 0 ? 'No': 'Si')?></span></p>
</td>
</tr>
<tr>
<td style="text-align: left;">
    <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Data registrazione<br /></strong><?=date("d/m/Y", strtotime($userCv['cv_data_inserimento']))?></span></p>
    <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Stato del profilo<br /></strong><?=$userCv['status_descr']?></span></p>
    <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Data incontro<br /></strong><?=(!is_null($userCv['cv_data_incontro']) ? date("d/m/Y", strtotime($userCv['cv_data_incontro'])) : '-')?></span></p>
    <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Valutazione<br /></strong><?= ($userCv['cv_valutazione'] == 0) ? 'Nessuna valutazione' : $userCv['cv_valutazione'] ?></span></p>
    <p style="text-align: left;"><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;"><strong>Osservazioni<br /></strong><?=$userCv['cv_considerazioni']?></span></p>
</td>
<td colspan="2" style="vertical-align: top;">
<h1><span style="font-size: 14pt; font-family: arial, helvetica, sans-serif;"><span style="font-size: 12pt;">Preferenze sede</span><br /></span></h1>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;">
<?php echo $curriculum::Utf8_ansi(implode(',', $cvSedi)) ?>
    </span></p>
<hr/>
<h1><span style="font-size: 14pt; font-family: arial, helvetica, sans-serif;"><span style="font-size: 12pt;">Percorso Formativo</span><br /></span></h1>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;">
<?php foreach ($per_form as $ef){
    echo "$ef[titolo_conseguito] - $ef[citta_titolo] - anno: $ef[anno]<br>";
} ?>
    </span></p>
<hr />
<h1><span style="font-size: 14pt; font-family: arial, helvetica, sans-serif;"><span style="font-size: 12pt;">Percorso Lavorativo</span><br /></span></h1>
<p><span style="font-family: arial, helvetica, sans-serif; font-size: 10pt;">
<?php foreach ($per_lav as $el){
    $dal = date("d/m/Y", strtotime($el['data_inizio_form']));
    $al = date("d/m/Y", strtotime($el['data_fine_form']));
    echo "$el[titolo_conseguito] - $el[citta_titolo] - $dal - $al<br>";
} ?>   
</span></p>
</td>
</tr>
</tbody>
</table>